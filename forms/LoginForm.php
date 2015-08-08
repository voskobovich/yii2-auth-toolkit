<?php

namespace voskobovich\auth\forms;

use voskobovich\auth\interfaces\UserAuthInterface;
use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;


/**
 * LoginForm is the model behind the login form.
 */
abstract class LoginForm extends Model
{
    /**
     * Email
     * @var string
     */
    public $email;

    /**
     * Password
     * @var string
     */
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword()) {
                $this->addError($attribute, Yii::t('loginForm', 'Incorrect email or password'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            'email',
            'password',
        ];
    }

    /**
     * Finds user by [[email]]
     *
     * @return UserAuthInterface|IdentityInterface|null
     */
    abstract public function getUser();

    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    abstract public function login();
}
