<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\Alert;

$this->title = 'Changer votre mot de passe';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];


?>


<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Administration</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

        <h3>Changer votre mot de passe</h3>

        <?= Alert::widget() ?>

        <p>Veuillez définir votre nouveau mot de passe</p><br>

        <div class="row">

            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true])->label("Nouveau mot de passe"); ?>

            <div class="form-group">
                <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
