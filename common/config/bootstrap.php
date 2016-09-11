<?php

use yii\helpers\VarDumper;

function dump($var, $depth = 10, $highlight = true) {
    VarDumper::dump($var, $depth, $highlight);
}

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
