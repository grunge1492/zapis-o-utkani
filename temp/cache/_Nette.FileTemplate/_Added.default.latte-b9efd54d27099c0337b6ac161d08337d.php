<?php //netteCache[01]000348a:2:{s:4:"time";s:21:"0.52962700 1356708217";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:59:"D:\stranky\!__NETTE\nette\app\templates\Added\default.latte";i:2;i:1356708216;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\nette\app\templates\Added\default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 's8p54oio3w')
;
// prolog NUIMacros
//
// block added_class
//
if (!function_exists($_l->blocks['added_class'][] = '_lb90343c2654_added_class')) { function _lb90343c2654_added_class($_l, $_args) { extract($_args)
?>added home<?php
}}

//
// block headline
//
if (!function_exists($_l->blocks['headline'][] = '_lbbc2274fea7_headline')) { function _lbbc2274fea7_headline($_l, $_args) { extract($_args)
;echo BasePresenter::STEP_5_TITLE; 
}}

//
// block button_back
//
if (!function_exists($_l->blocks['button_back'][] = '_lb0eadc1c551_button_back')) { function _lb0eadc1c551_button_back($_l, $_args) { extract($_args)
?><button id='select_rival_back' class='back left'><span><?php echo BasePresenter::STEP_4_TITLE ?>
</span></button><?php
}}

//
// block button_next
//
if (!function_exists($_l->blocks['button_next'][] = '_lb68cdd28231_button_next')) { function _lb68cdd28231_button_next($_l, $_args) { extract($_args)
?><button id='added2' class='forward right'><span><?php echo BasePresenter::STEP_6_TITLE ?>
</span></button><?php
}}

//
// block erase_button_id
//
if (!function_exists($_l->blocks['erase_button_id'][] = '_lbce2d1a7013_erase_button_id')) { function _lbce2d1a7013_erase_button_id($_l, $_args) { extract($_args)
?>erase_added<?php
}}

//
// block help
//
if (!function_exists($_l->blocks['help'][] = '_lb193e7eb510_help')) { function _lb193e7eb510_help($_l, $_args) { extract($_args)
?><p class='help'>Pro zařazení hráče na soupisku <strong>chytněte</strong> příslušný box <strong>a přetáhněte</strong> na požadovanou pozici v zápise nebo na box <strong>2x klikněte</strong>. Pro odstranění hráče postupujte obráceně. Hráče lze v zápisu <strong>libovolně posouvat</strong>. Podobným způsobem lze přiřadit <strong>Hlavního pořadatele</strong>.</p>
<p class='help'>Přímo editovat lze <strong>Kolo, den a čas utkání a počet pořadatelů</strong>. Ostatní položky jsou přednastaveny dle předchozího zadání.</p>
<?php
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

<?php call_user_func(reset($_l->blocks['button_back']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['button_next']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['erase_button_id']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['help']), $_l, get_defined_vars()) ; 