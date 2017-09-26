<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\AppData;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $id;
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['id'], 'integer'],
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Message'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        $message = "От: " . $this->name . PHP_EOL .
            "Тема: " . $this->subject . PHP_EOL .
            "Email: " . $this->email . PHP_EOL .
            "Текст сообщения: " . PHP_EOL .
            $this->body;

        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom(AppData::getData()['supportEmail'])
            ->setSubject($this->subject)
            ->setTextBody($message)
            ->send();
    }
}
