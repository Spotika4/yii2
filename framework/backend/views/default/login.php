<?php

use yii\widgets\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'login_page_title');
?>
<div class="site-login">
    <div class="mt-5 offset-lg-3 col-lg-6">
        <? $form = ActiveForm::begin([
	        'id' => 'login',
	        'method' => 'POST',
	        'action' => Url::to(['default/login']),
            'enableAjaxValidation' => false,
            'enableClientScript' => false
        ]); ?>
            <div class="form-group">
                <?=Html::tag('label', Yii::t('app', 'username'), ['class' => 'form-label'])?>
                <?=Html::tag('input', 'email', [
                    'type' => 'text',
                    'name' => 'username',
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app', 'username')
                ])?>
            </div>
            <div class="form-group">
                <?=Html::tag('label', Yii::t('app', 'password'), ['class' => 'form-label'])?>
                <?=Html::tag('input', 'password', [
                    'type' => 'password',
                    'name' => 'password',
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app', 'password')
                ])?>
            </div>
            <div class="mb-3">
                <?=Html::submitButton(Yii::t('app', 'login_btn_submit'), ['class' => 'btn btn-primary btn-block'])?>
            </div>
        <? ActiveForm::end() ?>
    </div>
</div>

<script>
	$(document).ready(function() {
		$('#login').app('submit', {
			success: function(response, form){
				window.location.replace('<?=\Yii::$app->getHomeUrl()?>');
            },
			validate: {
				rules: {
					username: {
						required: true,
						minlength: 3
					},
					password: {
						required: true,
						minlength: 3
					}
				}
            }
        });
	});
</script>
