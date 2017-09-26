<?php

namespace backend\components;

use Yii;
use common\components\Menu as CommonMenu;

/**
 * Class Menu
 *
 * @package backend\model
 */
class Menu extends CommonMenu
{
    public function __construct(array $config = [])
    {
        if (Yii::$app->user->isGuest) {
            $items = [
                [
                    'label' => Yii::t('app', 'Login'),
                    'url' => ['/site/login'],
                    'items' => [
                        ['label' => Yii::t('app', 'ATM'), 'url' => '/', 'options' => ['class' => 'logo center-align']]
                    ]
                ],
            ];
        } else {
            $items = [
                [
                    'label' => Yii::t('app', 'Home'),
                    'url' => ['site/index'],
                    'visible' => false
                ],
                [
                    'label' => Yii::t('app', 'Users'),
                    'url' => ['users/index'],
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Manage users'),
                            'url' => ['users/index'],
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Create user'),
                                    'url' => ['users/create'],
                                    'options' => ['class' => 'hidden']
                                ],
                                [
                                    'label' => Yii::t('app', 'Update user'),
                                    'url' => ['users/update'],
                                    'options' => ['class' => 'hidden']
                                ],
                            ]
                        ],
                        [
                            'label' => Yii::t('app', 'Manage roles'),
                            'url' => ['roles/index'],
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Create role'),
                                    'url' => ['roles/create'],
                                    'options' => ['class' => 'hidden']
                                ],
                                [
                                    'label' => Yii::t('app', 'Update role'),
                                    'url' => ['roles/update'],
                                    'options' => ['class' => 'hidden']
                                ],
                            ]
                        ],
                        [
                            'label' => Yii::t('app', 'Manage permissions'),
                            'url' => ['permissions/index'],
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Create permission'),
                                    'url' => ['permissions/create'],
                                    'options' => ['class' => 'hidden']
                                ],
                                [
                                    'label' => Yii::t('app', 'Update permission'),
                                    'url' => ['permissions/update'],
                                    'options' => ['class' => 'hidden']
                                ],
                            ]
                        ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Pages'),
                    'url' => ['pages/index'],
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Static pages'),
                            'url' => ['pages/index'],
                            'items' => [
                                ['label' => Yii::t('app', 'Manage pages'), 'url' => ['pages/index']],
                                ['label' => Yii::t('app', 'Create page'), 'url' => ['pages/create']],
                                ['label' => Yii::t('app', 'Update page'), 'url' => ['pages/update']],
                            ],
                        ],
                        [
                            'label' => Yii::t('app', 'News'),
                            'url' => ['news/index'],
                            'items' => [
                                ['label' => Yii::t('app', 'Manage pages'), 'url' => ['news/index']],
                                ['label' => Yii::t('app', 'Create page'), 'url' => ['news/create']],
                                ['label' => Yii::t('app', 'Update page'), 'url' => ['news/update']],
                            ],
                        ],
                    ]
                ],
                [
                    'label' => Yii::t('app', 'Menu'),
                    'url' => ['menu/index'],
                    'items' => [
                        ['label' => Yii::t('app', 'Manage menu'), 'url' => ['menu/index']],
                        ['label' => Yii::t('app', 'Create menu item'), 'url' => ['menu/create']],
                        ['label' => Yii::t('app', 'Update menu item'), 'url' => ['menu/update'], 'options' => ['class' => 'hidden']],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Main page'),
                    'url' => ['slider/index'],
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Manage slider'),
                            'url' => ['slider/index'],
                            'items' => [
                                ['label' => Yii::t('app', 'Manage slider'), 'url' => ['slider/index'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Create slider'), 'url' => ['slider/create'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Update slider'), 'url' => ['slider/update'], 'options' => ['class' => 'hidden']],
                            ],
                        ],
                        [
                            'label' => Yii::t('app', 'Manage teaser'),
                            'url' => ['teaser/index'],
                            'items' => [
                                ['label' => Yii::t('app', 'Manage teaser'), 'url' => ['teaser/index'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Create teaser'), 'url' => ['teaser/create'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Update teaser'), 'url' => ['teaser/update'], 'options' => ['class' => 'hidden']],
                            ],
                        ],
                        [
                            'label' => Yii::t('app', 'Main page data'),
                            'url' => ['mainpage/index'],
                        ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Catalog'),
                    'url' => ['product/index'],
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Product types'),
                            'url' => ['producttype/index'],
                            'items' => [
                                ['label' => Yii::t('app', 'Manage product types'), 'url' => ['producttype/index'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Create product type'), 'url' => ['producttype/create'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Update product type'), 'url' => ['producttype/update'], 'options' => ['class' => 'hidden']],
                            ],
                        ],
                        [
                            'label' => Yii::t('app', 'Specifications'),
                            'url' => ['specification/index'],
                            'items' => [
                                ['label' => Yii::t('app', 'Manage specifications'), 'url' => ['specification/index'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Create specification'), 'url' => ['specification/create'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Update specification'), 'url' => ['specification/update'], 'options' => ['class' => 'hidden']],
                            ],
                        ],
                        [
                            'label' => Yii::t('app', 'Makes'),
                            'url' => ['productmake/index'],
                            'items' => [
                                ['label' => Yii::t('app', 'Manage product make'), 'url' => ['productmake/index'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Create product make'), 'url' => ['productmake/create'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Update product make'), 'url' => ['productmake/update'], 'options' => ['class' => 'hidden']],
                            ],
                        ],
                        [
                            'label' => Yii::t('app', 'Products'),
                            'url' => ['product/index'],
                            'items' => [
                                ['label' => Yii::t('app', 'Manage specifications'), 'url' => ['product/index'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Create specification'), 'url' => ['product/create'], 'options' => ['class' => 'hidden']],
                                ['label' => Yii::t('app', 'Update specification'), 'url' => ['product/update'], 'options' => ['class' => 'hidden']],
                            ],
                        ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Reviews'),
                    'url' => ['reviews/index'],
                    'items' => [
                        ['label' => Yii::t('app', 'Manage reviews'), 'url' => ['reviews/index']],
                        ['label' => Yii::t('app', 'Create review'), 'url' => ['reviews/create']],
                        ['label' => Yii::t('app', 'Update review'), 'url' => ['reviews/update']],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Credit Applications'),
                    'url' => ['credit-application/index'],
                    'items' => [
                        ['label' => Yii::t('app', 'Credit applications view'), 'url' => ['credit-application/view'], 'options' => ['class' => 'hidden']],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Settings'),
                    'url' => ['appdata/index'],
                    'items' => [
                        ['label' => Yii::t('app', 'Settings'), 'url' => ['appdata/index']],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'options' => ['class' => 'mdl-navigation__link mdl-navigation__link-login'],
                    'template' => '<a data-method="post" class="mdl-navigation__link" href="{url}">{label}</a>',
                ],
            ];
        }

        $this->setItems($items);
        parent::__construct($config);
    }
}