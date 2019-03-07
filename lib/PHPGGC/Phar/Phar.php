<?php

namespace PHPGGC\Phar;


class Phar extends Format
{
    protected $format = '.phar';

    protected function update_signature()
    {
        $data = substr($this->data, 0, -28);
        $signature = $this->compute_signature($data);
        $this->data = $this->in_place_replace($this->data, -28, $signature);
    }
}