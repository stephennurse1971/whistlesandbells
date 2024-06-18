<?php


namespace App\Services\Project_Specific;

use App\Entity\Import;
use App\Entity\Project_Specific\TouristAttraction;
use App\Repository\Project_Specific\CountryRepository;
use App\Repository\Project_Specific\TouristAttractionRepository;
use App\Repository\StaticTextRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TouristAttractionImportOutlookService
{
    public function importTouristAttraction(string $fileName)
    {
        $firstName = '';
        $lastName = '';
        $company = '';
        $businessStreet = '';
        $businessCity = '';
        $businessPostalCode = '';
        $businessCountry = '';
        $businessPhone = '';
        $homePhone = '';
        $homePhone2 = '';
        $mobile1 = '';
        $email = '';
        $email2 = '';
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
            $firstName = trim($oneLineFromCsv[1]);
            $lastName = trim($oneLineFromCsv[3]);
            $company = trim($oneLineFromCsv[5]);
            $type = trim($oneLineFromCsv[7]);
            $businessStreet = trim($oneLineFromCsv[8]);
            $businessCity = trim($oneLineFromCsv[11]);
            $businessPostalCode = trim($oneLineFromCsv[13]);
            $businessCountry = trim($oneLineFromCsv[14]);

            if(empty( $businessCountry)){
                $businessCountry = "Cyprus";
            }

            if (count($oneLineFromCsv) >= 31) {
                $businessPhone = trim($oneLineFromCsv[31]);
                $businessPhone = str_replace([' ', "(0)", "(", ")", "-", "Switchboard", "+"], "", $businessPhone);
                if ($businessPhone != '') {
                    $businessPhone = "+" . $businessPhone;
                }
                $mobile1 = trim($oneLineFromCsv[40]);
                $mobile1 = str_replace([' ', "(0)", "(", ")", "-", "Switchboard", "+"], "", $mobile1);
                if ($mobile1 != '') {
                    $mobile1 = "+" . $mobile1;
                }
                $email = trim(strtolower($oneLineFromCsv[57]));
                $email2 = trim(strtolower($oneLineFromCsv[60]));
                $notes = trim(strtolower($oneLineFromCsv[77]));

            }
            if (count($oneLineFromCsv) >= 91) {
                $webPage = trim(strtolower($oneLineFromCsv[91]));
            }
            if (count($oneLineFromCsv) < 91) {
                $webPage = '';
            }

            if ($company != "Personal - Cyprus Tourist Attraction") {
                continue;
            }

            $touristattraction = $this->touristAttractionRepository->findOneBy(['firstName' => $firstName]);

            if (!$touristattraction) {
                $country = $this->countryRepository->findOneBy(['country'=>$businessCountry]);
                $touristattraction = new TouristAttraction();
                $touristattraction->setFirstName($firstName)
                    ->setLastName($lastName)
                    ->setFullName($firstName . ' ' . $lastName)
                    ->setCompany($company)
                    ->setType($type)
                    ->setBusinessStreet($businessStreet)
                    ->setBusinessCity($businessCity)
                    ->setBusinessPostCode($businessPostalCode)
                    ->setCountry($country)
                    ->setBusinessPhone($businessPhone)
                    ->setMobile($mobile1)
                    ->setEmail($email)
                    ->setEmail2($email2)
                    ->setWebPage($webPage)
                    ->setNotes($notes);
                $this->manager->persist($touristattraction);
                $this->manager->flush();
            }
        }
        $today = new \DateTime('now');
        $outlookImportDate = $this->staticTextRepository->findOneBy(['id' => 1]);
        $outlookImportDate->setLastOutlookDownload($today);
        $this->manager->flush();

        return null;
    }

    public function __construct(CountryRepository $countryRepository,ContainerInterface $container, TouristAttractionRepository $touristAttractionRepository, StaticTextRepository $staticTextRepository, EntityManagerInterface $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->touristAttractionRepository = $touristAttractionRepository;
        $this->staticTextRepository = $staticTextRepository;
        $this->countryRepository =  $countryRepository;
    }
}
