<?php

namespace app\modules\v1\controllers;

use app\models\Status;
use yii\rest\Controller;
use yii\web\Response;

// Created By @hoaaah * Copyright (c) 2020 belajararief.com

class DefaultController extends Controller
{

    public function behaviors()

    {

        $behaviors = parent::behaviors();


        $behaviors['contentNegotiator'] = [

            'class' => 'yii\filters\ContentNegotiator',

            'formats' => [

                'application/json' => Response::FORMAT_JSON,

            ]

        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        return [
            'status' => Status::STATUS_OK,
            'message' => "You may customize this page by editing the following file:" . __FILE__,
            'data' => ''
        ];
    }
}
