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
            $mobile1 = trim($oneLineFromCsv[1]);
            $mobile2 = trim($oneLineFromCsv[2]);
            $email1 = trim(strtolower($oneLineFromCsv[3]));
            $email2 = trim(strtolower($oneLineFromCsv[4]));
            $firstName = trim($oneLineFromCsv[5]);
            $lastName = trim($oneLineFromCsv[6]);

            if (!$email1) {
                continue;
            }

            $user = $this->userRepository->findOneBy(['email' => $email1]);

            if (!$user) {
                $user = new User();
                $user->setFullName($fullName)
                    ->setFirstName($firstName)
                    ->setLastName($lastName)
                    ->setEmail($email1)
                    ->setEmail2($email2)
                    ->setMobile($mobile1)
                    ->setMobile2($mobile2)
                    ->setPlainPassword('password')
                    ->setPassword('password');
                $this->manager->persist($user);
                $this->manager->flush();
            }

        }

return null;
    }

    public function __construct(ContainerInterface $container, UserRepository $userRepository, EntityManagerInterface $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->userRepository = $userRepository;
    }
}
