<?php

namespace Pusher\Commands;

class InstallPlugin
{
    public $repository;
    public $type;
    public $private;

    public function __construct($input)
    {
        $this->repository = $input['repository'];
        $this->type = $input['type'];
        $this->private = (isset($input['private'])) ? '1' : '0';
    }
}
