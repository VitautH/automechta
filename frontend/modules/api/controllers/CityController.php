<?

namespace frontend\modules\api\controllers;

use Yii;
use yii\base\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\db\Query;
use common\models\Product;
use common\models\City;
use yii\helpers\ArrayHelper;

class CityController extends Controller
{
    public function actionCity()
    {
        if (Yii::$app->request->isAjax) {
            $params = Yii::$app->request->get();
            $regionId = $params['regionId'];
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = City::find()->select(['id', 'city_name'])->where(['region' => $regionId])->asArray()->orderBy('city_name')->all();

            return $result;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

}