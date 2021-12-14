<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\USER */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->TOKEN]);

?>
<div class="password-reset">

    <p>Bonjour <?= $user->NOM ?>,</p>

    <p>Cliquez sur le lien suivant pour créer un nouveau mot de passe :</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>

</div>
