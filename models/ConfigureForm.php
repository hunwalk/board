<?php

namespace app\models;

use yii\base\Model;

/**
 * Class ConfigureForm
 * @package app\models
 */
class ConfigureForm extends Model
{
    public $dbHost = 'localhost';

    public $dbPort = '3306';

    public $dbName ;

    public $dbUser;

    public $dbPassword;

    public $dbDriver = 'mysql';

    public $dbCharset = 'utf8';

    public function rules()
    {
        return [
            [['dbHost', 'dbPort', 'dbName', 'dbPassword', 'dbUser', 'dbDriver', 'dbCharset'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'dbHost' => 'Host',
            'dbPort' => 'Port',
            'dbName' => 'Database name',
            'dbUser' => 'Username',
            'dbPassword' => 'Password',
            'dbDriver' => 'Database driver',
            'dbCharset' => 'Charset'
        ];
    }
}