<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use common\models\Complaint;
use backend\models\Dashboard;
use common\models\Callback;
use yii\helpers\Json;
use backend\models\LiveChat;
use backend\models\LiveChatRequest;
use backend\models\LiveChatResponse;
use backend\models\LiveChatDialog;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','chart'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $complaint = count(Complaint::find()->where(['=', 'viewed', 0])->all());
        $countProductMonth = Dashboard::getCountProductMonth();
        $countUserMonth = Dashboard::getCountUserMonth();
        $chartCreditApplicationMonth = Dashboard::chartCreditApplicationMonth();
        $daysOfMonth = Dashboard::getDaysOfMonth();
        $callback = Callback::find()->where(['viewed'=>Callback::NO_VIEWED])->count();
        $countChatNewMessage = LiveChatDialog::find()->where(['viewed'=>LiveChatDialog::NO_VIEWED])->count();

        return $this->render('index', [
            'complaint' => $complaint,
            'countProductMonth' => $countProductMonth,
            'countUserMonth' => $countUserMonth,
            'chartCreditApplicationMonth' => $chartCreditApplicationMonth,
            'daysOfMonth' => $daysOfMonth,
            'callback' => $callback,
            'countChatNewMessage'=>$countChatNewMessage
        ]);
    }
    public function actionChart()
    {
        $chartCreditApplicationMonth = Dashboard::chartCreditApplicationMonth();
        $daysOfMonth = Dashboard::getDaysOfMonth();

        return $this->render('chart', [
            'chartCreditApplicationMonth' => $chartCreditApplicationMonth,
            'daysOfMonth' => $daysOfMonth,
        ]);
    }
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
