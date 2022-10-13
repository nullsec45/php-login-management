<?php
namespace Program\PHPMVC\Service;

use Program\PHPMVC\Config\Database;
use Program\PHPMVC\Domain\User;
use Program\PHPMVC\Model\UserRegisterRequest;
use Program\PHPMVC\Repository\UserRepository;
use Program\PHPMVC\Model\UserRegisterResponse;
use Program\PHPMVC\Exception\ValidationException;
use Program\PHPMVC\Model\UserLoginRequest;
use Program\PHPMVC\Model\UserLoginResponse;

class UserService{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;        
    }

    public function register(UserRegisterRequest $request):UserRegisterResponse{
        $this->validateUserRegistrationRequest($request);

        try{
            Database::beginTransaction();
            $user=$this->userRepository->findByName($request->name);
            if($user !== null){
                throw new ValidationException("User already exists");
            }

            $user=new User();
            $user->name=$request->name;
            $user->password=password_hash($request->password, PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $response=new UserRegisterResponse();
            $response->user=$user;

            Database::commitTransaction();
            return $response;
       }catch(\Exception $exception){
            Database::rollbackTransaction();
            throw $exception;
       }
    }
    private function validateUserRegistrationRequest(UserRegisterRequest $request){
        if($request->name == null || $request->password == null || trim($request->name) == "" || trim($request->password) == ""){
                throw new ValidationException("Name and password can't blank");
        }
    }

    public function login(UserLoginRequest $request): UserLoginResponse{
        $this->validateUserLoginRequest($request);

        $user=$this->userRepository->findByName($request->name);

        if($user == null){
            throw new ValidationException("Name or password is wrong");
        }
        if(password_verify($request->password, $user->password)){
            $response=new UserLoginResponse();
            $response->user=$user;
            return $response;
        }else{
            throw new ValidationException("Name or password is wrong");
        }
    }

    private function validateUserLoginRequest(UserLoginRequest $request){
        if($request->name == null || $request->password == null || trim($request->name) == "" || trim($request->password) == ""){
            throw new ValidationException("Name and password can't blank");
        }
    }
}

?>