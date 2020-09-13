<?php

namespace app\records;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $logo
 * @property string|null $origin
 * @property int|null active
 * @property int|null remote_keyword_creation
 * @property string|null $api_push_key
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile image
     */
    public $image;

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
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active', 'remote_keyword_creation'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'logo', 'api_push_key', 'origin'], 'string', 'max' => 255],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert))
            return false;

        if ($this->image){
            if ($this->uploadImage()){
                $this->logo = '/uploads/logo/' . $this->image->baseName . '.' . $this->image->extension;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'logo' => Yii::t('app', 'Logo'),
            'api_push_key' => Yii::t('app', 'Api Push Key'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function uploadImage()
    {
        if ($this->validate()) {
            return $this->image->saveAs(Yii::getAlias('@webroot/').'/uploads/logo/' . $this->image->baseName . '.' . $this->image->extension);
        } else {
            return false;
        }
    }
}
