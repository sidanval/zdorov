<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\History */

$this->title = $model->purchase->name . ': история изменений';
$this->params['breadcrumbs'][] = ['label' => 'История', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->purchase->name;
?>
<div class="history-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => !$model->user ? '' : Html::a($model->user->username, [
                    'user/view', 'id' => $model->user_id
                ], ['target' => '_blank']),
                'format' => 'raw'
            ],
            [
                'attribute' => 'purchase_id',
                'value' => !$model->purchase ? '' : Html::a($model->purchase->name, [
                    'purchase/view', 'id' => $model->purchase_id
                ], ['target' => '_blank']),
                'format' => 'raw'
            ],
            [
                'attribute' => 'updated_at',
                'value' => $model->updated_at ? date('d.m.Y H:i', $model->updated_at) : ''
            ]
        ],
    ]) ?>

    <h3>Обновленные поля:</h3>

    <?php $purchase = $model->purchase ? : new \common\models\Purchase() ?>
    <table class="table table-striped table-bordered detail-view">
        <tr>
            <th>Поле</th>
            <th>Старое значение</th>
            <th>Новое значение</th>
        </tr>
        <?php foreach($model->elements as $element): ?>
            <tr>
                <td>
                    <?= $purchase->getAttributeLabel($element->field) ?>
                </td>
                <td>
                    <?= $purchase->transformValue($element->field, $element->oldValue) ?>
                </td>
                <td>
                    <?= $purchase->transformValue($element->field, $element->newValue) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
