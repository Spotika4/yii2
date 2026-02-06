<?php

/** @var yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script>
		$(document).ready(function() {

			let def = {
				token: null
			};

			<? if(!Yii::$app->user->isGuest) : ?>
			    def.token = `<?=Yii::$app->getUser()->getIdentity()->getAuthKey()?>`;
			<? endif; ?>


			$.fn.app(def);

			jQuery.validator.addMethod("api", function(value, element) {
				return true;
			}, "");

			jQuery.validator.setDefaults({
				debug: false,
				validClass: 'is-valid',
				errorClass: 'is-invalid',
				errorPlacement: function(error, element) {
					error.addClass('invalid-feedback').insertAfter(element);
				},
			});

			jQuery.extend(jQuery.validator.messages, {
				required: "<?=\Yii::t('app', 'jquery_validation_required')?>",
				remote: "<?=\Yii::t('app', 'jquery_validation_remote')?>",
				email: "<?=\Yii::t('app', 'jquery_validation_email')?>",
				url: "<?=\Yii::t('app', 'jquery_validation_url')?>",
				date: "<?=\Yii::t('app', 'jquery_validation_date')?>",
				dateISO: "<?=\Yii::t('app', 'jquery_validation_dateISO')?>",
				number: "<?=\Yii::t('app', 'jquery_validation_number')?>",
				digits: "<?=\Yii::t('app', 'jquery_validation_digits')?>",
				creditcard: "<?=\Yii::t('app', 'jquery_validation_creditcard')?>",
				equalTo: "<?=\Yii::t('app', 'jquery_validation_equalTo')?>",
				accept: "<?=\Yii::t('app', 'jquery_validation_accept')?>",
				maxlength: jQuery.validator.format("<?=\Yii::t('app', 'jquery_validation_maxlength')?>"),
				minlength: jQuery.validator.format("<?=\Yii::t('app', 'jquery_validation_minlength')?>"),
				rangelength: jQuery.validator.format("<?=\Yii::t('app', 'jquery_validation_rangelength')?>"),
				range: jQuery.validator.format("<?=\Yii::t('app', 'jquery_validation_range')?>"),
				max: jQuery.validator.format("<?=\Yii::t('app', 'jquery_validation_max')?>"),
				min: jQuery.validator.format("<?=\Yii::t('app', 'jquery_validation_min')?>")
			});
		});
    </script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<main role="main">
    <div class="container">
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
