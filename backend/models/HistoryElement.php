<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "historyElement".
 *
 * @property integer $id
 * @property integer $history_id
 * @property string $field
 * @property string $oldValue
 * @property string $newValue
 */
class HistoryElement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'historyElement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['history_id', 'field', 'oldValue', 'newValue'], 'required'],
            [['history_id'], 'integer'],
            [['field', 'oldValue', 'newValue'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'history_id' => 'History ID',
            'field' => 'Field',
            'oldValue' => 'Old Value',
            'newValue' => 'New Value',
        ];
    }

    public function getHistory()
    {
        return $this->hasOne(History::className(), ['id' => 'history_id']);
    }
}
