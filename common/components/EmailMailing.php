<?php

namespace common\components;

use yii\base\Component;
use yii\mail\MailerInterface;
use yii\db\Command;
use common\models\User;
use common\models\MailingLists;
use common\models\AppData;
use Yii;

class EmailMailing implements MailingInterface
{
    protected $email;

    public function getAddress()
    {
        $this->email = $this->getEmailAddress();

        return $this;
    }

    /*
     * ToDo: шаблон письма!
     */
    public function sendMailing($mailingId)
    {
        $mailingList = MailingLists::find()->where(['id' => $mailingId])->one();
        $appData = AppData::getData();

        foreach ($this->email as $email) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom($appData['adminEmail'])
                ->setSubject($mailingList->title)
                ->setHtmlBody($mailingList->text)
                ->send();
            gc_collect_cycles();
        }
        $this->setStatus($mailingId, MailingLists::STATUS_DONE);

        return true;
    }

    public function setStatus($mailingId, $status)
    {
        $model = MailingLists::find()->where(['id' => $mailingId])->one();
        $model->status = $status;
        $model->save();
    }

    public function getStatus($mailingId)
    {
        $model = MailingLists::find()->where(['id' => $mailingId])->one();

        return $model->status;
    }

    protected function getEmailAddress()
    {
        $email = (new \yii\db\Query())
            ->select(['email'])
            ->from(User::tableName())
            ->where('source IS NULL')
            ->orWhere(['source' => 'yandex'])
            ->orWhere(['source' => 'google'])
            ->orWhere(['source' => 'facebook'])
            ->orWhere(['source' => 'Smith'])
            ->all();

        return $email;
    }
}