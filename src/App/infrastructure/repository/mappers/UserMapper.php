<?php
declare(strict_types=1);


namespace App\infrastructure\repository\mappers;


use App\infrastructure\repository\entities\User;
use Ramsey\Uuid\Uuid;

class UserMapper
{
    public function itemMap(array $item): User
    {
        return new User(
            Uuid::fromString($item['uuid']),
            $item['name'],
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $item['created_at']),
        );
    }

}