<?php

namespace app\records;

use Yii;

/**
 * This is the model class for table "keyword".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $color
 * @property string|null $textColor
 * @property-read Alert[] $alerts
 */
class Keyword extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keyword';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'color', 'textColor'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'color' => Yii::t('app', 'Color'),
            'textColor' => Yii::t('app', 'Text Color'),
        ];
    }

    public function render()
    {
        return Yii::$app->view->render('@app/views/keyword/_keyword', [
            'model' => $this
        ]);
    }

    public function getAlerts()
    {
        return $this->hasMany(Alert::class, ['id' => 'alert_id'])
            ->viaTable('{{%alert_keyword}}',['keyword_id' => 'id']);
    }
}
