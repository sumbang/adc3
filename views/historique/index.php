<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistoriqueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historiques de fichiers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historique-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID',
            'LIBELLE',
            'QUANTITE',
            'FICHIER'=> [

                'header' => 'Fichier',
                'attribute' => 'FICHIER',
                'content' => function($model){
                    return Html::a('Ouvrir le fichier', $model->showFile(),['target'=>'_blank']);
                }
            ],

            ['class' => 'yii\grid\ActionColumn','template' => '{view}',
                'buttons' => [
                        'view' => function ($url, $model) {

                    if($model->TYPES == 1) {

                        $url1 = ['#'];

                        return Html::a('<span class="fa fa-eye fa-fw"></span>', $url1, [
                            'title' => Yii::t('app', 'Details'),
                            //'class'=>'btn btn-primary btn-xs',
                        ]);
                    }

                    else {

                        $url1 = ['decisionconges/index','table'=>'T6','HISTORIQUE'=>$model->ID];

                        return Html::a('<span class="fa fa-eye fa-fw"></span>', $url1, [
                            'title' => Yii::t('app', 'Details'),
                            //'class'=>'btn btn-primary btn-xs',
                        ]);

                    }



                         }
                        ]
            ],
        ],
    ]); ?>
</div>
