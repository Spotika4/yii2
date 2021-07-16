<?php

use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;
use common\components\core\widgets\NavbarWidget;
use common\components\core\widgets\BreadcrumbsWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
	<meta charset="<?=Yii::$app->charset?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php $this->registerCsrfMetaTags() ?>
	<title><?=Html::encode($this->title)?></title>
	<?php $this->head() ?>
	<style>
		.bootprompt-checkbox-list { display: flex; flex-wrap: wrap; justify-content: space-between; }
		.bootprompt-checkbox-list .form-check { width: 50%; }
	</style>
	<script>
		$(document).ready(function(){
			$('li.top_menu_clear_cache_title a.dropdown-item').on('click', function(event){
				event.preventDefault();
				let context = $(this).data('title');
				$.fn.app('ajax', {
					url: "<?=Url::to(['cache/runtimes'])?>",
					data: {
						'context': context
					},
					success: function(data, textStatus, jqXHR){
						if(data.success === false){
							bootprompt.alert({
								title: "<?=Yii::t('core', 'cache_clear_title')?>",
								message: $.fn.app('flash', {
									message: data.message.join("<br />"),
									type: (data.success === true) ? 'success' : 'danger',
								})
							});
							return false;
						}
						let inputs = [];
						data = data.data;
						$.each(data, function(index, value){
							inputs[inputs.length] = {
								text: data[index],
								value: index,
							};
						});
						$.fn.app('prompt', {
							title: "<?=Yii::t('core', 'cache_clear_title')?>",
							value: ["cache"],
							inputType: "checkbox",
							inputOptions: inputs,
							callback: (result) => {
								if(result !== null){
									$.fn.app('ajax', {
										url: "<?=Url::to(['cache/clear'])?>",
										data: {
											'context': context,
											runtimes: result,
										},
										success: function(data, textStatus, jqXHR){
											bootprompt.alert({
												title: "<?=Yii::t('core', 'cache_clear_title')?>",
												message: $.fn.app('flash', {
													message: data.message.join("<br />"),
													type: (data.success === true) ? 'success' : 'danger',
												})
											});
										},
									});
								}
							},
						});
					},
				});
			});
				$('a.top_right_logout_title.dropdown-item').on('click', function(event){
				event.preventDefault();
				$.fn.app('confirm', {
					ajax: {
						url: $(this).attr('href')
					},
					title: '<?=Yii::t("core", "logout")?>',
					message: '<?=Yii::t("core", "realy_logout")?>',
					after: function(result){
						if(result === true){
							window.location.replace('<?=Yii::$app->urlManager->createAbsoluteUrl(['default/login'])?>')
						}
					}
				});
			});
		});
	</script>
</head>
<body>
<?php $this->beginBody() ?>
<nav class="navbar navbar-expand-md navbar-light bg-light mb-4">
	<nav class="container-sm">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand mb-0 h1 mr-xl-5 mr-lg-5 mr-md-5 mr-sm-0 mr-0" href="<?=Url::to(['default/index'])?>"><?=Html::encode(Yii::$app->name)?></a>
		<div class="collapse navbar-collapse" id="navbar">
			<? if(!Yii::$app->user->isGuest) : ?>
				<?=NavbarWidget::widget(['id' => 88])?>
				<ul class="navbar-nav mr-auto"></ul>
				<?=NavbarWidget::widget(['id' => 89])?>
			<? endif; ?>
		</div>
	</nav>
</nav>
<header class="container">
	<div class="row">
		<div class="col-12">
			<?=BreadcrumbsWidget::widget()?>
		</div>
	</div>
</header>
<main class="container">
	<div class="row">
		<div class="col-12">
			<h1><?=Html::encode($this->title)?></h1>
			<?=$content?>
		</div>
	</div>
</main>
<footer class="container">
	<div class="row">
		<div class="col-12">
			<hr />
			<div class="text-muted"><?=date('Y')?> &copy; <?=Html::encode(Yii::$app->name)?></div>
		</div>
	</div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
