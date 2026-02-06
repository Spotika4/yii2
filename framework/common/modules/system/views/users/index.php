<?php

use yii\helpers\Url;

?>
<div class="container">
	<div class="row">
		<div class="col-3 pt-3">
            <div class="list-group">
                <a class="list-group-item list-group-item-action" href="#">Группы</a>
                <a class="list-group-item list-group-item-action" href="#">Пользователи</a>
            </div>
		</div>
		<div class="col-9">
            <h1 class="display-4 border-bottom mb-4">Роли в системе</h1>
            <table class="table table-bordered table-striped table-hover w-100" id="users-table"></table>
            <script>
				$(document).ready(function(){
					let usersTable = $('#users-table').app('table', {
						url: '<?=Url::to('/api/user')?>',
						order: [1, 'asc'],
						columns: [
							{
								data: 'id',
								visible: false,
								searchable: false,
								orderable: false
							},
							{
								data: 'username',
								title: '<?=Yii::t('app', 'username')?>',
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
								title: '<?=Yii::t('app', 'actions')?>',
								render: function(data, type, row, meta){
									if(meta.col === 2){
										let base_upd_url = '<?=Url::to(['users/update', 'id' => '*'])?>';
										let base_del_url = '<?=Url::to(['user/delete'])?>';

										return $('<div>').append(
											$('<a>')
												.attr('href', base_upd_url.replace('%2A', row.id))
												.addClass('p-1 text-secondary update')
												.html($('<i>').addClass('oi oi-pencil'))
										).append(
											$('<a>')
												.attr('href', "#")
												.attr('data-id', row.id)
												.attr('data-url', base_del_url)
												.addClass('p-1 text-danger delete')
												.html($('<i>').addClass('oi oi-trash'))
										).html();
									}
								},
							}
						],
						buttons: [
							{
								text: '<?=Yii::t('app', 'add')?>',
								action: function(nButton, oConfig, oFlash ){
									return location.href = '<?=Url::to(['users/create'])?>'
								}
							}
						]
					});

					$('#USERS_TABLE').on('click', 'td a.delete', function(event){
						$.fn.app('confirm', {
							ajax: {
								url: $(this).data('url'),
								data: {'id': $(this).data('id')},
							},
							title: '<?=Yii::t('app', "object_action_delete")?>',
							message: '<?=Yii::t('app', "object_realy_delete")?>',
							after: function(result){
								if(result === true){
									usersTable.ajax.reload();
								}
							}
						});
					});
				});
            </script>

		</div>
	</div>
</div>
