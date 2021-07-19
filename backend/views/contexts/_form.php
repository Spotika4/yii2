<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


?>
<div class="card">
	<ul class="nav nav-pills justify-content-center bg-light" role="tablist">
		<li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#default" role="tab" aria-selected="true" class="text-white"><?=Yii::t('core', 'main')?></a></li>
		<? if($update) : ?>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#map" role="tab" aria-selected="false"><?=Yii::t('core', 'review')?></a></li>
		<? endif;?>
	</ul>
	<div class="card-body">
		<?php $form = ActiveForm::begin(['enableClientScript' => false, 'id' => 'CONTEXT_FORM', 'action' => ($update) ? Url::to(['context/update']) : Url::to(['context/create'])]); ?>
			<? if($update) : ?>
				<?=Html::tag('input', false, ['type' => 'hidden', 'name' => 'id', 'value' => $context['id']])?>
			<? endif;?>
			<div class="tab-content">
				<div class="tab-pane fade show active" id="default" role="tabpanel" aria-labelledby="default-tab">
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<?=Html::tag('label', Yii::t('core', 'key'))?>
								<?=Html::tag('input',
									'email',
									[
										'type' => 'text',
										'name' => 'key',
										'class' => 'form-control',
										'value' => (isset($context['key'])) ? $context['key'] : false,
										'placeholder' => Yii::t('core', 'key')
									])?>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<?=Html::tag('label', Yii::t('core', 'title'))?>
								<?=Html::tag('input',
									'email',
									[
										'type' => 'text',
										'name' => 'name',
										'class' => 'form-control',
										'value' => (isset($context['name'])) ? $context['name'] : false,
										'placeholder' => Yii::t('core', 'title')
									])?>
							</div>
						</div>
					</div>
				</div>
				<? if($update) : ?>
					<div class="tab-pane fade show" id="map" role="tabpanel" aria-labelledby="map-tab">
						<div class="row">
							<div class="col-md-6">
								<h5><?=Yii::t('core', 'map')?></h5>
								<div class="mb-3">
									<div class="container">
										<div class="row">
											<div class="col-12 p-0">
												<button type="button" class="btn btn-sm btn-primary" id="BTN_CREATE_CONTROLLER_MODAL"><i class="fas fa-plus"></i></button>
												<button type="button" class="btn btn-sm btn-secondary" id="BTN_UPDATE_CONTROLLER_MODAL"><i class="fas fa-edit"></i></button>
												<button type="button" class="btn btn-sm btn-danger" id="BTN_DELETE_CONTROLLER_MODAL"><i class="fas fa-trash"></i></button>
											</div>
										</div>
									</div>
								</div>
								<div id="CONTROLLER_WRAPPER" class="mb-5">

								</div>
							</div>
							<div class="col-md-6">
								<h5><?=Yii::t('core', 'navigation')?></h5>
								<div class="mb-3">
									<div class="container">
										<div class="row">
											<div class="col-5 p-0">
												<button type="button" class="btn btn-sm btn-primary" id="BTN_CREATE_MENU_TREE_MODAL"><i class="fas fa-plus"></i></button>
												<button type="button" class="btn btn-sm btn-secondary" id="BTN_UPDATE_MENU_TREE_MODAL"><i class="fas fa-edit"></i></button>
												<button type="button" class="btn btn-sm btn-danger" id="BTN_DELETE_MENU_TREE_MODAL"><i class="fas fa-trash"></i></button>
											</div>
											<div class="col-7 p-0">
												<div class="input-group input-group-sm">
													<?=Html::dropDownList('status',
														'menu',
														$menus,
														[
															'id' => 'MENU_SELECT',
															'class' => 'form-control',
														])?>
													<div class="input-group-append">
														<div class="btn-group btn-group-sm" role="group">
															<button id="MENU_ACTION_GROUP" type="button" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																<i class="fas fa-bars"></i>
															</button>
															<div class="dropdown-menu" aria-labelledby="MENU_ACTION_GROUP">
																<a class="dropdown-item OPEN_MENU_MODAL" href="#" data-action="create"><?=Yii::t('core', 'add')?></a>
																<a class="dropdown-item OPEN_MENU_MODAL" href="#" data-action="update"><?=Yii::t('core', 'update')?></a>
																<a class="dropdown-item" href="#" id="MENU_DELETE" data-action="delete"><?=Yii::t('core', 'delete')?></a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="MENU_TREE_WRAPPER" class="mb-5">

								</div>
							</div>
						</div>
					</div>
				<? endif; ?>
			</div>
			<?=Html::submitButton(Yii::t('core', 'save'), ['class' => 'btn btn-primary'])?>
			<?=Html::tag('a', Yii::t('core', 'back'), ['href' => Url::to(['contexts/']), 'class' => 'btn btn-light'])?>
		<?php ActiveForm::end(); ?>
	</div>
