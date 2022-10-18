<?php


namespace App\Services;


class TaxYear
{
  public function findTaxYearAndDays(\DateTimeInterface $start_date,\DateTimeInterface $end_date){
      $tax_year = [];
      $start_date_year = $start_date->format('Y');
      $start_date_day = $start_date->format('d');
      $start_date_month = $start_date->format('m');

      $end_date_year = $start_date->format('Y');
      $end_date_day = $start_date->format('d');
      $end_date_month = $start_date->format('m');

      if($start_date_year == $end_date_year )
      {
          if($start_date < new \DateTime('04-04-'.$start_date_year) && $end_date <  new \DateTime('04-04-'.$start_date_year) ){
              $tax_year[] = ((int)$start_date_year)-1 ."-". ((int)$start_date_year);
          }
          elseif($start_date < new \DateTime('04-04-'.$start_date_year) && $end_date >  new \DateTime('04-04-'.$start_date_year)){

              $x = ((int)$start_date_year)-1;
              $y = ((int)$start_date_year);
              $tax_year[] = $x ."-". $y;

              $x = ((int)$start_date_year);
              $y = ((int)$start_date_year)+1;

             $tax_year[] = $x ."-". $y;
          }
          else{
              $year_start = $start_date_year;
              $year_end = (int)$start_date_year + 1;
             $tax_year[] = $year_start ."-".$year_end ;
          }
      }
else{
    if($start_date < new \DateTime('04-04-'.$start_date_year) && $end_date <  new \DateTime('04-04-'.$end_date_year) ){
        $tax_year[] = ((int)$start_date_year)-1 ."-". ((int)$start_date_year);

    }
    elseif($start_date < new \DateTime('04-04-'.$start_date_year) && $end_date >  new \DateTime('04-04-'.$end_date_year)){

        $x = ((int)$start_date_year)-1;
        $y = ((int)$start_date_year);
        $tax_year[] = $x ."-". $y;

        $x = ((int)$start_date_year);
        $y = ((int)$start_date_year)+1;

        $tax_year[] = $x ."-". $y;
    }
    elseif($start_date > new \DateTime('04-04-'.$start_date_year) && $end_date <  new \DateTime('04-04-'.$end_date_year)){
        $year_start = $start_date_year;
        $year_end = (int)$start_date_year + 1;
        $tax_year[] = $year_start ."-".$year_end ;
    }
    else{

    }
}


  }
}