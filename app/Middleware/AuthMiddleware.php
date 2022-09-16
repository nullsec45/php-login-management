<?php
namespace Program\PHPMVC\Middleware;

class AuthMiddleware implements Middleware{
    public function before():void{
        if(!isset($_SESSION["username"])){
            header("Location:/login");
            exit();
        }
    }
}
?>