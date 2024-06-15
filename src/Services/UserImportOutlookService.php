<?php


namespace App\Services;


use App\Entity\Import;
use App\Entity\User;
use App\Repository\SettingsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserImportOutlookService
{
    public function importUser(string $fileName)
    {
        $now = new \DateTime('now');
        $salutation = '';
        $firstName = '';
        $lastName = '';
        $company = '';
        $businessStreet = '';
        $businessCity = '';
        $businessPostalCode = '';
        $businessCountry = '';
        $homeStreet = '';
        $homeCity = '';
        $homePostalCode = '';
        $homeCountry = '';
        $businessPhone = '';
        $homePhone = '';
        $homePhone2 = '';
        $mobile1 = '';
        $birthday = '';
        $email = '';
        $email2 = '';
        $email3 = '';
        $notes = '';
        $webPage = '';
        $filepath = $this->container->getParameter('user_attachments_directory');
        $fullpath = $filepath . $fileName;
        $alldatatsFromCsv = [];
        $row = 0;
        if (($handle = fopen($fullpath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
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
            $salutation = trim($oneLineFromCsv[0]);
            $firstName = trim($oneLineFromCsv[1]);
            $lastName = trim($oneLineFromCsv[3]);
            $company = trim($oneLineFromCsv[5]);
            $businessStreet = trim($oneLineFromCsv[8]);
            $businessCity = trim($oneLineFromCsv[11]);
            $businessPostalCode = trim($oneLineFromCsv[13]);
            $businessCountry = trim($oneLineFromCsv[14]);
            $homeStreet = trim($oneLineFromCsv[15]);
            $homeCity = trim($oneLineFromCsv[18]);
            $homePostalCode = trim($oneLineFromCsv[20]);
            $homeCountry = trim($oneLineFromCsv[21]);
            if (count($oneLineFromCsv) >= 31) {
                $businessPhone = trim($oneLineFromCsv[31]);
                $businessPhone = str_replace([' ', "(0)", "(", ")", "-", "Switchboard", "+"], "", $businessPhone);
                if ($businessPhone != '') {
                    $businessPhone = "+" . $businessPhone;
                }
                $homePhone = trim($oneLineFromCsv[37]);
                $homePhone = str_replace([' ', "(0)", "(", ")", "-", "Switchboard", "+"], "", $homePhone);
                if ($homePhone != '') {
                    $homePhone = "+" . $homePhone;
                }
                $homePhone2 = trim($oneLineFromCsv[38]);
                $homePhone2 = str_replace([' ', "(0)", "(", ")", "-", "Switchboard", "+"], "", $homePhone2);
                if ($homePhone2 != '') {
                    $homePhone2 = "+" . $homePhone2;
                }
                $mobile1 = trim($oneLineFromCsv[40]);
                $mobile1 = str_replace([' ', "(0)", "(", ")", "-", "Switchboard", "+"], "", $mobile1);
                if ($mobile1 != '') {
                    $mobile1 = "+" . $mobile1;
                }
                $birthday = trim(strtolower($oneLineFromCsv[52]));
                $email = trim(strtolower($oneLineFromCsv[57]));
                $email2 = trim(strtolower($oneLineFromCsv[60]));
                $email3 = trim(strtolower($oneLineFromCsv[63]));
                $notes = trim(strtolower($oneLineFromCsv[77]));
                if ($birthday != '0/0/00') {
                    $birthday_array = explode("/", $birthday);
                    $birthday_string = $birthday_array[1] . "/" . $birthday_array[0] . "/" . $birthday_array[2];
                }
            }
            if (count($oneLineFromCsv) >= 91) {
                $webPage = trim(strtolower($oneLineFromCsv[91]));
            }
            if (count($oneLineFromCsv) < 91) {
                $webPage = '';
            }

            if (!$email) {
                $email=$firstName.$lastName."NoEmail@no_email.com";
            }
            if ($company == "Personal - Cyprus Tourist Attraction") {
                continue;
            }

            $old_user = $this->userRepository->findOneBy(['email' => $email]);
              if($old_user){
                  if($old_user->getFirstName() == $firstName &&
                      $old_user->getLastName() == $lastName &&
                      $old_user->getCompany() == $company &&
                      $old_user->getBusinessStreet() == $businessStreet &&
                      $old_user->getBusinessCity() == $businessCity &&
                      $old_user->getBusinessPostalCode() == $businessPostalCode &&
                      $old_user->getBusinessCountry() == $businessCountry &&
                      $old_user->getHomeStreet() == $homeStreet &&
                      $old_user->getHomeCity() == $homeCity &&
                      $old_user->getHomePostalCode() == $homePostalCode &&
                      $old_user->getHomeCountry() == $homeCountry &&
                      $old_user->getHomePhone() == $homePhone &&
                      $old_user->getHomePhone2() == $homePhone2 &&
                      $old_user->getMobile() == $mobile1 &&
                      $old_user->getWebPage() == $webPage &&
                      $old_user->getNotes() == $notes
                  )
                  {
                      $old_user->setEmail($email.'Duplicate');
                  }
                  else{
                      $new_user = new User();
                      $new_user->setSalutation($salutation)
                          ->setEmail($email)
                          ->setFirstName($firstName)
                          ->setLastName($lastName)
                          ->setFullName($firstName . ' ' . $lastName)
                          ->setCompany($company)
                          ->setBusinessStreet($businessStreet)
                          ->setBusinessCity($businessCity)
                          ->setBusinessPostalCode($businessPostalCode)
                          ->setBusinessCountry($businessCountry)
                          ->setHomeStreet($homeStreet)
                          ->setHomeCity($homeCity)
                          ->setHomePostalCode($homePostalCode)
                          ->setHomeCountry($homeCountry)
                          ->setBusinessPhone($businessPhone)
                          ->setHomePhone($homePhone)
                          ->setHomePhone2($homePhone2)
                          ->setMobile($mobile1)
                          ->setEmail2($email2)
                          ->setEmail3($email3)
                          ->setWebPage($webPage)
                          ->setRoles(['ROLE_USER'])
                          ->setNotes($notes)
                          ->setEntryConflict('Conflict')
                          ->setPlainPassword('password')
                          ->setPassword('password')
                          ->setImportTime($now);                      ;
                      if ($birthday != '0/0/00') {
                          $new_user->setBirthday(new \DateTime($birthday_string));
                      }
                      if ($company == "Personal - Headhunter") {
                          $new_user->setRoles(['ROLE_RECRUITER']);
                      }
                      if ($company == "Personal - Family") {
                          $new_user->setRoles(['ROLE_FAMILY']);
                      }

                      $this->manager->persist($new_user);
                      $this->manager->flush();
                  }
              }

           else {
               $new_user = new User();
               $new_user->setSalutation($salutation)
                   ->setFirstName($firstName)
                   ->setLastName($lastName)
                   ->setFullName($firstName . ' ' . $lastName)
                   ->setCompany($company)
                   ->setBusinessStreet($businessStreet)
                   ->setBusinessCity($businessCity)
                   ->setBusinessPostalCode($businessPostalCode)
                   ->setBusinessCountry($businessCountry)
                   ->setHomeStreet($homeStreet)
                   ->setHomeCity($homeCity)
                   ->setHomePostalCode($homePostalCode)
                   ->setHomeCountry($homeCountry)
                   ->setBusinessPhone($businessPhone)
                   ->setHomePhone($homePhone)
                   ->setHomePhone2($homePhone2)
                   ->setMobile($mobile1)
                   ->setEmail($email)
                   ->setEmail2($email2)
                   ->setEmail3($email3)
                   ->setWebPage($webPage)
                   ->setRoles(['ROLE_USER'])
                   ->setNotes($notes)
                   ->setPlainPassword('password')
                   ->setPassword('password')
                   ->setImportTime($now);
               if ($birthday != '0/0/00') {
                   $new_user->setBirthday(new \DateTime($birthday_string));
               }
               if ($company == "Personal - Headhunter") {
                   $new_user->setRoles(['ROLE_RECRUITER']);
               }
               if ($company == "Personal - Family") {
                   $new_user->setRoles(['ROLE_FAMILY']);
               }
               $this->manager->persist($new_user);
               $this->manager->flush();
           }
        }

        $today = new \DateTime('now');
        $outlookImportDate = $this->settingsRepository->findOneBy(['id' => 1]);
        $outlookImportDate->setLastOutlookDownload($today);
        $this->manager->flush();
        return null;
    }

    public function __construct(ContainerInterface $container, UserRepository $userRepository,SettingsRepository $settingsRepository,EntityManagerInterface $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->settingsRepository = $settingsRepository;
    }
}
