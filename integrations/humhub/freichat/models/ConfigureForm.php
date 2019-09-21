<?php

namespace humhub\modules\freichat\models;

use Yii;

/**
 * ConfigureForm defines the configurable fields.
 */
class ConfigureForm extends \yii\base\Model
{

    public $token;
    public $user_filters;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['token', 'string'],
            ['user_filters', 'string']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'token' => Yii::t('FreichatModule.base', 'FreiChat Token:'),
            'user_filters' => Yii::t('FreichatModule.base', 'Who should be visible in user list:'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'token' => Yii::t('FreichatModule.base', 'Token used to communicate with FreiChat server. Please do not edit this.'),
            'user_filters' => Yii::t('FreichatModule.base', 'The users will be filtered based on the option selected'),
        ];
    }

}
