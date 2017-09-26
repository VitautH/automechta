<?php
namespace console\controllers;

use Yii;
use yii\helpers\Console;
use common\models\Product;
use common\models\User;
use common\models\AppData;

class CatalogController extends \yii\console\Controller
{
    protected $timeToSendNotification;
    protected $timeToUnpublish;

    public function actionUpdate()
    {
        $models = Product::find()->active()->andWhere('priority=0')->all();
        foreach ($models as $model) {
            $this->checkProduct($model);
        }
    }

    protected function checkProduct(Product $model)
    {
        $timeToSent = $this->getTimeToSendNotification();
        if ($model->updated_at < $this->getTimeToSendNotification()) {
            $this->sendNotification($model);
        }

        if ($model->updated_at < $this->getTimeToUnpublish()) {
            $this->unpublish($model);
        }
    }

    /**
     * @param $model
     * @return boolean
     */
    protected function sendNotification(Product $model)
    {
        $appData = AppData::getData();
        $user = User::find()->where('id='.$model->created_by)->one();
        $view = Yii::$app->getView();
        $text = $view->render('@frontend/views/emailTemplates/' . Yii::$app->language . '/catalogNotification', [
            'model' => $model,
            'user' => $user,
        ]);
        $subject = 'Сообщение с сайта' . ' ' . Yii::$app->name;

        $this->stdout("Product #{$model->id} - notification sent to {$user->email}.\n", Console::FG_YELLOW);

        return Yii::$app->mailer->compose()
            ->setTo($user->email)
            ->setFrom($appData['supportEmail'])
            ->setSubject($subject)
            ->setTextBody($text)
            ->send();
    }

    /**
     * @param $model
     */
    protected function unpublish(Product $model)
    {
        Yii::$app->db->createCommand()
            ->update($model->tableName(), ['status' => Product::STATUS_UNPUBLISHED], 'id=:id', [':id' => $model->id])
            ->execute();

        $this->stdout("Product #{$model->id} unpublished.\n", Console::FG_RED);
    }

    /**
     * @return int
     */
    protected function getTimeToSendNotification()
    {
        if ($this->timeToSendNotification === null) {
            $this->timeToSendNotification = time() - (12 * 24 * 60 * 60);
        }
        return $this->timeToSendNotification;
    }

    /**
     * @return int
     */
    protected function getTimeToUnpublish()
    {
        if ($this->timeToUnpublish === null) {
            $this->timeToUnpublish = time() - (14 * 24 * 60 * 60);
        }
        return $this->timeToUnpublish;
    }
}