<?php

use yii\helpers\Url;


?>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-12">
				<table class="table table-striped w-100" id="CONTEXTS_TABLE"></table>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		let usersTable = $('#CONTEXTS_TABLE').app('table', {
			url: '<?=Url::to(['contexts/get'])?>',
			order: [1, 'asc'],
			columns: [
				{
					data: 'id',
					visible: false,
					searchable: false,
					orderable: false
				},
				{
					data: 'name',
					title: '<?=Yii::t('core', 'name')?>',
					className: 'name',
					searchable: true,
					orderable: true
				},
				{
					data: null,
					width: '75px',
					searchable: false,
					orderable: false,
					className: 'text-center',
					title: '<?=Yii::t('core', 'actions')?>',
					render: function(data, type, row, meta){
						if(meta.col == 2){
							let base_upd_url = '<?=Url::to(['contexts/update', 'id' => '*'])?>';
							let base_del_url = '<?=Url::to(['context/delete'])?>';

							return $('<div>').append(
								$('<a>')
								.attr('href', base_upd_url.replace('%2A', row.id))
								.addClass('p-1 text-secondary update')
								.html($('<i>').addClass('fas fa-pen'))
							).append(
								$('<a>')
								.attr('href', "#")
								.attr('data-id', row.id)
								.attr('data-url', base_del_url)
								.addClass('p-1 text-danger delete')
								.html($('<i>').addClass('fas fa-trash'))
							).html();
						}
					},
				}
			],
			buttons: [
				{
					text: '<?=Yii::t('core', 'add')?>',
					action: function(nButton, oConfig, oFlash ){
						return location.href = '<?=Url::to(['contexts/create'])?>'
					}
				}
			]
		});

		$('#CONTEXTS_TABLE').on('click', 'td a.delete', function(event){
			$.fn.app('confirm', {
				ajax: {
					url: $(this).data('url'),
					data: {'id': $(this).data('id')},
				},
				title: '<?=Yii::t("core", "object_action_delete")?>',
				message: '<?=Yii::t("core", "object_realy_delete")?>',
				after: function(result){
					if(result === true){
						usersTable.ajax.reload();
					}
				}
			});
		});
	});
</script>