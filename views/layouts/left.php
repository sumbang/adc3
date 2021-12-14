<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\USER;
use app\models\Roles;
use app\models\Menus;
use app\models\Tables;
use app\models\Habilitation;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?php

        $compte = USER::findIdentity(Yii::$app->user->identity->IDUSER);

        $habilations = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE])->all(); $menu = array();

        $menu[] = ['label' => 'Menu administration', 'options' => ['class' => 'header']];

        $menu[] = ['label' => 'Tableau de bord', 'icon' => 'dashboard', 'url' => ['site/index']];

        foreach($habilations as $habilation) {

            $menus = Menus::findOne($habilation->CODEMENU); $table = Tables::findOne($menus->CODETABLE);

            if($menus->CODE  == "M6") {

                $lien = [strtolower($table->LIBELLE) . '/update', 'table' => $table->CODE,'id'=>1];

                $menu[] = ['label' => $menus->LIBELLE, 'icon' => 'file-code-o', 'url' => $lien];

            }

            else if($menus->CODE  == "M12") {

                $lien = ['site/page'];

                $menu[] = ['label' => $menus->LIBELLE, 'icon' => 'file-code-o', 'url' => $lien];

            }

           /* else if($menus->CODE  == "M16") {

                $menu2 = array();

                $lien = ['site/employes']; $lien1 = ['site/services']; $lien2 = ['site/annee'];

                $menu2[] = ['label'=>'Par employe','url' => $lien];

                $menu2[] = ['label'=>'Par service','url' => $lien1];

                $menu2[] = ['label'=>'Par annee','url' => $lien1];

                $menu[] = ['label'=>$menus->LIBELLE,'icon'=>'file-code-o','url' => '#', 'items'=>$menu2];


            } */

            else {

                $lien = [strtolower($table->LIBELLE) . '/index', 'table' => $table->CODE];

                $menu[] = ['label' => $menus->LIBELLE, 'icon' => 'file-code-o', 'url' => $lien];

            }
        }

        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $menu,
            ]
        ) ?>


    </section>

</aside>
