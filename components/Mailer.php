<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 08.05.17
 * Time: 12:20
 */

namespace app\components;

use yii\base\Component;
use app\models\User;
use yii\helpers\Html;
use Yii;
use dektrium\user\models\Token;

class Mailer extends \dektrium\user\Mailer
{

    /** @var string */
    public $viewPath = '@dektrium/user/views/mail';

    /** @var string|array Default: `Yii::$app->params['adminEmail']` OR `no-reply@example.com` */
    public $sender;

    /** @var string */
    protected $welcomeSubject;

    /** @var string */
    protected $newPasswordSubject;

    /** @var string */
    protected $confirmationSubject;

    /** @var string */
    protected $reconfirmationSubject;

    /** @var string */
    protected $recoverySubject;

    /** @var \dektrium\user\Module */
    protected $module;

    /**
     * @return string
     */
    public function getWelcomeSubject()
    {
        if ($this->welcomeSubject == null) {
            $this->setWelcomeSubject(Yii::t('user', 'Welcome to {0}', Yii::$app->name));
        }

        return $this->welcomeSubject;
    }

    /**
     * @param string $welcomeSubject
     */
    public function setWelcomeSubject($welcomeSubject)
    {
        $this->welcomeSubject = $welcomeSubject;
    }

    /**
     * @return string
     */
    public function getNewPasswordSubject()
    {
        if ($this->newPasswordSubject == null) {
            $this->setNewPasswordSubject(Yii::t('user', 'Your password on {0} has been changed', Yii::$app->name));
        }

        return $this->newPasswordSubject;
    }

    /**
     * @param string $newPasswordSubject
     */
    public function setNewPasswordSubject($newPasswordSubject)
    {
        $this->newPasswordSubject = $newPasswordSubject;
    }

    /**
     * @return string
     */
    public function getConfirmationSubject()
    {
        if ($this->confirmationSubject == null) {
            $this->setConfirmationSubject(Yii::t('user', 'Confirm account on {0}', Yii::$app->name));
        }

        return $this->confirmationSubject;
    }

    /**
     * @param string $confirmationSubject
     */
    public function setConfirmationSubject($confirmationSubject)
    {
        $this->confirmationSubject = $confirmationSubject;
    }

    /**
     * @return string
     */
    public function getReconfirmationSubject()
    {
        if ($this->reconfirmationSubject == null) {
            $this->setReconfirmationSubject(Yii::t('user', 'Confirm email change on {0}', Yii::$app->name));
        }

        return $this->reconfirmationSubject;
    }

    /**
     * @param string $reconfirmationSubject
     */
    public function setReconfirmationSubject($reconfirmationSubject)
    {
        $this->reconfirmationSubject = $reconfirmationSubject;
    }

    /**
     * @return string
     */
    public function getRecoverySubject()
    {
        if ($this->recoverySubject == null) {
            $this->setRecoverySubject(Yii::t('user', 'Complete password reset on {0}', Yii::$app->name));
        }

        return $this->recoverySubject;
    }

    /**
     * @param string $recoverySubject
     */
    public function setRecoverySubject($recoverySubject)
    {
        $this->recoverySubject = $recoverySubject;
    }

    /** @inheritdoc */
    public function init()
    {
        $this->module = Yii::$app->getModule('user');
        parent::init();
    }

    public function sendWelcomeMessage(\dektrium\user\models\User $user, Token $token = NULL, $showPassword = false)
    {
        $subject = 'Вы успешно зарегистрировались';
        $body = \Yii::$app->settings->get('Settings.email_success');
        if ($token) {
            $body = str_replace('{%link%}', Html::a(Html::encode($token->url), $token->url), $body);
        }
        //if($showPassword || $this->module->enableGeneratingPassword){
        $body = str_replace('{%password%}', $user->password, $body);
        //}
        $this->sendEmail($user->email, $subject, $body);
    }

    /**
     * Sends a new generated password to a user.
     *
     * @param User  $user
     * @param Password $password
     *
     * @return bool
     */
    public function sendGeneratedPassword(\dektrium\user\models\User $user, $password)
    {
        return $this->sendMessage(
            $user->email,
            $this->getNewPasswordSubject(),
            'new_password',
            ['user' => $user, 'password' => $password, 'module' => $this->module]
        );
    }

    /**
     * Sends an email to a user with confirmation link.
     *
     * @param User  $user
     * @param Token $token
     *
     * @return bool
     */
    public function sendConfirmationMessage(\dektrium\user\models\User $user, $url)
    {
        $subject = 'Подтвердите Ваш e-mail';
        $body = \Yii::$app->settings->get('Settings.email_confirm');
        $body = str_replace('{%link%}', Html::a(Html::encode($url), $url), $body);
        $this->sendEmail($user->email, $subject, $body);
    }

