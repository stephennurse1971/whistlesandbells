<?php


namespace App\Services;


use App\Entity\Import;
use App\Entity\ChaveyDown;
use App\Repository\ChaveyDownRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ChaveyDownImportService
{
    public function importCD(String $fileName)
    {
        $filepath = $this->container->getParameter('temporary_attachment');
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
            $date = trim($oneLineFromCsv[0]);
            $amount = trim($oneLineFromCsv[1]);
            $vendor = trim($oneLineFromCsv[2]);

            {
                $cdexpense = new ChaveyDown();
                $cdexpense->setDate(new \DateTime($date))
                    ->setAmount($amount)
                    ->setVendor($vendor);
                $this->manager->persist($cdexpense);
                $this->manager->flush();
            }

        }

        return null;
    }

    public function __construct(ContainerInterface $container, ChaveyDownRepository $chaveyDownRepository, EntityManagerInterface $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->chaveyDownRepository = $chaveyDownRepository;
    }
}
