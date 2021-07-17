<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\AppAsset;

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
</head>
<body>
<?php $this->beginBody() ?>
<nav class="navbar navbar-expand-md navbar-light bg-light mb-4">
	<nav class="container-sm">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand mb-0 h1 mr-xl-5 mr-lg-5 mr-md-5 mr-sm-0 mr-0" href="<?=Url::to(['default/index'])?>"><?=Html::encode(Yii::$app->name)?></a>
	</nav>
</nav>
<header class="container">
	<div class="row">
		<div class="col-12">

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
