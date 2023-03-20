<?php
declare(strict_types=1);


namespace App\Console\queues\jobs;


use App\infrastructure\repository\contracts\AuctionStepRepositoryInterface;
use App\infrastructure\repository\contracts\LotRepositoryInterface;
use App\infrastructure\repository\entities\vo\lot\Status;
use Ramsey\Uuid\UuidInterface;
use yii\queue\JobInterface;

class AuctionJob implements JobInterface
{
    public function __construct(private UuidInterface $lot_uuid)
    {
    }

    public function execute($queue)
    {

        $lot = $this->getLotRepository()->findByUuid($this->lot_uuid);

        if (!$lot->isTimeout()) {
            $queue->delay($lot->getStep()->getTime())->push($this);
            return;
        }

        $winner = $this->getBetRepository()->getLastBetByLot($this->lot_uuid);

        if ($winner) {
            $lot->setWinner($winner->getUser());
        }
        $lot->setStatus(Status::FINISHED);
        $this->getLotRepository()->update($lot);
    }

    private function getLotRepository(): LotRepositoryInterface
    {
        return \Yii::$container->get(LotRepositoryInterface::class);
    }

    public function getBetRepository(): AuctionStepRepositoryInterface
    {
        return \Yii::$container->get(AuctionStepRepositoryInterface::class);
    }
}