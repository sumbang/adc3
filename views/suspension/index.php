<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Employe;
use app\models\Exercice;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use app\models\Menus;
use yii\jui\DatePicker;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SuspensionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suspensions de contrats';
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M10";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="suspension-index">

   <p>
       <?php if($habilation->ACREATE == 1) echo Html::a('Créer une Suspension', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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

            //'ID_SUSPENSION',
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
           /* 'DATEDEBUT'=>[
                'header' => 'Date de debut',
                'attribute' => 'DATEDEBUT',
                'value'=>'DATEDEBUT',
                'format' => 'html',
                'filter' => DatePicker::widget([
                    'name'=>'SuspensionSearch[DATEDEBUT]',
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
                    'name'=>'SuspensionSearch[DATEFIN]',
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
                'header' => 'Statut traitement',
                'attribute' => 'STATUT',
                'filter' => Html::activeDropDownList($searchModel, 'STATUT', ["B"=>"Brouillon","A"=>"Annulé","V"=>"Validé"],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    return $model->STATUT == null?'Inconnu':$model->getStatut($model->STATUT);
                }
            ],
            'STATUTLEVEE'=>[
                'header' => 'Statut',
                'attribute' => 'STATUTLEVE',
                'filter' => Html::activeDropDownList($searchModel, 'STATUTLEVE', [0=>"Aucun statut",1=>"Suspension en cours",2=>"Suspension levée"],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    return $model->STATUTLEVE == null?'Inconnu':$model->getStatut2($model->STATUTLEVE);
                }
            ],
            [
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'label' => 'Direction',
                'attribute' => 'direction',
                'value' => function ($data) {
                    $employe = Employe::find()->where(["MATRICULE"=>$data->MATICULE])->one();
                    if($employe != null) return $employe->DIRECTION; else return  "";

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

                        $serv = \app\models\Service::findOne($employe->SERVICE);

                        return ($serv == null)?"":$serv->LIBELLE;

                    } else return  "";

                },
            ],
            //'DATEEMIS',
            //'DATEVAL',
            //'DATEANN',

            ['class' => 'yii\grid\ActionColumn','template'=>$vue],
        ],
    ]); ?>
</div>
