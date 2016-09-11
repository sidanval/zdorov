<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый пользователь', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            'email',
            [
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->getStatusTitle();
                },
                'filter' => User::$statuses
            ],
            [
                'attribute' => 'role',
                'value' => function($data) {
                    return $data->getRoleTitle();
                },
                'filter' => User::$roles
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'summary' => 'Показано {begin} - {end} из {totalCount} записей.'
    ]); ?>
</div>
