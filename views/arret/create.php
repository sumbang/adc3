<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Arret */

$this->title = 'Création du reliquat';
$this->params['breadcrumbs'][] = ['label' => 'Reliquat de jouissance', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arret-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
