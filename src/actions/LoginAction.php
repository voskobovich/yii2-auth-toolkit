<?php

namespace voskobovich\auth\actions;

use voskobovich\auth\interfaces\AuthLoginFormInterface;
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
     * @param string $back
     * @return string
     */
    public function run($back = null)
    {
        if (!Yii::$app->user->isGuest) {
            if ($back) {
                return Yii::$app->response->redirect($back);
            }

            return $this->controller->goHome();
        }

        /** @var AuthLoginFormInterface|Model $model */
        $model = Yii::createObject($this->modelClass);
        $postData = Yii::$app->request->post();

        if ($model->load($postData)) {
            $request = Yii::$app->request;

            if ($request->isAjax && !$request->isPjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->login()) {
                if ($back) {
                    return Yii::$app->response->redirect($back);
                }

                return $this->controller->goBack();
            }
        }

        return $this->controller->render($this->viewName, [
            'model' => $model
        ]);
    }
}