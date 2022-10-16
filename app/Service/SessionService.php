<?php

namespace Program\PHPMVC\Service;

use Program\PHPMVC\Domain\User;
use Program\PHPMVC\Domain\Session;
use Program\PHPMVC\Repository\SessionRepository;
use Program\PHPMVC\Repository\UserRepository;

class SessionService{

    public static string $COOKIE_NAME="X-RAMARFF-SESSION";

    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
        $this->sessionRepository=$sessionRepository;   
    }

    public function create(int $userId) : Session{
        $session=new Session();
        $session->id=uniqid();
        $session->user_id=$userId;
        
        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME, $session->id, time() + (60 * 60 * 24 * 30), "/");

        return $session;

    }

    public function destroy(){
        $sessionId=$_COOKIE[self::$COOKIE_NAME] ?? "";
        $this->sessionRepository->deleteById($sessionId);

        setcookie(self::$COOKIE_NAME, "", 1,"/");
    }

    public function current() : ?User{
        $sessionId=$_COOKIE[self::$COOKIE_NAME] ?? "";

        $session=$this->sessionRepository->findById($sessionId);

        if($session == null){
            return null;
        }else{
             return $this->userRepository->findById($session->user_id);
        }




    }
}