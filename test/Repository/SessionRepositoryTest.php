<?php
namespace Test\PHPMVC\Repository;

use PHPUnit\Framework\TestCase;
use Program\PHPMVC\Domain\User;
use Program\PHPMVC\Config\Database;
use Program\PHPMVC\Domain\Session;
use Program\PHPMVC\Repository\SessionRepository;
use Program\PHPMVC\Repository\UserRepository;

class SessionRepositoryTest extends TestCase{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp() :void{
        $this->userRepository=new UserRepository(Database::getConnection());
        $this->sessionRepository=new SessionRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        // $this->userRepository->deleteAll();

        $user=new User();
        $user->name="fajar";
        $user->password="rahasiabanget_";
        $this->userRepository->save($user);
    }

    public function testSaveSuccess(){
        $session=new Session();
        $session->id=uniqid();

        $session->user_id=34;

        $this->sessionRepository->save($session);

        $result=$this->sessionRepository->findById($session->id);

        self::assertEquals($session->user_id, $result->user_id);
    }

    // public function testDeleteByIdSuccess(){

    // }

    // public function testFindByIdNotFound(){

    // }
}

?>