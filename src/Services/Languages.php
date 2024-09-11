<?php

namespace App\Services;

use App\Repository\LanguagesRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class Languages
{
    public function getLanguages()
    {
        return $this->languagesRepository->findAll();
    }

    public function LanguageSelected()
    {
        $session = $this->requestStack->getSession();
        if( $session->get('selected_language')) {
            $language = $session->get('selected_language');
            return $this->languagesRepository->findOneBy(['language' => $language]);
        }
        return $this->languagesRepository->findOneBy(['language' => 'English']);
    }

    public function getSelectedLanguageCode()
    {
        $session = $this->requestStack->getSession();
        if( $session->get('selected_language')) {
            $language = $session->get('selected_language');
            if ($language == 'English') {
                return '';
            } elseif ($language == 'French') {
                return 'FR';
            } elseif ($language == 'German') {
                return 'DE';
            }
        }
        return '';
    }


    public function __construct(LanguagesRepository $languagesRepository, RequestStack $requestStack)
    {
        $this->languagesRepository = $languagesRepository;
        $this->requestStack = $requestStack;
    }
}