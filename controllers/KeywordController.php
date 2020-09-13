<?php

namespace app\controllers;

use app\models\KeywordAssignForm;
use app\records\AlertKeyword;
use Yii;
use app\records\Keyword;
use app\records\search\KeywordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KeywordController implements the CRUD actions for Keyword model.
 */
class KeywordController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAssign($id){

        $record = $this->findModel($id);

        $model = new KeywordAssignForm();
        $model->keyword_id = $record->id;

        if ($model->load(Yii::$app->request->post())){

            $ak = AlertKeyword::find()
                ->where(['keyword_id' => $model->keyword_id])
                ->andWhere(['alert_id' => $model->alert_id])
                ->one();

            if (!$ak){

                $ak = new AlertKeyword();
                $ak->keyword_id = $model->keyword_id;
                $ak->alert_id = $model->alert_id;

                if ($ak->save()){
                    return $this->redirect(['/keyword/view','id' => $id]);
                }

            }else{
                return $this->redirect(['/keyword/view', 'id' => $id]);
            }
        }

        return $this->render('assign',[
            'model' => $model
        ]);
    }

    /**
     * Lists all Keyword models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KeywordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Keyword model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Keyword model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Keyword();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Keyword model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Keyword model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Keyword model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Keyword the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Keyword::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
