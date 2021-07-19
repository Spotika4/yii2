<?

use yii\helpers\Url;

?>
<? if(!empty($breadcrumbs)) : ?>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<? foreach($breadcrumbs as $k => $breadcrumb) : ?>
				<li class="breadcrumb-item">
					<? if($this->params['controller']['id'] == $breadcrumb['id']) : ?>
						<span>
							<?=$breadcrumb['display']?>
						</span>
					<?else : ?>
						<a href="<?=Url::to([$breadcrumb['url']])?>">
							<?=$breadcrumb['display']?>
						</a>
					<? endif; ?>
				</li>
			<? endforeach; ?>
		</ol>
	</nav>
<? endif; ?>