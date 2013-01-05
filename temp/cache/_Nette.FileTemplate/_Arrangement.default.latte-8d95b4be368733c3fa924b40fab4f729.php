<?php //netteCache[01]000355a:2:{s:4:"time";s:21:"0.71471600 1356718729";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:66:"D:\stranky\!__NETTE\zapisy\app\templates\Arrangement\default.latte";i:2;i:1356718723;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\zapisy\app\templates\Arrangement\default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'xujj6qir7a')
;
// prolog NUIMacros
//
// block added_title
//
if (!function_exists($_l->blocks['added_title'][] = '_lbe78891693c_added_title')) { function _lbe78891693c_added_title($_l, $_args) { extract($_args)
;echo BasePresenter::STEP_3_TITLE . " — "; 
}}

//
// block added_class
//
if (!function_exists($_l->blocks['added_class'][] = '_lbccb9ce4e53_added_class')) { function _lbccb9ce4e53_added_class($_l, $_args) { extract($_args)
?>home<?php
}}

//
// block headline
//
if (!function_exists($_l->blocks['headline'][] = '_lbe8691d028a_headline')) { function _lbe8691d028a_headline($_l, $_args) { extract($_args)
?>Domácí<?php
}}

//
// block top_buttons
//
if (!function_exists($_l->blocks['top_buttons'][] = '_lb3b3afb2bb8_top_buttons')) { function _lb3b3afb2bb8_top_buttons($_l, $_args) { extract($_args)
?><div class='buttons'>
    <button id='last_arrangement'><span>Minulá sestava</span></button>
</div>
<?php
}}

//
// block button_back
//
if (!function_exists($_l->blocks['button_back'][] = '_lb69d8c01fd2_button_back')) { function _lb69d8c01fd2_button_back($_l, $_args) { extract($_args)
?><button id='select_rival' class='back left'><span><?php echo BasePresenter::STEP_2_TITLE ?>
</span></button><?php
}}

//
// block button_next
//
if (!function_exists($_l->blocks['button_next'][] = '_lbefe3ff4b09_button_next')) { function _lbefe3ff4b09_button_next($_l, $_args) { extract($_args)
?><button id='arrangement_away' class='forward right'><span><?php echo BasePresenter::STEP_4_TITLE ?>
</span></button><?php
}}

//
// block erase_button_id
//
if (!function_exists($_l->blocks['erase_button_id'][] = '_lbfbe6bf4fe2_erase_button_id')) { function _lbfbe6bf4fe2_erase_button_id($_l, $_args) { extract($_args)
?>erase_arrangement<?php
}}

//
// block help_minula_sestava
//
if (!function_exists($_l->blocks['help_minula_sestava'][] = '_lbc1b4fcb3f2_help_minula_sestava')) { function _lbc1b4fcb3f2_help_minula_sestava($_l, $_args) { extract($_args)
?><p class='help'>Pomocí tlačítka <strong>Minulá sestava</strong> lze vyvolat nastavení z naposled tisknutého zápisu. Toto tlačítko lze opakovaně použít pouze v případě, že sestavu vymažete stiskem tlačítka <strong>Vymazat</strong>.</p><?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = "layout.latte"; $template->_extended = $_extended = TRUE;


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

<?php call_user_func(reset($_l->blocks['top_buttons']), $_l, get_defined_vars()) ; call_user_func(reset($_l->blocks['button_back']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['button_next']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['erase_button_id']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['help_minula_sestava']), $_l, get_defined_vars())  ?>

