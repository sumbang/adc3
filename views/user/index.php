<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestion des comptes';
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M17";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="user-index">

    <p>
        <?php if($habilation->ACREATE == 1) echo Html::a('Ajouter un compte', ['create'], ['class' => 'btn btn-success']) ?>
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

           // 'IDUSER',
            'EMAIL:email',
            //'PASSWORD',
           // 'DATECREATION',
           // 'TOKEN',
            //'AUTHKEY',
            'NOM',
            'ROLE'=>[
                'header' => 'Role',
                'attribute' => 'ROLE',
                'filter' => Html::activeDropDownList($searchModel, 'ROLE', ArrayHelper::map(Roles::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"CODE","LIBELLE"),['class'=>'form-control','prompt' => 'Tout']),
                'content' => function($model){
                    $current = Roles::findOne($model->ROLE);
                    if($current != null) return $current->LIBELLE; else return "";
                }
            ],
            'NIVEAU'=>[
                'header' => 'Niveau d\'accès ',
                'attribute' => 'NIVEAU',
                'filter' => Html::activeDropDownList($searchModel, 'NIVEAU', [1 => 'Niveau 1', 2=> 'Niveau 2'],['class'=>'form-control','prompt' => 'Tout']),
                'content' => function($model){

                    if($model->NIVEAU == 1) return 'Niveau 1';
                    else return 'Niveau 2';
                }
            ],

            'DIRECTION'=>[
                'header' => 'Direction',
                'attribute' => 'DIRECTION',
                'filter' => Html::activeDropDownList($searchModel, 'DIRECTION', ArrayHelper::map(\app\models\Direction::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"ID","LIBELLE"),['class'=>'form-control','prompt' => 'Tout']),
                'content' => function($model){
                    $current = \app\models\Direction::findOne($model->DIRECTION);
                    if($current != null) return $current->LIBELLE; else return "";
                }
            ],

            'DEPARTEMENT'=>[
                'header' => 'Département',
                'attribute' => 'DEPARTEMENT',
                'filter' => Html::activeDropDownList($searchModel, 'DEPARTEMENT', ArrayHelper::map(\app\models\Departements::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"CODEDPT","LIBELLE"),['class'=>'form-control','prompt' => 'Tout']),
                'content' => function($model){
                    $current = \app\models\Departements::findOne($model->DEPARTEMENT);
                    if($current != null) return $current->LIBELLE; else return "";
                }
            ],

            'SERVICE'=>[
                'header' => 'Service',
                'attribute' => 'SERVICE',
                'filter' => Html::activeDropDownList($searchModel, 'SERVICE', ArrayHelper::map(\app\models\Service::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"ID","LIBELLE"),['class'=>'form-control','prompt' => 'Tout']),
                'content' => function($model){
                    $current = \app\models\Service::findOne($model->SERVICE);
                    if($current != null) return $current->LIBELLE; else return "";
                }
            ],

            ['class' => 'yii\grid\ActionColumn','template'=>$vue],
        ],
    ]); ?>
</div>
