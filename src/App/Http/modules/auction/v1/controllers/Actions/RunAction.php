<?php
declare(strict_types=1);


namespace App\Http\modules\auction\v1\controllers\Actions;

use App\Http\modules\auction\v1\handlers\RunningActionHandler;
use App\infrastructure\repository\contracts\LotRepositoryInterface;
use Ramsey\Uuid\Uuid;
use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class RunAction extends Action
{
    public function __construct($id, $controller, private RunningActionHandler $handler, $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(string $uuid, LotRepositoryInterface $repository)
    {
        $lot = $repository->findByUuid(Uuid::fromString($uuid));
        if (!$lot) {
            throw new NotFoundHttpException('this lot not found');
        }

        if (!$lot->getStatus()->isCreated()) {
            throw new BadRequestHttpException('this lot is forbidden to run');
        }

        $this->handler->handle($lot);

        $this->controller->response->redirect("/auction/v1/betting/{$lot->getUuid()->toString()}");
    }
}