<?php


namespace App\Services\ATS;


use App\Entity\ATS\Log;
use App\Entity\Project_Specific\User;
use Doctrine\ORM\EntityManagerInterface;

class LogService
{
    public function userLoggedIn(User $user)
    {
        $createdAt= new \DateTime('now');
        $log = new Log();
        $log->setEventKey('user.logged_in')
            ->setAdditionalInfo($user->getFirstName() .' '.$user->getLastName() )
            ->setUser($user)
            ->setCreatedAt($createdAt);
        $this->manager->persist($log);
        $this->manager->flush();
    }

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

}