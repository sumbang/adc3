<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = 'Modifier le service ';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="service-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
