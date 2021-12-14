<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\Alert;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use app\models\Menus;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExerciceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exercices';
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M2";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="exercice-index">

    <p>
        <?php if($habilation->ACREATE == 1) echo Html::a('Créer un exercice', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Alert::widget() ?>

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

            'ANNEEEXIGIBLE',
            'DATEBEDUT'=>[
                'header' => 'Date de début',
                'attribute' => 'DATEBEDUT',
                'value'=>'DATEBEDUT',
                'format' => 'html',
                'filter' => DatePicker::widget([
                    'name'=>'ExerciceSearch[DATEBEDUT]',
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
                    'name'=>'ExerciceSearch[DATEFIN]',
                    'language' => 'fr',
                    'dateFormat' => 'yyyy-MM-dd'
                ]),
            ],
            'STATUT'=>[

                'header' => 'Statut',
                'attribute' => 'STATUT',
                'filter' => Html::activeDropDownList($searchModel, 'STATUT', ["B"=>"BROUILLON","O"=>"OUVERT","F"=>"CLOTURE"],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    if($model->STATUT == "B") return "BROUILLON";
                    else if($model->STATUT == "O") return "OUVERT";
                    else if($model->STATUT == "F") return "CLOTURE";
                }
            ],
            'DATEOUVERT'=>[
                'header' => 'Date d\'ouverture',
                'attribute' => 'DATEOUVERT',
                'value'=>'DATEOUVERT',
                'format' => 'html',
                'filter' => DatePicker::widget([
                    'name'=>'ExerciceSearch[DATEOUVERT]',
                    'language' => 'fr',
                    'dateFormat' => 'yyyy-MM-dd'
                ]),
            ],
            //'DATECLOTURE',

            ['class' => 'yii\grid\ActionColumn','template'=>$vue],
        ],
    ]); ?>
</div>
