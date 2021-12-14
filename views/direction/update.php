<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Direction */

$this->title = 'Modifier la direction';
$this->params['breadcrumbs'][] = ['label' => 'Directions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="direction-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
