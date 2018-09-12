<?php
use common\models\AppData;
$this->title= "Продано";
$appData= AppData::getData();
?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Продано</span></li>
        </ul>
    </div>
</div>
    <div class="sold">
   <div class="container">
       <div class="row">
           <div class="col-12 col-lg-8">
               <img src="<?= '/theme/images/sold.jpg'?>"/>
           </div>
           <div class="ads-block col-12 col-lg-3">
               <!-- Yandex.RTB R-A-248508-1 -->
               <div id="yandex_rtb_R-A-248508-1"></div>
               <script type="text/javascript">
                   (function(w, d, n, s, t) {
                       w[n] = w[n] || [];
                       w[n].push(function() {
                           Ya.Context.AdvManager.render({
                               blockId: "R-A-248508-1",
                               renderTo: "yandex_rtb_R-A-248508-1",
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