<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\CreditApplication;
use common\models\Product;
use common\models\ProductMake;

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
    public function actionCreditApplication($id = null)
    {
        $model = new CreditApplication();
        $model->detachBehavior('BlameableBehavior');

        $user = Yii::$app->user;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($user->isGuest) {
                $model->created_by = 1;
            }
            $model->save();
            Yii::$app->session->setFlash('success', Yii::t('app', 'The application is accepted and will be considered as soon as possible. Thank you.'));
            return $this->redirect(['/tools/credit-application']);
        } else {
            if ($id != null) {
                $product = Product::findOne($id);
                if ($product != null) {
                    $model->product = $product->getFullTitle().' ('. Yii::$app->urlManager->createAbsoluteUrl(['catalog/show', 'id' => $product->id]).')';
                    $model->credit_amount = $product->getByrPrice();
                }
            }
            return $this->render('creditApplication', [
                'model' => $model
            ]);
        }
    }

}
