<?php
declare(strict_types=1);


namespace App\infrastructure\repository\entities\vo\lot;


enum Status: string implements \JsonSerializable
{
    case  CREATED = 'created';
    case  RUNNING = 'running';
    case  FINISHED = 'finished';
    case ERROR = 'error';

    public static function create(string $status): self
    {
        return match ($status) {
            self::CREATED->value => self::CREATED,
            self::RUNNING->value => self::RUNNING,
            self::FINISHED->value => self::FINISHED,
            self::ERROR->value => self::ERROR,
            default => throw new \Exception('unable create status auction')
        };
    }

    public function isFinished(): bool
    {
        return $this === self::FINISHED;
    }

    public function isCreated()
    {
        return $this === self::CREATED;
    }

    public function isRunning()
    {
        return $this === self::RUNNING;
    }

    public function isError()
    {
        return $this === self::ERROR;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}