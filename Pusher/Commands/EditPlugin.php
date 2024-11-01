<?php

namespace Pusher\Commands;

class EditPlugin
{
    public $file;
    public $repository;
    public $status;
    public $pushToDeploy;

    public function __construct($input)
    {
        $this->file = $input['file'];
        $this->repository = $input['repository'];
        $this->status = (isset($input['status'])) ? '1' : '0';
        $this->pushToDeploy = (isset($input['ptd'])) ? '1' : '0';
    }
}
