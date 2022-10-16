<?php
namespace Program\PHPMVC\Controller;
use Program\PHPMVC\App\View;
use Program\PHPMVC\Config\Database;
use Program\PHPMVC\Repository\SessionRepository;
use Program\PHPMVC\Repository\UserRepository;
use Program\PHPMVC\Service\SessionService;

class HomeController{
   private SessionService $sessionService;

   public function __construct()
   {
      $connection=Database::getConnection();
      $sessionRepository=new SessionRepository($connection);
      $userRepository=new UserRepository($connection);
      $this->sessionService=new SessionService($sessionRepository, $userRepository);
   }
   public function index(){
        $user=$this->sessionService->current();

        if($user == null){
          View::render("Home/index",["title" => "PHP Login Management"]);
        }else{
          View::render("Home/dashboard",["title" => "Dashboard","user" => [
            "name" => $user->name
          ]]);
        }
         
   }
}