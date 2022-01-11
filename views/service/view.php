<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Habilitation;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = "Détail du service";
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M21";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="service-view">

    <p>
        <?php if ($habilation->AUPDATE == 1) echo  Html::a('Modifier', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?php  if ($habilation->ADELETE == 1)  echo Html::a('Supprimer', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'LIBELLE',
        ],
    ]) ?>

</div>
