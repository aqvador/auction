<?php
declare(strict_types=1);


namespace App\infrastructure\repository\mappers;


use App\infrastructure\repository\entities\AuctionStep;
use Ramsey\Uuid\Uuid;

class BettingMapper
{
    public function itemMap(array $item): AuctionStep
    {
        return new AuctionStep(
            Uuid::fromString($item['uuid']),
            Uuid::fromString($item['lot_uuid']),
            $item['user_uuid'],
            $item['step'],
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $item['created_at']),
        );
    }
}