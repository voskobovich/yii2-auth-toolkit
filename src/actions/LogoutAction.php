<?php

namespace voskobovich\auth\actions;

use Yii;
use yii\base\Action;

/**
 * Class LogoutAction
 * @package voskobovich\auth\actions
 */
class LogoutAction extends Action
{
    /**
     * @return string
     */
    public function run()
    {
        Yii::$app->user->logout();

        return $this->controller->goHome();
    }
}