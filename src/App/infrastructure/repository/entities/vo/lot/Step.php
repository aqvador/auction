<?php
declare(strict_types=1);


namespace App\infrastructure\repository\entities\vo\lot;


use Brick\Math\BigDecimal;

class Step implements \JsonSerializable
{
    public function __construct(
        readonly private BigDecimal $price,
        readonly private int        $time,
        private int                 $current,
    )
    {
    }

    public function getAmountWin(): BigDecimal
    {
        return $this->getPrice()->multipliedBy($this->current)->toScale(2);
    }

    public function setNextStep(): void
    {
        ++$this->current;
    }

    /**
     * @return BigDecimal
     */
    public function getPrice(): BigDecimal
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @return int
     */
    public function getCurrent(): int
    {
        return $this->current;
    }


    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}