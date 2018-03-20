<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 02.03.2018
 * Time: 15:50
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\Product;

class Bookmarks extends \yii\db\ActiveRecord
{
//    public $user_id;
//    public $product_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bookmarks';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            'BlameableBehavior' => [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'integer'],
            [['user_id', 'product_id'], 'required'],
        ];
    }
//
//    public function getProducts()
//    {
//        return $this->hasMany(Product::className(), ['id' => $this->product_id])->all();
//    }
}