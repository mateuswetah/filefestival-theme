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
			.file_metadata_to_notify_display_nome {
				display: none;
			}
			@keyframes file_metadata_to_notifyFadeInAnimation {
				from { opacity: 0; }
				to { opacity: 1; }
			}
			.file_metadata_to_notify_animacao_fade {
				animation: file_metadata_to_notifyFadeInAnimation 1s ease-in-out;
			}
		</style>
		<div class="field tainacan-metadatum--section-header">
				<h4><?php _e('Opções do FILE', 'filefestival'); ?>
				<button type="button" class="button is-success" onclick="(
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
									const editPanel = document.getElementById('file_metadata_to_notify_edit');
									// editPanel.classList.remove('file_metadata_to_notify_display_nome');
									editPanel.style.display = 'block';
									editPanel.classList.add('file_metadata_to_notify_animacao_fade');
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
					<?php _e('exibir', 'filefestival'); ?>
				</button> 
				</h4>
			<hr>
		</div>
		<div class="file_metadata_to_notify_display_nome" id="file_metadata_to_notify_edit">
			<div class="field">
				<label class="label"><?php _e('Notificar submissão por email?', 'filefestival'); ?></label>
				<div class="control is-expanded">
					<span class="select is-fullwidth is-empty">
						<select name="file_metadata_to_notify_submission">
							<option value="no"><?php _e('Não', 'filefestival'); ?></option>
							<option value="yes"><?php _e('Sim', 'filefestival'); ?></option>
						</select>
					</span>
				</div>
			</div>
			<div class="field" onload="alert('alert')">
				<label class="label"><?php _e('Metadado utilizado para notificação:', 'filefestival'); ?></label>
				<div class="control is-expanded" >
					<select id="file_metadata_to_notify_submission_metaid" name="file_metadata_to_notify_submission_metaid" onFocus="(
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
					></select>
				</div>
			</div>

			<div class="field">
				<label class="label">
					<?php _e('Título da notificação', 'filefestival'); ?>
				</label>
				<div class="control is-expanded">
					<input type="text" id="file_metadata_to_notify_submission_subject" name="file_metadata_to_notify_submission_subject" ></input>
				</div>
			</div>
			
			<div class="field">
				<label class="label">
					<?php _e('Mensagem da notificação', 'filefestival'); ?>
				</label>
				<div class="control is-expanded">
					<textarea id="file_metadata_to_notify_submission_message" name="file_metadata_to_notify_submission_message" rows="3" class="textarea"></textarea>
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