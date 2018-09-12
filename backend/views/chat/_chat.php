<?php

use common\helpers\User as UserHelpers;

$avatar = UserHelpers::getAvatar(Yii::$app->user->id, '40', '40', '', 'direct-chat-img');
if ($avatar == null) {

    $avatar = '<img width="40px" height="40px" class="direct-chat-img" src="/images/noavatar.png">';

}
$avatarUrl = UserHelpers::getAvatarUrl(Yii::$app->user->id);
if ($avatarUrl == null) {
    $avatarUrl = 'https://backend.automechta.by/images/noavatar.png';
}
if ($firstChat['user_name'] !== null || $firstChat['site_user_id'] !== null) {
    $user_name = $firstChat['user_name'];
} else {
    $user_name = 'Гость № ' . $firstChat['dialog_id'];
}
if ($firstChat['avatar_url'] !== null) {
    $avatar_user_url = $firstChat['avatar_url'];
} else {
    $avatar_user_url = 'https://backend.automechta.by/images/noavatar.png';
}
?>
<div class="box box-success direct-chat direct-chat-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?php
            echo $user_name;
            ?></h3>

        <div class="box-tools pull-right">
                        <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="<?php
                        echo $firstChat['count'];
                        ?> Новых сообщений"><?php
                            echo $firstChat['count'];
                            ?></span>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                        class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <!-- Conversations are loaded here -->
        <div class="direct-chat-messages" id="chat-<?php
        echo $firstChat['dialog_id'];
        ?>">
            <!-- Request-->
            <?php

            foreach ($dialog as $message):
                ?>
                <?php
                if ($message->from == 'user'):

                    if (($message->message == null) && ($message->attach != null)):
                        ?>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left"><?php echo $user_name;?></span>
                                <span class="direct-chat-timestamp pull-right"><?php echo $message->time; ?></span>
                            </div>
                            <div class="media">
                                <a href="https://automechta.by/<?php echo $message->attach; ?>" target="_blank">
                                    <img class="media-object"
                                         src='https://automechta.by/<?php echo $message->attach; ?>'/>
                                </a>
                            </div>
                        </div>
                    <?php
                    endif;
                    if (($message->message != null) && ($message->attach == null)):
                        ?>
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left"><?php
                                    echo $user_name;
                                    ?></span>
                                <span class="direct-chat-timestamp pull-right">    <?php
                                    echo $message->time;
                                    ?></span>
                            </div>
                            <img width="40px" height="40px" class="direct-chat-img" src="<?php echo $avatar_user_url; ?>">
                            <div class="direct-chat-text">
                                <?php
                                echo $message->message;
                                ?>
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                    <?php
                    endif;
                endif;
                ?>
                <?php
                if ($message->from == 'manager'):
                    if (($message->message == null) && ($message->attach != null)):
                        ?>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">Менеджер</span>
                                <span class="direct-chat-timestamp pull-right"><?php echo $message->time; ?></span>
                            </div>
                            <div class="media">
                                <a href="https://automechta.by/<?php echo $message->attach; ?>" target="_blank">
                                    <img class="media-object"
                                         src='https://automechta.by/<?php echo $message->attach; ?>'/>
                                </a>
                            </div>
                        </div>
                    <?php
                    endif;
                    if (($message->message != null) && ($message->attach == null)):
                        ?>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left"> Менеджер</span>
                                <span class="direct-chat-timestamp pull-right">    <?php
                                    echo $message->time;
                                    ?></span>
                            </div>
                            <?php
                            echo $avatar;
                            ?>
                            <div class="direct-chat-text">
                                <?php
                                echo $message->message;
                                ?>
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                    <?php
                    endif;
                endif;
                ?>
            <?php
            endforeach;
            ?>
        </div>
        <!--/.direct-chat-messages-->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <form>
            <div class="advance-input-group input-group">
                <div class="upload-btn-wrapper">
                    <button title="Отправить изображение"><span class="fa fa-cloud-upload"></span></button>
                    <div title="Отправить изображение" class="bx-messenger-textarea-file"
                         style="display: inline-block;">
                        <input type="file" id="file" name="chat-file" accept="image/*"/>
                    </div>
                </div>
            </div>
        </form>
        <form action="#" method="post" class="chat-form" data-chat="<?php
        echo $firstChat['dialog_id'];
        ?>" data-client_id="<?php
        echo $firstChat['client_id'];
        ?>" data-user_id="<?php
        echo $firstChat['user_id'];
        ?>" data-avatar="<?php echo $avatarUrl; ?>">
            <div class="input-group">
                <textarea rows="5" name="message" placeholder="Введите сообщение..." class="form-control"></textarea>
                <span class="input-group-btn">
                        <button type="submit" class="btn btn-success btn-flat">Отправть</button>
                      </span>
            </div>
        </form>
    </div>
    <!-- /.box-footer-->
</div>