<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Employe;
use app\models\Exercice;
use yii\helpers\ArrayHelper;
use app\models\Jouissance;
use app\models\Roles;
use app\models\Menus;
use yii\jui\DatePicker;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArretSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reliquat de jouissance';
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M11";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="arret-index">

    <p>
        <?php if($habilation->ACREATE == 1) echo Html::a('Créer un reliquat de jouisance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div style="overflow: auto;overflow-y: hidden; Height:?">

    <?php

    $vue = "";

    if ($habilation->AREAD== 1) $vue .= "{view} ";
    if ($habilation->AUPDATE == 1) $vue .= "{update} ";
    if ($habilation->ADELETE == 1) $vue .= "{delete}";

    echo  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'ID_SUSPENSION',
            [
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'label' => 'Employés',
                'filter' => Html::activeDropDownList($searchModel, 'employe', ArrayHelper::map(\app\models\Employe::find()->orderBy(["NOM"=>SORT_ASC])->all(),"MATRICULE","fullname"),['class'=>'form-control','prompt' => 'Choisir']),
                'attribute' => 'direction',
                'value' => function ($data) {

                    $jouissance = Jouissance::findOne($data->JOUISSANCE);
                    $decision  = \app\models\Decisionconges::findOne($jouissance->IDDECISION);
                    $employe = Employe::find()->where(["MATRICULE"=>$decision->MATICULE])->one();
                    if($employe != null) return $employe->getFullname(); else return  "";

                },
            ],
            'JOUISSANCE' =>[

                'header' => 'Jouissance',
                'attribute' => 'JOUISSANCE',
                'filter' => Html::activeDropDownList($searchModel, 'JOUISSANCE', ArrayHelper::map(Jouissance::find()->all(),"IDNATURE","NUMERO"),['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    $tab  = Jouissance::findOne($model->JOUISSANCE);
                    return $tab==null?'Inconnu':$tab->NUMERO;
                }
            ],
           /* 'DATEDEBUT'=>[
                'header' => 'Date de début',
                'attribute' => 'DATEDEBUT',
                'value'=>'DATEDEBUT',
                'format' => 'html',
                'filter' => DatePicker::widget([
                    'name'=>'ArretSearch[DATEDEBUT]',
                    'language' => 'fr',
                    'dateFormat' => 'yyyy-MM-dd'
                ]),
            ],
            'DATEFIN'=>[
                'header' => 'Date de fin',
                'attribute' => 'DATEFIN',
                'value'=>'DATEFIN',
                'format' => 'html',
                'filter' => DatePicker::widget([
                    'name'=>'ArretSearch[DATEFIN]',
                    'language' => 'fr',
                    'dateFormat' => 'yyyy-MM-dd'
                ]),
            ],*/
            'DATEDEBUT'=>[
                'header' => 'Date de debut',
                'attribute' => 'DATEDEBUT',
                'value'=>'DATEDEBUT',
                'format' => 'date',
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'DATEDEBUT',
                    'startAttribute' => 'DATEDEBUT',
                    'endAttribute' => 'DATEFIN',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'opens' => 'right',
                        'locale' => [
                            'format' => 'd-m-Y',
                            'cancelLabel' => 'Clear'
                        ]

                    ]
                ]),
            ],
            'STATUT'=>[
                'header' => 'Statut',
                'attribute' => 'STATUT',
                'filter' => Html::activeDropDownList($searchModel, 'STATUT', ["B"=>"Brouillon","A"=>"Annule","V"=>"Valide"],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    return $model->STATUT == null?'Inconnu':$model->getStatut($model->STATUT);
                }
            ],
            [
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'label' => 'Direction',
                'filter' => Html::activeDropDownList($searchModel, 'direction', ArrayHelper::map(\app\models\Direction::find()->all(),"ID","LIBELLE"),['class'=>'form-control','prompt' => 'Choisir']),
                'attribute' => 'direction',
                'value' => function ($data) {
                    $jouissance = Jouissance::findOne($data->JOUISSANCE);
                    $decision  = \app\models\Decisionconges::findOne($jouissance->IDDECISION);
                    $employe = Employe::find()->where(["MATRICULE"=>$decision->MATICULE])->one();
                    if($employe != null) {
                        $d = \app\models\Direction::findOne($employe->DIRECTION);
                        return $d->LIBELLE; } else return  "";

                },
            ],
            [
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'label' => 'Département',
                'filter' => Html::activeDropDownList($searchModel, 'departement', ArrayHelper::map(\app\models\Departements::find()->all(),"CODEDPT","LIBELLE"),['class'=>'form-control','prompt' => 'Choisir']),
                'attribute' => 'departement',
                'value' => function ($data) {

                    $jouissance = Jouissance::findOne($data->JOUISSANCE);
                    $decision  = \app\models\Decisionconges::findOne($jouissance->IDDECISION);

                    $employe = Employe::find()->where(["MATRICULE"=>$decision->MATICULE ])->one();

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
                'filter' => Html::activeDropDownList($searchModel, 'service', ArrayHelper::map(\app\models\Service::find()->all(),"ID","LIBELLE"),['class'=>'form-control','prompt' => 'Choisir']),
                'attribute' => 'service',
                'value' => function ($data) {

                    $jouissance = Jouissance::findOne($data->JOUISSANCE);
                    $decision  = \app\models\Decisionconges::findOne($jouissance->IDDECISION);

                    $employe = Employe::find()->where(["MATRICULE"=>$decision->MATICULE])->one();
                    if($employe != null) {
                        $d = \app\models\Service::findOne($employe->SERVICE);
                        return $d->LIBELLE; } else return  "";
                },
            ],
            //'DATEEMIS',
            //'DATEVAL',
            //'DATEANN',
            //'COMMENTAIRE:ntext',
            //'DOCUMENT',

            ['class' => 'yii\grid\ActionColumn','template'=>$vue],
        ],
    ]); ?>
    </div>
</div>
