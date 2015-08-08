<?php

namespace voskobovich\auth\actions;

use voskobovich\auth\interfaces\AuthLoginInterface;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class LoginAction
 * @package voskobovich\auth\actions
 */
class LoginAction extends Action
{
    /**
     * @var string
     */
    public $modelClass;

    /**
     * @var string
     */
    public $viewName = 'login';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->modelClass == null) {
            throw new InvalidConfigException('Param "modelClass" must be contain model name with namespace.');
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        /** @var AuthLoginInterface|Model $model */
        $model = new $this->modelClass;
        $postData = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            $model->load($postData);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load($postData) && $model->login()) {
            return $this->controller->goBack();
        }

        return $this->controller->render($this->viewName, [
            'model' => $model
        ]);
    }
}