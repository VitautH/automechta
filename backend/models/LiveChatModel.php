<?php

namespace backend\models;

use yii\base\Model;
use backend\models\LiveChat;
use backend\models\LiveChatDialog;
use yii\db\Query;
use Yii;
use common\models\User;
use common\helpers\User as UserHelper;

class LiveChatModel extends Model
{
    const  NO_VIEWED = 0;
    const  VIEWED = 1;
    public $newDialog;
    public $oldDialog;
    private $dialogId;
    public $dialog;
    public $dialogInfo;

    public function __construct($userId = null, array $config = [])
    {
        if ($userId != null) {
            $dialogId = LiveChat::find()->select('id')->where(['user_id' => $userId])->one()->id;

            $this->dialogId = $dialogId;
        }

        parent::__construct($config);
    }

    public function getNewDialogs()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
SELECT `live_chat_id`, max(time),COUNT(`id`)
FROM live_chat_dialog
WHERE `viewed` = " . LiveChatDialog::NO_VIEWED . "
GROUP BY `live_chat_id`
ORDER BY max(time) DESC");

        $newChats = $command->queryAll();

//ToDo: using Clouser
        $newChatArray = [];
        foreach ($newChats as $chat) {
            $newChatArray[] = [
                'user_id' => $chat['live_chat_id'],
                'count' => $chat["COUNT(`id`)"],
//                'user_name'=> function() use ($chat['live_chat_id']) {
//                $site_user_id = LiveChatDialog::findOne($chat['live_chat_id']);
//                    $user = User::findOne($chatUserInfo->site_user_id);
//                    $username = $user->first_name . ' ' . $user->last_name;
//                }
            ];
        }
        $this->dialogId = $newChatArray[0]['user_id'];
        $this->newDialog = $newChatArray;

        return $this;
    }

    public function getOldDialogs()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
SELECT `live_chat_id`, max(time),COUNT(`id`)
FROM live_chat_dialog
WHERE `viewed` = " . LiveChatDialog::VIEWED . "
GROUP BY `live_chat_id`
ORDER BY max(time) DESC");

        $oldChats = $command->queryAll();


        $oldChatArray = [];
        foreach ($oldChats as $chat) {
            $oldChatArray[] = [
                'user_id' => $chat['live_chat_id'],
            ];
        }

        $this->oldDialog = $oldChatArray;

        return $this;
    }

    /*
     * Get dialog
     */
    public function getDialog($chatId = null)
    {
        if ($chatId !== null) {
            $this->dialogId = $chatId;
        }

        $count = LiveChatDialog::find()
            ->where(['live_chat_id' => $this->dialogId])
            ->andWhere(['viewed' => LiveChatDialog::NO_VIEWED])
            ->count();

        $chatUserInfo = LiveChat::findOne($this->dialogId);
        $firstChatArray = [];
        $firstChatArray  ['dialog_id'] = $this->dialogId;
        $firstChatArray  ['client_id'] = $chatUserInfo->client_id;
        $firstChatArray  ['user_id'] = $chatUserInfo->user_id;
        $firstChatArray  ['count'] = $count;

        if ($chatUserInfo->site_user_id !== null) {
            $user = User::findOne($chatUserInfo->site_user_id);
            $username = $user->first_name . ' ' . $user->last_name;
            $avatarUrl = UserHelper::getAvatarUrl($user->id);
            if ($avatarUrl == null) {
                $avatarUrl = null;
            }
            $firstChatArray  ['user_name'] = $username;
            $firstChatArray  ['site_user_id'] = $user->id;
            $firstChatArray  ['avatar_url'] = $avatarUrl;
        } else {
            $firstChatArray  ['user_name'] = null;
            $firstChatArray  ['site_user_id'] = null;
            $firstChatArray  ['avatar_url'] = null;
        }


        $modelDialog = LiveChatDialog::find()
            ->where(['live_chat_id' => $this->dialogId])
            ->orderBy('time')
            ->all();

        $this->dialogInfo = $firstChatArray;
        $this->dialog = $modelDialog;

        return $this;
    }
}