    public function sendSuccessMessage(\dektrium\user\models\User $user)
    {
        $subject = 'Вы успешно зарегистрировались';
        $body = \Yii::$app->settings->get('Settings.email_confirm');
        $this->sendEmail($user->email, $subject, $body);
    }


    public function sendActivate(\dektrium\user\models\User $user)
    {
        //        $subject = 'Ваш аккаунт активирован';
        //        $body = \Yii::$app->settings->get('Settings.email_active');
        //        //$body = str_replace('{%link%}', Html::a(Html::encode($token->url), $token->url), $body);
        //        $this->sendEmail($user->email, $subject, $body);
    }

    public function sendBlock(\dektrium\user\models\User $user)
    {
        $subject = 'Ваш аккаунт заблокирован';
        $body = \Yii::$app->settings->get('Settings.email_block');
        $body = str_replace('{%comment%}', $user->profile->admins_comment, $body);
        $this->sendEmail($user->email, $subject, $body);
    }
    public function sendUnblock(\dektrium\user\models\User $user)
    {
        $subject = 'Ваш аккаунт разблокирован';
        $body = \Yii::$app->settings->get('Settings.email_unblock');
        //        $body = str_replace('{%comment%}', $user->profile->admins_comment, $body);
        $this->sendEmail($user->email, $subject, $body);
    }

    public function sendDelete(\dektrium\user\models\User $user)
    {
        $subject = 'Ваш аккаунт удален';
        $body = \Yii::$app->settings->get('Settings.email_delete');
        //        $body = str_replace('{%comment%}', $user->profile->admins_comment, $body);
        $this->sendEmail($user->email, $subject, $body);
    }
    public function sendOrder(\dektrium\user\models\User $user)
    {
        $subject = 'Ваш Заказ успешно оформлен и отправлен в Отдел Заказов';
        $body = \Yii::$app->settings->get('Settings.email_order');
        //        $body = str_replace('{%comment%}', $user->profile->admins_comment, $body);
        $this->sendEmail($user->email, $subject, $body);
    }

    /**
     * Sends an email to a user with reconfirmation link.
     *
     * @param User  $user
     * @param Token $token
     *
     * @return bool
     */
    public function sendReconfirmationMessage(\dektrium\user\models\User $user, Token $token)
    {
        if ($token->type == Token::TYPE_CONFIRM_NEW_EMAIL) {
            $email = $user->unconfirmed_email;
        } else {
            $email = $user->email;
        }

        return $this->sendMessage(
            $email,
            $this->getReconfirmationSubject(),
            'reconfirmation',
            ['user' => $user, 'token' => $token]
        );
    }

    /**
     * Sends an email to a user with recovery link.
     *
     * @param User  $user
     * @param Token $token
     *
     * @return bool
     */
    public function sendRecoveryMessage(\dektrium\user\models\User $user, Token $token)
    {
        return $this->sendMessage(
            $user->email,
            $this->getRecoverySubject(),
            'recovery',
            ['user' => $user, 'token' => $token]
        );
    }


    public function sendEmail($to, $subject, $body)
    {

        if (!$to) {
            return false;
        }
        if (\Yii::$app->settings->get('Settings.smtpEmail') && \Yii::$app->settings->get('Settings.smtpHost') == 'smtp.yandex.ru') {
            \Yii::$app->mailer->compose()
                ->setTo($to)
                ->setFrom(\Yii::$app->settings->get('Settings.smtpEmail'))
                ->setSubject($subject)
                ->setHtmlBody($body)
                ->send();
        } else {
            \Yii::$app->mailer->compose()
                ->setTo($to)
                ->setFrom(\Yii::$app->settings->get('Settings.adminEmail'))
                ->setSubject($subject)
                ->setHtmlBody($body)
                ->send();
        }
    }


    protected function sendMessage($to, $subject, $view, $params = [])
    {
        if (!$to) {
            return false;
        }
        /** @var \yii\mail\BaseMailer $mailer */
        $mailer = Yii::$app->mailer;
        $mailer->viewPath = $this->viewPath;
        $mailer->getView()->theme = Yii::$app->view->theme;

        if ($this->sender === null) {
            $this->sender = \Yii::$app->settings->get('Settings.adminEmail');
        }

        return $mailer->compose(['html' => $view, 'text' => 'text/' . $view], $params)
            ->setTo($to)
            ->setFrom($this->sender)
            ->setSubject($subject)
            ->send();
    }
}
