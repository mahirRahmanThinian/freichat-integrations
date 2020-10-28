<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="panel panel-default">

    <div class="panel-heading"><?= Yii::t('FreichatModule.base', 'FreiChat configuration'); ?></div>

    <div class="panel-body">

        <?php $form = ActiveForm::begin(['id' => 'configure-form']); ?>
        <div class="form-group">
            <?= $form->field($model, 'token')->textInput(['class' => 'form-control', 'disabled' => false])->label(false) ?>

        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('FreichatModule.base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
            <a class="btn btn-default" href="<?= Url::to(['/admin/module']); ?>"><?= \Yii::t('FreichatModule.base', 'Back to modules'); ?></a>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
