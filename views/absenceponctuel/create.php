<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Absenceponctuel */

$this->title = 'Créer une demande de permission';
$this->params['breadcrumbs'][] = ['label' => 'Demande de permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="absenceponctuel-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
