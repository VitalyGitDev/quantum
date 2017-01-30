<?php
namespace Application\Core;

class View
{
    public $template;

    public $layout;

    public function __construct()
    {
        $this->layout = __DIR__ . './../../templates/pageLayout.php';
    }

    public function generate($data=NULL)
    {
        include $this->layout;
    }
}
