<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Direction */

$this->title = 'Ajouter une Direction';
$this->params['breadcrumbs'][] = ['label' => 'Directions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="direction-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
