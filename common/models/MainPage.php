<?php

namespace common\models;
use common\models\Uploads as UploadsModel;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;

use Yii;

/**
 * This is the model class for table "main_page".
 *
 * @property integer $id
 * @property string $data_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $data_val
 *
 * @property MainPageI18n[] $mainPageI18ns
 */
class MainPage extends \yii\db\ActiveRecord
{
    /**
     * @var array
     */
    public static $fields;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data_val'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => I18nBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'data_key' => Yii::t('app', 'Data Key'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'data_val' => Yii::t('app', 'Data Val'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainPageI18ns()
    {
        return $this->hasMany(MainPageI18n::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MainPageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MainPageQuery(get_called_class());
    }

    /**
     * @return AppData[]
     */
    public static function getModels()
    {
        self::cleanData();
        $models = [];
        foreach (self::getFields() as $fieldKey => $fieldData) {
            $model = self::find()->where('data_key=:data_key', [':data_key' => $fieldKey])->one();
            if ($model === null) {
                $model = new self();
                $model->data_key = $fieldKey;
            } else {
                if ($fieldData['i18n']) {
                    //todo create empty values?
                } else {
                    MainPageI18n::deleteAll('parent_id='.$model->id);
                }
            }
            $models[] = $model;
        }
        return $models;
    }

    /**
     * @throws \Exception
     */
    public static function cleanData()
    {
        $models = self::find()->all();
        foreach($models as $model) {
            if (!isset(self::getFields()[$model->data_key])) {
                $model->delete();
            }
        }
    }


    public static function getFields()
    {
        if (self::$fields === null) {
            self::$fields = [
                'mainPageTeaserTitle' => [
                    'i18n' => true,
                    'widget' => 'input',
                    'label' => Yii::t('app', 'First Title'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                'mainPageTeaserHeader' => [
                    'i18n' => true,
                    'widget' => 'input',
                    'label' => Yii::t('app', 'Header'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                'mainPageTeaserCaption' => [
                    'i18n' => true,
                    'widget' => 'textarea',
                    'label' => Yii::t('app', 'Caption'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                    'options' => ['class'=>'js-wysiwyg'],
                ],
                //teaser 1
                'mainPageTeaser1title' => [
                    'i18n' => true,
                    'widget' => 'input',
                    'label' => Yii::t('app', 'Teaser 1 title'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                'mainPageTeaser1url' => [
                    'i18n' => true,
                    'widget' => 'input',
                    'label' => Yii::t('app', 'Teaser 1 url'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                'mainPageTeaser1image' => [
                    'i18n' => false,
                    'widget' => 'upload',
                    'label' => 'Main Page Teaser 1 image',
                    'upload_id' => 1,
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                //teaser 2
                'mainPageTeaser2title' => [
                    'i18n' => true,
                    'widget' => 'input',
                    'label' => Yii::t('app', 'Teaser 2 title'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                'mainPageTeaser2url' => [
                    'i18n' => true,
                    'widget' => 'input',
                    'label' => Yii::t('app', 'Teaser 2 url'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                'mainPageTeaser2image' => [
                    'i18n' => false,
                    'widget' => 'upload',
                    'label' => 'Main Page Teaser 2 image',
                    'upload_id' => 2,
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                //teaser 3
                'mainPageTeaser3title' => [
                    'i18n' => true,
                    'widget' => 'input',
                    'label' => Yii::t('app', 'Teaser 3 title'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                'mainPageTeaser3url' => [
                    'i18n' => true,
                    'widget' => 'input',
                    'label' => Yii::t('app', 'Teaser 3 url'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                'mainPageTeaser3image' => [
                    'i18n' => false,
                    'widget' => 'upload',
                    'label' => 'Main Page Teaser 3 image',
                    'upload_id' => 3,
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                //teaser 4
                'mainPageTeaser4title' => [
                    'i18n' => true,
                    'widget' => 'input',
                    'label' => Yii::t('app', 'Teaser 4 title'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                'mainPageTeaser4url' => [
                    'i18n' => true,
                    'widget' => 'input',
                    'label' => Yii::t('app', 'Teaser 4 url'),
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
                'mainPageTeaser4image' => [
                    'i18n' => false,
                    'widget' => 'upload',
                    'label' => 'Main Page Teaser 4 image',
                    'upload_id' => 4,
                    'group' =>  Yii::t('app', 'Main Page Teaser'),
                ],
            ];
        }
        return self::$fields;
    }

    /**
     * @return array
     */
    public static function getData()
    {
        $result = [];
        $models = self::find()->all();
        foreach($models as $model) {
            if (self::getFields()[$model->data_key]['widget'] === 'upload') {
                $upload = UploadsModel::find()
                    ->where('linked_table=:linked_table AND linked_id=:linked_id')
                    ->params([':linked_table'=>$model->tableName(), ':linked_id' => self::getFields()[$model->data_key]['upload_id']])
                    ->one();
                $result[$model->data_key] = $upload;
            } else {
                if (self::getFields()[$model->data_key]['i18n']) {
                    $result[$model->data_key] = $model->i18n()->data_val;
                } else {
                    $result[$model->data_key] = $model->data_val;
                }
            }
        }

        foreach (array_diff_key(self::getFields(), $result) as $emptyDataKey => $emptyDataValue) {
            if (self::getFields()[$model->data_key]['widget'] !== 'upload') {
                $result[$emptyDataKey] = '';
            }
        }

        return $result;
    }
}
