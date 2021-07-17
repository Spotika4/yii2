<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Alert;
use yii\bootstrap4\ActiveForm;


$this->title = Yii::$app->name;

?>
<div id="main" class="container">
	<div class="row justify-content-center">
		<main class="col-xl-5 col-lg-6 col-md-8 col-sm-9 col-12 align-self-start mt-5">
			<div class="card">
				<?php $form = ActiveForm::begin(['enableClientScript' => false]); ?>
				<div class="card-header"><?=$this->title?></div>
				<div class="card-body">
					<?=Alert::widget([
						'options' => [
							'class' => 'alert-' . (($processor->getSuccess()) ? 'success' : 'danger'),
						],
						'body' => implode('<br />', $processor->getMessage())
					]);?>
				</div>
				<div class="card-footer">
					<div class="row justify-content-md-center">
						<div class="col-12">
							<?=Html::tag('a', Yii::t('core', 'login'), [
								'class' => 'btn btn-primary d-block w-100',
								'href'  => Url::to(['default/login']),
							])?>
						</div>
					</div>
				</div>
				<?php ActiveForm::end(); ?>
			</div>
		</main>
	</div>
</div>
