<?php
declare(strict_types=1);


namespace App\Http\modules\auction\v1\controllers;


use App\Http\modules\auction\v1\controllers\Actions as Actions;
use yii\web\Controller;

class IndexController extends Controller
{
    public function actions()
    {
        return [
            'create' => Actions\CreateAction::class,
            'view' => Actions\ViewAction::class,
            'run' => Actions\RunAction::class,
            'betting' => Actions\BettingAction::class
        ];
    }
}