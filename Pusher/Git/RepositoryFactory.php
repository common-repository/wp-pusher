<?php

namespace Pusher\Git;

use Exception;

class RepositoryFactory
{
    protected $allowedTypes = array('gh', 'bb');

    public function build($type, $handle)
    {
        if ( ! in_array($type, $this->allowedTypes))
            throw new Exception('Repository type not allowed.');

        if ($type === 'gh') {
            return new GitHubRepository($handle);
        } else if ($type === 'bb') {
            return new BitbucketRepository($handle);
        }
    }
}
