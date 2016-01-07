<?php

namespace voskobovich\auth\controllers;

use voskobovich\auth\actions\LoginAction;
use voskobovich\auth\actions\LogoutAction;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class AuthController
 * @package voskobovich\auth\controllers
 */
class AuthController extends Controller
{
    /**
     * @var string
     */
    public $modelClass;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'post' => ['logout']
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['login'] = [
            'class' => LoginAction::className(),
            'modelClass' => $this->modelClass
        ];
        $actions['logout'] = [
            'class' => LogoutAction::className(),
        ];

        return $actions;
    }
} 