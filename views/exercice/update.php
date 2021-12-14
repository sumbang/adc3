<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Exercice */

$this->title = 'Modification de l\'exercice';
$this->params['breadcrumbs'][] = ['label' => 'Exercices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercice-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
