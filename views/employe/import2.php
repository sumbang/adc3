<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Alert;


/* @var $this yii\web\View */
/* @var $model app\models\Produits */

$this->title = 'Mise à jour des employés';
$this->params['breadcrumbs'][] = ['label' => 'Employes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produits-create">

    <?= Alert::widget() ?>

    <?= Html::beginForm(['import2'],'post',['enctype' => 'multipart/form-data']);?>

    <div>

        <label>Fichier de donn&eacute;es &agrave; importer</label><br>

        <input type="file" name="fichier" id="fichier" required accept=".xls,.xlsx" /> <br>


    </div>

    <input type="hidden" name="imp" id="imp" value="1" />

    <button type="submit" style="float: left" class="btn btn-success">Importer le fichier</button><br><br>
    <br><br>

    <?= Html::endForm();?>

</div>
