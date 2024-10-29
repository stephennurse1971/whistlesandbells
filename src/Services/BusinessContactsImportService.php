<?php


namespace App\Services;

use App\Entity\BusinessContacts;
use App\Repository\BusinessContactsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BusinessContactsImportService
{
    public function importBusinessContacts(string $fileName)
    {
        $status = '';
        $publicPrivate = '';
        $photo = '';
        $businessOrPerson = '';
        $firstName = '';
        $lastName = '';
        $email = '';
        $mobile = '';
        $landline = '';
        $company = '';
        $website = '';
        $addressStreet = '';
        $addressCity = '';
        $addressPostCode = '';
        $addressCountry = '';
        $locationLongitude = '';
        $locationLatitude = '';
        $notes = '';
        $filepath = $this->container->getParameter('business_contacts_import_filepath');
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
            $status = trim($oneLineFromCsv[1]);
            $publicPrivate = trim($oneLineFromCsv[2]);
            $photo = trim($oneLineFromCsv[3]);
            $businessOrPerson = trim($oneLineFromCsv[4]);
            $firstName = trim($oneLineFromCsv[5]);
            $lastName = trim($oneLineFromCsv[6]);
            $email = trim($oneLineFromCsv[7]);
            $mobile = trim($oneLineFromCsv[8]);
            $landline = trim($oneLineFromCsv[9]);
            $company = trim($oneLineFromCsv[10]);
            $website = trim($oneLineFromCsv[11]);
            $addressStreet = trim($oneLineFromCsv[12]);
            $addressCity = trim($oneLineFromCsv[13]);
            $addressPostCode = trim($oneLineFromCsv[14]);
            $addressCountry = trim($oneLineFromCsv[15]);
            $locationLongitude = trim($oneLineFromCsv[16]);
            $locationLatitude = trim($oneLineFromCsv[17]);

            if (empty($addressCountry)) {
                $addressCountry = "Cyprus";
            }
            if (count($oneLineFromCsv) >= 31) {
                $landline = trim($oneLineFromCsv[31]);
                $landline = str_replace([' ', "(0)", "(", ")", "-", "Switchboard", "+"], "", $businessPhone);
                if ($landline != '') {
                    $landline = "+" . $landline;
                }
                $mobile = trim($oneLineFromCsv[8]);
                $mobile = str_replace([' ', "(0)", "(", ")", "-", "Switchboard", "+"], "", $mobile1);
                if ($mobile != '') {
                    $mobile = "+" . $mobile1;
                }
            }
            if (count($oneLineFromCsv) >= 91) {
                $website = trim(strtolower($oneLineFromCsv[91]));
            }
            if (count($oneLineFromCsv) < 91) {
                $website = '';
            }

            if ($company != "Personal - Cyprus Tourist Attraction") {
                continue;
            }

            $businessContact = $this->businessContactsRepository->findOneBy(['firstName' => $firstName]);

            if (!$businessContact) {
                $businessContact = new BusinessContacts();
                $businessContact->setFirstName($firstName)
                    ->setLastName($lastName)
                    ->setCompany($company)
                    ->setAddressStreet($addressStreet)
                    ->setAddressCity($addressCity)
                    ->setAddressCountry($addressPostCode)
                    ->setAddressCountry($addressCountry)
                    ->setLandline($landline)
                    ->setMobile($mobile)
                    ->setEmail($email)
                    ->setWebsite($website);
                $this->manager->persist($businessContact);
                $this->manager->flush();
            }
        }
        $today = new \DateTime('now');
        $this->manager->flush();
        return null;
    }

    public function __construct(BusinessContactsRepository $businessContactsRepository, ContainerInterface $container, EntityManagerInterface $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->businessContactsRepository = $businessContactsRepository;
    }
}
