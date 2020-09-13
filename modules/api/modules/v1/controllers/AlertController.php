<?php

namespace app\modules\api\modules\v1\controllers;

use app\modules\api\modules\v1\models\PushAlertForm;
use app\records\Alert;
use app\records\AlertKeyword;
use app\records\Keyword;
use app\records\Project;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class AlertController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Allow-Origin' => ['*'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
        ];
    }

    public function actionPullAny($lastAlertId)
    {
        $alert = Alert::find()->where(['>', 'id', $lastAlertId])->one();
        if ($alert){

            return [
                'alert' => $alert,
                'content' => $alert->render()
            ];
        }
        return null;
    }

    public function actionClearAll()
    {
        \Yii::$app->db->createCommand()->truncateTable('{{%alert_keyword}}')->execute();
        \Yii::$app->db->createCommand()->truncateTable('{{%alert}}')->execute();

        return null;
    }

    public function actionPush()
    {

        $model = new PushAlertForm();
        if ($model->load(\Yii::$app->request->post(),'')){

            $project = Project::find()->where(['api_push_key' => $model->apiPushKey])->one();

            if ($project && $project->active){

                $alert = new Alert();
                $alert->project_id = $project->id;
                $alert->title = $model->alertName;
                $alert->body = ArrayHelper::isIn($model->type,['error', 'json']) ? json_encode($model->alertBody) : $model->alertBody;
                $alert->type = $model->type;
                $alert->sender = json_encode($model->sender);
                $alert->save();

                foreach ($model->keywords as $keyword){

                    $keywordRecord = Keyword::find()->where(['name' => $keyword])->one();

                    if (!$keywordRecord && $project->remote_keyword_creation){
                        $keywordRecord = new Keyword();
                        $keywordRecord->name = $keyword;
                        $keywordRecord->color = '#000000';
                        $keywordRecord->textColor = '#ffffff';
                        $keywordRecord->save();
                    }

                    if ($keywordRecord){
                        $ak = new AlertKeyword();
                        $ak->alert_id = $alert->id;
                        $ak->keyword_id = $keywordRecord->id;
                        $ak->save();

                        return [
                            'status' => 200
                        ];
                    }
                }
            }
        }

        return [
            'status' => 400,
            'model' => $model
        ];
    }
}