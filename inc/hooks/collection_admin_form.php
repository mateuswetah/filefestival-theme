<?php

function FILE_submission_notify_save_data_metadatum($object)
{
	if (!function_exists('tainacan_get_api_postdata')) {
		return;
	}
	$post = tainacan_get_api_postdata();
	if ($object->can_edit()) {
		if (isset($post->file_metadata_to_notify_submission)) {
			update_post_meta($object->get_id(), 'file_metadata_to_notify_submission', $post->file_metadata_to_notify_submission);
		}
		if (isset($post->file_metadata_to_notify_submission_metaid)) {
			update_post_meta($object->get_id(), 'file_metadata_to_notify_submission_metaid', $post->file_metadata_to_notify_submission_metaid);
		}
		if (isset($post->file_metadata_to_notify_submission_subject)) {
			update_post_meta($object->get_id(), 'file_metadata_to_notify_submission_subject', $post->file_metadata_to_notify_submission_subject);
		}
		if (isset($post->file_metadata_to_notify_submission_message)) {
			update_post_meta($object->get_id(), 'file_metadata_to_notify_submission_message', $post->file_metadata_to_notify_submission_message);
		}
	}
}
add_action('tainacan-insert-tainacan-collection', 'FILE_submission_notify_save_data_metadatum');


function FILE_submission_notify_add_meta_to_response($extra_meta, $request)
{
	$extra_meta = array(
		'file_metadata_to_notify_submission',
		'file_metadata_to_notify_submission_metaid',
		'file_metadata_to_notify_submission_subject',
		'file_metadata_to_notify_submission_message',
	);
	return $extra_meta;
}
add_filter('tainacan-api-response-collection-meta', 'FILE_submission_notify_add_meta_to_response', 10, 2);




