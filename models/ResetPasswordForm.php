<?php
/**
 * Created by PhpStorm.
 * User: Sumbang
 * Date: 31/12/2017
 * Time: 17:02
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            //throw new InvalidParamException('Password reset token cannot be blank.');
            Yii::$app->session->setFlash('error', 'Le mot de passe ne peut etre vide');
        }

        $this->_user = \app\models\User::findByPasswordResetToken($token);

        if (!$this->_user) {
            //throw new InvalidParamException('Wrong password reset token.');
            Yii::$app->session->setFlash('error', 'Token de reinitialisation incorrect');
        }

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
