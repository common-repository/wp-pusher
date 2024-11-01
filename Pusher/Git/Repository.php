<?php

namespace Pusher\Git;

use Exception;

class Repository
{
    protected $handle;
    protected $private = 0;

    public function __construct($handle)
    {
        if ( ! $this->validate($handle))
            throw new Exception("Repository is not valid.");
            
        $this->handle = $handle;
    }

    public function validate($repo)
    {
        preg_match('/^[a-zA-Z0-9_-]+[\/]+[a-zA-Z0-9_-]*+$/', $repo, $match);

        if (count($match) === 0) return false;

        return true;
    }

    public function getSlug()
    {
        $elements = preg_split('/\//', $this->handle);
        return $elements[1];
    }

    public function makePrivate()
    {
        $this->private = 1;
    }

    public function isPrivate()
    {
        return $this->private;
    }

    public function __toString()
    {
        return $this->handle;
    }
}
