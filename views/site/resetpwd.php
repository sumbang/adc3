<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Mot de passe oublie';

?>


<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Administration</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

        <h3>Mot de passe oubli&eacute; !</h3>

        <?= Alert::widget() ?>

        <p>Veuillez saisir votre adresse email, puis cliquer sur envoyer. Un lien de réinitialisation vous sera envoyé.</p><br>

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Envoyer', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
