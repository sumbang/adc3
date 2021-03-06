<?php

namespace app\controllers;

use app\models\Direction;
use app\models\Historique;
use app\models\Service;
use Yii;
use app\models\Decisionconges;
use app\models\DecisioncongesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Exercice;
use app\models\Parametre;
use app\models\Employe;
use kartik\mpdf\Pdf;
use app\models\Absenceponctuel;
use app\models\Departements;
use app\models\Ampliation;
use app\models\Loges;
use yii\filters\AccessControl;

/**
 * DecisioncongesController implements the CRUD actions for Decisionconges model.
 */
class DecisioncongesController extends Controller
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
     * Lists all Decisionconges models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $searchModel = new DecisioncongesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize=100;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Decisionconges model.
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
     * Creates a new Decisionconges model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = new Decisionconges();

        if ($model->load(Yii::$app->request->post()) ) {

            $exo =  Exercice::find()->where(['ANNEEEXIGIBLE' => $model->ANNEEEXIGIBLE])->One();

            $emp = Employe::findOne(["MATRICULE"=>$model->MATICULE]);

        if ($exo == NULL) {

            Yii::$app->session->setFlash('error', 'Attention, aucune occurence de trouv??e pour cet exercice');

            return $this->redirect(['create']);
        }

        else if ($emp == NULL) {

            Yii::$app->session->setFlash('error', 'Attention, aucune occurence de trouv??e pour cet employ??');

            return $this->redirect(['create']);
        }

        else {

            $conge = Decisionconges::find()->where(['MATICULE' => $model->MATICULE, 'ANNEEEXIGIBLE' => $model->ANNEEEXIGIBLE])->One();


            $model->DEBUTPLANIF = Generator::getDate($model->DEBUTPLANIF);
            $model->FINPLANIF = Generator::getDate($model->FINPLANIF);

            if ($conge == NULL) {

                $d1 = new \DateTime($exo->DATEBEDUT);
                $d2 = new \DateTime($exo->DATEFIN);

                $d3 = new \DateTime($model->DEBUTPLANIF);
                $d4 = new \DateTime($model->FINPLANIF);


                if($d3 >= $d4) {

                    Yii::$app->session->setFlash('error', 'La date de d??but doit ??tre inf??rieure ?? la date de fin.');

                    return $this->redirect(['create']);
                }

                //else if($d1 <= $d3 && $d2 >= $d4){

                else {

                    $employe = Employe::findOne($model->MATICULE);

                    $date1 = strtotime($model->DEBUTPLANIF);
                    $date2 = strtotime($model->FINPLANIF);

                    $diff = $date2 - $date1;
                    $nbjour = abs(round($diff / 86400)) + 1;

                    $setting = Parametre::findOne(1);

                    if ($nbjour > $setting->DUREECONGES) {

                        Yii::$app->session->setFlash('error', 'La d??cision de cong??s ne peut exc??der ' . $setting->DUREECONGES . ' jours');

                        return $this->redirect(['create']);
                    } else if ($employe->DATECALCUL == null) {

                        Yii::$app->session->setFlash('error', 'Cet employ?? ne dispose n\'a pas de date de prochain cong??s, bien vouloir renseigner cela depuis le module gestion des employ??s.');

                        return $this->redirect(['create']);
                    } else {

                        $depart = date('d/m/Y', strtotime($employe->DATECALCUL));

                        $d5 = new \DateTime($employe->DATECALCUL);

                        if ($d3 != $d5) {

                            Yii::$app->session->setFlash('error', 'La d??part en cong??s pour cet employ?? doit ??tre le ' . $depart);

                            return $this->redirect(['create']);
                        } else {

                            $model->DATEEMIS = date("Y-m-d H:i:s");
                            $model->STATUT = "V";
                            $model->DATEVAL = date("Y-m-d H:i:s");

                            $model->DEBUTPERIODE = $exo->DATEBEDUT;
                            $model->FINPERIODE = $exo->DATEFIN;
                            $model->DEPARTEMENT = $employe->CODEDPT;
                            $model->NBJOUR = $nbjour;
                            $model->TYPE_DEC = 1;
                            $model->IDUSER = Yii::$app->user->identity->IDUSER;

                            $model->save(false);

                            $numero = $this->getDecisionNumber($exo) . " - " . $setting->SUFFIXEREF . "" . Yii::$app->user->identity->INITIAL;

                            $model->REF_DECISION = $numero;
                            $model->save(false);

                            $logs = new Loges();
                            $logs->DATEOP = date("Y-m-d H:i:s");
                            $logs->USERID = Yii::$app->user->identity->IDUSER;
                            $logs->USERNAME = Yii::$app->user->identity->NOM;
                            $logs->OPERATION = "Cr??ation decision de conges numero ".$model->ID_DECISION;
                            $logs->save(false);

                            Yii::$app->session->setFlash('success', 'D??cision de cong??s enregistr??e avec succ??s');

                            return $this->redirect(['update', 'id' => $model->ID_DECISION]);
                        }

                    }

                }

               /* }

                else{

                    Yii::$app->session->setFlash('error', 'La d??cision de cong??s doit ??tre dans l\'intervalle de l\'exercice');

            return $this->redirect(['create']);
                } */

            }

            else{

                Yii::$app->session->setFlash('error', 'Une d??cision de cong??s a d??j?? ??t?? cr??ee pour cet employ?? pour cet exerice');

                return $this->redirect(['create']); 
            }

        }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Decisionconges model.
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

        if ($model->load(Yii::$app->request->post()) ) {

                $model->save(false);

                Yii::$app->session->setFlash('success', 'D??cision de cong?? enregistr??e avec succ??s');

                return $this->redirect(['update', 'id' => $model->ID_DECISION]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionValider(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $id = $_REQUEST["id"];  $model = $this->findModel($id);

        $exos = Exercice::find()->where(['ANNEEEXIGIBLE'=>$model->ANNEEEXIGIBLE, 'STATUT'=>'O'])->One();

        // calcul pour voir si les dates sont bonnes

        if($exos == null) {

            Yii::$app->session->setFlash('error', 'Impossible de faire une action sur un exercice clotur??');

            return $this->redirect(['update', 'id' => $model->ID_DECISION]);
        }

        else {

            $model->save(false);

            $logs = new Loges();
            $logs->DATEOP = date("Y-m-d H:i:s");
            $logs->USERID = Yii::$app->user->identity->IDUSER;
            $logs->USERNAME = Yii::$app->user->identity->NOM;
            $logs->OPERATION = "Validation decision de conges numero ".$model->ID_DECISION;
            $logs->save(false);

            Yii::$app->session->setFlash('success', 'D??cisions de cong??s valid??es avec succes');

            return $this->redirect(['update', 'id' => $model->ID_DECISION]);

        }

    }

    public function actionReprise(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $id = $_REQUEST["id"];  $model = $this->findModel($id);

        $exd1 = $model->DEBUTREELL; $exd2 = $model->FINREEL;

        $e1 = new \DateTime($exd1);  $e2 = new \DateTime($exd2);

        $exos = Exercice::find()->where(['ANNEEEXIGIBLE'=>$model->ANNEEEXIGIBLE, 'STATUT'=>'O'])->One();

        if($exos == null) {

            Yii::$app->session->setFlash('error', 'Impossible de faire une action sur un exercice clotur??');

            return $this->redirect(['update', 'id' => $model->ID_DECISION]);
        }

        else if($e2 < $e1) {

            Yii::$app->session->setFlash('error', 'La date de fin r??el doit ??tre sup??rieur ?? la date de d??but r??el');

            return $this->redirect(['update', 'id' => $model->ID_DECISION]);
        }

        else {

            $model->STATUT = "R";

            $model->DATEREPRISE = date("Y-m-d H:i:s");

            $model->save(false);

            $setting = Parametre::findOne(1);   $employe = Employe::findOne($model->MATICULE);

            $datefin = date('Y-m-d', strtotime($model->FINREEL. ' + '.($setting->DUREESERVICE + 1).' days'));

            $employe->DATECALCUL = $datefin; $employe->save(false);

            $logs = new Loges();
            $logs->DATEOP = date("Y-m-d H:i:s");
            $logs->USERID = Yii::$app->user->identity->IDUSER;
            $logs->USERNAME = Yii::$app->user->identity->NOM;
            $logs->OPERATION = "Reprise decision de conges numero ".$model->ID_DECISION;
            $logs->save(false);

            Yii::$app->session->setFlash('success', 'D??cision de cong??s enregistr??e avec succ??s');

            return $this->redirect(['update', 'id' => $model->ID_DECISION]);

        }

    }

    public function actionAnnuler(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $id = $_REQUEST["id"];  $model = $this->findModel($id);

        $model->STATUT = "A"; $model->DATEANN = date("Y-m-d H:i:s");

        $exos = Exercice::find()->where(['ANNEEEXIGIBLE'=>$model->ANNEEEXIGIBLE, 'STATUT'=>'O'])->One();

        if($exos == null) {

            Yii::$app->session->setFlash('error', 'Impossible de faire une action sur un exercice clotur??');

            return $this->redirect(['update', 'id' => $model->ID_DECISION]);
        }

        else {

        $model->save(false);

            $logs = new Loges();
            $logs->DATEOP = date("Y-m-d H:i:s");
            $logs->USERID = Yii::$app->user->identity->IDUSER;
            $logs->USERNAME = Yii::$app->user->identity->NOM;
            $logs->OPERATION = "Annulation decision de conges numero ".$model->ID_DECISION;
            $logs->save(false);

        Yii::$app->session->setFlash('success', 'D??cision de cong?? annul??e avec succ??s');

        return $this->redirect(['update', 'id' => $model->ID_DECISION]); }
    }

    public function actionSuspendu(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $id = $_REQUEST["id"];  $model = $this->findModel($id); $model->FINREEL = date("Y-m-d");

        $model->STATUT = "S"; $model->DATESUSP = date("Y-m-d H:i:s");

        $exos = Exercice::find()->where(['ANNEEEXIGIBLE'=>$model->ANNEEEXIGIBLE, 'STATUT'=>'O'])->One();

        if($exos == null) {

            Yii::$app->session->setFlash('error', 'Impossible de faire une action sur un exercice clotur??');

            return $this->redirect(['update', 'id' => $model->ID_DECISION]);
        }

        else {

        $model->save(false);

        $setting = Parametre::findOne(1);   $employe = Employe::findOne($model->MATICULE);

        $datefin = date('Y-m-d', strtotime($model->FINREEL. ' + '.($setting->DUREESERVICE + 1).' days'));

        $employe->DATECALCUL = $datefin; $employe->save(false);

            $logs = new Loges();
            $logs->DATEOP = date("Y-m-d H:i:s");
            $logs->USERID = Yii::$app->user->identity->IDUSER;
            $logs->USERNAME = Yii::$app->user->identity->NOM;
            $logs->OPERATION = "Suspension decision de conges numero ".$model->ID_ABSENCE;
            $logs->save(false);

        Yii::$app->session->setFlash('success', 'D??cisions de cong??s suspendues avec succes');

        return $this->redirect(['update', 'id' => $model->ID_DECISION]); }
    }

    public function actionRelance(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $id = $_REQUEST["id"];  $model = $this->findModel($id);

        $model->STATUT = "V";

        $exos = Exercice::find()->where(['ANNEEEXIGIBLE'=>$model->ANNEEEXIGIBLE, 'STATUT'=>'O'])->One();

        if($exos == null) {

            Yii::$app->session->setFlash('error', 'Impossible de faire une action sur un exercice clotur??');

            return $this->redirect(['update', 'id' => $model->ID_DECISION]);
        }

        else {

            $model->save(false);

            $logs = new Loges();
            $logs->DATEOP = date("Y-m-d H:i:s");
            $logs->USERID = Yii::$app->user->identity->IDUSER;
            $logs->USERNAME = Yii::$app->user->identity->NOM;
            $logs->OPERATION = "Reactivation decision de conges numero ".$model->ID_DECISION;
            $logs->save(false);

            Yii::$app->session->setFlash('success', 'D??cisions de cong??s r??activ??e avec succes');

            return $this->redirect(['update', 'id' => $model->ID_DECISION]); }
    }

    /**
     * Deletes an existing Decisionconges model.
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

        $nodelete = array('V','R','S');

        if(in_array($model->STATUT,$nodelete)) {

            Yii::$app->session->setFlash('error', 'Vous ne pouvez pas supprimer une d??cision de cong??s d??ja op??rationnel');

        }

        else {

            $logs = new Loges();
            $logs->DATEOP = date("Y-m-d H:i:s");
            $logs->USERID = Yii::$app->user->identity->IDUSER;
            $logs->USERNAME = Yii::$app->user->identity->NOM;
            $logs->OPERATION = "Suppression decision de conges numero ".$id;
            $logs->save(false);

            $this->findModel($id)->delete();

            Yii::$app->session->setFlash('success', 'D??cision supprim??e avec succ??s');

        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Decisionconges model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Decisionconges the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Decisionconges::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGenerer($id){

        $filename = Generator::decision($id);

        $logs = new Loges();
        $logs->DATEOP = date("Y-m-d H:i:s");
        $logs->USERID = Yii::$app->user->identity->IDUSER;
        $logs->USERNAME = Yii::$app->user->identity->NOM;
        $logs->OPERATION = "Generation modele d'edition decision numero ".$id;
        $logs->save(false);

        Yii::$app->session->setFlash('success', 'Mod??le d\'??dition cr??e avec succ??s : <a href="../web/uploads/'.$filename.'" target="_blank">Ouvrir</a>');

        return $this->redirect(['decisionconges/update', 'id' => $id, 'table' => 'T6']);

    }

    function getDecisionNumber($exercice){

        $decision = Decisionconges::find()->where(['ANNEEEXIGIBLE'=>$exercice])->all();

        $total = count($decision); $next = $total + 1;

        $position = 4 - strlen($next);

        $retour = "";

        for($i=1; $i<=$position; $i++){

            $retour.="0";
        }

        return $retour."".$next;
    }

    public function actionGeneration(){

        $selection=(array)Yii::$app->request->post('selection');

        $zip = new \ZipArchive();   $repertoire = '../web/uploads';

        $name = round(microtime(true)).".zip";

        $destination = $repertoire."/".$name;

        if($zip->open($destination,\ZIPARCHIVE::CREATE) !== true) {

            return false;
        }

        foreach($selection as $id){

            $model = Decisionconges::findOne((int)$id);

            $filename = Generator::decision($model->ID_DECISION);

            $cheminf = $repertoire."/".$filename;

            $zip->addFile($cheminf,$filename);

        }

        $zip->close();

        $historique = new Historique();
        $historique->LIBELLE = "Mod??le ??dition du ".date("d/m/Y H:i:s");
        $historique->QUANTITE = count($selection);
        $historique->FICHIER = $name;
        $historique->TYPES = 1;
        $historique->save(false);

        $logs = new Loges();
        $logs->DATEOP = date("Y-m-d H:i:s");
        $logs->USERID = Yii::$app->user->identity->IDUSER;
        $logs->USERNAME = Yii::$app->user->identity->NOM;
        $logs->OPERATION = "Generation modeles d'edition pour l'historique ".$historique->ID;
        $logs->save(false);

        Yii::$app->session->setFlash('success', 'Mod??les d\'??dition cr??es avec succ??s. <a href="'.$destination.'" target="_blank">Ouvrir le ZIP </a>');

        return $this->redirect(['decisionconges/index','table' => 'T6']);

    }

    public function actionExport(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = new Decisionconges();

        $model->scenario = 'export';

        if ($model->load(Yii::$app->request->post())) {

            $absences = Decisionconges::find()->where(['ANNEEEXIGIBLE'=>$model->ANNEEEXIGIBLE])->all();

            $jour = date("Y-m-d");

            $csvfile = "decision-".$model->ANNEEEXIGIBLE.".csv";

            //output header
            header("Content-type: text/x-csv");
            header("Content-type: text/csv");
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=".$csvfile."");
            header("Pragma: no-cache");
            header("Expires: 0");


            // create file pointer
            $output = fopen("php://output", "w");

            //output the column headings
            fputcsv($output, array('REFERENCE DECISION','EMPLOYE','DEBUT SERVICE','FIN SERVICE', 'DEBUT CONGE','FIN CONGE','NOMBRE DE JOURS','DATE EMISSION','DATE REPRISE', 'PROCHAIN CONGE', 'DATE DE NAISSANCE',  'COMMENTAIRE', 'STATUT','DIRECTION','DEPARTEMENT','SERVICE'),",");

            // creation du fichier d'export

            foreach ($absences as $absence) {

                $employe = Employe::findOne($absence->MATICULE);
               // $typeabs = Typeabsence::findOne($absence->CODEABS);

                if($employe->CODEDPT != null) {

                    $mdpt = Departements::findOne($employe->CODEDPT); $dpt = $mdpt->LIBELLE;

                } else $dpt = "";

                $date1 = strtotime($absence->DEBUTPLANIF); $date2 = strtotime($absence->FINPLANIF);

                $diff = $date2 - $date1; $nbjour = abs(round($diff/86400)) + 1;

                if($absence->EDITION != null) $edition = "EN COURS"; else $edition = "BROUILLON";

                $direction = Direction::findOne($employe->DIRECTION);
                $service = Service::findOne($employe->SERVICE);

                $tab2 = array();

                $tab2[] = $absence->REF_DECISION; $tab2[] = $employe->getFullname(); $tab2[] = $absence->DEBUTREELL;
                $tab2[] = $absence->FINREEL; $tab2[] = $absence->DEBUTPLANIF; $tab2[] = $absence->FINPLANIF; $tab2[] = $nbjour;
                $tab2[] = $absence->DATEEMIS; $tab2[] = $absence->DATEREPRISE;
                $tab2[] = $absence->DATECLOTURE; $tab2[] = $employe->DATNAISS;
                $tab2[] = $absence->COMMENTAIRE; $tab2[] = $edition;
                $tab2[] = ($direction != null)?$direction->LIBELLE:""; $tab2[] = $dpt;
                $tab2[] = ($service != null)?$service->LIBELLE:"";

                fputcsv($output, $tab2, ",");

            }

            $today = date("d/m/Y H:i:s");

            fclose($output);


            exit;

        }

        return $this->render('export', [
            'model' => $model,
        ]);

    }

}
