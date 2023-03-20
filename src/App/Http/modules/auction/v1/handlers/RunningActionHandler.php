<?php
declare(strict_types=1);


namespace App\Http\modules\auction\v1\handlers;


use App\Console\queues\jobs\AuctionJob;
use App\Console\queues\queueReleases\AppQueue;
use App\infrastructure\repository\contracts\LotRepositoryInterface;
use App\infrastructure\repository\entities\Lot;

class RunningActionHandler
{
    public function __construct(private LotRepositoryInterface $lotRepository, private AppQueue $queue)
    {
    }

    public function handle(Lot $lot): void
    {
        $lot->setRunning();

        $this->lotRepository->update($lot);
        # пушим в очередь с временем конца + 5 сек.
        $this->queue->delay($lot->getStep()->getTime() + 5)->push(new AuctionJob($lot->getUuid()));
    }

}