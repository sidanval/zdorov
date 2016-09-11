<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Purchase */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'clientName',
            'phone',
            'comment:ntext',
            [
                'attribute' => 'product_id',
                'value' => $model->product ? $model->product->name : ''
            ],
            'cost',
            [
                'attribute' => 'status',
                'value' => $model->getStatusTitle()
            ],
            [
                'attribute' => 'created_at',
                'value' => $model->created_at ? date('d.m.Y H:i', $model->created_at) : '',
            ],
            [
                'attribute' => 'updated_at',
                'value' => $model->updated_at ? date('d.m.Y H:i', $model->updated_at) : '',
            ]
        ],
    ]) ?>

</div>
