<?php //netteCache[01]000352a:2:{s:4:"time";s:21:"0.11942700 1356718696";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:63:"D:\stranky\!__NETTE\zapisy\app\templates\Homepage\default.latte";i:2;i:1356718692;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\zapisy\app\templates\Homepage\default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '0czfazpeof')
;
// prolog NUIMacros
//
// block added_title
//
if (!function_exists($_l->blocks['added_title'][] = '_lb1b79816652_added_title')) { function _lb1b79816652_added_title($_l, $_args) { extract($_args)
;
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbfef8b1c784_content')) { function _lbfef8b1c784_content($_l, $_args) { extract($_args)
?><div id='content' class='index'>
<h1>Zápis o utkání</h1>
<img id='znak-breznik' src='/images/znak-breznik.png' alt='Sokol Březník' />
<div class='buttons set'>
<?php $iterations = 0; foreach ($squads as $id_squad => $squad_titles): ?>
    <button id='squad_<?php echo htmlSpecialChars($id_squad, ENT_QUOTES) ?>' class='start_button forward' rel='<?php echo htmlSpecialChars($id_squad, ENT_QUOTES) ?>
'><span><?php echo NTemplateHelpers::escapeHtml($squad_titles['button_title'], ENT_NOQUOTES) ?>
<span></button>
<?php $iterations++; endforeach ?>
</div>
<p class='help'>Vybete jezdno z mužstev kliknutím na příslušné tlačítko.</p>
</div>
<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof NPresenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['added_title']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 