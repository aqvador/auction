<?php
declare(strict_types=1);


namespace App\Http\modules\auction\v1\handlers;


use App\infrastructure\repository\contracts\AuctionStepRepositoryInterface;
use App\infrastructure\repository\contracts\LotRepositoryInterface;
use App\infrastructure\repository\entities\AuctionStep;
use App\infrastructure\repository\entities\Lot;
use App\infrastructure\repository\entities\User;
use Ramsey\Uuid\Uuid;

class BettingAuctionHandler
{

    public function __construct(private AuctionStepRepositoryInterface $stepRepository, private LotRepositoryInterface $lotRepository)
    {
    }

    public function handle(Lot $lot, User $user): void
    {
        $lot->setNextStep();

        $step = new AuctionStep(
            Uuid::uuid6(),
            $lot->getUuid(),
            $user,
            $lot->getStep()->getCurrent(),
            new \DateTimeImmutable()
        );

        //  в транзакцию нужно обернуть
        $this->stepRepository->add($step);
        $this->lotRepository->update($lot);
    }
}