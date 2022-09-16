<?php
namespace Program\PHPMVC\Middleware;

interface Middleware{
    public function before():void;
}