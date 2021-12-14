<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Decisionconges */

$this->title = 'Modifier la décision de congés';
$this->params['breadcrumbs'][] = ['label' => 'Décisions de congés', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DECISION, 'url' => ['view', 'id' => $model->ID_DECISION]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="decisionconges-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
