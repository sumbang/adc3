<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */

$this->title = 'Modifier le document';
$this->params['breadcrumbs'][] = ['label' => 'Gestion documentaire', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documents-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
