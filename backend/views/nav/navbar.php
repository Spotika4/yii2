<?

use yii\helpers\Url;


?>
<ul class="navbar-nav">
	<? foreach($menu as $key => $element) : ?>
		<? if(empty($element['childs'])) : ?>
			<li class="nav-item <?=$element['title']?>">
				<a href="<?=Url::to([$element['url']])?>" class="nav-link" data-title="<?=$element['title']?>">
					<?=Yii::t('backend', $element['title'])?>
				</a>
			</li>
		<? else : ?>
			<li class="nav-item dropdown <?=$element['title']?>">
				<a href="<?=Url::to([$element['url']])?>" class="nav-link dropdown-toggle" data-toggle="dropdown">
					<?=Yii::t('backend', $element['title'])?>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<? foreach($element['childs'] as $k => $child) : ?>
						<? if(is_array($child)) : ?>
							<a class="dropdown-item <?=mb_strtolower($child['title'])?>" href="<?=Url::to([$child['url']])?>" data-title="<?=mb_strtolower($child['title'])?>">
								<?=Yii::t('backend', $child['title'])?>
							</a>
						<? endif; ?>
					<? endforeach; ?>
				</div>
			</li>
		<? endif; ?>
	<? endforeach; ?>
</ul>
