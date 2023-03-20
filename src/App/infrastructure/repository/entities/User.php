<?php
declare(strict_types=1);


namespace App\infrastructure\repository\entities;


use Ramsey\Uuid\UuidInterface;

class User implements \JsonSerializable
{
    public function __construct(
        readonly private UuidInterface $uuid,
        private string                 $name,
        private \DateTimeImmutable     $created_at
    )
    {
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}