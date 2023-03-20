<?php
declare(strict_types=1);


namespace App\infrastructure\repository\mappers;


use App\infrastructure\repository\entities\Lot;
use App\infrastructure\repository\entities\vo\lot\Status;
use App\infrastructure\repository\entities\vo\lot\Step;
use Brick\Math\BigDecimal;
use Ramsey\Uuid\Uuid;

class LotMapper
{
    public function lotMap(array $lot): Lot
    {
        $step = json_decode($lot['step'], true);
        return new Lot(
            Uuid::fromString($lot['uuid']),
            $lot['name'],
            new Step(
                BigDecimal::of($step['price']),
                $step['time'],
                $step['current']
            ),
            Status::create($lot['status']),
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $lot['created_at']),
            $lot['finally_at'] ? \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $lot['finally_at']) : null,
            $lot['winner'],
        );
    }
}