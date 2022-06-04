<?php


namespace App\Services;


class ImageResize
{
    public function imageResize($imageResourceId,$width,$height) {


        $targetWidth =400;

        $targetHeight =250;


        $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);

        imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


        return $targetLayer;

    }
}