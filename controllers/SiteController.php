<?php

namespace app\controllers;

use app\models\Post;
use app\models\User;
use app\models\Status;
use Yii;
use yii\rest\Controller;
use yii\web\ErrorAction;

/*
 * Created on Thu Feb 22 2018
 * By Heru Arief Wijaya
 * Copyright (c) 2018 belajararief.com
 */

class SiteController extends Controller
{    
    protected function verbs()
    {
       return [
           'signup' => ['POST'],
           'login' => ['POST'],
       ];
    }

    public function actionIndex()
    {
        $post = Post::find()->all();
        return [
            'status' => Status::STATUS_OK,
            'message' => 'Hello :)',
            'data' => $post
        ];
    }

    
    public function actionView($id)
    {
        $post = Post::findOne($id);
        return [
            'status' => Status::STATUS_FOUND,
            'message' => 'Data Found',
            'data' => $post
        ];
    }

    public function actionSignup()
    {
        $model = new User();
        $params = Yii::$app->request->post();
        if(!$params) {
            Yii::$app->response->statusCode = Status::STATUS_BAD_REQUEST;
            return [
                'status' => Status::STATUS_BAD_REQUEST,
                'message' => "Need username, password, and email.",
                'data' => ''
            ];
        }


        $model->username = $params['username'];
        $model->email = $params['email'];

        $model->setPassword($params['password']);
        $model->generateAuthKey();
        $model->status = User::STATUS_ACTIVE;

        if ($model->save()) {
            Yii::$app->response->statusCode = Status::STATUS_CREATED;
            $response['isSuccess'] = 201;
            $response['message'] = 'You are now a member!';
            $response['user'] = \app\models\User::findByUsername($model->username);
            return [
                'status' => Status::STATUS_CREATED,
                'message' => 'You are now a member',
                'data' => User::findByUsername($model->username),
            ];
        } else {
            Yii::$app->response->statusCode = Status::STATUS_BAD_REQUEST;
            $model->getErrors();
            $response['hasErrors'] = $model->hasErrors();
            $response['errors'] = $model->getErrors();
            return [
                'status' => Status::STATUS_BAD_REQUEST,
                'message' => 'Error saving data!',
                'data' => [
                    'hasErrors' => $model->hasErrors(),
                    'getErrors' => $model->getErrors(),
                ]
            ];
        }
    }

    public function actionLogin()
    {
        $params = Yii::$app->request->post();
        if(empty($params['username']) || empty($params['password'])) return [
            'status' => Status::STATUS_BAD_REQUEST,
            'message' => "Need username and password.",
            'data' => ''
        ];

        $user = User::findByUsername($params['username']);

        if ($user->validatePassword($params['password'])) {
            if(isset($params['consumer'])) $user->consumer = $params['consumer'];
            if(isset($params['access_given'])) $user->access_given = $params['access_given'];

            Yii::$app->response->statusCode = Status::STATUS_FOUND;
            $user->generateAuthKey();
            $user->save();
            return [
                'status' => Status::STATUS_FOUND,
                'message' => 'Login Succeed, save your token',
                'data' => [
                    'id' => $user->username,
                    'token' => $user->auth_key,
                    'email' => $user['email'],
                ]
            ];
        } else {
            Yii::$app->response->statusCode = Status::STATUS_UNAUTHORIZED;
            return [
                'status' => Status::STATUS_UNAUTHORIZED,
                'message' => 'Username and Password not found. Check Again!',
                'data' => ''
            ];
        }
    }
}