function FILE_submission_notify_tainacan_admin_hooks_metadata_contexts()
{
	if (!function_exists('tainacan_get_api_postdata')) {
		return '';
	}
	ob_start();
?>
	<div >
		<style>
			#filefestival-submission-notify-section-header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: -14px;
				border-bottom: 1px solid var(--tainacan-secondary);
				cursor: pointer;
			}
			#filefestival_metadata_to_notify_edit {
				margin-top: 2rem;
			}
			#filefestival-submission-notify-section-header .collapse-all__text {
				font-size: 0.875rem;
			}
			#filefestival-submission-notify-section-header.is-active .collapse-all__text {
				font-size: 0;
			}
			#filefestival-submission-notify-section-header.is-active .collapse-all__text::before {
				content: '<?php _e('Esconder opções avançadas', 'filefestival'); ?>';
				font-size: 0.875rem;
			}
			#filefestival-submission-notify-section-header.is-active .icon {
				rotate: 90deg;
			}
			#filefestival-submission-notify-section-header:not(.is-active)+#filefestival_metadata_to_notify_edit {
				display: none;
			}
		</style>
		<div 
				id="filefestival-submission-notify-section-header"
				class="field tainacan-metadatum--section-header"
				onclick="(
					function() {
						const collapseElement = document.getElementById('filefestival-submission-notify-section-header');
						if (collapseElement) collapseElement.classList.toggle('is-active');

						const selectElement = document.getElementById('file_metadata_to_notify_submission_metaid');
						if (!selectElement || selectElement.childElementCount > 0) return;

						const xhr = new XMLHttpRequest();
						const match = location.hash.match(/\/(\d+)\//);
						const collectionId = match ? match[1] : null;
						const url = tainacan_plugin.tainacan_api_url + '/collection/' + collectionId + '/metadata?include_disabled=false';

						xhr.open('GET', url, true);
						xhr.onload = function() {
							if (xhr.status === 200) {
								const response = JSON.parse(xhr.responseText);
								response.forEach(element => {
									let optionElement = document.createElement('option');
									optionElement.value = element.id;  // Define o valor do <option>
									optionElement.text = element.name;  // Define o texto visível do <option>
									// Adiciona o elemento <option> ao elemento <select>
									selectElement.appendChild(optionElement);
								})
								
							} else {
								console.error('Erro na requisição para recuperar lista de metadados da coleção. Código de status:', xhr.status);
							}
						};

						xhr.onerror = function() {
							console.error('Erro na requisição para recuperar lista de metadados da coleção. Verifique a conexão com a internet.');
						};
						xhr.send();
					}).call(this)"
			>
			<h4><?php _e('Tema FILE', 'filefestival'); ?></h4>
			<button type="button" class="link-style collapse-all" >
				<span class="icon"><i class="has-text-secondary tainacan-icon tainacan-icon-1-125em tainacan-icon-arrowright"></i></span>
				<span class="collapse-all__text"><?php _e('Exibir opções avançadas do tema', 'filefestival'); ?></span>
			</button> 
		</div>
		<div class="file_metadata_to_notify_display_none" id="filefestival_metadata_to_notify_edit">
			<div class="field">
				<label class="label"><?php _e('Notificar submissão de itens por email?', 'filefestival'); ?></label>
				<div class="control is-expanded">
					<span class="select is-fullwidth">
						<select name="file_metadata_to_notify_submission">
							<option value="no"><?php _e('Não', 'filefestival'); ?></option>
							<option value="yes"><?php _e('Sim', 'filefestival'); ?></option>
						</select>
					</span>
				</div>
			</div>
			<div class="field" onload="alert('alert')">
				<label class="label"><?php _e('Metadado que terá o email a ser notificado:', 'filefestival'); ?></label>
				<div class="control is-expanded" >
					<span class="select is-fullwidth">
						<select
								id="file_metadata_to_notify_submission_metaid"
								name="file_metadata_to_notify_submission_metaid"
								onfocus="(
							function() {
								const selectElement = document.getElementById('file_metadata_to_notify_submission_metaid');
								if(!selectElement || selectElement.childElementCount > 0) return;

								const xhr = new XMLHttpRequest();
								const match = location.hash.match(/\/(\d+)\//);
								const collectionId = match ? match[1] : null;
								const url = tainacan_plugin.tainacan_api_url + '/collection/' + collectionId + '/metadata?include_disabled=false';

								xhr.open('GET', url, true);
								xhr.onload = function() {
									if (xhr.status === 200) {
										const response = JSON.parse(xhr.responseText);
										response.forEach(element => {
											let optionElement = document.createElement('option');
											optionElement.value = element.id;  // Define o valor do <option>
											optionElement.text = element.name;  // Define o texto visível do <option>
											// Adiciona o elemento <option> ao elemento <select>
											selectElement.appendChild(optionElement);
										})
									} else {
										console.error('Erro na requisição para recuperar lista de metadados da coleção. Código de status:', xhr.status);
									}
								};

								xhr.onerror = function() {
									console.error('Erro na requisição para recuperar lista de metadados da coleção. Verifique a conexão com a internet.');
								};
								xhr.send();
							}).call(this)"
					>
					</select>
					</span>
				</div>
			</div>

			<div class="field">
				<label class="label">
					<?php _e('Título do email de notificação', 'filefestival'); ?>
				</label>
				<div class="control is-expanded">
					<input class="input" type="text" id="file_metadata_to_notify_submission_subject" name="file_metadata_to_notify_submission_subject" ></input>
				</div>
			</div>
			
			<div class="field">
				<label class="label">
					<?php _e('Corpo do email de notificação', 'filefestival'); ?>
				</label>
				<div class="control is-expanded">
					<textarea class="input" id="file_metadata_to_notify_submission_message" name="file_metadata_to_notify_submission_message" rows="3" class="textarea"></textarea>
				</div>
			</div>
		</div>
	</div>
<?php
	return ob_get_clean();
}

function FILE_submission_notify_register_admin_hook()
{
	if (function_exists('tainacan_register_admin_hook')) {
		tainacan_register_admin_hook(
			'collection',
			'FILE_submission_notify_tainacan_admin_hooks_metadata_contexts',
			'end-left'
		);
	}
}
add_action('tainacan-register-admin-hooks', 'FILE_submission_notify_register_admin_hook');