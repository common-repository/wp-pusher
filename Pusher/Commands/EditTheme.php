<?php

namespace Pusher\Commands;

class EditTheme
{
    public $stylesheet;
    public $repository;
    public $status;
    public $pushToDeploy;

    public function __construct($input)
    {
        $this->stylesheet = $input['stylesheet'];
        $this->repository = $input['repository'];
        $this->status = (isset($input['status'])) ? '1' : '0';
        $this->pushToDeploy = (isset($input['ptd'])) ? '1' : '0';
    }
}
