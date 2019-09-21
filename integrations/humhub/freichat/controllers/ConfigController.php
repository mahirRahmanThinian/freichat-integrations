<?php

namespace humhub\modules\freichat\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use humhub\modules\freichat\models\ConfigureForm;

class ConfigController extends Controller
{

    public function actionConfig()
    {
        $model = new ConfigureForm();
        $model->token = Yii::$app->getModule('freichat')->settings->get('token');
        $model->user_filters = Yii::$app->getModule('freichat')->settings->get('user_filters');

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->getModule('freichat')->settings->set('token', $model->token);
            Yii::$app->getModule('freichat')->settings->set('user_filters', $model->user_filters);
            $this->view->saved();
        }

        return $this->render('config', ['model' => $model]);
    }

}
