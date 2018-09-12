<?php

namespace frontend\controllers;

use backend\models\LiveChat;
use backend\models\LiveChatDialog;
use Yii;
use yii\web\Controller;
use common\models\CreditApplication;
use common\models\Product;
use common\models\ProductMake;
use common\helpers\Url;
use common\models\Callback;
use yii\web\Response;
use yii\web\Cookie;
use yii\web\CookieCollection;
use common\models\User;
use backend\models\LiveChatModel;
use common\helpers\User as UserHelper;
use yii\helpers\Json;

/**
 * Tools controller
 */
class ToolsController extends Controller
{
    public $layout = 'new-index';
    public $bodyClass;
    private $chat_guest_id;

    public function beforeAction($action)
    {

        /*
         * ToDo: проверка на уникальность
         */
        if (!isset($_COOKIE['chat_guest_id'])) {
            setcookie('chat_guest_id', Yii::$app->getSecurity()->generateRandomString(32), time() + (86400 * 3000), "/");
        } else {
            $this->chat_guest_id = $_COOKIE['chat_guest_id'];
        }

        Url::remember('/account/index', 'previous');

        return parent::beforeAction($action);
    }

    /**
     * @return index
     */
    public function actionCalculator()
    {

        return $this->render('calculator', [
        ]);
    }

    /**
     * @return callback
     */
    public function actionCallback()
    {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $requests = Yii::$app->request->post();

            $model = new Callback();
            if ($model->load($requests) && $model->save()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'failed'];
            }
        } else {
            if (Yii::$app->user->isGuest) {
                $username = null;
                $blockIntroduceYourself = true;
                $userName = LiveChat::find()->where(['user_id' => $this->chat_guest_id])->one()->user_name;
                if ($userName !== null) {
                    $username = $userName;
                    $blockIntroduceYourself = false;
                }

                $site_user_id = null;
                $avatarUrl = 'https://backend.automechta.by/images/noavatar.png';
            } else {
                $user = User::findOne(Yii::$app->user->identity->id);
                $username = $user->first_name . ' ' . $user->last_name;
                $site_user_id = Yii::$app->user->identity->id;
                $avatarUrl = UserHelper::getAvatarUrl(Yii::$app->user->id);
                if ($avatarUrl == null) {
                    $avatarUrl = 'https://backend.automechta.by/images/noavatar.png';
                }
            }

            $model = new LiveChatModel($this->chat_guest_id);
            $model->getDialog();

            return $this->render('callback', [
                'dialog' => $model->dialog,
                'blockIntroduceYourself' => $blockIntroduceYourself,
                'site_user_id' => $site_user_id,
                'username' => $username,
                'avatarUrl' => $avatarUrl
            ]);
        }
    }

    /**
     * @return index
     */
    public function actionCreditApplication($id = null)
    {


        $model = new CreditApplication();
        $model->detachBehavior('BlameableBehavior');

        $user = Yii::$app->user;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($user->isGuest) {
                $model->created_by = 1;
            }

            if ($model->save()) {
                Yii::$app->redis->executeCommand('PUBLISH', [
                    'channel' => 'notification',
                    'message' => Json::encode(['message' => 'Заявка на кредит'])
                ]);
            }

            if (!Yii::$app->request->isAjax) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'The application is accepted and will be considered as soon as possible. Thank you.'));

                return $this->redirect(['/tools/credit-application']);
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ['status' => 'success'];
            }
        } else {
            if ($id != null) {
                $product = Product::findOne($id);
                if ($product != null) {
                    $model->product = $product->getFullTitle() . ' (' . Url::UrlShowProduct($product->id) . ')';
                    $model->credit_amount = $product->getByrPrice();
                }
            }

            $this->bodyClass = 'credit-application';

            return $this->render('creditApplication', [
                'model' => $model
            ]);
        }
    }

}
