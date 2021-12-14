<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\Alert;
use app\models\Employe;
use app\models\Exercice;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use app\models\Menus;
use app\models\Typeabsence;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AbsenceponctuelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Demande de permissions';
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M5";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="absenceponctuel-index">

    <p>
        <?php if($habilation->ACREATE == 1) echo Html::a('Créer une permission', ['create'], ['class' => 'btn btn-success']) ?>

        <?php if(($habilation->ADELETE == 1) && (Yii::$app->user->identity->NIVEAU == 2) ) echo Html::a('Exporter les permissions', ['export'], ['class' => 'btn btn-primary']) ?>
    </p>

    <div style="overflow: auto;overflow-y: hidden; Height:?">
    <?php

    $vue = "";

    if ($habilation->AREAD== 1) $vue .= "{view} ";
    if ($habilation->AUPDATE == 1) $vue .= "{update} ";
    if ($habilation->ADELETE == 1) $vue .= "{delete}";

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID_ABSENCE',
            'CODEABS'=>[
                'header' => 'Type absence',
                'attribute' => 'CODEABS',
                'filter' => Html::activeDropDownList($searchModel, 'CODEABS', ArrayHelper::map(Typeabsence::find()->all(),"CODEABS","LIBELLE"),['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    $tab  = Typeabsence::findOne($model->CODEABS);
                    return $tab==null?'Inconnu':$tab->LIBELLE;
                }
            ],
            'MATICULE'=>[
                'header' => 'Employé',
                'attribute' => 'MATICULE',
                'filter' => Html::activeDropDownList($searchModel, 'MATICULE', ArrayHelper::map(Employe::find()->all(),"MATRICULE","fullname"),['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    $tab  = Employe::findOne($model->MATICULE);
                    return $tab==null?'Inconnu':$tab->getfullname();
                }
            ],
            'ANNEEEXIGIBLE'=>[
                'header' => 'Exercice',
                'attribute' => 'ANNEEEXIGIBLE',
                'filter' => Html::activeDropDownList($searchModel, 'ANNEEEXIGIBLE', ArrayHelper::map(Exercice::find()->all(),"ANNEEEXIGIBLE","ANNEEEXIGIBLE"),['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    $tab  = Exercice::findOne($model->ANNEEEXIGIBLE);
                    return $tab==null?'Inconnu':$tab->ANNEEEXIGIBLE;
                }
            ],
            'DATEDEBUT'=>[
                'header' => 'Début',
                'attribute' => 'DATEDEBUT',
                'value'=>'DATEDEBUT',
                'format' => 'html',
                'filter' => DatePicker::widget([
                    'name'=>'AbsenceponctuelSearch[DATEDEBUT]',
                    'language' => 'fr',
                    'dateFormat' => 'yyyy-MM-dd'
                ]),
            ],
            'DATEFIN'=>[
                'header' => 'Fin',
                'attribute' => 'DATEFIN',
                'value'=>'DATEFIN',
                'format' => 'html',
                'filter' => DatePicker::widget([
                    'name'=>'AbsenceponctuelSearch[DATEFIN]',
                    'language' => 'fr',
                    'dateFormat' => 'yyyy-MM-dd'
                ]),
            ],
            'STATUT'=>[
                'header' => 'Statut',
                'attribute' => 'STATUT',
                'filter' => Html::activeDropDownList($searchModel, 'STATUT', ["E"=>"Emise","A"=>"Annule","V"=>"Valide"],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    return $model->STATUT == null?'Inconnu':$model->getStatut();
                }
            ],
            'TYPE_DEMANDE'=>[
                'header' => 'Type de demande',
                'attribute' => 'TYPE_DEMANDE',
                'filter' => Html::activeDropDownList($searchModel, 'TYPE_DEMANDE', [0=>"Jour",1=>"Heure"],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    return $model->getTypeDemande();
                }
            ],
            'IMPUTERCONGES'=>[
                'header' => 'Imputer sur les congés	',
                'attribute' => 'IMPUTERCONGES',
                'filter' => Html::activeDropDownList($searchModel, 'IMPUTERCONGES', [1=>"Oui",2=>"Non"],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    return $model->IMPUTERCONGES == null?'Inconnu':$model->getGenre();
                }
            ],
            [
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'label' => 'Direction',
                'attribute' => 'direction',
                'value' => function ($data) {
                    $employe = Employe::find()->where(["MATRICULE"=>$data->MATICULE])->one();

                    if($employe != null) {

                        $d = \app\models\Direction::findOne($employe->DIRECTION);

                        if($d != null) return $d->LIBELLE; else return "";

                    }

                },
            ],
            [
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'label' => 'Département',
                'filter' => Html::activeDropDownList($searchModel, 'departement', ArrayHelper::map(\app\models\Departements::find()->all(),"CODEDPT","LIBELLE"),['class'=>'form-control','prompt' => 'Choisir']),
                'attribute' => 'departement',
                'value' => function ($data) {

                    $employe = Employe::find()->where(["MATRICULE"=>$data->MATICULE])->one();

                    if($employe != null) {

                        $d = \app\models\Departements::findOne($employe->CODEDPT);

                        if($d != null) return $d->LIBELLE; else return "";

                    }
                    else return  "";
                },
            ],
            [
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'label' => 'Service',
                'attribute' => 'service',
                'value' => function ($data) {

                    $employe = Employe::find()->where(["MATRICULE"=>$data->MATICULE])->one();

                    if($employe != null) {

                        $d = \app\models\Service::findOne($employe->SERVICE);

                        if($d != null) return $d->LIBELLE; else return "";

                    }
                },
            ],

            //'DATEEMIS',
            //'DATEVAL',
            //'DATEANN',

            ['class' => 'yii\grid\ActionColumn','template'=>$vue],
        ],
    ]); ?>
    </div>
</div>
