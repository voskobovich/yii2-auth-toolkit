<?php

namespace voskobovich\auth\forms;

use voskobovich\auth\interfaces\AuthLoginFormInterface;
use voskobovich\auth\interfaces\AuthUserInterface;
use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;
use yii\web\User;


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
            $user = Yii::$app->user;
            $user->on(User::EVENT_BEFORE_LOGIN, [$this, 'beforeLogin']);
            $user->on(User::EVENT_AFTER_LOGIN, [$this, 'afterLogin']);
            return $user->login($this->getUser());
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
     * This method is called before logging in a user.
     * @param IdentityInterface $identity the user identity information
     * @return bool
     */
    public function beforeLogin($identity)
    {
        return true;
    }

    /**
     * This method is called after logging in a user.
     * @param IdentityInterface $identity the user identity information
     * @param boolean $cookieBased whether the login is cookie-based
     * @param integer $duration number of seconds that the user can remain in logged-in status.
     * If 0, it means login till the user closes the browser or the session is manually destroyed.
     * @return null
     */
    public function afterLogin($identity, $cookieBased, $duration)
    {
    }
}
