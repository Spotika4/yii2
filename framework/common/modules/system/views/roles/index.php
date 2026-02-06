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
            <div id="tree"></div>
            <script>
				$(document).ready(function(){
					$.fn.app('api', {
						url: "<?=\yii\helpers\Url::to('/api/role')?>",
						success: function(response, textStatus, jqXHR){
							let roles = [];
							for(let i in response){
								roles.push({
									value: response[i].name,
									text: response[i].description,
                                });
                            }
							$('#tree').jstree({
								"plugins" : [ "contextmenu", "types", "themes" ],
								"contextmenu" : {
									items: function($node){
										let modalFormSettings = {
											api: true,
											method: 'POST',
											action: "<?=\yii\helpers\Url::to('/api/role')?>",

											title: 'Добавление роли',
											fields: {
												parent_name: {
													values: roles,
													html: 'select',
													type: 'select',
													name: 'parent_name',
													label: 'Родительская роль',
													placeholder: 'Родительская роль',
												},
												name: {
													html: 'input',
													type: 'text',
													name: 'name',
													label: 'Ключ',
													placeholder: 'Ключ',
												},
												description: {
													html: 'input',
													type: 'text',
													name: 'description',
													label: 'Название',
													placeholder: 'Название',
												}
											},

											submit: {
												success: function(response, form){
													$('#tree').jstree(true).refresh()
												},
												validate: {
													rules: {
														name: {
															required: true,
															minlength: 3
														},
														description: {
															required: true,
															minlength: 3
														}
													}
												}
											}
										};
										return {
                                            "create" : {
                                                "icon" : 'oi oi-plus text-success',
                                                "label" : "Добавить",
                                                "action": function (obj) {
                                                	let settings = modalFormSettings;
	                                                settings.method = 'POST';
	                                                settings.action = `<?=\yii\helpers\Url::to('/api/role/')?>`;
	                                                settings.fields.parent_name.selected = $node.original.name;
                                                    $.fn.app('form', settings);
                                                },
                                            },
                                            "update" : {
                                                "icon" : 'oi oi-pencil',
                                                "label" : "Изменить",
	                                            "_disabled": function (obj) {
		                                            return "administrator" === $node.original.name;
	                                            },
                                                "action": function (obj) {
	                                                let settings = modalFormSettings;
	                                                settings.method = 'PUT';
	                                                settings.action = `<?=\yii\helpers\Url::to('/api/role/')?>${$node.original.name}`;
	                                                settings.fields.parent_name.selected = $node.parent;
	                                                settings.fields.name.disabled = true;
	                                                settings.fields.name.value = $node.original.name;
	                                                settings.fields.description.value = $node.original.description;
	                                                $.fn.app('form', settings);
                                                },
                                            },
                                            "delete" : {
                                                "icon" : 'oi oi-trash text-danger',
                                                "label" : "Удалить",
	                                            "_disabled": function (obj) {
		                                            return "administrator" === $node.original.name;
	                                            },
                                                "action": function (obj) {

                                                },
                                            },
                                        }
									}
								},
								types: {
									"root": {
										"icon" : "oi oi-people text-secondary"
									},
									"child": {
										"icon" : "oi oi-people text-secondary"
									},
									"default" : {
										"icon" : "oi oi-people text-secondary"
									}
								},
								"core": {
									'data': {
										dataType: 'json',
										dataFilter: function(data) {
											data = JSON.parse(data);
											for (let row in data) {
												data[row].children = true;
												data[row].id = data[row].name;
												data[row].text = data[row].description;
											}
											return JSON.stringify(data);
										},
										url: function(node) {
											return `/api/role?access-token=${$.fn.app('token')}&expand=childs`
										},
										data: function(node) {
											if(node.id === '#'){
												return {
													'filter[name]': 'administrator'
												};
											}
											return {
												'filter[parent]': node.id
											};
										}
									}
								},
							});
						}
                    })
                });
            </script>

		</div>
	</div>
</div>
