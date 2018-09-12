<?php

use yii\helpers\Html;
use common\models\User;
use common\helpers\Url;
use common\helpers\User as UserHelpers;
use backend\models\RecipientMessage;
use backend\models\PrivateMessage;
use backend\models\Reports;
use common\models\Callback;
use common\models\Complaint;
use common\models\Product;
use common\models\CreditApplication;
use backend\models\LiveChatDialog;
use backend\models\Tasks;


/* @var $this \yii\web\View */
/* @var $content string */

$newMessageCount = RecipientMessage::find()->where(['recipient_user' => Yii::$app->user->id])->andWhere(['viewed' => null])->count();
$newMessage = RecipientMessage::find()->where(['recipient_user' => Yii::$app->user->id])->andWhere(['viewed' => null])->limit(4)->orderBy('created_at DESC')->all();
$newReportsCount = Reports::find()->where(['viewed' => Reports::NO_VIEWED])->count();
$newCallbackCount = Callback::find()->where(['viewed' => Callback::NO_VIEWED])->count();
$newComplaintCount = Complaint::find()->where(['=', 'viewed', 0])->count();
$newProductCount = Product::find()->notVerified()->orderBy('created_at DESC')->count();
$newCreditApplicationCount = CreditApplication::find()->orderBy('created_at DESC')->active()->count();
$countChatNewMessage = LiveChatDialog::find()->where(['viewed'=>LiveChatDialog::NO_VIEWED])->count();
$notice = $newReportsCount + $newCallbackCount + $newComplaintCount+$newProductCount+$newCreditApplicationCount+$countChatNewMessage;

$tasks = Tasks::find()->where(['employee_to'=>Yii::$app->user->id])->andWhere(['status'=>Tasks::OPEN_STATUS])->orWhere(['status'=>Tasks::DECLINE_STATUS])->orderBy('priority DESC')->addOrderBy('created_at DESC')->asArray()->all();
$tasksCount = count($tasks);

