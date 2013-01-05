<?php //netteCache[01]000356a:2:{s:4:"time";s:21:"0.90953000 1356718776";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:67:"D:\stranky\!__NETTE\zapisy\app\templates\Arrangement2\default.latte";i:2;i:1356718752;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\zapisy\app\templates\Arrangement2\default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '92t0yj6v1i')
;
// prolog NUIMacros
//
// block added_title
//
if (!function_exists($_l->blocks['added_title'][] = '_lbec0a510399_added_title')) { function _lbec0a510399_added_title($_l, $_args) { extract($_args)
;echo BasePresenter::STEP_4_TITLE . " — "; 
}}

//
// block added_class
//
if (!function_exists($_l->blocks['added_class'][] = '_lbce64227212_added_class')) { function _lbce64227212_added_class($_l, $_args) { extract($_args)
?>away<?php
}}

//
// block headline
//
if (!function_exists($_l->blocks['headline'][] = '_lbeecdcc0801_headline')) { function _lbeecdcc0801_headline($_l, $_args) { extract($_args)
?>Hosté<?php
}}

//
// block top_buttons
//
if (!function_exists($_l->blocks['top_buttons'][] = '_lbe30ab6053f_top_buttons')) { function _lbe30ab6053f_top_buttons($_l, $_args) { extract($_args)
;
}}

//
// block button_back
//
if (!function_exists($_l->blocks['button_back'][] = '_lb65010b4408_button_back')) { function _lb65010b4408_button_back($_l, $_args) { extract($_args)
?><button id='arrangement_home' class='back left'><span><?php echo BasePresenter::STEP_3_TITLE ?>
</span></button><?php
}}

//
// block button_next
//
if (!function_exists($_l->blocks['button_next'][] = '_lb6839e20d2e_button_next')) { function _lb6839e20d2e_button_next($_l, $_args) { extract($_args)
?><button id='added' class='forward right'><span><?php echo BasePresenter::STEP_5_TITLE ?>
</span></button><?php
}}

//
// block erase_button_id
//
if (!function_exists($_l->blocks['erase_button_id'][] = '_lb15400b7429_erase_button_id')) { function _lb15400b7429_erase_button_id($_l, $_args) { extract($_args)
?>erase_arrangement2<?php
}}

//
// block help_minula_sestava
//
if (!function_exists($_l->blocks['help_minula_sestava'][] = '_lbc9bee7dddc_help_minula_sestava')) { function _lbc9bee7dddc_help_minula_sestava($_l, $_args) { extract($_args)
?><p class='help'>Sestavu vymažete stiskem tlačítka <strong>Vymazat</strong>.</p><?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = "../Arrangement/layout.latte"; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
// ?>

<?php if ($_l->extends) { ob_end_clean(); return NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['added_title']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['added_class']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['headline']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['top_buttons']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['button_back']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['button_next']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['erase_button_id']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['help_minula_sestava']), $_l, get_defined_vars())  ?>

