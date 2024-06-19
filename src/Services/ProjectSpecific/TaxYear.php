<?php


namespace App\Services\ProjectSpecific;


use App\Repository\ProjectSpecific\CountryRepository;
use App\Repository\ProjectSpecific\UkDaysRepository;

class TaxYear
{
    public function findTaxYearAndDays(\DateTimeInterface $start_date, \DateTimeInterface $end_date)
    {
        $tax_year = [];
        $start_date_year = $start_date->format('Y');
        $start_date_day = $start_date->format('d');
        $start_date_month = $start_date->format('m');

        $end_date_year = $start_date->format('Y');
        $end_date_day = $start_date->format('d');
        $end_date_month = $start_date->format('m');

        if ($start_date_year == $end_date_year) {
            if ($start_date < new \DateTime('04-04-' . $start_date_year) && $end_date < new \DateTime('04-04-' . $start_date_year)) {
                $tax_year[] = ((int)$start_date_year) - 1 . "-" . ((int)$start_date_year);
                $days = date_diff($start_date, $end_date);
                $days = $days->days;
            } elseif ($start_date < new \DateTime('04-04-' . $start_date_year) && $end_date > new \DateTime('04-04-' . $start_date_year)) {

                $x = ((int)$start_date_year) - 1;
                $y = ((int)$start_date_year);
                $tax_year[] = $x . "-" . $y;

                $x = ((int)$start_date_year);
                $y = ((int)$start_date_year) + 1;

                $tax_year[] = $x . "-" . $y;
            } else {
                $year_start = $start_date_year;
                $year_end = (int)$start_date_year + 1;
                $tax_year[] = $year_start . "-" . $year_end;
            }
        } else {
            if ($start_date < new \DateTime('04-04-' . $start_date_year) && $end_date < new \DateTime('04-04-' . $end_date_year)) {
                $tax_year[] = ((int)$start_date_year) - 1 . "-" . ((int)$start_date_year);

            } elseif ($start_date < new \DateTime('04-04-' . $start_date_year) && $end_date > new \DateTime('04-04-' . $end_date_year)) {

                $x = ((int)$start_date_year) - 1;
                $y = ((int)$start_date_year);
                $tax_year[] = $x . "-" . $y;

                $x = ((int)$start_date_year);
                $y = ((int)$start_date_year) + 1;

                $tax_year[] = $x . "-" . $y;
            } elseif ($start_date > new \DateTime('04-04-' . $start_date_year) && $end_date < new \DateTime('04-04-' . $end_date_year)) {
                $year_start = $start_date_year;
                $year_end = (int)$start_date_year + 1;
                $tax_year[] = $year_start . "-" . $year_end;
            } else {

            }
        }
        return $tax_year;

    }

    public function daysInPeriod(\DateTimeInterface $start_date, \DateTimeInterface $end_date)
    {
        $tax_year = [];
        $start_date_year = $start_date->format('Y');
        $start_date_day = $start_date->format('d');
        $start_date_month = $start_date->format('m');
        $end_date_year = $start_date->format('Y');
        $end_date_day = $start_date->format('d');
        $end_date_month = $start_date->format('m');
        $dayscontainer = [];
        if ($start_date_year == $end_date_year) {
            if ($start_date < new \DateTime('04-04-' . $start_date_year) && $end_date < new \DateTime('04-04-' . $start_date_year)) {
                $daysPeriodOne = date_diff($start_date, $end_date);
                $dayscontainer[] = $daysPeriodOne->days;
            } elseif ($start_date < new \DateTime('04-04-' . $start_date_year) && $end_date > new \DateTime('04-04-' . $start_date_year)) {
                $breakDate = $start_date_year . '-04-04';
                $daysPeriodOne = date_diff($start_date, new \DateTime($breakDate));
                $days = $daysPeriodOne->days;
                $dayscontainer[] = $days;
                $daysPeriodTwo = date_diff(new \DateTime($breakDate), $end_date);
                $days = $daysPeriodTwo->days;
                $dayscontainer[] = $days;

            } else {
                $daysPeriodOne = date_diff($start_date, $end_date);
                $days = $daysPeriodOne->days;
                $dayscontainer[] = $days;
            }
        } else {
            if ($start_date < new \DateTime('04-04-' . $start_date_year) && $end_date < new \DateTime('04-04-' . $end_date_year)) {
                $tax_year[] = ((int)$start_date_year) - 1 . "-" . ((int)$start_date_year);

            } elseif ($start_date < new \DateTime('04-04-' . $start_date_year) && $end_date > new \DateTime('04-04-' . $end_date_year)) {

                $x = ((int)$start_date_year) - 1;
                $y = ((int)$start_date_year);
                $tax_year[] = $x . "-" . $y;

                $x = ((int)$start_date_year);
                $y = ((int)$start_date_year) + 1;

                $tax_year[] = $x . "-" . $y;
            } elseif ($start_date > new \DateTime('04-04-' . $start_date_year) && $end_date < new \DateTime('04-04-' . $end_date_year)) {
                $year_start = $start_date_year;
                $year_end = (int)$start_date_year + 1;
                $tax_year[] = $year_start . "-" . $year_end;
            } else {

            }
        }
        return $dayscontainer;
    }

    public function daysInTaxYear(string $taxYear, string $country)
    {
        $getDataByCountry = $this->ukDaysRepository->findBy(['country' => $this->countryRepository->findOneBy([
            'country' => $country
        ])
        ]);

        $days = 0;
        if ($getDataByCountry) {

            foreach ($getDataByCountry as $data) {
                $index = 0;
                $daysInPeriod = [];
                $taxPeriods = $this->findTaxYearAndDays($data->getStartDate(), $data->getEndDate());
                if (in_array($taxYear, $taxPeriods)) {
                    $daysInPeriod[] = $this->daysInPeriod($data->getStartDate(), $data->getEndDate());
                }
                if ($daysInPeriod) {
                    for ($i = 0; $i < count($taxPeriods); $i++) {
                        if ($taxPeriods[$i] == $taxYear) {
                            $index = $i;
                        }
                    }
                    $days = $days + (int)$daysInPeriod[0][$index];
                }

            }
        }
        return $days;
    }

    public function __construct(UkDaysRepository $ukDaysRepository, CountryRepository $countryRepository)
    {
        $this->ukDaysRepository = $ukDaysRepository;
        $this->countryRepository = $countryRepository;
    }
}