<?php

use  \backend\models\LiveChat;
use common\models\User;

$this->title = 'Диалоги (чат)';

?>
<style>
    .chats li {
        width: 100%;
        padding: 7px;
    }

    .chats span.label {
        padding-left: 3px;
        padding-right: 3px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid chats new-chats">
                <div class="box-header with-border">
                    <h3 class="box-title">Новые сообщения</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding" style="">
                    <ul class="nav nav-pills nav-stacked">
                        <?php
                        foreach ($newChats as $newChat):
                            $userSiteId = LiveChat::findOne($newChat['user_id']);
                        if ($userSiteId->site_user_id !== null){
                            $user = User::findOne($userSiteId->site_user_id);
                            $username = $user->first_name . ' ' . $user->last_name;
                        }
                        else {
                            $username = 'Гость № '.$newChat['user_id'] ;
                        }
                            ?>
                            <li><a class="load_dialog" href="#" data-dialog="<?php
                                echo $newChat['user_id'];
                                ?>"><i class="fa fa-inbox"></i><?php
                                    echo $username;
                                    ?>
                                    <span class="label label-primary pull-right"><?php
                                        echo $newChat['count'];
                                        ?></span></a></li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box box-solid chats old-chats">
                <div class="box-header with-border">
                    <h3 class="box-title">Старые  сообщения</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding" style="">
                    <ul class="nav nav-pills nav-stacked">
                        <?php
                        foreach ($oldChats as $oldChat):

                            $userSiteId = LiveChat::findOne($oldChat['user_id']);
                            if ($userSiteId->site_user_id !== null){
                                $user = User::findOne($userSiteId->site_user_id);
                                $username = $user->first_name . ' ' . $user->last_name;
                            }
                            else {
                                $username = 'Гость № '.$oldChat['user_id'] ;
                            }

                            ?>
                            <li><a class="load_dialog" href="#" data-dialog="<?php
                                echo $oldChat['user_id'];
                                ?>"><i class="fa fa-inbox"></i><?php
                                    echo $username;
                                    ?>
                                    </a></li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-8 dialog_box">
            <?php
            if (!empty($dialog)) {
                echo $this->renderAjax('_chat', ['firstChat' => $firstChat, 'dialog' => $dialog]);
            }
            ?>
        </div>
    </div>
</div>
