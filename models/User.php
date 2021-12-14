<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "USER".
 *
 * @property int $IDUSER
 * @property string $EMAIL
 * @property string $PASSWORD
 * @property string $DATECREATION
 * @property string $TOKEN
 * @property string $AUTHKEY
 * @property string $NOM
 * @property string $ROLE
 * @property string $INITIAL
 * @property int $NIVEAU
 * @property int $DIRECTION
 * @property int $DEPARTEMENT
 * @property int $SERVICE
 */
class USER extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'USER';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EMAIL', 'NOM','INITIAL','NIVEAU'], 'required'],
            [['EMAIL'],'unique'],
            [['DATECREATION','ROLE','AUTHKEY','INITIAL','DIRECTION','DEPARTEMENT','SERVICE'], 'safe'],
            [['EMAIL'], 'string', 'max' => 50],
            [['PASSWORD'], 'string', 'max' => 200],
            [['TOKEN', 'NOM'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IDUSER' => 'Iduser',
            'EMAIL' => 'Email',
            'PASSWORD' => 'Mot de passe',
            'DATECREATION' => 'Date de création',
            'TOKEN' => 'Token',
            'NOM' => 'Nom',
            'INITIAL' => 'Initial',
            'NIVEAU' => 'Niveau d\'accès',
            'DIRECTION' => 'Direction',
            'DEPARTEMENT' => 'Département',
            'SERVICE' => 'Service'
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.

        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.

        return static::findOne(['TOKEN'] == $token);
    }

    public static function findByPasswordResetToken($token)

    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'TOKEN' => $token,
        ]);

    }


    public function generatePasswordResetToken()

    {
        $this->TOKEN = Yii::$app->security->generateRandomString() . '_' . time();

    }

    /**
     * Removes password reset token
     */

    public function removePasswordResetToken()

    {
        $this->TOKEN = null;

    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);

        $expire = 3600;

        return $timestamp + $expire >= time();
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        //$this->password = Yii::$app->security->generatePasswordHash($password);

        $this->PASSWORD = $password;
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.

        return $this->getPrimaryKey();
    }


    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.

        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */

    public static function findByUsername($username)

    {
        return static::findOne(['EMAIL' => $username]);
    }


    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */

    public function validatePassword($password,$hash)

    {
        return $this->PASSWORD === sha1($password);

       /* if (Yii::$app->getSecurity()->validatePassword($password, $hash)) {

            return true;

        } else {

            return false;
        }*/

    }


    /**
     * Generates new password reset token
     */


    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            // Place your custom code here

            if($this->isNewRecord) {

                if($this->ROLE == "R3") $this->NIVEAU = 1;
                else $this->NIVEAU = 2;

                $this->PASSWORD = sha1($this->PASSWORD);
                $this->DATECREATION = date("Y-m-d H:i:s");
                $this->AUTHKEY = \Yii::$app->security->generateRandomString();

            } else{

                $current = $this->findByUsername($this->EMAIL);

                if($current->PASSWORD != $this->PASSWORD) {

                    $this->PASSWORD = sha1($this->PASSWORD);

                }

            }

            return true;

        } else {

            return false;
        }

    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }
}
