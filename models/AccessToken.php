<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * AccessToken Class for access_token table.
 * This is class to manage access_token than will be used in UserIdentity Class
 * UserIdentity class will find any token that active at current date and give Authorization based on access_token status
 *
 * @property integer $id
 * @property string $user_id
 * @property string $consumer
 * @property string $token
 * @property string $access_given
 * @property string $used_at
 * @property string $expire_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property float $tokenExpiration
 * @property string $defaultAccessGiven
 * @property integer $defaultConsumer
 *
 *
 * @author Heru Arief Wijaya @2020
 *
 */
class AccessToken extends ActiveRecord
{
    public float $tokenExpiration = 0.5 * 60 * 60; // in seconds
    public string $defaultAccessGiven = '{"access":["read"]}';
    public string $defaultConsumer = 'mobile';

    /**
     * Declares the name of the database table associated with this AR class
     *
     * @return string
     */
    public static function tableName()
    {
        return 'access_token';
    }

    /**
     * Generate new access_token that will be used at Authorization
     *
     * @param object $user the User Object (User::findOne($id))
     */
    public static function generateAuthKey(object $user)
    {
        // $this->auth_key = Yii::$app->security->generateRandomString();
        $accessToken = @AccessToken::findOne(['user_id' => $user->id]) ?: new AccessToken();
        $accessToken->user_id = $user->id;
        $accessToken->consumer = $user->consumer ?? $accessToken->defaultConsumer;
        $accessToken->access_given = $user->access_given ?? $accessToken->defaultAccessGiven;
        $accessToken->token = $user->auth_key;
        $accessToken->used_at = strtotime("now");
        $accessToken->expire_at = $accessToken->tokenExpiration + $accessToken->used_at;
        $accessToken->save();
    }

    /**
     * Make all user token based on any user_id expired
     *
     * @param int $userId
     */
    public static function makeAllUserTokenExpiredByUserId(int $userId)
    {
        AccessToken::updateAll(['expire_at' => strtotime("now")], ['user_id' => $userId]);
    }

    /**
     * Expire any access_token
     *
     * @return bool
     */
    public function expireThisToken(): bool
    {
        $this->expire_at = strtotime("now");
        return $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'used_at', 'expire_at', 'created_at', 'updated_at'], 'integer'],
            [['token'], 'required'],
            [['access_given'], 'string'],
            [['consumer'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 32],
            [['token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'consumer' => 'Consumer',
            'token' => 'Token',
            'access_given' => 'Access Given',
            'used_at' => 'Used At',
            'expire_at' => 'Expire At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }
}