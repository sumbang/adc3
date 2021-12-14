<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Habilitation */

$this->title = 'Créer une habilitation';
$this->params['breadcrumbs'][] = ['label' => 'Habilitations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habilitation-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
