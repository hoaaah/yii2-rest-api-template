<?php
namespace app\modules\v1\controllers;

use app\models\Status;
use yii\rest\Controller;

// Created By @hoaaah * Copyright (c) 2020 belajararief.com

class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return [
            'status' => Status::STATUS_OK,
            'message' => "You may customize this page by editing the following file:". __FILE__,
            'data' => ''
        ];
    }
}
