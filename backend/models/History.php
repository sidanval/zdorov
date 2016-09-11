<?php

namespace backend\models;

use common\models\Purchase;
use common\models\User;
use Yii;

/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $purchase_id
 * @property integer $updated_at
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'purchase_id', 'updated_at'], 'required'],
            [['user_id', 'purchase_id', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'purchase_id' => 'Заказ',
            'updated_at' => 'Обновлено',
        ];
    }

    public static function add($model, $changedAttributes = [])
    {
        $historyElements = [];
        foreach ($changedAttributes as $attributeName => $oldValue) {
            $oldValue = (string)$oldValue;
            $newValue = (string)$model->{$attributeName};

            if($oldValue === $newValue)
                continue;

            $historyElement = new HistoryElement();
            $historyElement->field = $attributeName;
            $historyElement->oldValue = $oldValue;
            $historyElement->newValue = $newValue;

            $historyElements[] = $historyElement;
        }

        if(!$historyElements)
            return;

        $history = new static();
        $history->updated_at = time();
        $history->purchase_id = $model->id; //!!!
        $history->link('user', Yii::$app->user->getIdentity());

        /** @var HistoryElement $historyElement */
        foreach($historyElements as $historyElement) {
            $historyElement->link('history', $history);
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPurchase()
    {
        return $this->hasOne(Purchase::className(), ['id' => 'purchase_id']);
    }

    public function getElements()
    {
        return $this->hasMany(HistoryElement::className(), ['history_id' => 'id']);
    }
}
