<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Форма заказа</h1>

        <div style="max-width: 400px; margin: auto">
            <?php $form = ActiveForm::begin(); ?>
                <p class="lead">
                    <?= $form->field($model, 'clientName')->textInput() ?>
                </p>

                <p class="lead">
                    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(),([
                        'mask' => '+7 (999) 999-99-99'
                    ])) ?>
                </p>

                <p class="lead">
                    <?= $form->field($model, 'comment')->textarea() ?>
                </p>

                <p class="lead">
                    <?= $form->field($model, 'product_id')->dropDownList(
                        ArrayHelper::map($products, 'id', 'name'),
                        ['prompt' => 'Выберите товар']
                    )?>
                </p>

            <?php /*dump($model->getErrors());*/?>

                <p><button class="btn btn-lg btn-success" type="submit">Заказать</button></p>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
