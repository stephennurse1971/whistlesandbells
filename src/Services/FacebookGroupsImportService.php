<?php


namespace App\Services;

use App\Entity\FacebookGroups;
use App\Repository\FacebookGroupsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FacebookGroupsImportService
{
    public function importFacebookGroups(string $fileName)
    {
        $name = '';
        $link = '';
        $comment = '';

        $filepath = $this->container->getParameter('facebook_groups_import_directory');
        $fullpath = $filepath . $fileName;
        $alldataFromCsv = [];
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
                    $alldataFromCsv[$row][] = $data[$c];
                }
            }
            fclose($handle);
        }
        foreach ($alldataFromCsv as $oneLineFromCsv) {
            $name = trim($oneLineFromCsv[0]);
            $link = trim($oneLineFromCsv[1]);
            $comments = trim($oneLineFromCsv[2]);

            $facebookGroup = $this->facebookGroupsRepository->findOneBy([
                'name' => $name,
                'link' => $link,
            ]);

            if (!$facebookGroup) {
                $facebookGroup = new FacebookGroups();
                $facebookGroup->setName($name)
                    ->setLink($link)
                    ->setComments($comments);
                $this->manager->persist($facebookGroup);
                $this->manager->flush();
            }
        }
        $this->manager->flush();
        return null;
    }

    public function __construct(FacebookGroupsRepository $facebookGroupsRepository, ContainerInterface $container, EntityManagerInterface $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->facebookGroupsRepository = $facebookGroupsRepository;
    }
}
