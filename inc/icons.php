<?php
function filefestival_add_custom_svg_icons($icons) {
	$icons['plus'] = '<svg id="Camada_1" data-name="Camada 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.82 6.75"><path id="Icon_ionic-ios-arrow-up" data-name="Icon ionic-ios-arrow-up" class="cls-1" d="M5.91,4.71,1.44.25A.84.84,0,0,0,.25.25a.85.85,0,0,0,0,1.2h0L5.31,6.5a.84.84,0,0,0,1.16,0l5.1-5.08a.85.85,0,0,0-1.2-1.2h0Z"/></svg>';
	$icons['minus'] = '<svg id="Camada_1" data-name="Camada 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.82 6.75"><path id="Icon_ionic-ios-arrow-up" data-name="Icon ionic-ios-arrow-up" class="cls-1" d="M5.91,4.71,1.44.25A.84.84,0,0,0,.25.25a.85.85,0,0,0,0,1.2h0L5.31,6.5a.84.84,0,0,0,1.16,0l5.1-5.08a.85.85,0,0,0-1.2-1.2h0Z"/></svg>';
	return $icons;
}
add_filter( 'twenty_twenty_one_svg_icons_ui', 'filefestival_add_custom_svg_icons');
