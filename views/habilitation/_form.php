<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $model app\models\Habilitation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="habilitation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CODEMENU')->dropDownList(ArrayHelper::map(Menus::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"CODE","LIBELLE")) ?>

    <?= $form->field($model, 'CODEROLE')->dropDownList(ArrayHelper::map(Roles::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"CODE","LIBELLE")) ?>

    <?= $form->field($model, 'ACREATE')->dropDownList([0 => "Non", 1=> "OUi"]) ?>

    <?= $form->field($model, 'AREAD')->dropDownList([0 => "Non", 1=> "OUi"])  ?>

    <?= $form->field($model, 'AUPDATE')->dropDownList([0 => "Non", 1=> "OUi"])  ?>

    <?= $form->field($model, 'ADELETE')->dropDownList([0 => "Non", 1=> "OUi"])  ?>

    <div class="form-group">
        <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
