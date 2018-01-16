<?php
use yii\helpers\Html;
use common\models\ProductType;
?>

<div class="create-ads-step-1 row">
    <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12">
    <header class="s-headerSubmit s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
        <h2 class=""><?= Yii::t('app', 'Select Your Vehicle Type') ?></h2>
    </header>
    <div class="col-md-4 col-md-offset-2 col-xs-12">
        <div class="add-item avto">
            <a href="/create-ads?Product%5Btype%5D=2&ProductForm%5Bstep%5D=2" data-title-profile="Автомобили" data-limit-profile="" class="add-item-link ">
                <div class="add-item-table">
                    <div class="add-item-tablecell">
                        <div class="add-item-wrap">
                            <div class="add-item-icon">
                            </div>
                            <div class="add-item-name">
                                <span>Легковой автомобиль</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-4 col-xs-12">
        <div class="add-item moto">
            <a href="/create-ads?Product%5Btype%5D=3&ProductForm%5Bstep%5D=2" data-title-profile="Автомобили" data-limit-profile="" class="add-item-link ">
                <div class="add-item-table">
                    <div class="add-item-tablecell">
                        <div class="add-item-wrap">
                            <div class="add-item-icon">
                            </div>
                            <div class="add-item-name">
                                <span>Мотоцикл</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
</div>