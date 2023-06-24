<?php

namespace CodeIgniter\View\Cells;

class Cell
{
    protected $view;

    public function __construct($view) 
    {
        $this->view = $view;
    }
}