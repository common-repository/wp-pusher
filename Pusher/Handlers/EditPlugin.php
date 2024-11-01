<?php

namespace Pusher\Handlers;

use Exception;
use Pusher\Commands\EditPlugin as EditPluginCommand;
use Pusher\Git\Repository;

class EditPlugin extends BaseHandler
{
    public function handle(EditPluginCommand $command)
    {
        $repository = new Repository($command->repository);

        $this->pusher->plugins->editPlugin($command->file, array(
            'repository' => $repository,
            'status' => $command->status,
            'ptd' => $command->pushToDeploy
        ));

        $this->pusher->dashboard->addMessage('Plugin changes was successfully saved.');
    }
}
