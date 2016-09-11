<?php

namespace common\models;

use backend\models\History;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "purchase".
 *
 * @property integer $id
 * @property string $name
 * @property string $clientName
 * @property string $phone
 * @property string $comment
 * @property integer $product
 * @property float $cost
 * @property integer $status
 */
class Purchase extends \yii\db\ActiveRecord
{
    const STATUS_ACCEPT = 0;
    const STATUS_DECLINE = 10;
    const STATUS_DEFECT = 20;

    public static $statuses = [
        self::STATUS_ACCEPT => 'Принята',
        self::STATUS_DECLINE => 'Отказана',
        self::STATUS_DEFECT => 'Брак',
    ];

    const SCENARIO_FRONTEND = 'frontend';
    const SCENARIO_BACKEND = 'backend';

    public static function tableName()
    {
        return '{{%purchase}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function scenarios()
    {
        $scenarios = [
            self::SCENARIO_FRONTEND => ['clientName', 'product_id', 'comment', 'phone']
        ];

        $scenarios[self::SCENARIO_BACKEND] = array_unique(array_merge(
            $scenarios[self::SCENARIO_FRONTEND],
            ['name', 'cost', 'status']
        ));

        return $scenarios;
    }

    public function rules()
    {
        return [
            [['name', 'clientName', 'product_id'], 'required', 'message' => '{attribute} не может быть пустым'],
            [['comment'], 'string'],
            [['product_id'], 'integer'],
            [['name', 'clientName'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['cost'], 'number', 'min' => 0, 'message' => '{attribute} должно быть числом'],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => self::STATUS_ACCEPT],
            [['status'], 'in', 'range' => array_keys(self::$statuses)],
            [['created_at'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'clientName' => 'ФИО',
            'phone' => 'Телефон',
            'comment' => 'Комментарий',
            'product_id' => 'Продукт',
            'cost' => 'Цена',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)) {
            return false;
        }

        if($this->scenario == self::SCENARIO_FRONTEND) {
            $newNumber = (int)static::find()->select('max(id)')->scalar() + 1;

            $this->name = "Заказ №{$newNumber}";
            $this->cost = $this->product->cost;
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if($this->scenario == self::SCENARIO_BACKEND) {
            History::add($this, $changedAttributes);
        }
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getStatusTitle()
    {
        return isset(self::$statuses[$this->status]) ? self::$statuses[$this->status] : '';
    }

    public function transformValue($attribute, $value)
    {
        switch ($attribute) {
            case 'product_id':
                $product = Product::find()->where(['id' => $value])->one();
                return $product ? $product->name : '';
            case 'status':
                return array_key_exists($value, self::$statuses) ? self::$statuses[$value] : '';
        }
        return $value;
    }
}
