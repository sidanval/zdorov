<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'История';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    if(!$model->user)
                        return '';

                    if(!Yii::$app->user->getIdentity()->isAdmin)
                        return $model->user->username;

                    return Html::a(
                        $model->user->username,
                        ['user/view', 'id' => $model->user->id],
                        ['target' => '_blank']
                    );
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'purchase_id',
                'value' => function($model) {
                    if(!$model->purchase)
                        return '';

                    return Html::a(
                        $model->purchase->name,
                        ['purchase/view', 'id' => $model->purchase->id],
                        ['target' => '_blank']
                    );
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model) {
                    return $model->updated_at ? date('d.m.Y H:i', $model->updated_at) : '';
                }
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
        'summary' => 'Показано {begin} - {end} из {totalCount} записей.'
    ]); ?>
</div>
