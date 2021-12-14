<?php

namespace app\controllers;

use app\models\Departements;
use app\models\Direction;
use app\models\Employe;
use app\models\Etablissement;
use app\models\Service;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Exercice;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\Absenceponctuel;
use app\models\Jouissance;
use app\models\Emploi;
use app\models\Decisionconges;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionResetpwd()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->sendEmail()) {

                Yii::$app->session->setFlash('success', 'Veuillez verifier votre boite email pour la suite.');

                return $this->redirect(['site/login']);
            }

            else {

                Yii::$app->session->setFlash('error', 'Impossible de vous envoyer un email de reinitialisation.');
            }
        }

        $this->layout='main-login';

        return $this->render('resetpwd', [
            'model' => $model,
        ]);
    }



    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->resetPassword();

            Yii::$app->session->setFlash('success', 'Nouveau mot de passe enregistre');

            return $this->redirect(['site/login']);
        }

        $this->layout='main-login';

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionCompte(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        return $this->render('compte');

    }

    public function actionExport1() {

        $jour = date("Y-m-d");

        $csvfile = "reporting-".$jour.".csv";

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
       fputcsv($output, array('MATRICULE','NOM','EXERCICE','PERMISSION IMPUTABLE (Jrs)', 'PERMISSION NON IMPUTABLE (Jrs)','JOUISSANCE','NON JOUISSANCE','CREDIT CONGÉS (Jrs)','PROCHAIN CONGÉ', 'DIRECTION', 'DEPARTEMENT',  'SERVICE', 'POSTE','STATUT'),",");

        $query = "SELECT * FROM EMPLOYE WHERE MATRICULE IS NOT NULL ";

        if(isset($_REQUEST["matricule"]) && !empty($_REQUEST["matricule"])) {
            $query.=" AND MATRICULE = '$_REQUEST[matricule]'";
        }

        if(isset($_REQUEST["nom"]) && !empty($_REQUEST["nom"])) {
            $query.=" AND NOM LIKE %'$_REQUEST[nom]'%";
        }

        if(isset($_REQUEST["direction"]) && !empty($_REQUEST["direction"]) ) {
            $query.=" AND DIRECTION = $_REQUEST[direction]";
        }

        if(isset($_REQUEST["service"]) && !empty($_REQUEST["service"])) {
            $query.=" AND SERVICE = $_REQUEST[service]";
        }

        if(isset($_REQUEST["departement"]) && ($_REQUEST["departement"] != 0)) {
            $query.=" AND CODEDPT = $_REQUEST[departement]";
        }

        if(isset($_REQUEST["conge"]) && !empty($_REQUEST["conge"])) {

            if(isset($_REQUEST["conges"]) && !empty($_REQUEST["conges"])) {

                $fin = $_REQUEST["conges"];

                $query.=" AND DATECALCUL BETWEEN '$_REQUEST[conge]' AND '$fin'";
            }

            else $query.=" AND DATECALCUL = '$_REQUEST[conge]'";
        }

        $query.=" ORDER BY NOM ASC";

       $employes = Employe::findBySql($query)->all();

        if(isset($_REQUEST["exercice"]) && ($_REQUEST["exercice"] != 0)) {
            $exo =  Exercice::findOne($_REQUEST["exercice"]);
        }
        else $exo =  Exercice::find()->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->One();

        foreach($employes as $employe) {

            $tab2 = array();
            $tab2[] = $employe->MATRICULE;
            $tab2[] = $employe->NOM." ".$employe->PRENOM;
            $tab2[] = $exo->ANNEEEXIGIBLE;

            $abscences = Absenceponctuel::find()->where(['MATICULE'=>$employe->MATRICULE,'ANNEEEXIGIBLE'=>$exo->ANNEEEXIGIBLE,'IMPUTERCONGES'=>1,'STATUT'=>'V'])->all();

            $duree1 = 0; $duree2 = 0;

            foreach($abscences as $abs) {

                if($abs->TYPE_DEMANDE == 0) {

                    $d1 = strtotime($abs->DATEDEBUT); $d2 = strtotime($abs->DATEFIN);

                    $diff = $d2 - $d1;

                    $nbjour = abs(round($diff/86400)) + 1;

                    $duree1+=$nbjour;
                }

                else {

                    $duree2+= $abs->DUREE;
                }

            }

            $jourheureconge = (int)($duree2 / 8);

            $duree1+= $jourheureconge;

            $tab2[] = $duree1;

            $abscences1 = Absenceponctuel::find()->where(['MATICULE'=>$employe->MATRICULE,'ANNEEEXIGIBLE'=>$exo->ANNEEEXIGIBLE,'IMPUTERCONGES'=>2,'STATUT'=>'V'])->all();

            $duree2 = 0; $duree1 = 0;

            foreach($abscences1 as $abs) {

                if($abs->TYPE_DEMANDE == 0) {

                    $d1 = strtotime($abs->DATEDEBUT); $d2 = strtotime($abs->DATEFIN);

                    $diff = $d2 - $d1;

                    $nbjour = abs(round($diff/86400)) + 1;

                    $duree1+=$nbjour;
                }

                else {

                    $duree2+= $abs->DUREE;
                }

            }

            $jourheureconge = (int)($duree2 / 8);

            $duree1+= $jourheureconge;

            $tab2[] = $duree1;

            $d = Decisionconges::find()->select('ID_DECISION')->where(['MATICULE'=>$employe->MATRICULE])->all();
            $l = array();

            foreach ($d as $el) $l[] = $el->ID_DECISION;

            $jouissance = Jouissance::find()->where(['TYPES'=>['01','02','04'], 'EXERCICE'=>$exo->ANNEEEXIGIBLE,'STATUT'=>'V'])->andWhere(['IN','IDDECISION',$l])->all();

            $tab2[] = count($jouissance);

            $d = Decisionconges::find()->select('ID_DECISION')->where(['MATICULE'=>$employe->MATRICULE])->all();

            $l = array();

            foreach ($d as $el) $l[] = $el->ID_DECISION;

            $jouissance1 = Jouissance::find()->where(['TYPES'=>'03', 'EXERCICE'=>$exo->ANNEEEXIGIBLE,'STATUT'=>'V'])->andWhere(['IN','IDDECISION',$l])->all();

            $tab2[] = count($jouissance1);

            $tab2[] = $employe->SOLDECREDIT;

            if($employe->DATECALCUL != null) {

                $d = explode("-",$employe->DATECALCUL);

                $tab2[] = $d["2"]."-".$d[1]."-".$d[0];
            }

            else $tab2[] = "";

            $direction = Direction::findOne($employe->DIRECTION);
            if($direction != null) $tab2[] = utf8_encode($direction->LIBELLE); else $tab2[] = "";

            $departement = Departements::findOne($employe->CODEDPT);
            if($departement != null) $tab2[] = utf8_encode($departement->LIBELLE); else $tab2[] = "";

            $service = Service::findOne($employe->SERVICE);
            if($service != null) $tab2[] = utf8_encode($service->LIBELLE); else $tab2[] = "";

            $emploi = Emploi::findOne($employe->CODEEMP);
            if($emploi != null) $tab2[] = utf8_encode($emploi->LIBELLE); else $tab2[] = "";

            if($employe->STATUT == 1) $tab2[] = "ACTIF"; else $tab2[] = "INACTIF";

            fputcsv($output, $tab2,",");


        }

       fclose($output);

        exit;
    }

    public function actionPage(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        return $this->render('page');

    }


    public function actionEmployes(){

        if (Yii::$app->user->isGuest) {

            return $this->redirect(['login']);
        }

        return $this->render('employe');
    }
}
