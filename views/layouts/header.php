<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */


$img_obj_logo = "profile.png";
$img = Url::to('@web/img/').$img_obj_logo;
$logo = '<img src="'.$img.'" width="100" height="auto" />';

$img_obj_profil = "profile.png";
$img1 = Url::to('@web/img/').$img_obj_profil;
$profil = '<img src="'.$img1.'" class="img-circle" alt="User Image" />';
$profil1 = '<img src="'.$img1.'" class="user-image" alt="User Image" />';

?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">ADC</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= $profil1 ?>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->NOM ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?= $profil ?>

                            <p><?= Yii::$app->user->identity->NOM ?></p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php  //Html::a('Mon compte',['/site/compte'],['class' => 'btn btn-default btn-flat']) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Déconnexion',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </nav>
</header>
