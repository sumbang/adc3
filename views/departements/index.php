<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Roles;
use app\models\Menus;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DepartementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Départements';
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M8";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="departements-index">

    <p>
        <?php if($habilation->ACREATE == 1) echo Html::a('Ajouter un département', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


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

            //'CODEDPT',
            'LIBELLE',

            ['class' => 'yii\grid\ActionColumn','template'=>$vue],
        ],
    ]); ?>
</div>
