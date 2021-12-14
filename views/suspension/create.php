<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Suspension */

$this->title = 'Créer une Suspension';
$this->params['breadcrumbs'][] = ['label' => 'Suspensions de contrats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suspension-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
