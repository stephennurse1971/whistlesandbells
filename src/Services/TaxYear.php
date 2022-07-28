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

      if($start_date_year == $end_date_year){
          if($end_date_month >=4 && $end_date_day >14){
              $tax_year[] = $start_date_year-1 . "-" . $start_date_year;
              $tax_year[] = $start_date_year . "-" . $start_date_year+1;
          }
      }

  }
}