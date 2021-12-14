<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $model app\models\Habilitation */

$this->title = "Détail de l'habilitation";
$this->params['breadcrumbs'][] = ['label' => 'Habilitations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M16";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="habilitation-view">

    <p>
        <?php if($habilation->AUPDATE == 1) echo Html::a('Modifier', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?php if($habilation->ADELETE == 1) echo Html::a('Supprimer', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'ID',
            'CODEMENU'=>[
                'label' => 'Menu',
                'value'=>$model->getMenu(),
            ],
            'CODEROLE'=>[
                'label' => 'Role',
                'value'=>$model->getRole(),
            ],
            'ACREATE',
            'AREAD',
            'AUPDATE',
            'ADELETE',
        ],
    ]) ?>

</div>
