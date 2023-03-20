<?php
declare(strict_types=1);


namespace App\infrastructure\repository\entities;

use Ramsey\Uuid\UuidInterface;

class AuctionStep implements \JsonSerializable
{
    public function __construct(
        readonly private UuidInterface      $uuid,
        readonly private UuidInterface      $lot_uuid,
        readonly private User               $user,
        readonly private int                $step,
        readonly private \DateTimeImmutable $created_at,
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
     * @return UuidInterface
     */
    public function getLotUuid(): UuidInterface
    {
        return $this->lot_uuid;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getStep(): int
    {
        return $this->step;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}