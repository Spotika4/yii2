<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


?>
<div class="container">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="nav-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Общее</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#roles" id="nav-roles-tab" data-bs-toggle="tab" data-bs-target="#nav-roles" type="button" role="tab" aria-controls="nav-roles" aria-selected="true">Роли</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="card-body tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <? $form = ActiveForm::begin([
                            'id' => 'user',
                            'method' => 'POST',
                            'action' => ($update) ? Url::to(['user/update']) : Url::to(['user/create']),
                            'enableAjaxValidation' => false,
                            'enableClientScript' => false
                        ]); ?>
                        <? if($update) : ?>
                            <?=Html::tag('input', false, ['type' => 'hidden', 'name' => 'id', 'value' => $user['id']])?>
                        <? endif;?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <?=Html::tag('label', Yii::t('app', 'status'))?>
                                    <?=Html::dropDownList('status',
                                        ($update && isset($user['status'])) ? $user['status'] : false,
                                        $statuses,
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => Yii::t('app', 'status')
                                        ])?>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <?=Html::tag('label', Yii::t('app', 'role'))?>
                                    <?=Html::dropDownList('role',
                                        ($update && isset($user['role'])) ? $user['role'] : false,
                                        $roles,
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => Yii::t('app', 'role')
                                        ])?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <?=Html::tag('label', Yii::t('app', 'username'))?>
                                    <?=Html::tag('input',
                                        'email',
                                        [
                                            'type' => 'text',
                                            'name' => 'username',
                                            'class' => 'form-control',
                                            'value' => (!empty($user['username']) ? $user['username'] : ''),
                                            'placeholder' => Yii::t('app', 'username')
                                        ])?>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <?=Html::tag('label', Yii::t('app', 'email'))?>
                                    <?=Html::tag('input',
                                        'email',
                                        [
                                            'type' => 'email',
                                            'name' => 'email',
                                            'class' => 'form-control',
                                            'value' => (!empty($user['email']) ? $user['email'] : ''),
                                            'placeholder' => Yii::t('app', 'email')
                                        ])?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <?=Html::tag('label', Yii::t('app', 'password'))?>
                                    <?=Html::tag('input',
                                        'email',
                                        [
                                            'type' => 'password',
                                            'name' => 'password',
                                            'id' => 'PASSWORD',
                                            'class' => 'form-control',
                                            'placeholder' => Yii::t('app', 'password')
                                        ])?>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <?=Html::tag('label', Yii::t('app', 'passwordr'))?>
                                    <?=Html::tag('input',
                                        'password',
                                        [
                                            'type' => 'password',
                                            'name' => 'passwordr',
                                            'class' => 'form-control',
                                            'placeholder' => Yii::t('app', 'passwordr')
                                        ])?>
                                </div>
                            </div>
                        </div>
                        <?=Html::submitButton(Yii::t('app', 'save'), ['class' => 'btn btn-primary'])?>
                        <?=Html::tag('a', Yii::t('app', 'back'), ['href' => Url::to(['users/']), 'class' => 'btn btn-secondary'])?>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="tab-pane fade" id="nav-roles" role="tabpanel" aria-labelledby="nav-roles-tab" tabindex="0">
                        123
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		$("#user").app('submit', {
			validate: {
				<? if($update) : ?>
				reset: false,
				<? endif; ?>
				rules: {
					status: {
						required: true
					},
					role: {
						required: true
					},
					username: {
						minlength: 3,
						required: true
					},
					email: {
						minlength: 6,
						email: true,
						required: true
					},
					password: {
						minlength: 6,
						<? if(!$update) : ?>
						required: true
						<? endif; ?>
					},
					passwordr: {
						minlength: 6,
						equalTo: '#PASSWORD',
						<? if(!$update) : ?>
						required: true
						<? endif; ?>
					}
				}
			},
		});
	})
</script>
