<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Absenceponctuel */

$this->title = 'Modifier la demande de permission';
$this->params['breadcrumbs'][] = ['label' => 'Demande de permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_ABSENCE, 'url' => ['view', 'id' => $model->ID_ABSENCE]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="absenceponctuel-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
