<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ampliation */

$this->title = 'Modifier l \'ampliations';
$this->params['breadcrumbs'][] = ['label' => 'Ampliations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ampliation-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
