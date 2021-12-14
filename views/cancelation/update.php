<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cancelation */

$this->title = 'Modifier la suspension';
$this->params['breadcrumbs'][] = ['label' => 'Suspensions de jouissance', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="cancelation-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
