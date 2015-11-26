<?php

namespace voskobovich\auth\forms;

use voskobovich\auth\interfaces\AuthLoginFormInterface;
use voskobovich\auth\interfaces\AuthUserInterface;
use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;


/**
 * LoginForm is the model behind the login form.
 */
abstract class LoginForm extends Model implements AuthLoginFormInterface
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
            if (!$user || !$user->validatePassword($this->password)) {
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
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $result = Yii::$app->user->login($this->getUser());
            if ($result) {
                $this->afterLogin();
            }
            return $result;
        }

        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return AuthUserInterface|IdentityInterface|null
     */
    abstract public function getUser();

    /**
     *
     */
    public function afterLogin()
    {
    }
}