?>
<div class="popup"></div>
<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <?php
                        if ($newMessageCount > 0):
                            ?>
                            <span class="label label-success"><?php echo $newMessageCount; ?></span>
                        <?php
                        endif;
                        ?>
                    </a>
                    <?php
                    if ($newMessageCount > 0):
                        ?>
                        <ul class="dropdown-menu">
                            <li class="header"><?php echo $newMessageCount; ?> новых сообщений</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php
                                    foreach ($newMessage as $recipientMessage):
                                        $message = PrivateMessage::findOne($recipientMessage->message_id);
                                        $ownerMessage = User::findOne($recipientMessage->owner_user);
                                        ?>
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <?php
                                                    $avatar = UserHelpers::getAvatar($recipientMessage->owner_user, '40', '40', '', 'img-circle');
                                                    ?>
                                                    <? if ($avatar == null):

                                                        $avatar = '<img width="40px" height="40px" class="img-circle" src="/images/noavatar.png">';

                                                    endif;
                                                    ?>
                                                    <?php
                                                    echo $avatar;
                                                    ?>
                                                </div>
                                                <h4>
                                                    <?php
                                                    echo $ownerMessage->first_name . ' ' . $ownerMessage->last_name;
                                                    ?>
                                                    <small><i class="fa fa-clock-o"></i> <?php
                                                        echo \Yii::$app->formatter->asDatetime($message->created_at, "php:d-m  H:i");
                                                        ?></small>
                                                </h4>
                                                <p><?php echo $message->message; ?></p>
                                            </a>
                                        </li>
                                    <?php
                                    endforeach;
                                    ?>
                                </ul>
                            </li>
                            <?php
                            if ($newMessageCount > 4):
                                ?>
                                <li class="footer"><a href="#">Посмотреть все сообщения</a></li>
                            <?php
                            endif;
                            ?>
                        </ul>
                    <?php
                    endif;
                    ?>
                </li>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o notifications-count"></i>
                        <?php
                        if ($notice > 0):
                            ?>
                            <span class="label label-warning"><?php echo $notice; ?></span>
                        <?php
                        endif;
                        ?>
                    </a>
                    <?php
                    if ($notice > 0):
                        ?>
                        <ul class="dropdown-menu">
                            <li class="header"><?php echo $notice; ?> новых уведомлений</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php
                                    if ($newComplaintCount > 0):
                                        ?>
                                        <li>
                                            <a href="/complaint">
                                                <i class="fa fa-warning text-red"></i> <?php echo $newComplaintCount; ?>
                                                жалоб
                                            </a>
                                        </li>
                                    <?php
                                    endif;
                                    ?>
                                    <?php
                                    if ($countChatNewMessage > 0):
                                        ?>
                                        <li>
                                            <a href="/chat/index">
                                                <i class="fa fa-envelope-o text-blue"></i> <?php echo $countChatNewMessage; ?>
                                                сообщений чата
                                            </a>
                                        </li>
                                    <?php
                                    endif;
                                    ?>
                                    <?php
                                    if ($newReportsCount > 0):
                                        ?>
                                        <li>
                                            <a href="/reports/index">
                                                <i class="fa fa-flag-o text-red"></i> <?php echo $newReportsCount; ?>
                                                новых отчётов
                                            </a>
                                        </li>
                                    <?php
                                    endif;
                                    ?>
                                    <?php
                                    if ($newProductCount> 0):
                                        ?>
                                        <li>
                                            <a href="<?= Url::to(['product/index', 'ProductSearch[status]' => Product::STATUS_TO_BE_VERIFIED]) ?>">
                                                <i class="fa fa-money text-blue"></i> <?php echo $newProductCount; ?>
                                                новых объявлений
                                            </a>
                                        </li>
                                    <?php
                                    endif;
                                    ?>
                                    <?php
                                    if ($newCallbackCount > 0):
                                        ?>
                                        <li>
                                            <a href="/callback/index">
                                                <i class="fa fa-phone text-green"></i> <?php echo $newCallbackCount; ?>
                                                обратных звонков
                                            </a>
                                        </li>
                                    <?php
                                    endif;
                                    ?>
                                    <?php
                                    if ($newCreditApplicationCount > 0):
                                        ?>
                                        <li>
                                            <a href="/credit-application/index">
                                                <i class="fa fa-bank text-green"></i> <?php echo $newCreditApplicationCount; ?>
                                                заявок на кредит
                                            </a>
                                        </li>
                                    <?php
                                    endif;
                                    ?>
                                </ul>
                            </li>
                        </ul>
                    <?php
                    endif;
                    ?>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <?php
                        if ($tasksCount > 0):
                        ?>
                        <span class="label label-danger"><?php echo $tasksCount;?> </span>
                        <?php
                        endif;
                        ?>
                    </a>
                    <?php
                    if ($tasksCount > 0):
                    ?>
                    <ul class="dropdown-menu">
                        <li class="header">У вас <?php echo $tasksCount;?> новых задач</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php
                                foreach ($tasks as $task):
                                ?>
                                <li><!-- Task item -->
                                    <a href="/task/show?id=<?php echo $task['id'];?>">
                                        <h3>
                                            <?php
                                            if($task['priority'] == Tasks::HIGH_PRIORITY):
                                                ?>
                                                <i class="icon fa fa-warning" style="color: red;font-size: 18px;margin-right: 5px;"></i>
                                            <?php
                                            endif;
                                            ?>
                                            <?php echo $task['title'];?>
                                        </h3>
                                        <div class="footer-task">
                                            От <?php
                                            $user = User::findOne($task['created_by']);
                                            echo $user->first_name.' '.$user->last_name;
                                            ?>
                                            исполнить к <?php
                                            echo date('d-m-Y', $task['execute_date']);
                                            ?>
                                        </div>
                                    </a>
                                </li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="/task/user">Просмотреть все задачи</a>
                        </li>
                    </ul>
                    <?php
                    endif;
                    ?>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <?php
                $avatar = UserHelpers::getAvatar(Yii::$app->user->id, '', '', '', 'user-image');
                ?>
                <? if ($avatar == null):

                    $avatar = '<img class="user-image" src="/images/noavatar.png">';

                endif;
                ?>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <? echo $avatar; ?>
                        <span class="hidden-xs"><?php echo $userName; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php
                            $avatar = UserHelpers::getAvatar(Yii::$app->user->id, '', '', '', 'img-circle');
                            ?>
                            <? if ($avatar == null):

                                $avatar = '<img class="img-circle" src="/images/noavatar.png">';

                            endif;
                            ?>
                            <?php echo $avatar; ?>

                            <p>
                                <?php echo $userName; ?> - Администратор
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= Url::to(['users/account']) ?>" class="btn btn-default btn-flat">Профиль</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выйти',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
