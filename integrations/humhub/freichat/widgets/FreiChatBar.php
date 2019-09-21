<?php

namespace humhub\modules\freichat\widgets;

use Yii;
use yii\helpers\Url;
use humhub\libs\Html;
use humhub\components\Widget;

class FreiChatBar extends Widget
{
    public $contentContainer;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $settings = Yii::$app->getModule('freichat')->settings;
        $token = $settings->get('token');
        $user_filters = $settings->get('user_filters');
        $baseUrl = $settings->get('baseUrl');
        $identity = Yii::$app->user->identity;
        $id = $identity->getId();
        $name = $identity->getDisplayName();

        if ($user_filters === "friends") {
            $friends = $identity->getFriends()->all();
            $friendIds = [];

            foreach ($friends as $friend) {
                array_push($friendIds, $friend->id);
            }
        } else {
            $friendIds = null;
        }

        return $this->render('freichat', ['token' => $token, 'baseUrl' => $baseUrl, 'id' => $id, 'name' => $name, 'friendIds' => $friendIds]);
    }
}
