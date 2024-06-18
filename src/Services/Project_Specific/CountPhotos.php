<?php


namespace App\Services\Project_Specific;

use App\Repository\Project_Specific\PhotosRepository;

class CountPhotos
{
    public function calculateTotalPhotos($location)
    {
        $photos = $this->photosRepository->findBy([
            'location' => $location
        ]);
        if ($photos) {
            return count($photos);
        }
        return 0;

    }


    public function __construct(PhotosRepository $photosRepository)
    {
        $this->photosRepository = $photosRepository;
    }
}