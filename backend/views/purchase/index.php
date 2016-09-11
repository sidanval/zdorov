<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-index">
    <p>
        <?= Html::a(
            'Скачать CSV',
            array_merge(['csv'], Yii::$app->request->queryParams),
            ['class' => 'btn btn-default'])
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'clientName',
            //'phone',
            //'comment:ntext',
            [
                'attribute' => 'product_id',
                'value' => function($model) {
                    return $model->product ? $model->product->name : '';
                }
            ],
             'cost',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusTitle();
                },
                'filter' => \common\models\Purchase::$statuses
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model) {
                    return $model->created_at ? date('d.m.Y H:i', $model->created_at) : '';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
        'summary' => 'Показано {begin} - {end} из {totalCount} записей.'
    ]); ?>
</div>
