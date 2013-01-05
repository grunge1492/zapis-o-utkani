<?php //netteCache[01]000356a:2:{s:4:"time";s:21:"0.08501800 1348398761";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:67:"D:\stranky\!__NETTE\nette\app\templates\ImportPlayers\default.latte";i:2;i:1348398759;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\nette\app\templates\ImportPlayers\default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'odvj7utei0')
;
// prolog NUIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb9a2eee8979_content')) { function _lb9a2eee8979_content($_l, $_args) { extract($_args)
?><div id='content' class='import'>
<h1>Import</h1>
<p><?php echo NTemplateHelpers::escapeHtml($done, ENT_NOQUOTES) ?></p>
<p><a href='<?php echo htmlSpecialChars($_control->link("Homepage:"), ENT_QUOTES) ?>' title='Start'>Start</a></p>

<?php
    if (!empty($report)) {
        NDebugger::dump($report);
    }
?>

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