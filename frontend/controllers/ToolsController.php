<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\CreditApplication;

/**
 * Tools controller
 */
class ToolsController extends Controller
{
    public $layout = 'index';
  

    /**
     * @return index
     */
    public function actionCalculator()
    {

        return $this->render('calculator', [
        ]);
    }

    /**
     * @return index
     */
    public function actionCreditApplication()
    {
        $model = new CreditApplication();
        $model->detachBehavior('BlameableBehavior');

        $user = Yii::$app->user;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($user->isGuest) {
                $model->created_by = 1;
            }
            $model->save();
            Yii::$app->session->setFlash('success',  Yii::t('app', 'The application is accepted and will be considered as soon as possible. Thank you.'));
            return $this->redirect(['/tools/credit-application']);
        } else {
            return $this->render('creditApplication', [
                'model' => $model,
            ]);
        }
    }

}
