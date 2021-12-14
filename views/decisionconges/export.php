<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Alert;
use app\models\Employe;
use app\models\Exercice;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\models\Typeabsence;
use yii\jui\AutoComplete;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $model app\models\Absenceponctuel */

$this->title = 'Exporter les décisions de congés';
$this->params['breadcrumbs'][] = ['label' => 'Décisions de congés', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="absenceponctuel-form">

    <?= Alert::widget() ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ANNEEEXIGIBLE')->dropDownList(ArrayHelper::map(Exercice::find()->all(),"ANNEEEXIGIBLE","ANNEEEXIGIBLE"),['prompt'=>'choisir','id'=>'exercice','onchange'=>'myexo()']) ?>

    <div class="form-group">
        <?php

        echo Html::submitButton('Exporter les décisions', ['class' => 'btn btn-primary']);

        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

