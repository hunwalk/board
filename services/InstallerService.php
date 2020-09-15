<?php

namespace app\services;

use yii\base\Component;

class InstallerService extends Component
{
    public $version;

    public $installerEnabled = false;

    public $recommendInstall = false;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        $config = json_decode(file_get_contents(\Yii::getAlias('@app/board.json')));

        //assigning values to props found in json
        foreach ($config as $key => $value){
            if ($this->hasProperty($key)){
                $this->$key = $value;
            }
        }

        try {
            \Yii::$app->db->getTableSchema('{{%user}}');
        }catch (\Exception $e){

            // If the connection has not been established yet, installing will be recommended
            if ($this->installerEnabled){
                $this->recommendInstall = true;
            }

        }
    }

    public function install()
    {

    }
}