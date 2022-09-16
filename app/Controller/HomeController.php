<?php
namespace Program\PHPMVC\Controller;
use Program\PHPMVC\App\View;


class HomeController{
    public function index():void{
        $model=["title" => "Home Page", "body" => "Welcome to my web"];
        View::render("Home/index", $model);
    }
    
    public function hello():void{
        echo "HomeController.hello";
    }

    public function world():void{
        echo "HomeController.world";
    }

    public function login():void{
        $request=["username" => $_POST["username"], 
                 "password" => $_POST["password"]
                ];
        
        $response=[
            "message" => "Login Sukses"
        ];
        // Kirimkan response ke view
    }
}