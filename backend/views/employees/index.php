<?php

use common\helpers\User as UserHelpers;
use common\models\User;
use backend\models\RecipientMessage;
use backend\models\OwnerMessage;
use backend\models\PrivateMessage;

$name = 'Сотрудники';
$this->title = $name;
$this->registerJs("require(['controllers/employees/message']);", \yii\web\View::POS_HEAD);

$currentUser = User::findOne(Yii::$app->user->id);

?>
<div class="employees-main row">
    <input type="hidden" value="<?php echo $currentUser->first_name.' '.$currentUser->last_name; ?>" class="current-user-name">
    <?php
    foreach ($users as $user):
        $messagesRecipient = RecipientMessage::find()->where(['recipient_user'=>Yii::$app->user->id])->andWhere(['owner_user'=>$user['id']])->orderBy('created_at DESC')->all();
    $messagesOwner = OwnerMessage::find()->where(['owner_user'=>Yii::$app->user->id])->andWhere(['recipient_user'=>$user['id']])->orderBy('created_at DESC')->all();
        ?>
        <div class="modal fade" id="message-for-employees<?php echo $user['id'];?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?php echo $user['first_name'].' '.$user['last_name'];?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <!-- DIRECT CHAT PRIMARY -->
                        <div id="message-for-<?php echo $user['id'];?>" class="box box-primary direct-chat direct-chat-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Сообщения</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <!-- Conversations are loaded here -->
                                <div class="direct-chat-messages">

                                    <?php
                                   foreach ($messagesOwner as $messageOwner):
                                       $message = PrivateMessage::findOne($messageOwner->message_id);
                                    ?>
                                    <!-- Message. Default to the left -->
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left"><?php echo $currentUser->first_name.' '.$currentUser->last_name; ?></span>
                                            <span class="direct-chat-timestamp pull-right"><?php
                                                echo \Yii::$app->formatter->asDatetime($message->created_at, "php:d-m  H:i");
                                                ?></span>
                                        </div>
                                        <?php
                                        $avatar = UserHelpers::getAvatar($currentUser->id, '40', '40', '', 'direct-chat-img');
                                        ?>
                                        <? if ($avatar == null):

                                            $avatar = '<img width="40px" height="40px" class="direct-chat-img" src="/images/noavatar.png">';

                                        endif;
                                        ?>
                                        <?php
                                        echo $avatar;
                                        ?>
                                        <div class="direct-chat-text">
                                            <?php
                                            echo $message->message;
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                            endforeach;
                                    ?>
                                    <?php
                                    foreach ($messagesRecipient as $messageRecipient):
                                        $message = PrivateMessage::findOne($messageRecipient->message_id);
                                        $ownerUser = User::findOne($messageRecipient->owner_user);
                                        ?>
                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-right"><?php echo $ownerUser->first_name.' '.$ownerUser->last_name; ?></span>
                                            <span class="direct-chat-timestamp pull-left"><?php
                                                echo \Yii::$app->formatter->asDatetime($message->created_at, "php:d-m  H:i");
                                                ?></span>
                                        </div>
                                        <?php
                                        $avatar = UserHelpers::getAvatar($ownerUser->id, '40', '40', '', 'direct-chat-img');
                                        ?>
                                        <? if ($avatar == null):

                                            $avatar = '<img width="40px" height="40px" class="direct-chat-img" src="/images/noavatar.png">';

                                        endif;
                                        ?>
                                        <?php
                                        echo $avatar;
                                        ?>
                                        <div class="direct-chat-text">
                                            <?php
                                            echo $message->message;
                                            ?>
                                        </div>

                                    </div>
                                        <!-- Message. Default to the left -->
                                    <?php
                                    endforeach;
                                    ?>
                                    <!-- /.direct-chat-msg -->
                                    <!-- Message to the right -->

                                    <!-- /.direct-chat-msg -->
                                </div>
                                <!--/.direct-chat-messages--
                            </div>
                            <!-- /.box-body -->
                            </div>
                            <div class="box-footer">
                                <form action="#" class="form-message" method="post">
                                    <div class="input-group">
                                        <input type="hidden" name="to" value="<?php echo $user['id'];?>">
                                        <input type="text"  name="message" placeholder="Сообщение ..." class="message-input form-control">
                                        <span class="input-group-btn">
                                            <div data-for="message-for-<?php echo $user['id'];?>" class="send-message btn btn-primary btn-flat">
                                                Отправить
                                            </div>
                      </span>
                                    </div>
                                </form>
                            </div>
                            <!-- /.box-footer-->
                        </div>
                        <!--/.direct-chat -->
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="col-md-4">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username"><?php echo $user['first_name'].' '.$user['last_name'];?></h3>
                    <h5 class="widget-user-desc"><?php echo Yii::t('app', $user['item_name']);?></h5>
                </div>
                <div class="widget-user-image">
                    <?php
                    $avatar = UserHelpers::getAvatar($user['id'], '80px', '80px', '100%', 'img-circle');
                    ?>
                    <? if ($avatar == null):

                        $avatar = '<img class="img-circle" src="/images/noavatar.png" style="width: 80px; height: 80px; border-radius: 100%;">';

                    endif;
                    ?>
                    <?php echo $avatar; ?>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-7 border-right">
                            <div class="description-block">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#message-for-employees<?php echo $user['id'];?>">
                                  Сообщение
                                </button>
                            </div>
                            <!-- /.description-block -->
                        </div>

                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">35</h5>
                                <span class="description-text">PRODUCTS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    <?php
    endforeach;
    ?>
</div>