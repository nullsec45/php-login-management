<?php
namespace Program\PHPMVC\Controller;

use PHPUnit\Util\Xml\Validator;
use Program\PHPMVC\App\View;
use Program\PHPMVC\Config\Database;
use Program\PHPMVC\Exception\ValidationException;
use Program\PHPMVC\Model\UserLoginRequest;
use Program\PHPMVC\Model\UserRegisterRequest;
use Program\PHPMVC\Repository\SessionRepository;
use Program\PHPMVC\Repository\UserRepository;
use Program\PHPMVC\Service\SessionService;
use Program\PHPMVC\Service\UserService;

class UserController{
    private UserService $userService;
    private SessionService $sessionService;
    
    public function __construct()
    {
        $conection=Database::getConnection();
        $userRepository=new UserRepository($conection);
        $this->userService=new UserService($userRepository);

        $sessionRepository=new SessionRepository($conection);
        $this->sessionService=new SessionService($sessionRepository, $userRepository);
    }
    public function register(){
        View::render("User/register", ["title" => "Register new User"]);
    }

    public function postRegister(){
        $request=new UserRegisterRequest();
        $request->name=$_POST["name"];
        $request->password=$_POST["password"];
        try{
             $this->userService->register($request);
             View::redirect("/users/login");    
        }catch(ValidationException $exception){ 
            View::render("User/register", ["title" => "Register new User","error" => $exception->getMessage()]);
        }
    }

    public function login(){
        View::render("User/login", ["title" => "Login User"]);
    }

    public function postLogin(){
        $request=new UserLoginRequest();
        $request->name=$_POST["name"];
        $request->password=$_POST["password"];

        try{
            $response=$this->userService->login($request);
            $this->sessionService->create($response->user->id);
            View::redirect("/");
        }catch(ValidationException $exception){
            View::render("User/login", ["title" => "Login User","error" => $exception->getMessage()]);
        }
    }
}
?>  