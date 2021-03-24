<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    //    public $subject;
    public $body;
    public $file;
    public $agree;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            //            [['subject'], 'required', 'message' => 'Необходимо выбрать тему'],
            //            [['subject'], 'in', 'range' => [1,2,3,4,5] ,'message' => 'Необходимо выбрать тему'],
            [['name', 'email', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            ['file', 'file'],
            ['agree', 'compare', 'compareValue' => 1],
            // verifyCode needs to be entered correctly
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'E-mail',
            'body' => 'Текст',
            'agree' => '',
            //            'subject' => 'Тема',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($zakaz = null, $subject = '')
    {
        if ($this->validate()) {
            if (!$zakaz) {
                $email = Yii::$app->settings->get('Settings.adminEmail');
            } else {
                $email = Yii::$app->settings->get('Settings.sellEmail');
            }

            $file = UploadedFile::getInstance($this, 'file');

            if (\Yii::$app->settings->get('Settings.smtpEmail') && \Yii::$app->settings->get('Settings.smtpHost') == 'smtp.yandex.ru') {
                $mail = Yii::$app->mailer->compose()
                    ->setTo($email)
                    ->setFrom(\Yii::$app->settings->get('Settings.smtpEmail'))
                    ->setSubject($subject)
                    ->setTextBody('От: ' . $this->email . "\n" .  $this->body);
            } else {
                $mail = Yii::$app->mailer->compose()
                    ->setTo($email)
                    ->setFrom(\Yii::$app->settings->get('Settings.adminEmail'))
                    ->setSubject($subject)
                    ->setTextBody('От: ' . $this->email . "\n" .  $this->body);
            }



            if ($file) {
                $mail->attach($file->tempName, ['fileName' => $file->name]);
            }
            $mail->send();

            return true;
        }
        return false;
    }
}
