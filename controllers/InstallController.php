<?php

namespace app\controllers;

use app\models\ConfigureForm;
use Yii;
use yii\console\controllers\MigrateController;
use yii\web\Controller;

class InstallController extends Controller
{
    public $defaultAction = 'prompt';

    public function actionPrompt()
    {
        return $this->render('prompt');
    }

    public function actionConfigure()
    {
        $model = new ConfigureForm();

        if ($model->load(\Yii::$app->request->post())){

            $output = $this->renderPartial('env_template',[
                'params' => $model->attributes
            ]);

            if (file_put_contents(\Yii::getAlias('@app/.env'),$output)){
                return $this->redirect('/install/install');
            }
        }
        return $this->render('configure',[
            'model' => $model
        ]);
    }

    public function actionInstall()
    {
        $oldApp = \Yii::$app;
        // Load Console Application config
        $config = require \Yii::getAlias('@app'). '/config/console.php';
        new \yii\console\Application($config);

        $result = \Yii::$app->runAction('migrate-user', ['migrationPath' => '@vendor/dektrium/yii2-user/migrations', 'interactive' => false]);
        \Yii::$app = $oldApp;

        dump($result);
        exit;
    }

    /**
     * TODO: delete this, when installer is finished
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionTest()
    {
        if(!defined('STDIN'))  define('STDIN',  fopen('php://stdin',  'rb'));
        if(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'wb'));
        if(!defined('STDERR')) define('STDERR', fopen('php://stderr', 'wb'));

        /** @var MigrateController $migrateController */
        $migrateController = Yii::createObject('yii\console\controllers\MigrateController',['migrate-user',$this]);
        $migrateController->migrationPath = '@vendor/dektrium/yii2-user/migrations';

        $result = $migrateController->runAction('up',['interactive' => 0]);
        dump($result);
        exit;
    }
}