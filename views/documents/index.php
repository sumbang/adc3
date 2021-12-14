<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Typedocument;
use app\models\Roles;
use app\models\Menus;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestion documentaire';
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M15";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="documents-index">
    <p>
        <?php if($habilation->ACREATE == 1) echo  Html::a('Ajouter un document', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php

    $vue = "";

    if ($habilation->AREAD== 1) $vue .= "{view} ";
    if ($habilation->AUPDATE == 1) $vue .= "{update} ";
    if ($habilation->ADELETE == 1) $vue .= "{delete}";

    echo    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID',
            'NATURE'=> [
                'header' => 'Nature',
                'attribute' => 'NATURE',
                'filter' => Html::activeDropDownList($searchModel, 'NATURE', ArrayHelper::map(Typedocument::find()->all(), "ID", "LIBELLE"), ['class' => 'form-control', 'prompt' => 'Tout']),
                'content' => function ($model) {
                    $current = Typedocument::findOne($model->NATURE);
                    if ($current != null) return $current->LIBELLE; else return "";
                }
            ],
            'LIBELLE',
           // 'DOCUMENT',
           // 'DATECREATION',
            //'IDUSER',

            ['class' => 'yii\grid\ActionColumn','template'=>$vue],
        ],
    ]); ?>
</div>
