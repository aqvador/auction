<?php
declare(strict_types=1);


namespace App\infrastructure\repository\contracts;


use App\infrastructure\repository\entities\User;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function findByUuid(UuidInterface $uuid): ?User;

    public function getRandomUser(): ?User;
}