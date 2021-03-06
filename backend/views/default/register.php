<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

?>
<div id="main" class="container">
	<div class="row justify-content-center">
		<main class="col-xl-5 col-lg-6 col-md-8 col-sm-9 col-12 align-self-start mt-5">
			<div class="card">
				<div class="card-header">
					<div class="card-title">
						<?=$this->title?>
					</div>
				</div>
				<div class="card-body">
					<?php $form = ActiveForm::begin(['enableClientScript' => false, 'id' => 'REGISTER', 'action' => Url::to(['user/register'])]);?>
						<div class="form-group">
							<?=Html::tag('label', Yii::t('core', 'username'))?>
							<?=Html::tag('input', '',
								['type' => 'text', 'name' => 'username', 'class' => 'form-control',
									'placeholder' => Yii::t('core', 'username')
								])?>
						</div>
						<div class="form-group">
							<?=Html::tag('label', Yii::t('core', 'email'))?>
							<?=Html::tag('input', '',
								['type' => 'text', 'name' => 'email', 'class' => 'form-control',
									'placeholder' => Yii::t('core', 'email')
								])?>
						</div>
					<?php ActiveForm::end(); ?>
				</div>
				<div class="card-footer">
					<div class="row justify-content-md-center">
						<div class="col-6 pr-2">
							<?=Html::submitButton(Yii::t('core', 'register'), [
								'class' => 'btn btn-primary d-block w-100',
								'name'  => 'register-button',
								'form'  => 'REGISTER',
							])?>
						</div>
						<div class="col-6 pl-2">
							<?=Html::tag('a', Yii::t('core', 'login'), [
								'href'  => Url::to(['default/login']),
								'class' => 'btn btn-light d-block w-100'
							])?>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#REGISTER").app('validate', {
			rules: {
				email: {
					minlength: 6,
					email: true,
					required: true
				},
				username: {
					minlength: 3,
					required: true
				}
			}
		});
	})
</script>