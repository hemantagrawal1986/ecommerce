<?php
namespace App\Action;


class OrderAction
{
    public $attributes=[];
    public function __construct() {

    }
    public function execute()
    {
        return false;
    }

    public function foo()
    {
        return $this;
    }

    public function bar()
    {
        return $this;
    }
    
    public function done()
    {
        return "Ten";
    }

    public function __set($name,$value)
    {
        $this->attributes[$name]=$value;
    }
    

    public function __get($name)
    {
        return $this->attributes[$name];
    }
}