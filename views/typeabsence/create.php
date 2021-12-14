<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Typeabsence */

$this->title = 'Ajouter un type';
$this->params['breadcrumbs'][] = ['label' => 'Types de permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="typeabsence-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
