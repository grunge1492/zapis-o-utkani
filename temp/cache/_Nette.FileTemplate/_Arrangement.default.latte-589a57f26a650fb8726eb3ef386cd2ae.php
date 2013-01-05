<?php //netteCache[01]000354a:2:{s:4:"time";s:21:"0.41967500 1356708700";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:65:"D:\stranky\!__NETTE\nette\app\templates\Arrangement\default.latte";i:2;i:1356708143;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\nette\app\templates\Arrangement\default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'ugp9xxomye')
;
// prolog NUIMacros
//
// block added_class
//
if (!function_exists($_l->blocks['added_class'][] = '_lb2ba3b8124e_added_class')) { function _lb2ba3b8124e_added_class($_l, $_args) { extract($_args)
?>home<?php
}}

//
// block headline
//
if (!function_exists($_l->blocks['headline'][] = '_lb7bbcf802c0_headline')) { function _lb7bbcf802c0_headline($_l, $_args) { extract($_args)
?>Domácí<?php
}}

//
// block top_buttons
//
if (!function_exists($_l->blocks['top_buttons'][] = '_lbadcbe0def1_top_buttons')) { function _lbadcbe0def1_top_buttons($_l, $_args) { extract($_args)
?><div class='buttons'>
    <button id='last_arrangement'><span>Minulá sestava</span></button>
</div>
<?php
}}

//
// block button_back
//
if (!function_exists($_l->blocks['button_back'][] = '_lb7be78d8ab5_button_back')) { function _lb7be78d8ab5_button_back($_l, $_args) { extract($_args)
?><button id='select_rival' class='back left'><span><?php echo BasePresenter::STEP_2_TITLE ?>
</span></button><?php
}}

//
// block button_next
//
if (!function_exists($_l->blocks['button_next'][] = '_lb5a5104cb1a_button_next')) { function _lb5a5104cb1a_button_next($_l, $_args) { extract($_args)
?><button id='arrangement_away' class='forward right'><span><?php echo BasePresenter::STEP_4_TITLE ?>
</span></button><?php
}}

//
// block erase_button_id
//
if (!function_exists($_l->blocks['erase_button_id'][] = '_lbe6ca5aed44_erase_button_id')) { function _lbe6ca5aed44_erase_button_id($_l, $_args) { extract($_args)
?>erase_arrangement<?php
}}

//
// block help_minula_sestava
//
if (!function_exists($_l->blocks['help_minula_sestava'][] = '_lb0e4915dffc_help_minula_sestava')) { function _lb0e4915dffc_help_minula_sestava($_l, $_args) { extract($_args)
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
call_user_func(reset($_l->blocks['added_class']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['headline']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['top_buttons']), $_l, get_defined_vars()) ; call_user_func(reset($_l->blocks['button_back']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['button_next']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['erase_button_id']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['help_minula_sestava']), $_l, get_defined_vars())  ?>

