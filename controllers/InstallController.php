<?php

namespace app\controllers;

use app\models\ConfigureForm;
use app\models\user\RegistrationForm;
use Yii;
use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\base\InvalidRouteException;
use yii\console\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class InstallController
 * @package app\controllers
 */
class InstallController extends Controller
{
    /**
     * @var string
     */
    public $defaultAction = 'prompt';

    /**
     * Just a regular ass view, where I placed an Install button
     * @return string
     */
    public function actionPrompt()
    {
        return $this->render('prompt');
    }

    /**
     * This is where we ask for the db info
     * @return string|Response
     */
    public function actionConfigure()
    {
        $model = new ConfigureForm();

        if ($model->load(Yii::$app->request->post())) {

            $output = $this->renderPartial('env_template', [
                'params' => $model->attributes
            ]);

            if (file_put_contents(Yii::getAlias('@app/.env'), $output)) {
                return $this->redirect('/install/install');
            }
        }
        return $this->render('configure', [
            'model' => $model
        ]);
    }

    /**
     * @return Response
     * @throws Exception
     * @throws InvalidConfigException
     * @throws InvalidRouteException
     */
    public function actionInstall()
    {

        if (!Yii::$app->installer->dbOk) {
            Yii::$app->session->setFlash('danger', 'We could not connect to the database.');
            return $this->redirect('/install/configure');
        }

        ob_start();
        Yii::$app->installer->install();
        ob_end_clean();

        return $this->redirect('/user/register');
    }
}