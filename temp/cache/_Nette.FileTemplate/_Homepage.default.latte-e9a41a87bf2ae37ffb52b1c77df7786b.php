<?php //netteCache[01]000351a:2:{s:4:"time";s:21:"0.08585700 1356708706";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:62:"D:\stranky\!__NETTE\nette\app\templates\Homepage\default.latte";i:2;i:1356704664;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\nette\app\templates\Homepage\default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'vzi9usmbs5')
;
// prolog NUIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb99757fea86_content')) { function _lb99757fea86_content($_l, $_args) { extract($_args)
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
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 