<?php

function FILE_save_data_metadatum($object)
{
	if (!function_exists('tainacan_get_api_postdata')) {
		return;
	}
	$post = tainacan_get_api_postdata();
	if ($object->can_edit()) {
		if (isset($post->file_metadata_to_notify_submission)) {
			update_post_meta($object->get_id(), 'file_metadata_to_notify_submission', $post->file_metadata_to_notify_submission);
		}
	}
}
add_action('tainacan-insert-tainacan-metadatum', 'FILE_save_data_metadatum');


function FILE_add_meta_to_response($extra_meta, $request)
{
	$extra_meta = array(
		'file_metadata_to_notify_submission',
	);
	return $extra_meta;
}
add_filter('tainacan-api-response-metadatum-meta', 'FILE_add_meta_to_response', 10, 2);


function FILE_tainacan_admin_hooks_metadata_contexts()
{
	if (!function_exists('tainacan_get_api_postdata')) {
		return '';
	}
	ob_start();
?>
	<div>
		<div class="field tainacan-metadatum--section-header">
			<h4><?php _e('Opções do FILE', 'filefestival'); ?></h4>
			<hr>
		</div>
		<div class="field">
			<label class="label"><?php _e('Utilizar valor como email para notificação de submissão?', 'filefestival'); ?></label>
			<div class="control is-expanded">
				<span class="select is-fullwidth is-empty">
					<select name="file_metadata_to_notify_submission">
						<option value="no"><?php _e('Não', 'filefestival'); ?></option>
						<option value="yes"><?php _e('Sim', 'filefestival'); ?></option>
					</select>
				</span>
			</div>
		</div>
	</div>
<?php
	return ob_get_clean();
}



function FILE_register_admin_hook()
{
	if (function_exists('tainacan_register_admin_hook')) {
		tainacan_register_admin_hook(
			'metadatum',
			'FILE_tainacan_admin_hooks_metadata_contexts',
			'end-left',
			[
				'attribute' => 'metadata_type', 'value' => 'Tainacan\Metadata_Types\Text'
			]
		);
	}
}
add_action('tainacan-register-admin-hooks', 'FILE_register_admin_hook');
