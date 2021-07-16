'use strict';

(function($){

	jQuery.fn.app = function(method, options){


		let settings = {

			csrf: {
				param: function(){
					return $('meta[name="csrf-param"]').attr('content');
				},
				token: function(){
					return $('meta[name="csrf-token"]').attr('content');
				},
			},

			//Loader
			loader: {
				status: true,
				element: false,
				class: 'spinner-grow spinner-grow-sm',
			},

			//Loader
			progress: {
				status: false,
				element: false,
			},

			//Flash
			flash: {
				element: false,
				class: 'alert',
				type: 'info',
				types: {
					warning: 'alert-warning',
					success: 'alert-success',
					danger: 'alert-danger',
					info: 'alert-info',
				},
			},

			//Prompt
			prompt: {
				// todo
				buttons: {
					cancel: {
						label: "Отмена",
						className: "btn btn-light"
					},
					confirm: {
						label: "Далее",
						className: "btn btn-primary"
					}
				},
				title: 'Ошибка'
			},

			// Ajax
			ajax: {
				url: false,
				type: 'POST',
				cache: false,
				dataType: 'json',
				responseFields: 'json',
				error: function(jqXHR, textStatus, errorThrown){
					bootprompt.alert({
						title: textStatus,
						message: methods.flash({
							message: errorThrown,
							type: 'danger',
						})
					});
				},
				success: function(data, textStatus, jqXHR){
					return data;
				},
				complete: function(jqXHR, textStatus){
					// code...
				},
				beforeSend(jqXHR, settings){
					return true;
				}
			},

			//jstree
			jstree: {
				core : {
					'data' : false,
					'check_callback' : true
				},
				plugins: [
					"json_data",
					'contextmenu'
				],
				contextmenu: {
					actions: {
						create: function(){
							let selected = false;
							let wrapper = settings.jstree.wrapper;
							let form = settings.jstree.actions.create.form;
							let modal = settings.jstree.actions.create.modal;
							let url = settings.jstree.actions.create.url;
							let title = settings.jstree.actions.create.title;
							let customFields = settings.jstree.actions.create.customFields;

							let ref = wrapper.jstree(true);
							let sel = ref.get_selected();
							if(sel[0]) selected = ref._model.data[sel[0]];

							modal.find('h5.modal-title').text(title);

							form.find('.alert').remove();
							form.find('.is-valid').removeClass('is-valid');
							form.find('.is-invalid').removeClass('is-invalid');

							form.attr('action', url);
							form.find('input[name="title"]').val('');
							form.find('input[name="url"]').val('');
							form.find('input[name="icon"]').val('');
							form.find('input[name="sort"]').val('');
							form.find('input[name="parent"]').val('0');
							if(selected){
								form.find('input[name="parent"]').val(selected.data.id);
							}
							$.each(customFields, function(col) {
								form.find('input[name="' + col + '"]').val(customFields[col]);
							});
							modal.modal('show');
						},
						update: function(){
							let options = settings.jstree.actions.update;
							let selected = '0';
							let form = options.form;
							let modal = options.modal;
							let wrapper = options.wrapper;
							let url = options.url;
							let title = options.title;

							let ref = wrapper.jstree(true);
							if(typeof ref.get_selected === 'function'){
								let sel = ref.get_selected();
								if(sel[0]){
									selected = ref._model.data[sel[0]];
								}
							}

							form.find('.alert').remove();
							form.find('.is-valid').removeClass('is-valid');
							form.find('.is-invalid').removeClass('is-invalid');

							form.attr('action', url);
							if(selected !== false){
								$.each(selected, function(col) {
									form.find('input[name="' + col + '"]').val(selected[col]);
								});
							}
							modal.modal('show');
						},
					},
					items: function ($node){
						return {
							create: {
								label: 'create',
								action: settings.jstree.contextmenu.actions.create
							},
							update: {
								label: 'update',
								action: settings.jstree.contextmenu.actions.update
							},
							delete: {
								label: 'delete',
								action: function(obj){
									console.log(obj);
								}
							}
						};
					}
				},
				run: function(wrapper, options){
					options.data.t = String(new Date().getTime());
					$.fn.app('ajax', {
						url: options.url,
						data: options.data,
						success: function(result){
							if(result.success !== false){
								let node = [];
								let resources = [];
								$.each(result.data, function(i, row) {
									node = [];
									node.id = 'node_' + row.id;
									node.parent = (row.parent > 0) ? 'node_' + row.parent : '#';
									node.text = (row.display) ? row.display : row.title;
									node.icon = row.icon;
									node.data = row;
									resources[i] = node;
								});
								if(wrapper.jstree(true) !== false){
									wrapper.jstree(true).settings.core.data = resources;
									wrapper.jstree(true).refresh(true);
								}else{
									settings.jstree.core.data = resources;
									settings.jstree.contextmenu = options.menu;
									wrapper.jstree(settings.jstree);
								}
							}
						}
					});
				}
			},

			//Confirm
			confirm: {
				ajax: false,
				loader: true,
				backdrop: true,
				title: 'Вы уверены?',
				message: 'Вы уверены?',
				callback: function(result){
					if(result === true){
						if(settings.confirm.loader){
							$(this).find('button.btn:first-child').addClass('invisible');
							methods.loader({status: true, element: $(this).find('button.btn:last-child')});
						}
						if(settings.confirm.ajax !== false){
							settings.confirm.ajax.success = function(response){
								if(response.message){
									bootprompt.alert({
										title: settings.confirm.title,
										message: methods.flash({message: response.message, type: response.success})
									});
								}
							};
							$.extend(settings.confirm.ajax.data, {
								[settings.csrf.param()] : settings.csrf.token()
							});
							methods.ajax(settings.confirm.ajax);
						}
						if(settings.confirm.loader){
							$(this).find('button.btn:first-child').removeClass('invisible');
							methods.loader({status: false, element: $(this).find('button.btn:last-child')});
						}
					}
					return settings.confirm.after(result);
				},
				buttons: {
					cancel: {
						label: "Отмена",
						className: "btn btn-light",
						callback: () => {
							// code...
						},
					},
					confirm: {
						label: "Да",
						className: "btn btn-primary",
						callback: () => {
							// code...
						},
					}
				},
				after: function(result){
					// code...
				}
			},

			//Validator
			validate: {
				lang: 'ru',
				rules: false,
				reset: true,
				message: true,
				loader: false,
				onkeyup: false,
				onfocusout: false,
				errorElement: 'div',
				validClass: 'is-valid',
				errorClass: 'is-invalid',
				errorAddClass: 'invalid-feedback',
				elementTypes: 'select, input',
				messageClass: 'alert',
				messageElement: 'div',
				messageErrorClass: 'alert-danger',
				messageSuccessClass: 'alert-success',

				submitHandler: function(form){
					methods.ajax({
						url: $(form).attr('action'),
						data: $(form).serializeArray(),
						beforeSend: function(){
							settings.validate.loader = $('[form="' + $(form).attr('id') + '"]');
							if(settings.validate.loader.length === 0){
								settings.validate.loader = $(form).find('[type="submit"]');
							}
							methods.loader({status: true, element: settings.validate.loader});
						},
						complete: function(){
							methods.loader({status: false, element: settings.validate.loader});
						},
						success: function(response, textStatus, jqXHR){
							if(settings.validate.message && response.message){
								methods.flash({
									element: form, message: response.message, type: response.success,
								});
							}
							if(response.success === true || response.errors.length === 0){
								$(form).find(settings.validate.elementTypes).removeClass(settings.validate.validClass);
							}
							$.each($(form).find(settings.validate.elementTypes), function(i, element){
								let elementName = $(element).attr('name');
								if(response.errors.length > 0){
									settings.validate.highlight(element);
									settings.validate.errorPlacement(response.errors[elementName], element);
								}else{
									settings.validate.unhighlight(element);
									settings.validate.errorPlacement(false, element);
								}
							});
							if(response.success === true){
								if(settings.validate.reset === true){
									form.reset();
								}
								settings.validate.after(response);
							}
						}
					});
				},
				errorPlacement: function(error, element){
					if(error instanceof Array){
						error = error.join('<br />');
						error = $(document.createElement(settings.validate.errorElement)).text(error);
					}
					$(element).siblings('.' + settings.validate.errorAddClass).remove();
					if(error) $(element).after(error.addClass(settings.validate.errorAddClass));
				},
				highlight: function(element){
					$(element).removeClass(settings.validate.validClass).addClass(settings.validate.errorClass);
				},
				unhighlight: function(element){
					$(element).removeClass(settings.validate.errorClass).addClass(settings.validate.validClass);
				},
				after: function(result){
					// code...
				}
			},

			//Tables
			table: {
				order: [[0, 'asc']],
				serverSide: true,
				processing: true,
				paginate: true,
				searching: true,
				lengthChange: true,
				iDisplayLength: 10,
				info: true,
				responsive: true,
				dom: '<"row"<"col-md-6"<"d-flex flex-row"<"mr-3"l>f>><"col-md-6"<"float-right"TB>>><"row"<"col-md-12"rt>><"row"<"col-md-6"i><"col-md-6"<"float-right"p>>>',
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
					dataFilter: function(data){
						let json = $.parseJSON(data);
						if(json.success === true && (typeof(json.data) !== 'undefined')){
							data = JSON.stringify(json.data);
						}else{
							data = JSON.stringify({data: []});
						}
						return data;
					},
					data: function(data){
						if(options.formData){
							data = $.extend(data, options.formData);
						}
						data[settings.csrf.param()] = settings.csrf.token();
						return data;
					},
				}
			},

		};

		let methods = {

			//Loader
			progress: function(options = {}){
				let bar = options.element.find('.progress-bar');
				let now = Number(bar.attr('aria-valuenow')) + Number(options.status);
				if(now < 100 && now > 0){
					options.element.removeClass('d-none');
					bar.attr('aria-valuenow', now).css('width', now + '%');
				}else{
					options.element.addClass('d-none');
					bar.attr('aria-valuenow', 0).css('width', 0);
				}
				return (now < 100 && now > 0) ? now : false;
			},

			//Loader
			loader: function(options = {}){
				if(options.status === true){
					let tagName = (typeof options.element == 'object') ? options.element[0].tagName.toLowerCase() : options.element.tagName.toLowerCase() ;
					if(tagName === 'button'){
						let text = (options.text) ? options.text : options.element.text();
						options.element.attr('disabled', 'disabled')
						.data('text', options.element.text())
						.html(
							$(document.createElement('div')).addClass(settings.loader.class)
						).append('&nbsp;&nbsp;&nbsp;' + text);
					}else{
						options.element.prepend('<div class="loader"></div>');
					}
				}else{
					if(options.element[0].nodeName === "BUTTON"){
						options.element.attr('disabled', false)
						.text($(options.element).data('text'));
					}else{
						options.element.find('.loader').remove();
					}
				}
				return true;
			},

			// Table
			table: function(options = {}){
				$.fn.dataTable.ext.classes.sFilterInput = 'form-control';
				$.fn.dataTable.ext.classes.sLengthSelect = 'form-control';
				$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-primary';
				if(options.url !== false && options.ajax !== false){
					options.ajax = $.extend(settings.ajax, options.ajax);
					options.ajax.url = options.url;
					delete options.ajax.success;
				}
				return $(this).DataTable(options);
			},

			// Ajax
			ajax: function(options = {}){
				$.ajaxSetup({
					'data': {
						[settings.csrf.param()]: settings.csrf.token()
					}
				});
				return $.ajax($.extend(settings.ajax, options));
			},

			// Flash
			flash: function(options = {}){
				if(typeof options.type === "boolean"){
					options.type = (options.type === false) ? 'danger' : 'success';
				}
				if(options.message instanceof Array){
					options.message = options.message.join("<br />");
				}
				let message = $(document.createElement('div'))
				.addClass(settings.flash.types[options.type])
				.addClass(settings.flash.class)
				.html(options.message);
				if(!options.element) return message;
				$(options.element).find('.' + settings.flash.class).remove();
				$(options.element).prepend(message);
			},

			//Confirm
			confirm: function(options = {}){
				options.message = $(document.createElement('div')).addClass('alert alert-warning').html(options.message);
				return bootprompt.confirm(options);
			},

			//jstree
			jstree: function(options = {}){
				return settings.jstree.run(this, options);
			},

			//prompt
			prompt: function(options = {}){
				return bootprompt.prompt(options);
			},

			// Ajax
			validate: function(options = {}){
				return $(this).validate(options);
			},

			// Settings
			settings: function(options = {}){
				return options;
			},
		};


		if(methods[method]){
			if((options) && typeof options === 'object'){
				if(settings[method]){
					settings[method] = $.extend(true, {}, settings[method], options);
					return methods[method].call(this, settings[method]);
				}else{
					settings = $.extend(true, {}, settings, options);
					return methods[method].call(this, settings);
				}
			}
		}else if(typeof method === 'object' || ! method ){
			if((method) && typeof method === 'object') {
				settings = $.extend(settings, method);
			}
			return methods.init.call(this, settings);
		}else{
			$.error( 'Метод с именем ' +  method + ' не существует для jQuery.tooltip' );
		}
	}

})(jQuery);


jQuery.validator.addMethod('lettersstart', function(value, element) {
	return this.optional(element) || /^([a-z])([a-z-_0-9])+$/i.test(value);
}, "Поле должно начинаться с буквы");

jQuery.validator.addMethod("regex", function(value, element, regexp) {
	let re = new RegExp(regexp);
	return this.optional(element) || re.test(value);
}, "Please check your input.");