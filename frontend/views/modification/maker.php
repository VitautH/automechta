<?php

use common\models\AutoMakes;
use common\helpers\Url;
use yii\widgets\LinkSorter;

$this->registerCssFile('@web/theme/css/catalog.css');
$this->registerCssFile('@web/css/modification-index-style.css');

//ToDo: Сортировка
//$this->registerJsFile('/js/sort.js');
?>
<script src="/js/sort.js"></script>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><a href="/catalog">Энциклопедия автомобилей<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2"><?php echo $markName; ?></span></li>
        </ul>
    </div>
</div>
<div class="container">
    <div class="logo-row row">
        <div class="col-lg-3">
                                                    <span class="brand-img "
                                                          style="background-image: url('/theme/images/logoAutoMain/<?php echo $logo; ?>');"></span>
            <span class="brand-name"><?php echo $markName; ?></span>

        </div>
    </div>
</div>

<div class="container">
    <div class="title-row row">
        <div class="col-lg-12">
<h3>Характеристикик, спецификации</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        <div class="sorter">
            <span>Сортировать по:</span>
            <?= LinkSorter::widget([
                'sort' => $sort,
                'attributes' => [
                    'alphabet',
                    'year'
                ]
            ]);

            ?>
    </div>
</div>
    </div>
</div>
<div class="container">
    <div class="models row">
        <div class="col-lg-9 col-12">
            <div class="row">
                <?php
                foreach ($models as $model):
                    ?>
                    <div class="col-lg-4 item">
                        <a href="/catalog/<?php echo $markSlug; ;?>/<?php echo $model->slug; ?>">
                            <div class="image_box" style="background-image:url(<?php echo $model->img_url; ?>);">
                            </div>
                        </a>
                        <span> <b><?php echo $model->model; ?></b></span>
                        <span class="cars-models-years"><?php echo $model->years; ?></span>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
        <div class="col-lg-3 hidden-mobile">
            <div class="ads-block">
                <!-- Yandex.RTB R-A-288803-1 -->
                <div id="yandex_rtb_R-A-288803-1"></div>
                <script type="text/javascript">
                    (function(w, d, n, s, t) {
                        w[n] = w[n] || [];
                        w[n].push(function() {
                            Ya.Context.AdvManager.render({
                                blockId: "R-A-288803-1",
                                renderTo: "yandex_rtb_R-A-288803-1",
                                async: true
                            });
                        });
                        t = d.getElementsByTagName("script")[0];
                        s = d.createElement("script");
                        s.type = "text/javascript";
                        s.src = "//an.yandex.ru/system/context.js";
                        s.async = true;
                        t.parentNode.insertBefore(s, t);
                    })(this, this.document, "yandexContextAsyncCallbacks");
                </script>
            </div>
        </div>
    </div>
</div>