<?php

/* @var $this yii\web\View */

$this->title = 'Task';

use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Дабро пожаловать!</h1>

        <p><a class="btn btn-lg btn-success" href="/site/parse">Сохранить</a></p>
    </div>
    <div class="col-lg-12">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

<!--        --><?//= $form->field($model, 'iib')->textInput(['autofocus' => true]) ?>
<!---->
<!--        --><?//= $form->field($model, 'accountKey')->passwordInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
