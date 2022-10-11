<?php
namespace Program\PHPMVC\Controller;
use Program\PHPMVC\App\View;


class HomeController{
   public function index(){
        View::render("Home/index",["title" => "PHP Login Management"]);
   }
}