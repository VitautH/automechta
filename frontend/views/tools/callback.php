<?php

use yii\widgets\ActiveForm;
use Yii;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use \common\models\Callback;

Yii::$app->view->registerMetaTag([
    'name' => 'robots',
    'content' => 'noindex, nofollow'
]);
$this->title = 'Вопрос ответ';
$this->registerJsFile('/js/dropdown.js');
$this->registerJs("require(['controllers/tools/callback']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/tools/chat']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/site/moment']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/site/cookie']);", \yii\web\View::POS_HEAD);
$this->registerCssFile("/css/chat.css");
AppAsset::register($this);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><a href="/site/contact">Контакты<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Вопрос ответ</span></li>
        </ul>
    </div>
</div>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-12">
            <h3>Вопрос-ответ</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <h4>Ответы на частые вопросы клиентов</h4>
        </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 no-padding">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="collapsed" aria-expanded="false">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                                Мне 20 лет, есть отсрочка от армии, на какой срок я могу взять кредит?
                        </h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    </a>
                    <div id="collapse1" class="panel-collapse collapse in">
                        <div class="panel-body"> Вы можете взять кредит только на время действия отсрочки.</div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="collapsed" aria-expanded="false">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                                Имею вид на жительство и постоянное место работы в РБ, могу ли я взять автомобиль в
                                кредит?
                        </h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    </a>
                    <div id="collapse2" class="panel-collapse collapse">
                        <div class="panel-body">Можете, но только на срок действия вида на жительства в РБ</div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">

                    <div class="panel-heading">
                        <h4 class="panel-title">
                                Все ли автомобили, из размещённых на вашем сайте объявлений, имеются в наличии и
                                находятся у вас на стоянке?
                        </h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    </a>
                    <div id="collapse3" class="panel-collapse collapse">
                        <div class="panel-body">
                            Если вы нашли автомобиль на нашем сайте в рубрике <b>"Автомобили кампании"</b>, все
                            автомобили из
                            этого раздела в наличии и находятся на площадке. Если же в рубрике <b>"Частные
                                объявления"</b>, то
                            необходимо звонить владельцу по № телефона указанном в объявлении, и уточнять информацию о
                            наличии и состоянии, номер размещен рядом с фотографией,
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">

                    <div class="panel-heading">
                        <h4 class="panel-title">
                                Кто может купить автомобиль в кредит?
                        </h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    </a>
                    <div id="collapse4" class="panel-collapse collapse">
                        <div class="panel-body"><p>Для того чтобы приобрести авто в кредит вам необходимо официально (по
                                трудовой книжке) работать на территории РБ не менее 3-х месяцев. При наличии судимости,
                                судимость должна быть погашена. Возраст: 18-62 лет , сумма до 5000р. выдаётся без
                                справок о
                                доходах , свыше 5000р. нужна справка о доходах за последние 3 месяца.</p>
                            <p> Мужчинам призывного
                                возраста иметь приписное или военный билет либо служебное удостоверение. Женщины ,
                                находящиеся в декретном отпуске автокредит получить не могут. При наличии действующих
                                кредитов, должна быть хорошая кредитная история. При получения кредита до 5000р.
                                официальная
                                зарплата должна быть не менее 250р.</p>
                            <p> Справка о доходах может быть произвольной формы, но
                                обязательно должна содержать следующее: паспортные данные с личным номером, дату
                                трудоустройства на последнее место работы, дату окончания контракта(договора),
                                заключённого
                                между работодателем и работником, должность работника и таблицу зарплат с вычетами.
                                Справку
                                можно скачать с нашего сайта.</p>
                            <p>
                                Если вы нашли автомобиль на нашем сайте в рубрике <b>"Автомобили кампании"</b>, то он
                                имеется в наличии. Если же в рубрике <b>"Частные объявления"</b>, то нужно звонить
                                по № телефонов, которые размещены рядом с фотографией.</p>
                            <p>
                                Имея вышеперечисленные документы, вы
                                должны приехать по адресу: г. Минск, ул. Суражская, 8а. Сначала определяетесь по
                                кредиту,
                                затем по автомобилю. При положительном ответе из банка, мы с Вами созвонимся с
                                собственником
                                автомобиля и либо он к нам приедет или Вы с нашим сотрудником вместе проедите и
                                осмотрите
                                автомобиль, так же у нас есть много партнёром других автостоянок с большим выбором
                                автомобилей.</p>
                            <p>
                                После этого оформляется на необходимую сумму кредит и оформляется счёт-справка
                                и все необходимые документы для ГАИ. Первоначальный взнос вносится по желанию
                                кредитополучателя.</p>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                    <div class="panel-heading">
                        <h4 class="panel-title">

                                Принимаете ли вы автомобили в зачёт?
                        </h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    </a>
                    <div id="collapse5" class="panel-collapse collapse">
                        <div class="panel-body">Да принимаем. Для этого вам нужно на автомобиле приехать по адресу: г.
                            Минск, ул. Суражская, 8а. Наш оценщик оценит его, и, если вас устраивает наша цена, мы
                            примем Ваш автомобиль в зачет нового при этом официально оформим сделку.
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                                С какого возраста можно купить автомобиль в кредит?
                        </h4>
                        <i class="fas fa-chevron-down"></i>

                    </div>
                    </a>
                    <div id="collapse6" class="panel-collapse collapse">
                        <div class="panel-body">Купить автомобиль в кредит можно в возрасте от 18 до 62 лет.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-row">
    <div class="container">
        <div class="row">
            <h3>Не нашли ответ на интересующий вопрос?</h3>
        </div>
        <div class="row">
            <h4>Задайте вопрос и мы ответим в ближайшее время</h4>
        </div>
            <div class="row justify-content-center">
                <a href="#callback" class="mt-lg-4 mt-2 custom-button">
                    <i class="fas fa-plus"></i>
                    Задать вопрос
                </a>
            </div>
        </div>
    </div>
