<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


?>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-3">
				<div class="list-group flex-column mb-3" id="myTab" role="tablist">
					<a class="list-group-item list-group-item-action active" id="profile-tab" data-toggle="tab" href="#profile-content" role="tab" aria-controls="profile-content" aria-selected="true">
						<?=Yii::t('core', 'email')?>
					</a>
					<a class="list-group-item list-group-item-action" id="password-tab" data-toggle="tab" href="#password-content" role="tab" aria-controls="password-content" aria-selected="false">
						<?=Yii::t('core', 'password')?>
					</a>
				</div>
			</div>
			<div class="col-9">
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active pb-25" id="profile-content" role="tabpanel" aria-labelledby="profile-tab">
						<div class="card-title"><?=Yii::t('core', 'email')?></div>
						<?php $form = ActiveForm::begin([
							'enableClientScript' => false,
							'id' => 'PROFILE_UPDATE',
							'action' => Url::to(['profile/email-update'])
						]); ?>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<?=Html::tag('label', Yii::t('core', 'email'))?>
									<?=Html::tag('input',
										'email',
										[
											'type' => 'email',
											'name' => 'email',
											'class' => 'form-control',
											'value' => $profile['email'],
											'placeholder' => Yii::t('core', 'email')
										])?>
								</div>
							</div>
						</div>
						<?=Html::submitButton(Yii::t('core', 'save'), ['class' => 'btn btn-primary'])?>
						<?=Html::tag('a', Yii::t('core', 'back'), ['href' => Url::to(['users/']), 'class' => 'btn btn-light'])?>
						<?php ActiveForm::end(); ?>
					</div>
					<div class="tab-pane fade" id="password-content" role="tabpanel" aria-labelledby="password-tab">
						<div class="card-title"><?=Yii::t('core', 'password')?></div>
						<?php $form = ActiveForm::begin([
							'enableClientScript' => false,
							'id' => 'CHANGE_PASSWORD',
							'action' => Url::to(['profile/password-update'])
						]); ?>
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<?=Html::tag('label', Yii::t('core', 'password'))?>
									<?=Html::tag('input',
										'email',
										[
											'type' => 'password',
											'name' => 'password',
											'id' => 'PASSWORD',
											'class' => 'form-control',
											'placeholder' => Yii::t('core', 'password')
										])?>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<?=Html::tag('label', Yii::t('core', 'passwordr'))?>
									<?=Html::tag('input',
										'password',
										[
											'type' => 'password',
											'name' => 'passwordr',
											'class' => 'form-control',
											'placeholder' => Yii::t('core', 'passwordr')
										])?>
								</div>
							</div>
						</div>
						<?=Html::submitButton(Yii::t('core', 'save'), ['class' => 'btn btn-primary'])?>
						<?=Html::tag('a', Yii::t('core', 'back'), ['href' => Url::to(['users/']), 'class' => 'btn btn-light'])?>
						<?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		// Смена пароля
		$("#CHANGE_PASSWORD").app('validate', {
			rules: {
				password: {
					minlength: 6,
					required: true
				},
				passwordr: {
					minlength: 6,
					required: true,
					equalTo: '#PASSWORD'
				}
			}
		});

		// Обновление профиля
		$("#PROFILE_UPDATE").app('validate', {
			reset: false,
			rules: {
				email: {
					minlength: 6,
					email: true
				}
			}
		});
	})
</script>