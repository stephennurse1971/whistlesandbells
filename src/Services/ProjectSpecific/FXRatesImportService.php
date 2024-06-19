<?php


namespace App\Services\ProjectSpecific;


use App\Entity\ProjectSpecific\FxRatesHistory;
use App\Repository\ProjectSpecific\FxRatesHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FXRatesImportService
{
    public function importFXRates(string $fileName)
    {
        $filepath = $this->container->getParameter('fx_attachments_directory');
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
            $date = trim($oneLineFromCsv[0]);
            $UsdFxRate = trim($oneLineFromCsv[1]);
            $GbpFxRate = trim($oneLineFromCsv[2]);
            $EurFxRate = trim($oneLineFromCsv[3]);
            $ChfFxRate = trim($oneLineFromCsv[4]);


            $prior_record = $this->fxRatesHistoryRepository->findOneBy(['date' => new \DateTime($date)]);
            if ($prior_record) {
                continue;
            } else {
                $new_fx_history = new FxRatesHistory();
                $new_fx_history->setDate(new \DateTime($date))
                    ->setEURFXRate($UsdFxRate)
                    ->setGbpFxRate($GbpFxRate)
                    ->setEurFxRate($EurFxRate)
                    ->setChfFxRate($ChfFxRate);;

                $this->manager->persist($new_fx_history);
                $this->manager->flush();
            }
        }
        return null;
    }

    public function __construct(ContainerInterface $container, FxRatesHistoryRepository $fxRatesHistoryRepository, EntityManagerInterface $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->fxRatesHistoryRepository = $fxRatesHistoryRepository;
    }
}
