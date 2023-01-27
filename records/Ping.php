<?php

namespace app\records;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "ping".
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $batch
 * @property string|null $handle
 * @property string|null $title
 * @property int|null $count
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Ping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ping';
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['batch', 'handle', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'batch' => 'Batch',
            'handle' => 'Handle',
            'title' => 'Title',
            'count' => 'Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public static function generateHourSplitBatch(){

        $base = date('YmdH').'::';
        $minVariant = intval(date('i')) > 30 ? '1' : '0';

        return base64_encode($base.$minVariant);
    }
}
