<?php

function FILE_tainacan_submission_item_finish_notify(\Tainacan\Entities\Item $item, $request) {
	if (!defined('FILE_METADATAS_IDS_TO_NOTIFY') || !is_array(FILE_METADATAS_IDS_TO_NOTIFY) ) {
		return;
	}

	$notify_metadata = array_filter(
		$item->get_metadata([]), function($meta) {
			return in_array($meta->get_metadatum()->get_id(), FILE_METADATAS_IDS_TO_NOTIFY);
		}
	);
	foreach($notify_metadata as $me){
		$email_to = $me->get_value();
		if (filter_var($email_to, FILTER_VALIDATE_EMAIL)) {
			$subject = "Submissão enviada";
			$message = "Obrigado, sua submissão foi recebida.";
			\wp_mail($email_to, $subject, $message);
		}
	}
}
add_action ( 'tainacan-submission-item-finish', 'FILE_tainacan_submission_item_finish_notify', 10, 2);