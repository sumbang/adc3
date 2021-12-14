<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Habilitation;
use yii\web\User;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HabilitationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Habilitations';
$this->params['breadcrumbs'][] = $this->title;


$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M16";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="habilitation-index">

    <p>
        <?php if($habilation->ACREATE == 1) echo Html::a('Créer une habilitation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php

    $vue = "";

    if ($habilation->AREAD== 1) $vue .= "{view} ";
    if ($habilation->AUPDATE == 1) $vue .= "{update} ";
    if ($habilation->ADELETE == 1) $vue .= "{delete}";

   echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID',
            'CODEMENU'=>[
                'header' => 'Menu',
                'attribute' => 'CODEMENU',
                'filter' => Html::activeDropDownList($searchModel, 'CODEMENU', ArrayHelper::map(Menus::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"CODE","LIBELLE"),['class'=>'form-control','prompt' => 'Tout']),
                'content' => function($model){
                    $current = Menus::findOne($model->CODEMENU);
                    if($current != null) return $current->LIBELLE; else return "";
                }
            ],
            'CODEROLE'=>[
                'header' => 'Role',
                'attribute' => 'CODEROLE',
                'filter' => Html::activeDropDownList($searchModel, 'CODEROLE', ArrayHelper::map(Roles::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"CODE","LIBELLE"),['class'=>'form-control','prompt' => 'Tout']),
                'content' => function($model){
                    $current = Roles::findOne($model->CODEROLE);
                    if($current != null) return $current->LIBELLE; else return "";
                }
            ],
            'ACREATE'=>[
                'header' => 'Création',
                'attribute' => 'ACREATE',
                'filter' => Html::activeDropDownList($searchModel, 'ACREATE',[1=>'OUI',0=>'NON'],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    if($model->ACREATE == 0) return "NON";
                    else return "OUI";
                }
            ],
            'AREAD'=>[
                'header' => 'Lecture',
                'attribute' => 'AREAD',
                'filter' => Html::activeDropDownList($searchModel, 'AREAD',[1=>'OUI',0=>'NON'],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    if($model->AREAD == 0) return "NON";
                    else return "OUI";
                }
            ],
            'AUPDATE'=>[
                'header' => 'Modification',
                'attribute' => 'AUPDATE',
                'filter' => Html::activeDropDownList($searchModel, 'AUPDATE',[1=>'OUI',0=>'NON'],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    if($model->AUPDATE == 0) return "NON";
                    else return "OUI";
                }
            ],
            'ADELETE'=>[
                'header' => 'Suppression',
                'attribute' => 'ADELETE',
                'filter' => Html::activeDropDownList($searchModel, 'ADELETE',[1=>'OUI',0=>'NON'],['class'=>'form-control','prompt' => 'Choisir']),
                'content' => function($model){
                    if($model->ADELETE == 0) return "NON";
                    else return "OUI";
                }
            ],

            ['class' => 'yii\grid\ActionColumn','template'=>$vue],
        ],
    ]); ?>
</div>
