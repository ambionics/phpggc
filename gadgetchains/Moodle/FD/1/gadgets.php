<?php

class cachelock_file
{
    protected $locks = [];

    public function __construct($lockfile) {
        $this->locks[] = $lockfile;
    }
}
