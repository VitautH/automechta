<?php
use common\models\AppData;
$this->title= "Продано";
$appData= AppData::getData();
?>
<section class="b-pageHeader"
         style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class="wow zoomInLeft" data-wow-delay="0.5s"> Продано </h1>
    </div>
</section>
<!--b-pageHeader-->
<section>
    <div class="b-detail s-shadow">
   <div class="container">
       <div class="row">
           <div class="col-md-3">
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
           <div class="col-md-4 col-md-offset-2">
               <img src="<?= '/theme/images/sold.jpg'?>"/>
           </div>
       </div>
   </div>
    </div>
</section>