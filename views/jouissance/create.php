<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Jouissance */

$this->title = 'Créer une jouissance';
$this->params['breadcrumbs'][] = ['label' => 'Jouissances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jouissance-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
