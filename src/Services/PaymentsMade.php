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
        $payments1 = $this->tennisBookingsRepository->findBy([
            'player1'=>$userid]
        );
        $payments2 = $this->tennisBookingsRepository->findBy([
            'player2'=>$userid]
        );

        $payments3 = $this->tennisBookingsRepository->findBy([
                'player3'=>$userid]
        );

        $payments4 = $this->tennisBookingsRepository->findBy([
                'player3'=>$userid]
        );

        $total = 0;
        foreach ($payments1 as $payment1) {
            $total = $total + ($payment1->getCost()/$payment1->getNumberOfPlayers() );
        }
        foreach ($payments2 as $payment2) {
            $total = $total + ($payment2->getCost()/$payment2->getNumberOfPlayers() );
        }
        foreach ($payments3 as $payment3) {
            $total = $total + ($payment3->getCost()/$payment3->getNumberOfPlayers() );
        }
        foreach ($payments4 as $payment4) {
            $total = $total + ($payment4->getCost()/$payment4->getNumberOfPlayers() );
        }


        return $total;

    }


    public function __construct(PaymentsRepository $paymentsRepository, TennisBookingsRepository $tennisBookingsRepository)
    {
        $this->paymentsRepository = $paymentsRepository;
        $this->tennisBookingsRepository = $tennisBookingsRepository;
    }
}