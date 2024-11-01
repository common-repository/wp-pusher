<?php

namespace Pusher\Handlers;

use Pusher\Commands\UpdateTheme as UpdateThemeCommand;
use Pusher\Git\Repository;

class UpdateTheme extends BaseHandler
{
    public function handle(UpdateThemeCommand $command)
    {
        $theme = $this->pusher->themes->pusherThemeFromRepository($command->repository);

        $upgrader = $this->pusher->themeUpgrader;

        $upgrader->upgrade($theme);

        $this->pusher->dashboard->addMessage('Theme was successfully updated.');
    }
}
