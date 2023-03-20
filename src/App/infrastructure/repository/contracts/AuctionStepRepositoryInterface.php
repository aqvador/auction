<?php
declare(strict_types=1);


namespace App\infrastructure\repository\contracts;


use App\infrastructure\repository\entities\AuctionStep;
use Ramsey\Uuid\UuidInterface;

interface AuctionStepRepositoryInterface
{
    public function add(AuctionStep $step): void;

    public function getLastBetByLot(UuidInterface $uuid_lot): ?AuctionStep;
}