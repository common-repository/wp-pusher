<?php

namespace Pusher\Handlers;

use Pusher\Commands\InstallTheme as InstallThemeCommand;
use Pusher\Git\BitbucketRepository;
use Pusher\Git\GitHubRepository;

class InstallTheme extends BaseHandler
{
    public function handle(InstallThemeCommand $command)
    {
        $repository = $this->pusher->repositoryFactory->build(
            $command->type,
            $command->repository
        );

        if ($command->private) $repository->makePrivate();

        $theme = $this->pusher->themes->fromSlug($repository->getSlug());
        $theme->setRepository($repository);

        $upgrader = $this->pusher->themeUpgrader;

        $result = $upgrader->install($theme);

        if ($result !== true) return;

        $theme = $this->pusher->themes->fromSlug($repository->getSlug());
        $theme->setRepository($repository);

        $this->pusher->themes->store($theme);

        $activationLink = get_admin_url()
                . "themes.php?action=activate&stylesheet="
                . urlencode($theme->stylesheet)
                . "&_wpnonce="
                . wp_create_nonce('switch-theme_' . $theme->stylesheet);

        $this->pusher->dashboard->addMessage("Theme was successfully installed. Go ahead and <a href=\"{$activationLink}\">activate</a> it.");
    }
}
