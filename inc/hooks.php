<?php
require_once(dirname(__FILE__) . '/hooks/collection_admin_form.php');

function FILE_tainacan_submission_item_finish_notify(\Tainacan\Entities\Item $item, $request)
{
	$collection_id = $item->get_collection_id();
	$file_metadata_to_notify_submission = get_post_meta($collection_id, 'file_metadata_to_notify_submission', true);
	if($file_metadata_to_notify_submission == 'yes') {
		$item_id = $item->get_id();
		$metadata_id = get_post_meta($collection_id, 'file_metadata_to_notify_submission_metaid', true);
		$submission_message = get_post_meta($collection_id, 'file_metadata_to_notify_submission_message', true);
		$subject = get_post_meta($collection_id, 'file_metadata_to_notify_submission_subject', true);;

		$meta_value = get_post_meta($item_id, $metadata_id, false);
		$meta_value = is_array($meta_value) ? $meta_value : [$meta_value];
		
		foreach ($meta_value as $email_to) {
			if (filter_var($email_to, FILTER_VALIDATE_EMAIL)) {
				\wp_mail($email_to, $subject, $submission_message);
			}
		}
	}
}
add_action('tainacan-submission-item-finish', 'FILE_tainacan_submission_item_finish_notify', 10, 2);