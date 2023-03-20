<?php
declare(strict_types=1);


namespace App\infrastructure\repository;


use App\infrastructure\repository\contracts\UserRepositoryInterface;
use App\infrastructure\repository\entities\User;
use App\infrastructure\repository\mappers\UserMapper;
use Ramsey\Uuid\UuidInterface;
use yii\db\Connection;
use yii\db\Expression;
use yii\db\Query;

class UserRepository implements UserRepositoryInterface
{
    private const TABLE = 'user';

    public function __construct(private Connection $connection, private UserMapper $mapper)
    {
    }

    public function getRandomUser(): ?User
    {
        $query = (new Query())->from(self::TABLE);
        $user = $query->orderBy(new Expression('rand()'))->one($this->connection);

        if (!$user) {
            return null;
        }

        return $this->mapper->itemMap($user);
    }

    public function findByUuid(UuidInterface $uuid): ?User
    {
        $user = (new Query())->from(self::TABLE)->andWhere(['uuid' => $uuid->toString()])->one($this->connection);

        if (!$user) {
            return null;
        }

        return $this->mapper->itemMap($user);
    }
}