<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
$this->title = Yii::$app->name;
?>
<? $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>" class="h-100">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <? $this->registerCsrfMetaTags() ?>
    <title><?=Html::encode($this->title)?></title>
    <? $this->head() ?>
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
<? $this->beginBody() ?>

<header>
    <? NavBar::begin([
        'brandLabel' => \Yii::$app->name,
        'brandUrl' => \Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-nav navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ])?>

    <?=Nav::widget([
        'options' => ['class' => 'navbar-nav me-5'],
        'items' => [
            [
                'label' => 'Система',
                'url' => ['/system/index'],
                'items' => [
                    [
                        'label' => 'Роли',
                        'url' => ['/system/roles'],
                    ],
                    [
                        'label' => 'Пользователи',
                        'url' => ['/system/users'],
                    ]
                ]
            ]
        ],
    ])?>

    <?=Html::beginForm(['/default/logout'], 'post', ['class' => 'form-inline'])?>
    <?=Html::submitButton('Выход', ['class' => 'btn btn-link nav-link logout'])?>
    <?=Html::endForm()?>

    <? NavBar::end() ?>
</header>

<main role="main">
    <div class="container">
        <?=Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])?>
    </div>
    <div class="container">
        <?=Alert::widget()?>
    </div>
	<?=$content?>
</main>

<footer class="footer mt-auto text-muted">
    <div class="container border-top border-gray py-3">
        <div>&copy; <?=Html::encode(Yii::$app->name)?> <?=date('Y')?></div>
    </div>
</footer>

<? $this->endBody() ?>
</body>
</html>
<? $this->endPage() ?>
