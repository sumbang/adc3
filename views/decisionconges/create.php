<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Decisionconges */

$this->title = 'Créer une décision de congés';
$this->params['breadcrumbs'][] = ['label' => 'Décisions de congés', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="decisionconges-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
