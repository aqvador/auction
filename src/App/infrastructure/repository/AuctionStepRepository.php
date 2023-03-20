<?php
declare(strict_types=1);


namespace App\infrastructure\repository;


use App\infrastructure\repository\contracts\AuctionStepRepositoryInterface;
use App\infrastructure\repository\contracts\UserRepositoryInterface;
use App\infrastructure\repository\entities\AuctionStep;
use App\infrastructure\repository\mappers\BettingMapper;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use yii\db\Connection;
use yii\db\Query;

class AuctionStepRepository implements AuctionStepRepositoryInterface
{
    private const TABLE = 'auction_step';

    public function __construct(
        private Connection              $connection,
        private UserRepositoryInterface $userRepository,
        private BettingMapper           $mapper
    )
    {
    }

    public function add(AuctionStep $step): void
    {
        $this->connection->createCommand()->insert(self::TABLE, [
            'uuid' => $step->getUuid()->toString(),
            'lot_uuid' => $step->getLotUuid()->toString(),
            'user_uuid' => $step->getUser()->getUuid()->toString(),
            'step' => $step->getStep(),
            'created_at' => $step->getCreatedAt()->format('Y-m-d H:i:s')
        ])->execute();
    }

    public function getLastBetByLot(UuidInterface $uuid_lot): ?AuctionStep
    {
        $query = (new Query())->from(self::TABLE);
        $query->andWhere(['lot_uuid' => $uuid_lot->toString()]);
        $query->orderBy(['step' => SORT_DESC])->limit(1);

        $bet = $query->one($this->connection);

        if (!$bet) {
            return null;
        }

        $bet['user_uuid'] = $this->userRepository->findByUuid(Uuid::fromString($bet['user_uuid']));

        if (!$bet['user_uuid']) {
            throw new \Exception('not found require user fot bet');
        }

        return $this->mapper->itemMap($bet);
    }
}