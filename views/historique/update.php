<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Historique */

$this->title = 'Update Historique: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Historiques', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="historique-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
