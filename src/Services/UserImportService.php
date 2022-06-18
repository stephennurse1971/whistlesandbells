<?php


namespace App\Services;


use App\Entity\Import;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserImportService
{
    public function importUser(String $fileName)
    {
        $filepath = $this->container->getParameter('user_attachments_directory');
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
            $firstName = trim($oneLineFromCsv[0]);
            $lastName = trim($oneLineFromCsv[1]);
            $company = trim($oneLineFromCsv[2]);
            $businessAddress = trim($oneLineFromCsv[3]);
            $homeAddress = trim($oneLineFromCsv[4]);
            $businessPhone = trim($oneLineFromCsv[5]);
            $homePhone = trim($oneLineFromCsv[6]);
            $homePhone2 = trim($oneLineFromCsv[7]);
            $mobile1 = trim($oneLineFromCsv[8]);
            $birthday = trim($oneLineFromCsv[9]);
            $email = trim(strtolower($oneLineFromCsv[10]));
            $email2 = trim(strtolower($oneLineFromCsv[11]));
            $email3 = trim(strtolower($oneLineFromCsv[12]));
            $webPage = trim(strtolower($oneLineFromCsv[13]));
//            $notes = trim(strtolower($oneLineFromCsv[14]));

            if (!$email) {
                continue;
            }

            $user = $this->userRepository->findOneBy(['email' => $email]);

            if (!$user) {
                $user = new User();
                $user->setFirstName($firstName)
                    ->setLastName($lastName)
                    ->setFullName($firstName . ' ' .$lastName)
                    ->setCompany($company)
                    ->setBusinessAddress($businessAddress)
                    ->setHomeAddress($homeAddress)
                    ->setBusinessPhone($businessPhone)
                    ->setHomePhone($homePhone)
                    ->setHomePhone2($homePhone2)
                    ->setMobile($mobile1)
//                    ->setBirthday($birthday)
                    ->setEmail($email)
                    ->setEmail2($email2)
                    ->setEmail3($email3)
                    ->setWebPage($webPage)
//                    ->setNotes($notes)
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