<div class="content">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-success direct-chat direct-chat-success">
                <!-- /.box-header -->
                <div class="box-body" style="">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">
                        <!-- Message. Default to the left -->
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-timestamp pull-left"></span>
                            </div>
                            <!-- /.direct-chat-info -->
                            <div class="direct-chat-img manager-avatar"></div>
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                Добро пожаловать в открытую линию компании АвтоМечта!
                                Вам ответит первый освободившийся оператор.
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                        <?php

                        if ($username == null) {
                            $username = 'Гость';
                        }

                        foreach ($dialog as $message):
                            ?>
                            <?php
                            if ($message->from == 'manager'):
                                if (($message->message != null) && ($message->attach == null)):
                                    ?>
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left">Менеджер</span>
                                            <span class="direct-chat-timestamp pull-left"><?php echo $message->time; ?></span>
                                        </div>
                                        <!-- /.direct-chat-info -->
                                        <div class="direct-chat-img manager-avatar"></div>
                                        <!-- /.direct-chat-img -->
                                        <div class="direct-chat-text">
                                            <?php
                                            echo $message->message;
                                            ?>
                                        </div>
                                        <!-- /.direct-chat-text -->
                                    </div>
                                <?php
                                endif;
                                if (($message->message == null) && ($message->attach != null)):
                                    ?>
                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left">Менеджер</span>
                                            <span class="direct-chat-timestamp pull-left"><?php echo $message->time; ?></span>
                                        </div>
                                        <div class="media">
                                            <a href="<?php echo $message->attach; ?>" target="_blank">
                                                <img class="media-object" src='<?php echo $message->attach; ?>'/>
                                            </a>
                                        </div>
                                    </div>
                                <?
                                endif;
                            endif;
                            ?>
                            <?php
                            if ($message->from == 'user'):
                                if (($message->message == null) && ($message->attach != null)):
                                    ?>
                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-right"><?php echo $username; ?></span>
                                            <span class="direct-chat-timestamp pull-right"><?php echo $message->time; ?></span>
                                        </div>
                                        <div class="media">
                                            <img class="media-object" src='<?php echo $message->attach; ?>'/>
                                        </div>
                                    </div>
                                <?php
                                endif;
                                if (($message->message != null) && ($message->attach == null)):
                                    ?>
                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-right"><?php echo $username; ?></span>
                                            <span class="direct-chat-timestamp pull-right"><?php echo $message->time; ?></span>
                                        </div>
                                        <!-- /.direct-chat-info -->
                                        <div class="direct-chat-img guest-avatar" style="background-image: url('<?php echo $avatarUrl; ?>');"></div>
                                        <div class="direct-chat-text">
                                            <?php
                                            echo $message->message;
                                            ?>
                                        </div>
                                        <!-- /.direct-chat-text -->
                                    </div>
                                <?php
                                endif;
                                ?>
                            <?php
                            endif;
                        endforeach;
                        ?>
                        <!-- /.direct-chat-msg -->

                        <!-- Message to the right -->
                        <!-- /.direct-chat-msg -->
                    </div>
                    <!--/.direct-chat-messages-->
                </div>
                <!-- /.box-body -->
                <div class="box-footer" style="">
                    <a name="callback"></a>
                        <div class="advance-input-group col-12 col-lg-6 offset-lg-3 offset-0 no-padding-mobile ">
                            <div class="welcome">Заполните форму, пожалуйста</div>
                            <?php
                           if (($site_user_id == null) && ($blockIntroduceYourself == true)):?>
                            <form id="whois">
                                <div class="contact-information-input-group input-group">
                            <input type="text" name="user_name" placeholder="Имя"
                                   class="user-name form-control">
                            <input type="text" name="contact" placeholder="Телефон/E-mail"
                                   class="contact form-control">
                           <input type="submit" class="custom-button hidden-mobile" value="Представиться">
                                </div>
                                <input type="submit" class="form-control custom-button hidden-desktop" value="Представиться">

                            </form>
                            <?php
                            endif;
                            ?>
                            <form action="#" method="post" id="live_chat">
                        <input type="hidden" value="<?php echo Yii::$app->session->getId(); ?>" name="user_id">
                        <input type="hidden" value="<?php echo $site_user_id; ?>" name="site_user_id">
                        <input type="hidden" value="<?php echo $avatarUrl; ?>" name="avatarUrl">
                        <input type="hidden" value="<?php if ($username != 'Гость') {
                            echo $username;
                        } ?>" name="username">
                        <div class="input-group">
                            <textarea name="message" rows="5" placeholder="Введите сообщение ..." class="form-control" required></textarea>
                        </div>
                            <div class="form-footer-button">
