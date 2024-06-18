<?php

namespace App\Services\ATS;

use App\Repository\ATS\CompanyDetailsRepository;

class CompanyDetails
{
public function getCompanyDetails(){
return  $this->companyDetailsRepository->find(1);
}
public function __construct(CompanyDetailsRepository $companyDetailsRepository){
    $this->companyDetailsRepository = $companyDetailsRepository;
}
}