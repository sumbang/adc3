<?php

namespace app\controllers;

use Yii;
use app\models\Suspension;
use app\models\SuspensionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Exercice;
use app\models\Employe;
use yii\web\UploadedFile;
use app\models\Loges;
use yii\filters\AccessControl;

/**
 * SuspensionController implements the CRUD actions for Suspension model.
 */
class SuspensionController extends Controller
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
     * Lists all Suspension models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $searchModel = new SuspensionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Suspension model.
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
     * Creates a new Suspension model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = new Suspension();

        if ($model->load(Yii::$app->request->post()) ) {

            $exo =  Employe::find()->where(['MATRICULE' => $model->MATICULE])->One();

            if ($exo == NULL) {

                Yii::$app->session->setFlash('error', 'Attention, aucune occurence de trouvée pour cet employé');

                return $this->redirect(['create']);
            }

            else {

                $exist = Suspension::find()->where(["MATICULE"=>$model->MATICULE,"DEJA"=>0])->all();

                if($exist != null) {

                    Yii::$app->session->setFlash('error', 'Il n\'est pas possible de créer plusieurs suspensions en cours pour le même employé');

                    return $this->redirect(['create']);
                }

                else {

                    $model->STATUT = "E"; $model->DATEEMIS = date("Y-m-d");

                    $model->DOCUMENTFILE = UploadedFile::getInstance($model, 'DOCUMENTFILE');

                    if ($model->DOCUMENTFILE != null) {

                        $model->DOCUMENT = $model->DOCUMENTFILE->baseName . '.' . $model->DOCUMENTFILE->extension;
                    }

                    $model->STATUTLEVE = 0;

                    $model->IDUSER = Yii::$app->user->identity->IDUSER;

                    $model->save(false);

                    if ($model->DOCUMENTFILE != null) $model->DOCUMENTFILE->saveAs('../web/uploads/' . $model->DOCUMENTFILE->baseName . '.' . $model->DOCUMENTFILE->extension);


                //    Yii::$app->session->setFlash('success', 'Suspension enregistrée avec succès');

                    $logs = new Loges();
                    $logs->DATEOP = date("Y-m-d H:i:s");
                    $logs->USERID = Yii::$app->user->identity->IDUSER;
                    $logs->USERNAME = Yii::$app->user->identity->NOM;
                    $logs->OPERATION = "Création suspension numero ".$model->ID_SUSPENSION;
                    $logs->save(false);

                    return $this->redirect(['valider', 'id' => $model->ID_SUSPENSION]);
                }

            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Suspension model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

                if(isset($_REQUEST["lever"])) {

                    $employe = Employe::findOne($model->MATICULE);

                    $employe->STATUT = 1; $employe->save(false);

                    $date1 = strtotime($model->DATEDEBUT);

                    $date2 = strtotime($model->DATEFIN);

                    $diff = $date2 - $date1; $nbjour = abs(round($diff/86400)) + 1;

                    $nexconge = date('Y-m-d',strtotime($employe->DATECALCUL.' +'.($nbjour).' day'));

                    $employe->DATECALCUL = $nexconge; $employe->save(false);

                    $model->STATUTLEVE = 2;

                    $model->save(false);

                    Yii::$app->session->setFlash('success', 'Suspension levée avec succès');

                }

                else {

                    $model->DOCUMENTFILE = UploadedFile::getInstance($model, 'DOCUMENTFILE');

                    if ($model->DOCUMENTFILE != null) {

                        $model->DOCUMENT = $model->DOCUMENTFILE->baseName . '.' . $model->DOCUMENTFILE->extension;

                        $model->save(false);

                        $model->DOCUMENTFILE->saveAs('../web/uploads/' . $model->DOCUMENTFILE->baseName . '.' . $model->DOCUMENTFILE->extension);

                    } else {
                        $model->save(false);
                    }

                    Yii::$app->session->setFlash('success', 'Suspension enregistrée avec succès');
                }

            return $this->redirect(['view', 'id' => $model->ID_SUSPENSION]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Suspension model.
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

        $model = $this->findModel($id);

        if($model->STATUT != "E") {

            Yii::$app->session->setFlash('error', 'Impossible de supprimer une suspension en activité.');

            return $this->redirect(['update', 'id' => $model->ID_SUSPENSION]);
        }

        else {

            $logs = new Loges();
            $logs->DATEOP = date("Y-m-d H:i:s");
            $logs->USERID = Yii::$app->user->identity->IDUSER;
            $logs->USERNAME = Yii::$app->user->identity->NOM;
            $logs->OPERATION = "Suppression suspension numero ".$id;
            $logs->save(false);

        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'Suspension supprimée avec succes');

        return $this->redirect(['index']); }
    }



    /**
     * Finds the Suspension model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Suspension the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Suspension::findOne($id)) !== null) {
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

        $exos = Exercice::find()->where(['ANNEEEXIGIBLE'=>$model->ANNEEEXIGIBLE, 'STATUT'=>'O'])->One();

                if($exos == null) {

                    Yii::$app->session->setFlash('error', 'Impossible de faire une action sur un exercice cloture');

                    return $this->redirect(['update', 'id' => $model->ID_SUSPENSION]);
                }
                else {

                    // decallage de la date de prochain conge de l'employe

                    $employe = Employe::findOne($model->MATICULE);

                    $employe->STATUT = 0; $employe->save(false);

                    $model->STATUTLEVE = 1;

        $model->save(false);

                    $logs = new Loges();
                    $logs->DATEOP = date("Y-m-d H:i:s");
                    $logs->USERID = Yii::$app->user->identity->IDUSER;
                    $logs->USERNAME = Yii::$app->user->identity->NOM;
                    $logs->OPERATION = "Validation suspension numero ".$model->ID_SUSPENSION;
                    $logs->save(false);

        Yii::$app->session->setFlash('success', 'Suspension validée avec succès');

        return $this->redirect(['view', 'id' => $model->ID_SUSPENSION]); }
    }

    public function actionLever($id){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

       $model = $this->findModel($id); $model->DATELEVEE = date("Y-m-d");

        $model->STATUT = "V";

            // decallage de la date de prochain conge de l'employe

            $employe = Employe::findOne($model->MATICULE);

            $employe->STATUT = 1; $employe->save(false);

            $date1 = strtotime($model->DATEDEBUT);

            $date2 = strtotime($model->DATEFIN);

            $diff = $date2 - $date1; $nbjour = abs(round($diff/86400)) + 1;

            $nexconge = date('Y-m-d',strtotime($employe->DATECALCUL.' +'.($nbjour).' day'));

            $employe->DATECALCUL = $nexconge; $employe->save(false);

            $model->STATUTLEVE = 2;

            $model->save(false);

        $logs = new Loges();
        $logs->DATEOP = date("Y-m-d H:i:s");
        $logs->USERID = Yii::$app->user->identity->IDUSER;
        $logs->USERNAME = Yii::$app->user->identity->NOM;
        $logs->OPERATION = "Levage suspension numero ".$model->ID_SUSPENSION;
        $logs->save(false);

            Yii::$app->session->setFlash('success', 'Suspension levée avec succès');

            return $this->redirect(['view', 'id' => $model->ID_SUSPENSION]);
    }

    public function actionAnnuler($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);

        if($model->STATUT != "E") {

            Yii::$app->session->setFlash('error', 'Impossible de supprimer une suspension en activité.');

            return $this->redirect(['update', 'id' => $model->ID_SUSPENSION]);
        }

        else {

            $this->findModel($id)->delete();

            $logs = new Loges();
            $logs->DATEOP = date("Y-m-d H:i:s");
            $logs->USERID = Yii::$app->user->identity->IDUSER;
            $logs->USERNAME = Yii::$app->user->identity->NOM;
            $logs->OPERATION = "Suppression suspension numero ".$model->ID_SUSPENSION;
            $logs->save(false);

            Yii::$app->session->setFlash('success', 'Suspension supprimée avec succes');

            return $this->redirect(['index']); }
    }
}
