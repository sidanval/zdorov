<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\Purchase;
use common\models\Product;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Purchase(['scenario' => 'frontend']);
        $products = Product::find()->all();

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();

            Yii::$app->session->setFlash('success', 'Заказ успешно оформлен. 
                Менеджер свяжется с вами в ближайшее время.');


            return $this->redirect(Url::to(['/']));
        }

        return $this->render('index', [
            'model' => $model,
            'products' => $products,
        ]);
    }
}
