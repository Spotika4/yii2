<?

use yii\helpers\Url;


?>
<ul class="navbar-nav">
	<? foreach($menu as $key => $element) : ?>
		<? if(empty($element['childs'])) : ?>
			<li class="nav-item <?=$element['title']?>">
				<a href="<?=Url::to([$element['url']])?>" class="nav-link" data-title="<?=$element['title']?>">
					<?=$element['display']?>
				</a>
			</li>
		<? else : ?>
			<li class="nav-item dropdown <?=$element['title']?>">
				<a href="<?=Url::to([$element['url']])?>" class="nav-link dropdown-toggle" data-toggle="dropdown">
					<?=$element['display']?>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<? foreach($element['childs'] as $k => $child) : ?>
						<? if(is_array($child)) : ?>
							<a class="dropdown-item <?=mb_strtolower($child['title'])?>" href="<?=Url::to([$child['url']])?>" data-title="<?=mb_strtolower($child['title'])?>">
								<?=$child['display']?>
							</a>
						<? endif; ?>
					<? endforeach; ?>
				</div>
			</li>
		<? endif; ?>
	<? endforeach; ?>
</ul>
