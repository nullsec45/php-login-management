<?php
require_once __DIR__."/../vendor/autoload.php";

use Program\PHPMVC\App\Router;
use Program\PHPMVC\Controller\{HomeController,ProductController};
use Program\PHPMVC\Middleware\AuthMiddleware;

// Router::add("GET","/","HomeController","index");
// Router::add("GET","/login","UserController","login");
// Router::add("GET","/register","UserController","register");

Router::add("GET","/products/([0-9a-zA-Z]*)/categories/([0-9a-zA-Z]*)",ProductController::class,"categories");
Router::add("GET","/products/user",ProductController::class,"user");

Router::add("GET","/", HomeController::class,"index");
Router::add("GET","/hello", HomeController::class,"hello", [AuthMiddleware::class]);
Router::add("GET","/world", HomeController::class,"world", [AuthMiddleware::class]);
Router::add("GET","/register", HomeController::class,"viewRegister");
Router::add("POST","/register", HomeController::class,"register");
Router::add("GET","/login", HomeController::class,"viewLogin");
Router::add("POST","/login", HomeController::class,"login");
Router::add("GET","/logout", HomeController::class,"logout");

Router::run();