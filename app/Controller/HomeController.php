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

    public function viewRegister(){
        View::render("Home/register");
    }
    public function register(){
        session_start();
        $request=["username" => $_POST["username"], 
        "password" => $_POST["password"]];
        $_SESSION["username"]=$request["username"];
        $_SESSION["password"]=hash("sha256",$request["password"]);

    }

    public function viewLogin(){
        View::render("Home/login");
    }

    public function login():void{
        session_start();
        $request=["username" => $_POST["username"], 
                 "password" => hash("sha256", $_POST["password"])
        ];
        
        $response=[
            "message" => "Login Sukses" 
        ];
        // Kirimkan response ke view
        if($request["username"] === $_SESSION["username"] && $request["password"] === $_SESSION["password"]){
            // header("Location:/hello");
            header("Location:/hello");
            exit();
        }
    }

    public function logout(){
        session_destroy();
        View::render("Home/logout");
    }
}