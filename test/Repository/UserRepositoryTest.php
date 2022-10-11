<?php
namespace Test\PHPMVC\Repository;

use PHPUnit\Framework\TestCase;
use Program\PHPMVC\Domain\User;
use Program\PHPMVC\Config\Database;
use Program\PHPMVC\Repository\UserRepository;

class UserRepositoryTest extends TestCase{
    private UserRepository $userRepository;

    protected function setUp() :void{
        $this->userRepository=new UserRepository(Database::getConnection());
    }

    public function testSaveSuccesss(){
        $user=new User();
        // $user->id=null;
        $user->name="Rama";
        $user->password="kopihitam645";

        $this->userRepository->save($user);

        $result=$this->userRepository->findById(1);

        // self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);
    }

    public function testFindByIdNotFound(){
        $user=$this->userRepository->findById("notfound");
        self::assertNull($user);
    }
}

?>