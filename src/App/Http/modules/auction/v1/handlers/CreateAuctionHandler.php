<?php
declare(strict_types=1);


namespace App\Http\modules\auction\v1\handlers;


use App\Http\modules\auction\v1\controllers\requests\CreateAuction;
use App\infrastructure\repository\contracts\LotRepositoryInterface;
use App\infrastructure\repository\entities\Lot;
use App\infrastructure\repository\entities\vo\lot\Status;
use App\infrastructure\repository\entities\vo\lot\Step;
use Ramsey\Uuid\Uuid;

class CreateAuctionHandler
{
    public function __construct(private LotRepositoryInterface $lotRepository)
    {
    }

    public function handle(CreateAuction $auction): Lot
    {
        $lot = new Lot(
            Uuid::uuid6(),
            $auction->getName(),
            new Step(
                $auction->getPrice(),
                $auction->getStepTime(),
                0,
            ),
            Status::CREATED,
            new \DateTimeImmutable(),
            null,
            null,
        );

        #  добавляем в репозиторий
        $this->lotRepository->add($lot);

        return $lot;
    }

}