</div>

<? if($update) : ?>
	<div id="CONTROLLER_MODAL" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><!-- modal title --></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php $form = ActiveForm::begin(['enableClientScript' => false, 'id' => 'CONTROLLER_FORM', 'action' => '#']); ?>
					<?=Html::tag('input', false, ['type' => 'hidden', 'name' => 'id', 'value' => ''])?>
					<?=Html::tag('input', false, ['type' => 'hidden', 'name' => 'context_id', 'value' => $context['id']])?>
					<div class="form-row">
						<div class="form-group col-6">
							<?=Html::tag('label', Yii::t('core', 'parent'))?>
							<?=Html::tag('input',
								'',
								[
									'type' => 'text',
									'name' => 'parent',
									'class' => 'form-control',
									'placeholder' => Yii::t('core', 'parent')
								])?>
						</div>
						<div class="form-group col-6">
							<?=Html::tag('label', Yii::t('core', 'sort'))?>
							<?=Html::tag('input',
								'',
								[
									'type' => 'text',
									'name' => 'sort',
									'class' => 'form-control',
									'placeholder' => Yii::t('core', 'sort')
								])?>
						</div>
					</div>
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'title'))?>
						<?=Html::tag('input',
							'',
							[
								'type' => 'text',
								'name' => 'title',
								'class' => 'form-control',
								'placeholder' => Yii::t('core', 'title')
							])?>
					</div>
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'url'))?>
						<?=Html::tag('input',
							'',
							[
								'type' => 'text',
								'name' => 'url',
								'class' => 'form-control',
								'placeholder' => Yii::t('core', 'url')
							])?>
					</div>
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'icon'))?>
						<?=Html::tag('input',
							'',
							[
								'type' => 'text',
								'name' => 'icon',
								'class' => 'form-control',
								'placeholder' => Yii::t('core', 'icon')
							])?>
					</div>
					<?php ActiveForm::end(); ?>
				</div>
				<div class="modal-footer">
					<?=Html::submitButton(Yii::t('core', 'save'), ['class' => 'btn btn-primary', 'form' => 'CONTROLLER_FORM'])?>
					<?=Html::tag('a', Yii::t('core', 'back'), ['href' => '#', 'class' => 'btn btn-light', 'data-dismiss'=>'modal', 'aria-label'=>'Close'])?>
				</div>
			</div>
		</div>
	</div>
	<div id="MENU_MODAL" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><!-- modal title --></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php $form = ActiveForm::begin(['enableClientScript' => false, 'id' => 'MENU_FORM', 'action' => '#']); ?>
					<?=Html::tag('input', false, ['type' => 'hidden', 'name' => 'id', 'value' => ''])?>
					<?=Html::tag('input', false, ['type' => 'hidden', 'name' => 'key', 'value' => ''])?>
					<?=Html::tag('input', false, ['type' => 'hidden', 'name' => 'context_key', 'value' => $context['key']])?>
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'key'))?>
						<?=Html::tag('input',
							'',
							[
								'type' => 'text',
								'name' => 'key',
								'class' => 'form-control',
								'placeholder' => Yii::t('core', 'key')
							])?>
					</div>
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'title'))?>
						<?=Html::tag('input',
							'',
							[
								'type' => 'text',
								'name' => 'name',
								'class' => 'form-control',
								'placeholder' => Yii::t('core', 'title')
							])?>
					</div>
					<?php ActiveForm::end(); ?>
				</div>
				<div class="modal-footer">
					<?=Html::submitButton(Yii::t('core', 'save'), ['class' => 'btn btn-primary', 'form' => 'MENU_FORM'])?>
					<?=Html::tag('a', Yii::t('core', 'back'), ['href' => '#', 'class' => 'btn btn-light', 'data-dismiss'=>'modal', 'aria-label'=>'Close'])?>
				</div>
			</div>
		</div>
	</div>
	<div id="MENU_TREE_MODAL" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><!-- modal title --></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php $form = ActiveForm::begin(['enableClientScript' => false, 'id' => 'MENU_TREE_FORM', 'action' => '#']); ?>
					<?=Html::tag('input', false, ['type' => 'hidden', 'name' => 'id', 'value' => ''])?>
					<?=Html::tag('input', false, ['type' => 'hidden', 'name' => 'menu_key', 'value' => ''])?>
					<div class="form-row">
						<div class="form-group col-6">
							<?=Html::tag('label', Yii::t('core', 'parent'))?>
							<?=Html::tag('input',
								'',
								[
									'type' => 'text',
									'name' => 'parent',
									'class' => 'form-control',
									'placeholder' => Yii::t('core', 'parent')
								])?>
						</div>
						<div class="form-group col-6">
							<?=Html::tag('label', Yii::t('core', 'sort'))?>
							<?=Html::tag('input',
								'',
								[
									'type' => 'text',
									'name' => 'sort',
									'class' => 'form-control',
									'placeholder' => Yii::t('core', 'sort')
								])?>
						</div>
					</div>
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'title'))?>
						<?=Html::tag('input',
							'',
							[
								'type' => 'text',
								'name' => 'title',
								'class' => 'form-control',
								'placeholder' => Yii::t('core', 'title')
							])?>
					</div>
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'url'))?>
						<?=Html::tag('input',
							'',
							[
								'type' => 'text',
								'name' => 'url',
								'class' => 'form-control',
								'placeholder' => Yii::t('core', 'url')
							])?>
					</div>
					<div class="form-group">
						<?=Html::tag('label', Yii::t('core', 'icon'))?>
						<?=Html::tag('input',
							'',
							[
								'type' => 'text',
								'name' => 'icon',
								'class' => 'form-control',
								'placeholder' => Yii::t('core', 'icon')
							])?>
					</div>
					<?php ActiveForm::end(); ?>
				</div>
				<div class="modal-footer">
					<?=Html::submitButton(Yii::t('core', 'save'), ['class' => 'btn btn-primary', 'form' => 'MENU_TREE_FORM'])?>
					<?=Html::tag('a', Yii::t('core', 'back'), ['href' => '#', 'class' => 'btn btn-light', 'data-dismiss'=>'modal', 'aria-label'=>'Close'])?>
				</div>
			</div>
		</div>
	</div>
