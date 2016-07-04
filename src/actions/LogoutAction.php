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
     * @param string $back
     * @return string
     */
    public function run($back = null)
    {
        Yii::$app->user->logout();

        if ($back) {
            return Yii::$app->response->redirect($back);
        }

        return $this->controller->goHome();
    }
}