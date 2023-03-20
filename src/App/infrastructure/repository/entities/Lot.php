<?php
declare(strict_types=1);


namespace App\infrastructure\repository\entities;


use App\infrastructure\repository\entities\vo\lot\Status;
use App\infrastructure\repository\entities\vo\lot\Step;
use Brick\Math\BigDecimal;
use Ramsey\Uuid\UuidInterface;

class Lot implements \JsonSerializable
{
    public function __construct(
        readonly private UuidInterface $uuid,
        private string                 $name,
        private Step                   $step,
        private Status                 $status,
        private \DateTimeImmutable     $created_at,
        private ?\DateTimeImmutable    $finally_at,
        private ?User                  $winner,
    )
    {
    }

    /**
     * @return Step
     */
    public function getStep(): Step
    {
        return $this->step;
    }

    public function getAmountWin(): BigDecimal
    {
        if (!$this->getWinner()) {
            return BigDecimal::zero();
        }

        return $this->getStep()->getAmountWin();
    }


    private function FinishTheAuction(User $user)
    {
        $this->setStatus(Status::FINISHED);
        $this->setWinner($user);
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function setRunning()
    {
        $this->status = Status::RUNNING;
        $this->finally_at = (new \DateTimeImmutable())->modify("+{$this->step->getTime()} second");
    }

    public function isTimeout(): bool
    {
        return !is_null($this->finally_at) && (new \DateTimeImmutable()) >= $this->finally_at;
    }

    public function setNextStep(): void
    {
        $this->getStep()->setNextStep();
        $this->finally_at = (new \DateTimeImmutable())->modify("+{$this->step->getTime()} second");
    }

    public function setWinner(User $user): void
    {
        $this->winner = $user;
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
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return User|null
     */
    public function getWinner(): ?User
    {
        return $this->winner;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getFinallyAt(): ?\DateTimeImmutable
    {
        return $this->finally_at;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}