<?php
require_once __DIR__."/../vendor/autoload.php";

use Program\PHPMVC\App\Router;
use Program\PHPMVC\Controller\{HomeController};


Router::add("GET","/", HomeController::class,"index");

Router::run();