<!--                                <div class="upload-btn-wrapper hidden-mobile">-->
<!--                                    <button title="Отправить изображение"><span class="fa fa-cloud-upload"></span></button>-->
<!--                                    <div title="Отправить изображение" class="bx-messenger-textarea-file"-->
<!--                                         style="display: inline-block;">-->
<!--                                        <input type="file" id="file" name="chat-file" accept="image/*"/>-->
<!--                                    </div>-->
<!--                                </div>-->
                        <button type="submit" class="custom-button">Отправить <i class="fas fa-chevron-right ml-2"></i></button>
                      </div>
                    </form>
                </div>
                </div>
                <!-- /.box-footer-->
            </div>
        </div>
    </div>
</div>
</div>
<div class="bottom">
    <div class="container">
        <div class="row">
<div class="col-12 col-lg-6 offset-0 offset-lg-3">
    <h4>или</h4>
    <h3>закажите обратный звонок</h3>
        <?php echo Html::beginForm(['/tools/callback'], 'post', ['id' => 'callback-form']); ?>
    <div class="contact-information-input-group input-group">
        <?php echo  Html::textInput('Callback[name]', '', ['placeholder' => 'Имя*', 'class'=>'user-name form-control','required'=>true,'id' => 'callback-name-field']); ?>
     <?php echo Html::textInput('Callback[phone]', '', ['placeholder' => 'Телефон*', 'class'=>'phone form-control','required'=>true,'id' => 'callback-phone-field']); ?>
        <?php echo Html::submitButton('Отправить <i class="fas fa-chevron-right ml-2"></i>', ['class' => 'custom-button']); ?>
    </div>
    <?php echo Html::endForm(); ?>
</div>
        </div>
    </div>
</div>