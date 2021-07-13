<?php


namespace App\Services;


use App\Repository\PaymentsRepository;
use App\Repository\TennisBookingsRepository;
use App\Repository\UserRepository;

class PaymentsMade
{
    public function TotalPaymentsMade(int $userid)
    {
        $payments = $this->paymentsRepository->findBy([
            'user'=>$userid]);
        $total = 0;
        foreach ($payments as $payment) {
            $total = $total + $payment->getAmount();
        }
        return $total;

    }

    public function TotalBookingsCost (int $userid)
    {
        $payments = $this->tennisBookingsRepository->findBy([
            'player1'=>$userid]);
        $total = 0;
        foreach ($payments as $payment) {
            $total = $total + $payment->getCost();
        }
        return $total;

    }


    public function __construct(PaymentsRepository $paymentsRepository, TennisBookingsRepository $tennisBookingsRepository)
    {
        $this->paymentsRepository = $paymentsRepository;
        $this->tennisBookingsRepository = $tennisBookingsRepository;
    }
}