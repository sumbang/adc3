<?php

namespace app\controllers;

use app\models\Cancelation;
use Yii;
use app\models\Arret;
use app\models\ArretSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Loges;
use yii\filters\AccessControl;

/**
 * ArretController implements the CRUD actions for Arret model.
 */
class ArretController extends Controller
{
    /**
     * @inheritdoc
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

            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Arret models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $searchModel = new ArretSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Arret model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        return $this->redirect(['update','id'=>$id]);
    }

    /**
     * Creates a new Arret model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = new Arret();

        if ($model->load(Yii::$app->request->post()) ) {

            //$cancel = \app\models\Cancelation::find()->where(['JOUISSANCE'=>$model->JOUISSANCE,'STATUT'=>0])->all();

            $cancel = Cancelation::findOne($model->JOUISSANCE);

            if($cancel == null) {

                Yii::$app->session->setFlash('error', 'Attention, vous ne pouvez créer de reliquat pour ce congé');

                return $this->redirect(['create']);
            }

            else {

                $duree = $cancel->PERIODE; $model->JOUISSANCE = $cancel->JOUISSANCE;

                $cancel->STATUT = 1; $cancel->save(false);

                $model->DOCUMENTFILE = UploadedFile::getInstance($model, 'DOCUMENTFILE');

                if ($model->DOCUMENTFILE != null) {

                    $model->DOCUMENT = $model->DOCUMENTFILE->baseName . '.' . $model->DOCUMENTFILE->extension;
                }

                $model->STATUT = "V"; $model->DATEEMIS = date("Y-m-d");

                $datefin = date('Y-m-d', strtotime($model->DATEDEBUT. ' + '.($duree - 1).' days'));

                $model->DATEFIN = $datefin; $model->DATEVAL = date("Y-m-d");

                $model->IDUSER = Yii::$app->user->identity->IDUSER;

                $model->save(false);

                if ($model->DOCUMENTFILE != null) $model->DOCUMENTFILE->saveAs('../web/uploads/' . $model->DOCUMENTFILE->baseName . '.' . $model->DOCUMENTFILE->extension);

                Yii::$app->session->setFlash('success', 'Reliquat crée avec succès');

                $logs = new Loges();
                $logs->DATEOP = date("Y-m-d H:i:s");
                $logs->USERID = Yii::$app->user->identity->IDUSER;
                $logs->USERNAME = Yii::$app->user->identity->NOM;
                $logs->OPERATION = "Création reliquat ".$model->ID_SUSPENSION;
                $logs->save(false);

                return $this->redirect(['view', 'id' => $model->ID_SUSPENSION]);

            }


        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Arret model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->DOCUMENTFILE = UploadedFile::getInstance($model, 'DOCUMENTFILE');

            if($model->DOCUMENTFILE != null) {

                $model->DOCUMENT = $model->DOCUMENTFILE->baseName . '.' . $model->DOCUMENTFILE->extension;

                $model->save(false);

                $model->DOCUMENTFILE->saveAs('../web/uploads/' . $model->DOCUMENTFILE->baseName . '.' . $model->DOCUMENTFILE->extension);

            } else { $model->save(false); }

            Yii::$app->session->setFlash('success', 'Reliquat modifié avec succès');

            return $this->redirect(['view', 'id' => $model->ID_SUSPENSION]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Arret model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $logs = new Loges();
        $logs->DATEOP = date("Y-m-d H:i:s");
        $logs->USERID = Yii::$app->user->identity->IDUSER;
        $logs->USERNAME = Yii::$app->user->identity->NOM;
        $logs->OPERATION = "Suppression reliquat numero ".$id;
        $logs->save(false);

        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'Reliquat supprime avec succes');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Arret model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Arret the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Arret::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionValider(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $id = $_REQUEST["id"];  $model = $this->findModel($id); $model->DATEVAL = date("Y-m-d");

        $model->STATUT = "V"; 


                 /*  $employe = Employe::findOne($model->MATRICULE);
                   
                   $date1 = strtotime($model->DATEDEBUT); $date2 = strtotime($model->DATEFIN);

                   $diff = $date2 - $date1; $nbjour = abs(round($diff/86400)) + 1;

                    $employe->SOLDECREDIT+=$nbjour;

                    $employe->save(false); */
                    
                
        $model->save(false);

        Yii::$app->session->setFlash('success', 'Suspension validees avec succes');

        return $this->redirect(['view', 'id' => $model->ID_SUSPENSION]); 
    }

    public function actionAnnuler(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $id = $_REQUEST["id"];  $model = $this->findModel($id); $model->DATEANN = date("Y-m-d");

        $model->STATUT = "A"; 

        $model->save(false);

        Yii::$app->session->setFlash('success', 'Suspension annulees avec succes');

        return $this->redirect(['view', 'id' => $model->ID_SUSPENSION]);
                
    }
}
