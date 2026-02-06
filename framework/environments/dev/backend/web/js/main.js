

(function ($) {

	let options = {
		token: null
	};

	let methods = {

		init: function (params) {
			this.options = params;
		},

		submit: function (params) {
			return this.each(function(){
				$(this).on('submit', function(e){
					e.preventDefault();
				});
				let validator = $(this).validate({
					lang: 'ru',
					message: true,
					onkeyup: false,
					onfocusout: false,
					errorElement: 'div',
					loader: true,
					reset: true,
					validClass: 'is-valid',
					errorClass: 'is-invalid',
					errorAddClass: 'invalid-feedback',
					messageClass: 'alert',
					messageElement: 'div',
					messageErrorClass: 'alert-danger',
					messageSuccessClass: 'alert-success',

					rules: params.validate.rules,
					submitHandler: function(form) {
						let $form = $(form);
						let headers = {};
						let data = $form.serialize();
						let submit = $form.find(`[type="submit"]`);
						let addSubmit = $('body').find(`[form="${form.id}"]`);

						if($form.attr('data-api') !== ''){
							headers['Authorization'] = `Bearer ${$.fn.app('token')}`;
						}

						let settings = {
							data: data,
							dataType: 'json',
							headers: headers,
							url: $form.attr('action'),
							method: $form.attr('method'),
							beforeSend: function(test){
								$form.find('.alert').remove();
								$form.find('is-invalid').removeClass('is-valid');
								$form.find('is-invalid').removeClass('is-invalid');

								submit.attr('disabled', true).prepend(
									$('<span class="spinner-grow spinner-grow-sm mr-3" role="status" aria-hidden="true">')
								);
								addSubmit.attr('disabled', true).prepend(
									$('<span class="spinner-grow spinner-grow-sm mr-3" role="status" aria-hidden="true">')
								);
							},
							complete: function (jqXHR, textStatus) {
								submit.attr('disabled', false).children('.spinner-grow').remove();
								addSubmit.attr('disabled', false).children('.spinner-grow').remove();
							},
							success: function (response, textStatus, jqXHR) {
								params.success(response, form);
							},
							error: function (jqXHR, exception) {
								if(jqXHR.status === 422 && jqXHR?.responseJSON){
									for (let i in jqXHR.responseJSON) {

										let field = jqXHR.responseJSON[i]?.field;
										let message = jqXHR.responseJSON[i]?.message;

										if(validator.settings.rules[field]){
											validator.showErrors({
												[field]: message
											});
										}
									}
								}
							}
						};

						$.fn.app('ajax', settings);

						return false;
					}
				});
			});
		},

		modal: function(params){
			let modal = $(`<div class="modal fade" id="modal_${new Date().getTime()}" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">`).append(
				$('<div class="modal-dialog" role="document">').append(
					$('<div class="modal-content">').append(
						$('<div class="modal-header">').append(
							$(`<h5 class="modal-title" id="exampleModalLabel">${params?.title}</h5>`)
						)
					).append(
						$('<div class="modal-body">').append(
							params.body
						)
					).append(
						$('<div class="modal-footer">').append(
							params.footer
						)
					)
				)
			);

			modal.on('hide.bs.modal', function (e) {
				$(this).remove();
			});

			return modal;
		},

		form: function (params = {}) {
			const create = {
				input: (options) => {
					let disabled = options?.disabled;
					return jQuery('<div class="mb-2">').append(
						$(`<label>${options?.label}</label>`)
					).append(
						$(`<input type="${options?.type}" class="form-control" placeholder="${options?.placeholder}" name="${options?.name}" value="${!options?.value ? '' : options.value}" ${disabled === true ? 'disabled' : ''}>`)
					)
				},
				textarea: (options) => {
					let disabled = options?.disabled;
					return jQuery('<div class="mb-2">').append(
						$(`<label>${options.label}</label>`)
					).append(
						$(`<textarea class="form-control" rows="${options.rows}" placeholder="${options.placeholder}" name="${options?.name}" ${disabled === true ? 'disabled' : ''}>`).text(!options?.value ? '' : options.value)
					)
				},
				select: (options) => {
					let disabled = options?.disabled;
					let select = $(`<select class="form-control" name="${options?.name}" ${disabled === true ? 'disabled' : ''}>`);
					for (let v in options.values) {
						let selected = !!(options?.selected && options.selected === options.values[v].value);
						select.append(
							jQuery(`<option value="${options.values[v].value}" ${selected === true ? 'selected' : ''}>`).text(options.values[v].text)
						);
					}

					return jQuery('<div class="mb-2">').append(
						$(`<label>${options.label}</label>`)
					).append(select)
				}
			};

			let title = params.title;
			let formId = `form_${new Date().getTime()}`;
			let submit = $(`<button type="submit" class="btn btn-primary" form="${formId}">`).text('Применить');
			let cancel = $('<button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">').text('Отменить');
			let footer = $(`<div>`).append(cancel).append(submit);

			let form = jQuery(`<form id="${formId}">`);
			form.attr('id', formId);
			form.attr('method', params?.method);
			form.attr('action', params?.action);
			form.attr('data-api', (params?.api === true) ? params.action : '');

			for (let name in params.fields) {
				let field = params.fields[name];
				form.append(create[field.html](field));
			}

			let modal = $.fn.app('modal', {
				title, body: form, footer
			});

			$('body').append(modal);

			let successCallback = (response, form) => console.log(response);
			if(params?.submit?.success) successCallback = params.submit.success;
			params.submit.success = function(response, form){
				modal.modal('hide');
				successCallback();
			};
			form.app('submit', params.submit);

			modal.modal('show');
		},

		api: function (params = {}) {
			if(!params?.headers) params.headers = {};
			params.headers['Authorization'] = `Bearer ${$.fn.app('token')}`;

			$.fn.app('ajax', (jQuery.extend({
				url: `/api/`,
				method: 'GET',
				dataType: 'json'
			}, params)));
		},

		ajax: function (params = {}) {
			$.ajax(jQuery.extend({
				method: 'GET',
				dataType: 'json',
				success: function(response, textStatus, jqXHR){
					console.log(response);
				},
				error: function (jqXHR, exception) {
					console.log(jqXHR.status);
				}
			}, params));
		},

		storage: function (key, value = null) {
			if(value !== null){
				localStorage.setItem(key, JSON.stringify(value));
			}else{
				let content = localStorage.getItem(key);
				if(content !== false) content = JSON.parse(content);
				return content;
			}
			return true;
		},

		alert: function (params) {
			let modalId = 'modal_' + new Date().getTime();
			let type = 'danger';
			let buttons = {
				ok: `Хорошо`
			};
			$('body').append($(`<div class="modal fade" id="${modalId}" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">`).append(
				$('<div class="modal-dialog" role="document">').append(
					$('<div class="modal-content">').append(
						$('<div class="modal-header">').append(
							$(`<h5 class="modal-title" id="exampleModalLabel">${params.title}</h5>`)
						)
					).append(
						$('<div class="modal-body">').append(
							$(`<div class="alert alert-${type}" role="alert">`).text(params.body)
						)
					).append(
						$('<div class="modal-footer text-center">').append(
							$(`<button type="button" class="btn btn-primary" data-dismiss="modal">`).text(`${buttons.ok}`)
						)
					)
				)
			));
			$(`#${modalId}`).on('hide.bs.modal', function (e) {
				$(this).remove();
				if(params?.after){
					params.after();
				}
			}).modal('show');
		},

		table: function(params) {

            $.extend( DataTable.ext.classes, {
                sWrapper:      "dataTables_wrapper dt-bootstrap4",
                sFilterInput:  "form-control input-sm",
                sLengthSelect: "form-control input-sm",
                sProcessing:   "dataTables_processing panel panel-default",
                sPageButton:   "paginate_button page-item"
            } );

			let settings = {
				order: [[0, 'asc']],
				serverSide: true,
				processing: true,
				paginate: true,
				searching: true,
				lengthChange: true,
				iDisplayLength: 10,
				info: true,
				responsive: true,
				sWrapper: "dataTables_wrapper dt-bootstrap4",
				dom: '<"row"<"col-6"<"d-flex"lf>><"col-6"<"float-right"TB>>><"row"<"col-12"rt>><"row"<"col-6"i><"col-6"p>>',
				lengthMenu: [[1, 5, 10, 25, 50, 100], [1, 5, 10, 25, 50, 100]],
				oLanguage: {
				sProcessing:   'Подождите...',
					sSearchPlaceholder: 'Поиск...',
					sLengthMenu:   '_MENU_',
					sZeroRecords:  'Записи отсутствуют.',
					sInfo:         'Записи с _START_ до _END_ из _TOTAL_ записей',
					sInfoEmpty:    'Записи с 0 до 0 из 0 записей',
					sInfoFiltered: '(отфильтровано из _MAX_ записей)',
					sInfoPostFix:  '',
					sSearch:       '',
					sUrl:          '' ,
					oPaginate: {
						sFirst: 'Первая',
							sPrevious: 'Предыдущая',
							sNext: 'Следующая',
							sLast: "Последняя"
					}
				},
				ajax: {
					dataFilter: function(data, type){
						$.fn.dataTableSettings;
						let json = $.parseJSON(data);
						return JSON.stringify({
							recordsTotal: json._meta.totalCount,
							recordsFiltered: json._meta.totalCount,
							data: json.items
						});
					},
					data: function(data){
						data['access-token'] = `${$.fn.app('token')}`;
						return data;
					},
				}
			};
			$.fn.dataTable.ext.classes.sFilterInput = 'form-control';
			$.fn.dataTable.ext.classes.sLengthSelect = 'form-control';
			$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-primary';
			if(params.url !== false && params.ajax !== false){
				params = $.extend(settings, params);
				params.ajax.url = params.url;
			}
			return $(this).DataTable(params);
		},

		options: function(){
			return this.options;
		},

		token: function(){
			return this.options.token;
		}
	};

	$.fn.app = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Метод с именем ' + method + ' не существует для jQuery.app');
		}
	};

})(jQuery);
