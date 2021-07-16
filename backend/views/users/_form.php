<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


?>
<div class="card">
	<div class="card-body">
		<?php $form = ActiveForm::begin(['enableClientScript' => false, 'id' => 'USER', 'action' => ($update) ? Url::to(['user/update']) : Url::to(['user/create'])]); ?>
			<? if($update) : ?>
				<?=Html::tag('input', false, ['type' => 'hidden', 'name' => 'id', 'value' => $user['id']])?>
			<? endif;?>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'status'))?>
						<?=Html::dropDownList('status',
							($update) ? $user['status'] : false,
							$statuses,
							[
								'class' => 'form-control',
								'placeholder' => Yii::t('core', 'status')
							])?>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'role'))?>
						<?=Html::dropDownList('role',
							($update) ? $user['role'] : false,
							$roles,
							[
								'class' => 'form-control',
								'placeholder' => Yii::t('core', 'role')
							])?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'username'))?>
						<?=Html::tag('input',
							'email',
							[
								'type' => 'text',
								'name' => 'username',
								'class' => 'form-control',
								'value' => (!empty($user['username']) ? $user['username'] : ''),
								'placeholder' => Yii::t('core', 'username')
							])?>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'email'))?>
						<?=Html::tag('input',
							'email',
							[
								'type' => 'email',
								'name' => 'email',
								'class' => 'form-control',
								'value' => (!empty($user['email']) ? $user['email'] : ''),
								'placeholder' => Yii::t('core', 'email')
							])?>
					</div>
				</div>
			</div>
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
<script>
	$(document).ready(function(){
		$("#USER").app('validate', {
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
			},
		});
	})
</script>