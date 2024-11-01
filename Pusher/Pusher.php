<?php

namespace Pusher;

class Pusher
{
    protected $services = array();

    public function init()
    {
        add_action('admin_init', array($this, 'registerPluginActionLinks'));
        add_action('admin_init', array($this, 'registerSettings'));
        add_action('admin_init', array($this->dispatcher, 'dispatchPostRequests'));
        add_action('admin_menu', array($this, 'adminMenu'));
    }

    public function activate()
    {
        $this->db->install();
    }

    public function adminMenu()
    {
        add_menu_page($this->getName(), $this->getName(), 'manage_options', 'wppusher', array($this->dashboard, 'getIndex'), 'dashicons-marker');
        add_submenu_page('wppusher', 'New plugin', 'New plugin', 'manage_options', 'wppusher-plugins-create', array($this->dashboard, 'getPluginsCreate'));
        add_submenu_page('wppusher', 'WP Pusher Plugins Setup', 'All plugins', 'manage_options', 'wppusher-plugins', array($this->dashboard, 'getPlugins'));
        add_submenu_page('wppusher', 'New theme', 'New theme', 'manage_options', 'wppusher-themes-create', array($this->dashboard, 'getThemesCreate'));
        add_submenu_page('wppusher', 'WP Pusher Themes Setup', 'All themes', 'manage_options', 'wppusher-themes', array($this->dashboard, 'getThemes'));
    }

    public function getName()
    {
        return ($this->isPro()) ? 'WP Pusher Pro' : 'WP Pusher';
    }

    public function isPro()
    {
        return ($this instanceof \Pusher\Pro\Pusher);
    }

    public function registerPluginActionLinks()
    {
        $plugins = $this->plugins->allPusherPlugins();
        $url = get_admin_url(null, 'admin.php?page=wppusher-plugins');
        $link = '<a href="'. $url .'"><img src="http://wppusher.com/png_400px.png" width="20">&nbsp; Manage</a>';

        foreach ($plugins as $plugin) {
            add_filter('plugin_action_links_' . $plugin->file, function ($links) use ($link)
            {
                $links[] = $link;
                return $links;
            });
        }
    }

    public function registerSettings()
    {
        register_setting('pusher-gh-settings', 'gh_token');
        register_setting('pusher-bb-settings', 'bb_user');
        register_setting('pusher-bb-settings', 'bb_pass');
    }

    public function register(ProviderInterface $provider)
    {
        $provider->register($this);
    }

    public function singleton($service, $callback)
    {
        $this->services[$service] = $callback($this);
    }

    public function __get($service)
    {
        if ( ! isset($this->services[$service]))
            return null;

        if ( ! is_callable($this->services[$service]))
            return $this->services[$service];

        return $this->services[$service]($this);
    }

    public function __set($service, $callback)
    {
        $this->services[$service] = $callback;
    }
}
