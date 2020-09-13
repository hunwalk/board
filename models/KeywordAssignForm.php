<?php

namespace app\models;

use yii\base\Model;

/**
 * Class KeywordAssignForm
 * @package app\models
 *
 * @property int $alert_id
 * @property int $keyword_id
 */
class KeywordAssignForm extends Model
{
    /**
     * @var int $alert_id
     */
    public $alert_id;

    /**
     * @var int $keyword_id
     */
    public $keyword_id;

    public function rules()
    {
        return [
            [['alert_id', 'keyword_id'], 'safe']
        ];
    }

}