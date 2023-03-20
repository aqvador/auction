<?php
declare(strict_types=1);


namespace App\Http\modules\auction\v1\controllers\Actions;

use App\Http\modules\auction\v1\handlers\BettingAuctionHandler;
use App\Http\modules\auction\v1\handlers\RunningActionHandler;
use App\infrastructure\repository\contracts\LotRepositoryInterface;
use App\infrastructure\repository\contracts\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;
use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class BettingAction extends Action
{
    public function __construct($id, $controller,
                                private LotRepositoryInterface $repository,
                                private UserRepositoryInterface $userRepository,
                                private BettingAuctionHandler $handler,
        $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(string $uuid_lot)
    {
        $lot = $this->repository->findByUuid(Uuid::fromString($uuid_lot));

        if (!$lot) {
            throw new NotFoundHttpException('this lot not found');
        }


        if ($this->controller->request->isGet) {
            $currentUser = $this->userRepository->getRandomUser();
            return $this->controller->render('betting', compact('lot', 'currentUser'));
        }


        if ($lot->isTimeout()) {
            return $this->controller->response->redirect("/auction/v1/view/{$lot->getUuid()->toString()}");
        }

        $uuid_user = $this->controller->request->post('betting_user');
        if (!Uuid::isValid($uuid_user)) {
            throw new BadRequestHttpException('no valid user');
        }
        $currentUser = $this->userRepository->findByUuid(Uuid::fromString($uuid_user));

        if (!$currentUser) {
            throw new BadRequestHttpException('user not found');
        }


        $this->handler->handle($lot, $currentUser);

        return $this->controller->response->redirect("/auction/v1/betting/{$lot->getUuid()->toString()}");
    }
}