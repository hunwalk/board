<?php

namespace app\records;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "alert".
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $title
 * @property string|null $body
 * @property string|null $format
 * @property string|null $type
 * @property string|null $sender
 * @property string|null $created_at
 * @property-read string[] $types
 * @property string|null $updated_at
 *
 * @property-read Project|null $project
 * @property-read Keyword[] $keywords
 */
class Alert extends \yii\db\ActiveRecord
{

    const TYPE_JSON = 'json';

    const TYPE_HTML = 'html';

    const TYPE_TEXT = 'text';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getTypes()
    {
        return [
            self::TYPE_JSON => 'JSON'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alert';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id'], 'integer'],
            [['created_at', 'updated_at', 'type'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project ID'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function render(){
        return Yii::$app->view->render('@app/views/alert/_alert',[
            'model' => $this
        ]);
    }

    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    public function getKeywords()
    {
        return $this->hasMany(Keyword::class, ['id' => 'keyword_id'])
            ->viaTable('{{%alert_keyword}}', ['alert_id' => 'id']);
    }
}
