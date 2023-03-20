<?php
declare(strict_types=1);


namespace App\infrastructure\repository\contracts;


use App\infrastructure\repository\entities\Lot;
use Ramsey\Uuid\UuidInterface;
use yii\debug\models\search\Log;

interface LotRepositoryInterface
{

    public function add(Lot $lot): void;

    public function update(Lot $lot): void;

    public function findByUuid(UuidInterface $uuid): ?Lot;

}