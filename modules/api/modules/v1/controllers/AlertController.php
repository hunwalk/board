<?php

namespace app\modules\api\modules\v1\controllers;

use app\modules\api\modules\v1\models\PingForm;
use app\modules\api\modules\v1\models\PushAlertForm;
use app\records\Alert;
use app\records\AlertKeyword;
use app\records\Keyword;
use app\records\Ping;
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

    /**
     * This method if called creates empty missing batches for existing pings by handle
     */
    public function actionCronPing(){
        $projects = Project::find()->all();
        foreach ($projects as $project){

            $pingsByHandle = Ping::find()->where(['project_id' => $project->id])->groupBy('handle')->all();

            foreach ($pingsByHandle as $ping){

                $batch = Ping::generateHourSplitBatch();
                $handle = $ping->handle;

                $pingCheck = Ping::find()->where(['batch' => $batch, 'handle' => $handle, 'project_id' => $project->id])->one();

                if (!$pingCheck){
                    $dummy_ping = new Ping();
                    $dummy_ping->project_id = $project->id;
                    $dummy_ping->handle = $ping->handle;
                    $dummy_ping->batch = Ping::generateHourSplitBatch();
                    $dummy_ping->count = 0;
                    $dummy_ping->save();
                }
            }
        }
    }

    public function actionGetPings($project_id, $handle){
        $output = [];

        $pings = Ping::find()->where(['project_id' => $project_id, 'handle' => $handle])->all();

        foreach ($pings as $ping){
            $data = [];
            $temp = substr(base64_decode($ping->batch), -5);
            $parts = explode('::',$temp);
            $part = $parts[1] > 0 ? '30' : '00' ;
            $label = $parts[0].':'.$part;
            $data['label'] = $label;
            $data['count'] = $ping->count;

            $output[] = $data;
        }

        return [
            'timestamps' => $output
        ];
    }

    public function actionPing(){

        $model = new PingForm();
        if ($model->load(\Yii::$app->request->post(), '')){

            $project = Project::find()->where(['api_push_key' => $model->apiPushKey])->one();

            if ($project && $project->active){

                $batch = Ping::generateHourSplitBatch();
                $handle = $model->handle;

                $ping = Ping::find()->where(['batch' => $batch, 'handle' => $handle, 'project_id' => $project->id])->one();

                // if there is no existing ping under the batch, we create one
                if (!$ping){
                    $ping = new Ping();
                    $ping->project_id = $project->id;
                    $ping->handle = $model->handle;
                    $ping->batch = Ping::generateHourSplitBatch();
                }

                if ($model->title){
                    $ping->title = $model->title;
                }

                $ping->count++;
                $ping->save();

                return [
                    'status' => 200,
                ];

            }
        }

        return [
            'status' => 400,
            'model' => $model
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

    public function actionPullAnyKeyword($lastAlertId,$keyword)
    {
        $alert = Alert::find()->alias('a')->joinWith('keywords k')->where(['>', 'a.id', $lastAlertId])->andWhere(['k.name' => $keyword])->one();
        if ($alert){

            return [
                'alert' => $alert,
                'content' => $alert->render()
            ];
        }
        return null;
    }

    public function actionActivePullAny($lastAlertId)
    {
        $alert = Alert::find()->where(['>', 'id', $lastAlertId])->one();
        if ($alert){

            return [
                'alert' => $alert,
                'content' => $alert->activeRender()
            ];
        }
        return null;
    }

    public function actionActivePullAnyKeyword($lastAlertId,$keyword){
        $alert = Alert::find()->alias('a')->joinWith('keywords k')->where(['>', 'a.id', $lastAlertId])->andWhere(['k.name' => $keyword])->one();
        if ($alert){

            return [
                'alert' => $alert,
                'content' => $alert->activeRender()
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

                if (!is_string($model->alertName)){
                    if (ArrayHelper::isIn($model->type,['error', 'json'])){
                        if (is_array($model->alertBody)){
                            $model->alertBody['noise'] = $model->alertName;
                            $tempBody = $model->alertBody;
                        }else{
                            $tempBody = [
                                'alertBody' => $model->alertBody,
                                'noise' => $model->alertName
                            ];
                        }
                        $alert->title = 'Alert with title noise (JSON)';
                        $alert->body = json_encode($tempBody);
                    }else{
                        $alert->title = 'Alert with title noise (RAW)';
                        $alert->body = $model->alertBody.';noise::'.$model->alertName;
                    }
                }else{
                    $alert->title = strlen($model->alertName) < 255 ? $model->alertName : substr($model->alertName,0,250).'...';
                    $alert->body = ArrayHelper::isIn($model->type,['error', 'json']) ? json_encode($model->alertBody) : $model->alertBody;
                }

                $alert->type = $model->type;
                $alert->sender = json_encode($model->sender);

                if (!$alert->save()){
                    $ia = new Alert();
                    $ia->project_id = $project->id;
                    $ia->title = 'Alert did not save';
                    $ia->body = json_encode($alert->getErrors());
                    $ia->type = 'html';
                    $ia->save();
                }

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
                    }
                }

                return [
                    'status' => 200
                ];
            }
        }

        return [
            'status' => 400,
            'model' => $model
        ];
    }
}