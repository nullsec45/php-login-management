<?php
require_once __DIR__."/../vendor/autoload.php";

use Program\PHPMVC\App\Router;
use Program\PHPMVC\Controller\HomeController;

// Router::add("GET","/","HomeController","index");
// Router::add("GET","/login","UserController","login");
// Router::add("GET","/register","UserController","register");


Router::add("GET","/", HomeController::class,"index");
Router::add("GET","/hello", HomeController::class,"hello");
Router::add("GET","/world", HomeController::class,"world");

Router::run();