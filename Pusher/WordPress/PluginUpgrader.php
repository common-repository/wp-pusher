<?php

namespace Pusher\WordPress;

use Plugin_Upgrader;
use Pusher\Git\Repository;
use Pusher\Plugin;
use Pusher\Pusher;
use Pusher\WordPress\PluginUpgraderSkin;

class PluginUpgrader extends Plugin_Upgrader
{
    public function __construct(Pusher $pusher, PluginUpgraderSkin $skin)
    {
        $this->pusher = $pusher;
        parent::__construct($skin);
    }

    public function install(Plugin $plugin)
    {
        add_filter('upgrader_source_selection', array($this, 'upgraderSourceSelectionFilter'), 10, 3);

        $this->plugin = $plugin;
        return parent::install($this->plugin->repository->getZipUrl());
    }

    public function upgrade(Plugin $plugin)
    {
        add_filter("pre_site_transient_update_plugins", array($this, 'preSiteTransientUpdatePluginsFilter'), 10, 3);
        add_filter('upgrader_source_selection', array($this, 'upgraderSourceSelectionFilter'), 10, 3);

        $this->plugin = $plugin;
        return parent::upgrade($this->plugin->file);
    }

    public function upgraderSourceSelectionFilter($source, $remote_source, $upgrader)
    {
        $newSource = trailingslashit($remote_source) . trailingslashit($upgrader->plugin->repository->getSlug());

        global $wp_filesystem;

        if ( ! $wp_filesystem->move($source, $newSource, true))
            return new WP_Error();

        return $newSource;
    }

    public function preSiteTransientUpdatePluginsFilter($transient)
    {
        $options = array('package' => $this->plugin->repository->getZipUrl());
        $transient->response[$this->plugin->file] = (object) $options;

        return $transient;
    }
}
