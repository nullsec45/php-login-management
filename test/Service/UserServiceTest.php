<?php
namespace Test\PHPMVC\Service;

use PHPUnit\Framework\TestCase;
use Program\PHPMVC\Domain\User;
use Program\PHPMVC\Config\Database;
use Program\PHPMVC\Service\UserService;
use Program\PHPMVC\Model\UserRegisterRequest;
use Program\PHPMVC\Repository\UserRepository;
use Program\PHPMVC\Exception\ValidationException;
use Program\PHPMVC\Model\UserLoginRequest;

class UserServiceTest extends TestCase{
    private UserService $userService;
    private UserRepository $userRepository;

    protected function setUp():void{
        $connection=Database::getConnection();
        $this->userRepository=new UserRepository($connection);
        $this->userService=new UserService($this->userRepository);

        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess(){
        $request=new UserRegisterRequest();
        $request->name="rama";
        $request->password="kjkszpj645";

        $response=$this->userService->register($request);

        self::assertEquals($request->name, $response->user->name);
        self::assertNotEquals($request->password, $response->user->password);

        self::assertTrue(password_verify($request->password, $response->user->password));
    }

    public function testRegisterFailed(){
        $this->expectException(ValidationException::class);
        
        $request=new UserRegisterRequest();
        $request->name="";
        $request->password="";

        $this->userService->register($request);
    }

    public function testRegisterDuplicate(){
        $user=new User();
        $user->name="rama";
        $user->password="kjkszpj645";      
  
        $this->userRepository->save($user);
        
        $this->expectException(ValidationException::class);

        $request=new UserRegisterRequest();
        $request->name="rama";
        $request->password="kjkszpj645";

        $this->userService->register($request);
    }

    public function testLoginNotFound(){
        $this->expectException(ValidationException::class);
        $request=new UserLoginRequest();
        $request->name="fajar";
        $request->password="rahasia";

        $this->userService->login($request);
    }

    public function testLoginWrongPassword(){
        $this->expectException(ValidationException::class);

        $user=new User();
        $user->name="fajar";
        $user->password=password_hash("KEPO123", PASSWORD_BCRYPT);

        $request=new UserLoginRequest();
        $request->name="fajar";
        $request->password="rahasia";

        $this->userService->login($request);
    }

    public function testLoginSuccess(){
        $user=new User();
        $user->name="fajar";
        $user->password=password_hash("KEPO123", PASSWORD_BCRYPT);

        $this->expectException(ValidationException::class);

        $request=new UserLoginRequest();
        $request->name="fajar";
        $request->password="KEPO123";

        $response=$this->userService->login($request);

        self::assertEquals($request->name, $response->user->name);
        self::assertTrue(password_verify($request->password, $response->user->password));

    }
}

?>