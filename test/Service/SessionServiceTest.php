<?php
namespace Test\PHPMVC\Service;

use PHPUnit\Framework\TestCase;
use Program\PHPMVC\Config\Database;
use Program\PHPMVC\Domain\Session;
use Program\PHPMVC\Repository\SessionRepository;
use Program\PHPMVC\Repository\UserRepository;
use Program\PHPMVC\Service\SessionService;

function setcookie(string $name, string $value){
    echo "$name:$value";
}

class SessionServiceTest extends TestCase{
    private SessionService $sessionService;
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp():void{
        $this->sessionRepository=new SessionRepository(Database::getConnection());

        $this->userRepository=new UserRepository(Database::getConnection());
        $this->sessionService=new SessionService($this->sessionRepository, $this->userRepository);

        // $this->sessionRepository->deleteAll();
        // $this->userRepository->deleteAll();
    }

    public  function testCreate(){
        $session=$this->sessionService->create(34);

        $this->expectOutputRegex("[X-RAMARFF-SESSION:$session->id]");

        $result=$this->sessionRepository->findById($session->id);

        self::assertEquals(34, $result->user_id);
    }

    public function testDestroy(){
        $session=new Session();
        $session->id=uniqid();
        $session->user_id=34;

        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME]=$session->id;

        $this->sessionService->destroy();
        $this->expectOutputRegex("[X-RAMARFF-SESSION: ]");
        
        $result=$this->sessionRepository->findById($session->id);
        self::assertNull($result);
    }

    public function testCurrent(){
        $session=new Session();
        $session->id=uniqid();
        $session->user_id=34;

        $this->sessionRepository->save($session);
        $_COOKIE[SessionService::$COOKIE_NAME]=$session->id;

        $user=$this->sessionService->current();
        self::assertEquals($session->user_id,$user->id);
    }

  
}

?>