<?php

namespace app\controllers;

use app\models\Post;
use app\models\User;
use app\models\Status;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\rest\Controller;
use yii\web\ErrorAction;
use yii\web\Request;
use yii\web\Response;

/*
 * Created on Thu Feb 22 2018
 * By Heru Arief Wijaya
 * Copyright (c) 2018 belajararief.com
 */

class SiteController extends Controller
{

    public function behaviors(): array
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

    protected function verbs(): array
    {
        return [
            'signup' => ['POST'],
            'login' => ['POST'],
            'index' => ['GET'],
            'view' => ['POST']

        ];
    }

    public function actionIndex(): array
    {
        $post = Post::find()->all();
        return [
            'status' => Status::STATUS_OK,
            'message' => 'Hello :)',
            'data' => $post
        ];
    }


    public function actionView($id): array
    {
        $post = Post::findOne($id);

        return [
            'status' => ($post instanceof Post) ? Status::STATUS_FOUND : Status::STATUS_NOT_FOUND,
            'message' => ($post instanceof Post) ? Status::STATUS_SUCCESS : Status::STATUS_ERROR,
            'data' => $post
        ];
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function actionSignup(Request $request): array|string
    {
        $model = new User();
        $model->status = User::STATUS_ACTIVE;
        $response = [];
        $password = $request->post('password');
        $validatePasswordStrength = $model->validatePasswordStrength($password);
        if ($model->load($request->post()) and $model->validate() and $validatePasswordStrength['error']) {
            $response['status'] = Yii::$app->response->statusCode = Status::STATUS_BAD_REQUEST;
            $response['message'] = "Need username, password, and email.";
            $response['hasErrors'] = true;
            $response['errors'] = array_merge($model->getErrors(), $validatePasswordStrength['message']);
            return $response;
        }
        $model->setPassword($password);
        $model->generateAuthKey();
        if ($model->save()) {
            $response['status'] = Yii::$app->response->statusCode = Status::STATUS_CREATED;
            $response['isSuccess'] = 201;
            $response['message'] = 'You are now a member!';
            $response['user'] = $model->findByUsername($model->username);
            return $response;
        }
        $response['status'] = Yii::$app->response->statusCode = Status::STATUS_BAD_REQUEST;
        $response['message'] = 'Error saving your data';
        $response['hasErrors'] = $model->hasErrors();
        $response['errors'] = $model->getErrors();
        return $response;
    }

    public function actionLogin()
    {
        $params = Yii::$app->request->post();
        if (empty($params['username']) || empty($params['password'])) return [
            'status' => Status::STATUS_BAD_REQUEST,
            'message' => "Need username and password.",
            'data' => ''
        ];

        $user = User::findByUsername($params['username']);

        if ($user->validatePassword($params['password'])) {
            if (isset($params['consumer'])) $user->consumer = $params['consumer'];
            if (isset($params['access_given'])) $user->access_given = $params['access_given'];

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