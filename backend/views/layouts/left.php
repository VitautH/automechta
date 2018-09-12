<?php
use common\helpers\User as UserHelpers;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php
                $avatar = UserHelpers::getAvatar(Yii::$app->user->id, '50px', '50px', '100%', 'img-circle');
                ?>
                <? if ($avatar == null):

                    $avatar = '<img class="img-circle" src="/images/noavatar.png">';

                endif;
                ?>
                <?php echo $avatar; ?>
            </div>
            <div class="pull-left info">
                <p><?php echo $userName;?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' =>   [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Домой', 'icon' => 'dashboard', 'url' => ['site/index']],
                    ['label' => 'Модификации', 'icon' => '', 'url' => ['/modifications']],
                    ['label' => 'Сотрудники', 'icon' => 'fa-user-secret', 'url' => ['/employees']],
                    [
                        'label' => 'Отчёты',
                        'icon' => 'fa fa-table',
                        'visible'=>function(){
                            return  Yii::$app->user->can('viewReportField');
                        },
                        'url' => ['#'],
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Отчёты'),
                                'url' => ['reports/index'],
                            ],
                            [
                                'label' => 'Создать поля',
                                'url' => ['report-field/index'],
                            ],
                        ]
                    ],
                    ['label' => 'Пользователи', 'icon' => 'users',
                      'items' =>
                          [
                              [
                                  'label' => 'Пользователи',
                                  'url' => ['users/index'],
                              ],
                         [
                                    'label' => Yii::t('app', 'Create user'),
                                    'url' => ['users/create'],
                                ],
                            ]


                    ],
                    [
                        'label' => 'Роли',
                        'url' => ['#'],
                        'items' => [
                            [
                                'label' => 'Роли',
                                'url' => ['roles/index'],
                            ],
                            [
                                'label' => Yii::t('app', 'Create role'),
                                'url' => ['roles/create'],
                            ],
                        ]
                    ],
                    [
                        'label' => 'Разрешения',
                        'url' => ['#'],
                        'items' => [
                            [
                                'label' => 'Разрешения',
                                'url' => ['permissions/index'],
                            ],
                            [
                                'label' => Yii::t('app', 'Create permission'),
                                'url' => ['permissions/create'],
                            ],
                        ]
                    ],
                    [
                        'label' => Yii::t('app', 'Pages'),
                        'url' => ['#'],
                        'items' => [
                                    ['label' => Yii::t('app', 'Manage pages'), 'url' => ['pages/index']],
                                    ['label' => Yii::t('app', 'Create page'), 'url' => ['pages/create']],
                                ],
                            ],
                    [
                        'label' => 'Новости',
                        'url' => ['#'],
                        'items' => [
                            ['label' => 'Новости', 'url' => ['news/index']],
                            ['label' => 'Создать', 'url' => ['news/create']],
                        ],
                    ],
                    [
                        'label' => Yii::t('app', 'Catalog'),
                        'url' => ['#'],
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Product types'),
                                'url' => ['producttype/index'],
                            ],
                            [
                                'label' => Yii::t('app', 'Specifications'),
                                'url' => ['specification/index'],
                            ],
                            [
                                'label' => Yii::t('app', 'Makes'),
                                'url' => ['productmake/index'],
                            ],
                            [
                                'label' => Yii::t('app', 'Products'),
                                'url' => ['product/index'],
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('app', 'Credit Applications'),
                        'url' => ['credit-application/index'],
                        ],
                    [
                        'label' => Yii::t('app', 'Жалобы'),
                        'url' => ['/complaint'],
                        ],
                    [
                        'label' => Yii::t('app', 'Рассылки'),
                        'url' => ['/mailing-lists/index'],
                        ],
                    [
                        'label' => 'Видео',
                        'url' => ['/parservideo/index'],
                    ],
                    [
                        'label' => Yii::t('app', 'Settings'),
                        'url' => ['appdata/index'],
                        ],
                    [
                        'label' => Yii::t('app', 'Menu'),
                        'url' => ['menu/index'],
                        ],
                    [
                        'label' => Yii::t('app', 'Слайдер'),
                        'url' => ['slider/index'],
                        ],
                    [
                        'label' => Yii::t('app', 'Manage teaser'),
                        'url' => ['teaser/index'],
                        ],
                    [
                        'label' => Yii::t('app', 'Main page data'),
                        'url' => ['mainpage/index'],
                    ],
                    [
                        'label' => Yii::t('app', 'Слайдер'),
                        'url' => ['slider/index'],
                        ],
                    ],
            ]
        ) ?>

    </section>

</aside>