<? endif; ?>
<script>
	<? if($update) : ?>
		/** Управление картой контекста **/
		function OPEN_CREATE_CONTROLLER_MODAL() {
			let form = $("#CONTROLLER_FORM");
			let modal = $("#CONTROLLER_MODAL");
			let wrapper = $("#CONTROLLER_WRAPPER");
			let url = '<?=Url::to(['controller/create'])?>';
			let title = '<?=Yii::t('core', 'object_action_create')?>';

			let selected = { data: { id: '0'}};
			let ref = wrapper.jstree(true);
			let sel = ref.get_selected();
			if(sel[0]) selected = ref._model.data[sel[0]];

			modal.find('.alert').remove();
			form.find('.is-valid').removeClass('is-valid');
			form.find('.is-invalid').removeClass('is-invalid');

			form.attr('action', url);
			form.find('input[type="text"]').val('');
			modal.find('h5.modal-title').text(title);
			form.find('input[name="context_id"]').val(<?=$context['id']?>);
			if(selected !== false){
				form.find('input[name="parent"]').val(selected.data.id);
			}
			modal.modal('show');
		}

		function OPEN_UPDATE_CONTROLLER_MODAL() {
			let form = $("#CONTROLLER_FORM");
			let modal = $("#CONTROLLER_MODAL");
			let wrapper = $("#CONTROLLER_WRAPPER");
			let url = '<?=Url::to(['controller/update'])?>';
			let title = '<?=Yii::t('core', 'object_action_update')?>';

			let ref = wrapper.jstree(true);
			let sel = ref.get_selected();
			if(!sel[0]) return false;
			let selected = ref._model.data[sel[0]].data;

			modal.find('.alert').remove();
			form.find('.is-valid').removeClass('is-valid');
			form.find('.is-invalid').removeClass('is-invalid');

			form.attr('action', url);
			form.find('input[name="id"]').val('');
			form.find('input[type="text"]').val('');
			form.find('input[name="context_id"]').val(<?=$context['id']?>);
			$.each(selected, function(col) {
				form.find('input[name="' + col + '"]').val(selected[col]);
			});
			modal.find('h5.modal-title').text(title);
			modal.modal('show');
		}

		function OPEN_DELETE_CONTROLLER_MODAL() {
			let wrapper = $("#CONTROLLER_WRAPPER");
			let title = '<?=Yii::t('core', 'object_action_delete')?>';
			let message = '<?=Yii::t('core', 'object_realy_delete')?>';

			let ref = wrapper.jstree(true);
			let sel = ref.get_selected();
			if(!sel[0]) return false;
			let selected = ref._model.data[sel[0]].data;

			$.fn.app('confirm', {
				ajax: {
					url: '<?=Url::to(['controller/delete'])?>',
					data: {
						id: selected.id
					},
				},
				title: title,
				message: message,
				after: function(result){
					if(result === true){
						//LOAD_CONTROLLERS(true);
						ref.delete_node(sel);
					}
				}
			});
		}

		function LOAD_CONTROLLERS(reload = false){
			let url = '<?=Url::to(['controller/tree'])?>';
			let data = {'context_id': <?=$context['id']?>, 'lexicon': 'backend' };
			if(reload === true){
				$('#CONTROLLER_WRAPPER').app('jstree', {
					reload: reload, url: url, data: data
				});
			}else{
				$('#CONTROLLER_WRAPPER').app('jstree', {
					reload: reload, url: url, data: data,
					menu: {
						"items": function ($node) {
							return {
								create: {
									label: "<?=Yii::t('core', 'add')?>",
									action: OPEN_CREATE_CONTROLLER_MODAL
								},
								update: {
									label: "<?=Yii::t('core', 'update')?>",
									action: OPEN_UPDATE_CONTROLLER_MODAL
								},
								delete: {
									label: "<?=Yii::t('core', 'delete')?>",
									separator_before: true,
									action: OPEN_DELETE_CONTROLLER_MODAL
								}
							};
						}
					}
				});
			}
		}

		/** Управление меню контекста **/
		function OPEN_CREATE_MENU_TREE_MODAL() {
			let form = $("#MENU_TREE_FORM");
			let modal = $("#MENU_TREE_MODAL");
			let menuselect = $("#MENU_SELECT");
			let wrapper = $("#MENU_TREE_WRAPPER");
			let url = '<?=Url::to(['menu-tree/create'])?>';
			let title = '<?=Yii::t('core', 'object_action_create')?>';

			if(!menuselect.val()) return false;

			let selected = { data: { id: '0'}};
			let ref = wrapper.jstree(true);
			if(typeof ref.get_selected === 'function'){
				let sel = ref.get_selected();
				if(sel[0]){
					selected = ref._model.data[sel[0]];
				}
			}

			modal.find('.alert').remove();
			form.find('.is-valid').removeClass('is-valid');
			form.find('.is-invalid').removeClass('is-invalid');

			form.attr('action', url);
			form.find('input[name="id"]').val('');
			form.find('input[type="text"]').val('');
			modal.find('h5.modal-title').text(title);
			form.find('input[name="menu_key"]').val(menuselect.val());
			if(selected !== false){
				form.find('input[name="parent"]').val(selected.data.id);
			}
			modal.modal('show');
		}

		function OPEN_UPDATE_MENU_TREE_MODAL() {
			let form = $("#MENU_TREE_FORM");
			let modal = $("#MENU_TREE_MODAL");
			let menuselect = $("#MENU_SELECT");
			let wrapper = $("#MENU_TREE_WRAPPER");
			let url = '<?=Url::to(['menu-tree/update'])?>';
			let title = '<?=Yii::t('core', 'object_action_update')?>';

			if(!menuselect.val()) return false;

			let ref = wrapper.jstree(true);
			let sel = ref.get_selected();
			if(!sel[0]){
				return false;
			}
			let selected = ref._model.data[sel[0]];

			modal.find('.alert').remove();
			form.find('.is-valid').removeClass('is-valid');
			form.find('.is-invalid').removeClass('is-invalid');

			form.attr('action', url);
			form.find('input[name="id"]').val('');
			form.find('input[type="text"]').val('');
			form.find('input[name="menu_id"]').val(menuselect.val());
			$.each(selected.data, function(col) {
				form.find('input[name="' + col + '"]').val(selected.data[col]);
			});
			modal.find('h5.modal-title').text(title);
			modal.modal('show');
		}

		function OPEN_DELETE_MENU_TREE_MODAL() {
			let wrapper = $("#MENU_TREE_WRAPPER");
			let menuselect = $("#MENU_SELECT");
			let title = '<?=Yii::t('core', 'object_action_delete')?>';
			let message = '<?=Yii::t('core', 'object_realy_delete')?>';

			if(!menuselect.val()) return false;

			let ref = wrapper.jstree(true);
			let sel = ref.get_selected();
			if(!sel[0]){
				return false;
			}
			let selected = ref._model.data[sel[0]];

			$.fn.app('confirm', {
				ajax: {
					url: '<?=Url::to(['menu-tree/delete'])?>?t=' + String(new Date().getTime()),
					data: {
						id: selected.data.id
					},
				},
				title: title,
				message: message,
				after: function(result){
					if(result === true){
						//LOAD_MENU_TREE(true);
						ref.delete_node(sel);
					}
				}
			});
		}

		function LOAD_MENU_TREE(reload = false){
			let url = '<?=Url::to(['menu-tree/tree'])?>';
			let data = {'menu_key': $("#MENU_SELECT").val(), 'lexicon': 'backend' };
			if(reload === true){
				$('#MENU_TREE_WRAPPER').app('jstree', {
					reload: true, url: url, data: data
				});
			}else{
				$('#MENU_TREE_WRAPPER').app('jstree', {
					reload: false, url: url, data: data,
					menu: {

						items: function ($node) {
							return {
								create: {
									label: "<?=Yii::t('core', 'add')?>",
									action: OPEN_CREATE_MENU_TREE_MODAL
								},
								update: {
									label: "<?=Yii::t('core', 'update')?>",
									action: OPEN_UPDATE_MENU_TREE_MODAL
								},
								delete: {
									label: "<?=Yii::t('core', 'delete')?>",
									separator_before: true,
									action: OPEN_DELETE_MENU_TREE_MODAL
								}
							};
						}
					}
				});
			}
		}

		// обновляем список доступных меню
		function UPDATE_MENU_SELECT(selected){
			$.fn.app('ajax', {
				url: '<?=Url::to(['menu/listing'])?>',
				data: {'context_key': "<?=$context['key']?>", 'lexicon': 'backend'},
				success: function(result){
					$("#MENU_SELECT option").remove();
					$.each(result.data, function(i, row) {
						$("#MENU_SELECT").append('<option value="' + i + '">' + row + '</option>');
					});
					$("#MENU_SELECT option[value='" + selected + "']").attr("selected", "selected");
					LOAD_MENU_TREE();
				}
			});
		}

	<? endif; ?>

	$(document).ready(function(){
		$("#CONTEXT_FORM").app('validate', {
			<? if($update) : ?>
				reset: false,
			<? endif; ?>
			rules: {
				name: {
					minlength: 3,
					required: true
				}
			}
		});

		<? if($update) : ?>
			LOAD_CONTROLLERS();

			// кнопки для вызова модальных окон с формами
			// для редактирования ресурсов
			$('#BTN_CREATE_CONTROLLER_MODAL').click(function(){
				OPEN_CREATE_CONTROLLER_MODAL();
			});

			$('#BTN_UPDATE_CONTROLLER_MODAL').click(function(){
				OPEN_UPDATE_CONTROLLER_MODAL();
			});

			$('#BTN_DELETE_CONTROLLER_MODAL').click(function(){
				OPEN_DELETE_CONTROLLER_MODAL();
			});

			// вылидация формы редактирования ресурсов
			$("#CONTROLLER_FORM").app('validate', {
				reset: true,
				rules: {
					parent: {
						required: true
					},
					sort: {
						required: false
					},
					title: {
						required: true
					},
					url: {
						required: true
					},
					icon: {
						required: false
					}
				},
				after: function(result){
					LOAD_CONTROLLERS(true);
					$('#CONTROLLER_MODAL').modal('toggle');
				}
			});

			// Загрузка дерева активного меню
			LOAD_MENU_TREE();

			// кнопки для вызова модальных окон с формами
			// для редактировани элементов меню
			$('#BTN_CREATE_MENU_TREE_MODAL').click(function(){
				OPEN_CREATE_MENU_TREE_MODAL();
			});

			$('#BTN_UPDATE_MENU_TREE_MODAL').click(function(){
				OPEN_UPDATE_MENU_TREE_MODAL();
			});

			$('#BTN_DELETE_MENU_TREE_MODAL').click(function(){
				OPEN_DELETE_MENU_TREE_MODAL();
			});

			// вылидация формы редактирования элементов меню
			$("#MENU_TREE_FORM").app('validate', {
				reset: true,
				rules: {
					parent: {
						required: true
					},
					sort: {
						required: false
					},
					title: {
						required: true
					},
					url: {
						required: true
					},
					icon: {
						required: false
					}
				},
				after: function(result){
					if(result.success === true){
						LOAD_MENU_TREE();
						$('#MENU_TREE_MODAL').modal('toggle');
					}
				}
			});

			// выбираем меню для редактрования
			$("#MENU_SELECT").change(function(){
				LOAD_MENU_TREE();
			});

			// открываем модальное окно для редактирования меню
			$('.OPEN_MENU_MODAL').click(function(){
				let form = $('#MENU_FORM');
				let modal = $('#MENU_MODAL');
				let menuselect = $('#MENU_SELECT option:selected');

				modal.find('.alert').remove();
				form.find('.is-valid').removeClass('is-valid');
				form.find('.is-invalid').removeClass('is-invalid');

				form.find('input[name="id"]').val('');
				form.find('input[name="name"]').val('');

				form.find('input[name="key"]').val('');
				form.find('input[name="key"][type="text"]').attr('disabled', false);
				form.find('input[name="key"][type="hidden"]').attr('disabled', true);

				form.find('input[name="context_id"]').val(<?=$context['id']?>);
				if($(this).attr('data-action') === 'create'){
					form.attr('action', '<?=Url::to(['menu/create'])?>');
					modal.find('h5.modal-title').text("<?=Yii::t('core', 'object_action_create')?>");
				}else if($(this).attr('data-action') === 'update'){
					$.fn.app('ajax', {
						url: '<?=Url::to(['menu/read'])?>',
						data: {'key': menuselect.val()},
						success: function(result){
							form.find('input[name="key"][type="text"]').attr('disabled', true);
							form.find('input[name="key"][type="hidden"]').attr('disabled', false);

							form.find('input[name="id"]').val(result.data.id);
							form.find('input[name="key"]').val(result.data.key);
							form.find('input[name="name"]').val(result.data.name);
							form.attr('action', '<?=Url::to(['menu/update'])?>');
							modal.find('h5.modal-title').text("<?=Yii::t('core', 'object_action_update')?>");
						}
					});
				}
				modal.modal('show');
			});

			// вылидация формы редактирования меню
			$("#MENU_FORM").app('validate', {
				reset: true,
				rules: {
					context_key: {
						minlength: 1,
						required: true
					},
					name: {
						minlength: 3,
						required: true
					},
					key: {
						minlength: 3,
						required: true
					}
				},
				after: function(result){
					if(result.success === true){
						if(result.data.id){
							UPDATE_MENU_SELECT(result.data.key);
						}else{
							UPDATE_MENU_SELECT(result.attributes.key);
						}
						UPDATE_MENU_SELECT(result.data.key);
						$('#MENU_MODAL').modal('hide');
					}
				}
			});

			// удаляем меню
			$('#MENU_DELETE').click(function(){
				let menuselect = $("#MENU_SELECT");
				let title = '<?=Yii::t('core', 'object_action_delete')?>';
				let message = '<?=Yii::t('core', 'object_realy_delete')?>';

				if(!menuselect.val()){
					return false;
				}

				$.fn.app('confirm', {
					ajax: {
						url: '<?=Url::to(['menu/delete'])?>',
						data:{
							key: menuselect.val()
						}
					},
					title: title,
					message: message,
					after: function(result){
						if(result === true){
							$('#MENU_TREE_WRAPPER ul').empty();
							UPDATE_MENU_SELECT();
						}
					}
				});
			});
		<? endif; ?>
	})
</script>