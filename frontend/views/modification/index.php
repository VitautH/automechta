<?php

use common\models\AutoMakes;
use common\models\AutoRegions;

$this->registerJs("require(['controllers/modification/searchForm']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/modification/index']);", \yii\web\View::POS_HEAD);
$this->registerJs(" $('[name=\"AutoSearch[model]\"]').empty();", \yii\web\View::POS_HEAD);
$this->registerJsFile("/js/modernizm.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/css/modification-index-style.css');

?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Энциклопедия автомобилей</span></li>
        </ul>
    </div>
</div>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <h3>Энциклопедия автомобилей</h3>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-3 col-12">
            <?= $this->render('_searchForm', $_params_) ?>
            <div class="ads-block mt-1">
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
        <div class="col-lg-9 col-12">
            <div class="marks-list">
                <?php

                foreach (AutoRegions::find()->all() as $i=>$region):
                    if ($i == 0 ){
                    $classHidden = null;
                    $classActive = 'country-active';
                    }
                    else {
                        $classHidden = 'hidden';
                        $classActive = 'country-hidden';;
                    }
                    ?>
                    <div class="row">
                        <div class="country <?php echo $classActive;?>" data-to="country_<?php echo $i;?>">
                        <h3><?php echo $region->region_name; ?><i class="fas fa-chevron-up"></i></h3>
                        </div>
                    </div>
                    <div id="country_<?php echo $i;?>" class="row <?php echo $classHidden;?>">
                        <?php
                        foreach (AutoMakes::find()->where(['region_id' => $region->id])->all() as $model):
                            ?>
                            <div class="mark col-lg-3 col-6">
                                <a href="/catalog/<? echo $model->slug; ?>">
                                    <div class="item">
                                    <div class="mark_logo" style="background-image: url(<?php echo $model->url;?>);"></div>
                                    </div>
                                    <span class="mark_name"> <?php echo $model->name; ?></span>
                                </a>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>
<div class="hidden-desktop mt-1">
    <!-- Yandex.RTB R-A-288803-2 -->
    <div id="yandex_rtb_R-A-288803-2"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Context.AdvManager.render({
                    blockId: "R-A-288803-2",
                    renderTo: "yandex_rtb_R-A-288803-2",
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