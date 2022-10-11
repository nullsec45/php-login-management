<?php
namespace Program\PHPMVC\Service;

use Program\PHPMVC\Config\Database;
use Program\PHPMVC\Domain\User;
use Program\PHPMVC\Model\UserRegisterRequest;
use Program\PHPMVC\Repository\UserRepository;
use Program\PHPMVC\Model\UserRegisterResponse;
use Program\PHPMVC\Exception\ValidationException;

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
}

?>