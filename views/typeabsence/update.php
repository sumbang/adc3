<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Typeabsence */

$this->title = 'Modifier le type';
$this->params['breadcrumbs'][] = ['label' => 'Types permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CODEABS, 'url' => ['view', 'id' => $model->CODEABS]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="typeabsence-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
