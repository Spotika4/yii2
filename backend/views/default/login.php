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
					<?php $form = ActiveForm::begin(['enableClientScript' => false, 'id' => 'LOGIN', 'action' => Url::to(['user/login'])]);?>
						<div class="form-group">
							<?=Html::tag('label', Yii::t('core', 'username'))?>
							<?=Html::tag('input',
								'email',
								['type' => 'text', 'name' => 'username',
									'class' => 'form-control',
									'placeholder' => Yii::t('core', 'username')
								])?>
						</div>
						<div class="form-group">
							<?=Html::tag('label', Yii::t('core', 'password'))?>
							<?=Html::tag('input',
								'email',
								['type' => 'password', 'name' => 'password',
									'id' => 'PASSWORD',
									'class' => 'form-control',
									'placeholder' => Yii::t('core', 'password')
								])?>
						</div>
					<?php ActiveForm::end(); ?>
				</div>
				<div class="card-footer">
					<div class="row justify-content-md-center">
						<div class="col-6 pr-2">
							<?=Html::submitButton(Yii::t('core', 'login'), [
								'class' => 'btn btn-primary d-block w-100',
								'name'  => 'login-button',
								'form'  => 'LOGIN'
							])?>
						</div>
						<div class="col-6 pl-2">
							<?=Html::tag('a', Yii::t('core', 'recovery'), [
								'href'  => Url::to(['default/recovery']),
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
		$("#LOGIN").app('validate', {
			rules: {
				username: {
					minlength: 3,
					required: true
				},
				password: {
					minlength: 3,
					required: true
				}
			},
			after: function(result){
				if(result.success === true){
					setTimeout(function(){ document.location.href = '<?=Url::home(true)?>'; }, 1000);
				}
			}
		});
	})
</script>