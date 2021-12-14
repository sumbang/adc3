<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Exercice */

$this->title = 'Create Exercice';
$this->params['breadcrumbs'][] = ['label' => 'Exercices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercice-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
