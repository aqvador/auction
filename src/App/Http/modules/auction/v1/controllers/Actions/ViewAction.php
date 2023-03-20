<?php
declare(strict_types=1);


namespace App\Http\modules\auction\v1\controllers\Actions;


use App\infrastructure\repository\contracts\LotRepositoryInterface;
use Ramsey\Uuid\Uuid;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class ViewAction extends Action
{
    public function run(string $uuid, LotRepositoryInterface $repository)
    {
        $lot = $repository->findByUuid(Uuid::fromString($uuid));
        if (!$lot) {
            throw new NotFoundHttpException('lot not found');
        }

        return $this->controller->render('view', compact('lot'));

    }

}