<?php

namespace Pusher\Handlers;

use Exception;
use Pusher\Commands\EditTheme as EditThemeCommand;
use Pusher\Git\Repository;

class EditTheme extends BaseHandler
{
    public function handle(EditThemeCommand $command)
    {
        $repository = new Repository($command->repository);

        $this->pusher->themes->editTheme($command->stylesheet, array(
            'repository' => $repository,
            'status' => $command->status,
            'ptd' => $command->pushToDeploy
        ));

        $this->pusher->dashboard->addMessage('Theme changes was successfully saved.');
    }
}
