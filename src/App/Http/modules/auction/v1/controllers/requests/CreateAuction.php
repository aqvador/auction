<?php
declare(strict_types=1);


namespace App\Http\modules\auction\v1\controllers\requests;


use Brick\Math\BigDecimal;

class CreateAuction implements \JsonSerializable
{
    public function __construct(
        readonly private string $name,
        readonly private BigDecimal $price,
        readonly private int $step_time
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
    public function getStepTime(): int
    {
        return $this->step_time;
    }

    public function jsonSerialize(): mixed
    {
        return  get_object_vars($this);
    }
}