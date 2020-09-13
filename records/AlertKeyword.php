<?php

namespace app\records;

use Yii;

/**
 * This is the model class for table "alert_keyword".
 *
 * @property int $id
 * @property int|null $alert_id
 * @property int|null $keyword_id
 */
class AlertKeyword extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alert_keyword';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alert_id', 'keyword_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alert_id' => Yii::t('app', 'Alert ID'),
            'keyword_id' => Yii::t('app', 'Keyword ID'),
        ];
    }
}
