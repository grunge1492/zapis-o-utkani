<?php //netteCache[01]000350a:2:{s:4:"time";s:21:"0.87952900 1356718785";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:61:"D:\stranky\!__NETTE\zapisy\app\templates\Added2\default.latte";i:2;i:1356718772;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\zapisy\app\templates\Added2\default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '8r4q8hz5t8')
;
// prolog NUIMacros
//
// block added_title
//
if (!function_exists($_l->blocks['added_title'][] = '_lbc5a44c26e7_added_title')) { function _lbc5a44c26e7_added_title($_l, $_args) { extract($_args)
;echo BasePresenter::STEP_6_TITLE . " — "; 
}}

//
// block added_class
//
if (!function_exists($_l->blocks['added_class'][] = '_lbb2be258775_added_class')) { function _lbb2be258775_added_class($_l, $_args) { extract($_args)
?>added away<?php
}}

//
// block headline
//
if (!function_exists($_l->blocks['headline'][] = '_lba6a378a3a6_headline')) { function _lba6a378a3a6_headline($_l, $_args) { extract($_args)
;echo BasePresenter::STEP_6_TITLE; 
}}

//
// block button_back
//
if (!function_exists($_l->blocks['button_back'][] = '_lb91faf7daaf_button_back')) { function _lb91faf7daaf_button_back($_l, $_args) { extract($_args)
?><button id='added_back' class='back left'><span><?php echo BasePresenter::STEP_5_TITLE ?>
</span></button><?php
}}

//
// block button_next
//
if (!function_exists($_l->blocks['button_next'][] = '_lbccacf3e63e_button_next')) { function _lbccacf3e63e_button_next($_l, $_args) { extract($_args)
?><button id='final_print' class='right'><span><?php echo BasePresenter::STEP_7_TITLE ?>
</span></button><?php
}}

//
// block erase_button_id
//
if (!function_exists($_l->blocks['erase_button_id'][] = '_lb638d36d31a_erase_button_id')) { function _lb638d36d31a_erase_button_id($_l, $_args) { extract($_args)
?>erase_added2<?php
}}

//
// block help
//
if (!function_exists($_l->blocks['help'][] = '_lb3dccfbbcec_help')) { function _lb3dccfbbcec_help($_l, $_args) { extract($_args)
?><p class='help'>Pro zařazení hráče na soupisku <strong>chytněte</strong> příslušný box <strong>a přetáhněte</strong> na požadovanou pozici v zápise nebo na box <strong>2x klikněte</strong>. Pro odstranění hráče postupujte obráceně. Hráče lze v zápisu <strong>libovolně posouvat</strong></p>
<p class='help'>Přímo editovat lze <strong>Kolo a den a čas utkání</strong>. Ostatní položky jsou přednastaveny dle předchozího zadání.</p>
<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = "../Added/layout.latte"; $template->_extended = $_extended = TRUE;


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

<?php call_user_func(reset($_l->blocks['button_back']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['button_next']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['erase_button_id']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['help']), $_l, get_defined_vars()) ; 