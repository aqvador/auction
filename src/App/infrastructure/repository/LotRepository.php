<?php
declare(strict_types=1);


namespace App\infrastructure\repository;


use App\infrastructure\repository\contracts\LotRepositoryInterface;
use App\infrastructure\repository\contracts\UserRepositoryInterface;
use App\infrastructure\repository\entities\Lot;
use App\infrastructure\repository\mappers\LotMapper;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use yii\db\Connection;
use yii\db\Query;

class LotRepository implements LotRepositoryInterface
{
    private const TABLE = 'auction_lot';

    public function __construct(
        private Connection              $connection,
        private UserRepositoryInterface $userRepository,
        private LotMapper               $mapper
    )
    {
    }


    public function add(Lot $lot): void
    {
        $this->connection->createCommand()->insert(self::TABLE, [
            'uuid' => $lot->getUuid()->toString(),
            'name' => $lot->getName(),
            'step' => json_encode($lot->getStep()->jsonSerialize()),
            'status' => $lot->getStatus()->value,
            'created_at' => $lot->getCreatedAt()->format('Y-m-d H:i:s'),
            'finally_at' => $lot->getFinallyAt()?->format('Y-m-d H:i:s'),
        ])->execute();
    }

    public function update(Lot $lot): void
    {
        $this->connection->createCommand()->update(self::TABLE, [
            'status' => $lot->getStatus()->value,
            'step' => json_encode($lot->getStep()->jsonSerialize()),
            'finally_at' => $lot->getFinallyAt()->format('Y-m-d H:i:s'),
            'winner' => $lot->getWinner()?->getUuid()->toString()
        ])->execute();
    }

    public function findByUuid(UuidInterface $uuid): ?Lot
    {
        $item = (new Query())->from(self::TABLE)->andWhere(['uuid' => $uuid->toString()])->one($this->connection);

        if (!$item) {
            return null;
        }

        if ($item['winner']) {
            $item['winner'] = $this->userRepository->findByUuid(Uuid::fromString($item['winner']));
        }

        return $this->mapper->lotMap($item);
    }
}