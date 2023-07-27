<?php


namespace App\Services;


use App\Entity\Import;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserImportGrapevineService
{
    public function importUser(string $fileName)
    {
        $filepath = $this->container->getParameter('user_attachments_directory');
        $fullpath = $filepath . $fileName;
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
            $salutation = trim($oneLineFromCsv[0]);
            $firstName = trim($oneLineFromCsv[1]);
            $lastName = trim($oneLineFromCsv[2]);
            $jobTitle = trim($oneLineFromCsv[3]);
            $recruitingArea = trim($oneLineFromCsv[4]);
            $company = trim($oneLineFromCsv[5]);
            $businessAddress1 = trim($oneLineFromCsv[6]);
            $businessAddress2 = trim($oneLineFromCsv[7]);
            $businessAddress3 = trim($oneLineFromCsv[8]);
            $businessAddress4 = trim($oneLineFromCsv[9]);
            $businessAddressTown = trim($oneLineFromCsv[10]);
            $businessAddressCounty = trim($oneLineFromCsv[11]);
            $businessAddressPostcode = trim($oneLineFromCsv[12]);
            $businessAddressCountry = trim($oneLineFromCsv[13]);
            $email = trim(strtolower($oneLineFromCsv[14]));
            $businessPhone = trim($oneLineFromCsv[15]);
            $businessPhone = str_replace([' ','.', "(0)", "-", "Switchboard", "+", "(", ")"], "", $businessPhone);
            if ($businessPhone != '') {$businessPhone = "+" . $businessPhone;}
            $webPage = trim(strtolower($oneLineFromCsv[17]));
            $companyEmail = trim(strtolower($oneLineFromCsv[18])) ;
            $linkedIn = trim($oneLineFromCsv[21]);
            $businessAddress = $businessAddress1;
            if ($businessAddress2 != '') {
                $businessAddress = $businessAddress . ', ' . $businessAddress2;
            }
            if ($businessAddress3 != '') {
                $businessAddress = $businessAddress . ', ' . $businessAddress3;
            }
            if ($businessAddress4 != '') {
                $businessAddress = $businessAddress . ', ' . $businessAddress4;
            }
            $recruitingAreaDefault = $recruitingArea;
            $recruitingAreaListPref = [];
            $recruitingArea = str_replace(", ",",",$recruitingArea);
            $recruitingArea = explode(',',$recruitingArea);
            $recruitingAreaList = ['Asset Management','Investment Banking', 'Fixed Income','Equities', 'Hedge Funds', 'Risk',
                'Private Equity', 'CEOs','Compliance', 'HR', 'Human Resources', 'Benefits'];
            foreach ($recruitingAreaList as $area){
               if(in_array($area,$recruitingArea)){
                   $recruitingAreaListPref[]=$area;
               }
            }
            if ($email == '') {
                continue;
            }
            $find_user = $this->userRepository->findOneBy(['email' => $email]);
            if ($find_user) {
                $find_user->setLinkedIn($linkedIn);
                $this->manager->flush();
            } else {
                $user = new User();
                $user->setSalutation($salutation)
                    ->setFirstName($firstName)
                    ->setLastName($lastName)
                    ->setJobTitle($jobTitle)
                    ->setRecruitingArea($recruitingAreaDefault)
                    ->setRecruitingAreaList($recruitingAreaListPref)
                    ->setEmail($email)
                    ->setLinkedIn($linkedIn)
                    ->setFullName($firstName . ' ' . $lastName)
                    ->setCompany($company)
                    ->setBusinessStreet($businessAddress)
                    ->setBusinessCity($businessAddressTown)
                    ->setBusinessPostalCode($businessAddressPostcode)
                    ->setBusinessCountry($businessAddressCountry)
                    ->setBusinessPhone($businessPhone)
                    ->setEmail($email)
                    ->setEmail2($companyEmail)
                    ->setWebPage($webPage)
                    ->setRoles(['ROLE_RECRUITER'])
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
