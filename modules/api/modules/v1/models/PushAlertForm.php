<?php

namespace app\modules\api\modules\v1\models;

use yii\base\Model;

/**
 * Class PushAlertForm
 * @package app\modules\api\modules\v1\models
 */
class PushAlertForm extends Model
{
    /**
     * @var string $apiPushKey
     */
    public $apiPushKey;

    /**
     * @var string $alertName
     */
    public $alertName;

    /**
     * @var string $alertBody
     */
    public $alertBody;

    /**
     * @var string $type
     */
    public $type;

    /**
     * @var array $keywords
     */
    public $keywords;

    /**
     * @var array $sender
     */
    public $sender;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['apiPushKey', 'alertName', 'alertBody', 'type', 'keywords', 'sender'], 'safe']
        ];
    }
}