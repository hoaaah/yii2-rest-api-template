<?php

namespace app\models;

use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;

/**
 * UserIdentity class for "user" table.
 * This is a base user class that is implementing IdentityInterface.
 * User model should extend from this model, and other user related models should
 * extend from User model.
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $consumer
 * @property string $access_given
 * @property string $account_activation_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserIdentity extends ActiveRecord implements IdentityInterface
{
    public string $consumer;

    /**
     * Declares the name of the database table associated with this AR class.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

//------------------------------------------------------------------------------------------------//
// IDENTITY INTERFACE IMPLEMENTATION
//------------------------------------------------------------------------------------------------//

    /**
     * Finds an identity by the given ID.
     *
     * @param int|string $id The user id.
     * @return IdentityInterface|static
     */
    public static function findIdentity($id): IdentityInterface|static
    {
        return static::findOne(['id' => $id, 'status' => User::STATUS_ACTIVE]);
    }

    /**
     * Finds an identity by the given access token.
     *
     * @param mixed $token
     * @param null $type
     * @return ActiveRecord|array
     */
    public static function findIdentityByAccessToken($token, $type = null): array|ActiveRecord
    {
        $accessToken = AccessToken::find()->where(['token' => $token])->andWhere(['>', 'expire_at', strtotime('now')])->one();
        if (!$accessToken) return $accessToken;
        return User::findOne(['id' => $accessToken->user_id, 'status' => User::STATUS_ACTIVE]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     *
     * @return int|mixed|string
     */
    public function getId(): mixed
    {
        return $this->getPrimaryKey();
    }

    /**
     * Returns a key that can be used to check the validity of a given
     * identity ID. The key should be unique for each individual user, and
     * should be persistent so that it can be used to check the validity of
     * the user identity. The space of such keys should be big enough to defeat
     * potential identity attacks.
     *
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * @param string $authKey The given auth key.
     * @return boolean          Whether the given auth key is valid.
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

//------------------------------------------------------------------------------------------------//
// IMPORTANT IDENTITY HELPERS
//------------------------------------------------------------------------------------------------//

    /**
     * Generates "remember me" authentication key.
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
        AccessToken::generateAuthKey($this);
    }

    /**
     * Validates password.
     *
     * @param string $password
     * @return bool
     *
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     *
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function setPassword(string $password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

}
