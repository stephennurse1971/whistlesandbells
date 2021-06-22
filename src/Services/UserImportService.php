<?php


namespace App\Services;


use App\Entity\Import;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserImportService

{
    public function import(String $fileName)
    {
        $filepath = $this->container->getParameter('import_user_directory');
        $fullpath = $filepath  . $fileName;
        $alldatatsFromCsv = [];
        $row = 0;
        if (($handle = fopen($fullpath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row == 0) {
                    $row++;
                    continue;
                }
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $alldatatsFromCsv[$row][] = $data[$c];
                }
            }
            fclose($handle);
        }

        foreach ($alldatatsFromCsv as $oneLineFromCsv) {
            $fullName = trim($oneLineFromCsv[0]);
            $email = trim(strtolower($oneLineFromCsv[1]));
            $mobile = trim($oneLineFromCsv[2]);

            if (!$email) {
                continue;
            }

            $user = $this->userRepository->findOneBy(['email' => $email]);

            if (!$user) {
                $user = new User();
                $user->setFullName($fullName)
                    ->setEmail($email)
                    ->setMobile($mobile)
                    ->setPlainPassword('password')
                    ->setPassword('password');
                $this->manager->persist($user);
                $this->manager->flush();
            }

        }


    }

    public function __construct(ContainerInterface $container, UserRepository $userRepository, EntityManagerInterface $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->userRepository = $userRepository;
    }
}
