<?php

namespace app\helpers;

use Yii;
use yii\base\NotSupportedException;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Class AuthMethodsFromParamsHelper provide useful method to create your compositeAuth authMethods from application parameter
 * 
 * @author Heru Arief Wijaya @ 2020
 */
class AuthMethodsFromParamsHelper
{
    /**
     * Give array of authMethods from params.php
     * the result of AuthMethodsFromParamsHelper::authMethods would be like following
     * ```php
     * [
     *      Http:BasicAuth::class,
     *      HttpBearerAuth::class,
     *      QueryParamAuth::class,
     * ]
     * ```
     * 
     * @return array the array representation of the object
     */
    public static function authMethods(){
        $methods = new self();
        return $methods->getAuthMethods();
    }

    /**
     * Give array of authMethods from params.php
     * the result of $this->getAuthMethods would be like following
     * ```php
     * [
     *      Http:BasicAuth::class,
     *      HttpBearerAuth::class,
     *      QueryParamAuth::class,
     * ]
     * ```
     * 
     * @return array the array representation of the object
     */
    private function getAuthMethods(){
        $authMethodsArray = null;
        if(Yii::$app->params['useHttpBasicAuth']) $authMethodsArray[] = HttpBasicAuth::class;
        if(Yii::$app->params['useHttpBearerAuth']) $authMethodsArray[] = HttpBearerAuth::class;
        if(Yii::$app->params['useQueryParamAuth']) $authMethodsArray[] = QueryParamAuth::class;
        if($authMethodsArray == null) throw new NotSupportedException('You must choose at least one auth methods, configure your app\config\params.php for more options.');
        return $authMethodsArray;
    }
}