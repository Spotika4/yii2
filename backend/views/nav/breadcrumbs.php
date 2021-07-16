<?

use yii\helpers\Url;


?>
<? if(!empty($breadcrumbs)) : ?>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<? foreach($breadcrumbs as $k => $breadcrumb) : ?>
				<li class="breadcrumb-item">
					<? if($this->params['resource']['id'] == $breadcrumb['id']) : ?>
						<span>
							<?=Yii::t('backend', $breadcrumb['title'])?>
						</span>
					<?else : ?>
						<a href="<?=Url::to([$breadcrumb['url']])?>">
							<?=Yii::t('backend', $breadcrumb['title'])?>
						</a>
					<? endif; ?>
				</li>
			<? endforeach; ?>
		</ol>
	</nav>
<? endif; ?>