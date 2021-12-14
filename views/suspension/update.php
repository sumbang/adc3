<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Suspension */

$this->title = 'Modifier la suspension';
$this->params['breadcrumbs'][] = ['label' => 'Suspensions de contrats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_SUSPENSION, 'url' => ['view', 'id' => $model->ID_SUSPENSION]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="suspension-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
