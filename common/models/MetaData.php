<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;

/**
 * This is the model class for table "meta_data".
 *
 * @property integer $id
 * @property string $linked_table
 * @property integer $linked_id
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property MetaDataI18n[] $metaDataI18ns
 */
class MetaData extends \yii\db\ActiveRecord
{
    const TYPE_TITLE = 1;
    const TYPE_KEYWORDS = 2;
    const TYPE_DESCRIPTION = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'meta_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['linked_id', 'type', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['linked_table'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'linked_table' => Yii::t('app', 'Linked Table'),
            'linked_id' => Yii::t('app', 'Linked ID'),
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => I18nBehavior::className(),
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetaDataI18ns()
    {
        return $this->hasMany(MetaDataI18n::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MetaDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MetaDataQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_TITLE => Yii::t('app', 'Meta Title'),
            self::TYPE_KEYWORDS => Yii::t('app', 'Meta Keywords'),
            self::TYPE_DESCRIPTION => Yii::t('app', 'Meta Description'),
        ];
    }

    /**
     * @param \yii\db\ActiveRecord $model
     * @return array|MetaData[]
     */
    public static function getModels(\yii\db\ActiveRecord $model)
    {
        $metadataModels = [];
        if (!$model->isNewRecord) {
            $metadataModels = MetaData::find()
                ->where('linked_table=:linked_table AND linked_id=:linked_id')
                ->indexBy('type')
                ->params([
                    ':linked_table' => $model->tableName(),
                    ':linked_id' => $model->id,
                ])->all();
        }

        $types = self::getTypes();

        foreach ($metadataModels as $key => $metadataModel) {
            if (!isset($types[$metadataModel->type])) {
                $metadataModel->delete();
                unset($metadataModels[$key]);
            }
        }

        foreach ($types as $typeId => $typeName) {
            if (!isset($metadataModels[$typeId])) {
                $metadataModel = new MetaData();
                $metadataModel->linked_table = $model->tableName();
                $metadataModel->linked_id = $model->id;
                $metadataModel->type = $typeId;
                $metadataModels[$typeId] = $metadataModel;
            }
        }

        return $metadataModels;
    }
}
