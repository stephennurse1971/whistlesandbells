<?php


namespace App\Services;


use App\Entity\FxRatesHistory;
use App\Entity\MarketDataHistory;
use App\Repository\FxRatesHistoryRepository;
use App\Repository\MarketDataHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SecurityPricesImportService
{
    public function importSecurityPrices(string $fileName, $security)
    {
        $filepath = $this->container->getParameter('security_prices_attachments_directory');
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
            $shareprice = trim($oneLineFromCsv[1]);

//            $prior_record = $this->$marketDataHistoryRepository->findOneBy(['date' => new \DateTime($date)]);
//            if ($prior_record) {
//                continue;
//            } else {
            $new_share_price_history = new MarketDataHistory();
            $new_share_price_history->setDate(new \DateTime($date))
                ->setSecurity($security)
                ->setMarketPrice($shareprice);
            $this->manager->persist($new_share_price_history);
            $this->manager->flush();
        }
//        }
        return null;
    }

    public function __construct(ContainerInterface $container, MarketDataHistoryRepository $marketDataHistoryRepository, EntityManagerInterface $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->marketDataHistoryRepository = $marketDataHistoryRepository;
    }
}
