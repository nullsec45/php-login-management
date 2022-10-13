<?php
require_once __DIR__."/../vendor/autoload.php";

use Program\PHPMVC\App\Router;
use Program\PHPMVC\Config\Database;
use Program\PHPMVC\Controller\{HomeController, UserController};

Database::getConnection('production');

// Home Controller
Router::add("GET","/", HomeController::class,"index");

// User Controller
Router::add("GET","/users/register", UserController::class,"register");
Router::add("POST","/users/register", UserController::class,"postRegister");
Router::add("GET","/users/login", UserController::class,"login");
Router::add("POST","/users/login", UserController::class,"postLogin");

Router::run();