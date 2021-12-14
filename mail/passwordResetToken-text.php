<?php

/* @var $this yii\web\View */
/* @var $user app\models\USER */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->TOKEN]);

?>
Bonjour <?= $user->NOM ?>,

Cliquez sur le lien suivant pour créer un nouveau mot de passe :

<?= $resetLink ?>
