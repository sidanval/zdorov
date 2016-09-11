<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    //['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Пользователи',
                        'url' => ['user/index'],
                        'icon' => 'fa fa-user',
                        'visible' => !Yii::$app->user->isGuest && Yii::$app->user->getIdentity()->isAdmin,
                        'active' => Yii::$app->controller->id == 'user'
                    ],
                    [
                        'label' => 'Заказы',
                        'icon' => 'fa fa-ticket',
                        'url' => ['purchase/index'],
                        'active' => Yii::$app->controller->id == 'purchase'
                    ],
                    [
                        'label' => 'История',
                        'icon' => 'fa fa-history',
                        'url' => ['history/index'],
                        'active' => Yii::$app->controller->id == 'history'
                    ],
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'], 'visible' => YII_DEBUG],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'], 'visible' => YII_DEBUG],
                ],
            ]
        ) ?>

    </section>

</aside>
