<?php
declare(strict_types=1);


namespace App\Http\modules\auction\v1\controllers\Actions;

use App\Http\modules\auction\v1\controllers\requests\CreateAuction;
use App\Http\modules\auction\v1\handlers\CreateAuctionHandler;
use Brick\Math\BigDecimal;
use yii\base\Action;

class CreateAction extends Action
{
    public function __construct($id, $controller, private CreateAuctionHandler $handler, $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    /** без серьезных валидаций */
    public function run()
    {
        if ($this->controller->request->isGet) {
            return $this->controller->render('create');
        }

        try {
            $name = $this->controller->request->post('auction_name');
            $price = $this->controller->request->post('auction_price');
            $step_time = $this->controller->request->post('step_time');

            $request = new CreateAuction(
                $name,
                BigDecimal::of($price),
                (int)$step_time,
            );

            $response = $this->handler->handle($request);

            return $this->controller->response->redirect("/auction/v1/view/{$response->getUuid()->toString()}");
        } catch (\Exception|\Error $error) {
            // send log
            return $this->controller->asJson(['message' => $error->getMessage(), 'file' => $error->getFile(), 'line' => $error->getLine()]);
//            return $this->controller->response->refresh();
        }
    }
}