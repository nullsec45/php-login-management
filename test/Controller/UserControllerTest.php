<?php
namespace Program\PHPMVC\App{
    function header(string $value){
        echo $value;
    }
}


namespace Test\PHPMVC\Controller{
    use PHPUnit\Framework\TestCase;
    use Program\PHPMVC\Domain\User;
    use Program\PHPMVC\Config\Database;
    use Program\PHPMVC\Controller\UserController;
    use Program\PHPMVC\Repository\UserRepository;

    class UserControllerTest extends TestCase{
        private UserController $userController;
        private UserRepository $userRepository;

        protected function setUp():void{
            $this->userController=new UserController();

            $this->userRepository=new UserRepository(Database::getConnection());
            $this->userRepository->deleteAll();

            putenv("mode=test");
        }
        public function testRegister(){
            $this->userController->register();
            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Password]");
        }

        public function testRegisterSuccess(){
            $_POST["name"]="fajar";
            $_POST["password"]="rahasia";

            $this->userController->postRegister();

            $this->expectOutputRegex("[Location: /users/login]"); 
        }

        public function testRegisterValidationError(){
            $_POST["name"]="";
            $_POST["password"]="rahasia";

            $this->userController->postRegister();

            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Name and password can't blank]");
        }

        public function testPostRegisterDuplicate(){
            $user=new User();
            $user->name="fajar";
            $user->password="rahasia";
            
            $this->userRepository->save($user);
            
            $_POST["name"]="fajar";
            $_POST["password"]="rahasia";

            $this->userController->postRegister();

            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[User already exists]");
        }

        public function testLogin(){
            $this->userController->login();

            $this->expectOutputRegex("[Login User]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Password]");
        }

        public function testLoginSuccess(){
            $user=new User();
            $user->name="fajar";
            $user->password=password_hash("rahasia123",PASSWORD_BCRYPT);
            
            $this->userRepository->save($user);            

            $_POST["name"]="fajar";
            $_POST["password"]="rahasia123";

            $this->userController->postLogin();
            $this->expectOutputRegex("[Location: /]");
        }

        public function testLoginValidationError(){
            $_POST["name"]="";
            $_POST["password"]="";

            $this->userController->postLogin();

            $this->expectOutputRegex("[Login User]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Name and password can't blank]");
        }

        public function testLoginUserNotFound(){
            $_POST["name"]="entong";
            $_POST["password"]="entong";

            $this->userController->postLogin();

            $this->expectOutputRegex("[Login User]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Name or password is wrong]");
        }

        public function testLoginWrongPassword(){
            $user=new User();
            $user->name="fajar";
            $user->password=password_hash("rahasia", PASSWORD_BCRYPT);
  
            $this->userRepository->save($user);

            $_POST["name"]="fajar";
            $_POST["password"]="salah";

            $this->userController->postLogin();

            $this->expectOutputRegex("[Login User]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Name or password is wrong]");
        }
    }    
}
?>