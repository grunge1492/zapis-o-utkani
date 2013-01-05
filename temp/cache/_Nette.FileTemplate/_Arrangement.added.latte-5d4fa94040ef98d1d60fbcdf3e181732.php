<?php //netteCache[01]000352a:2:{s:4:"time";s:21:"0.33446900 1335617957";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:63:"D:\stranky\!__NETTE\nette\app\templates\Arrangement\added.latte";i:2;i:1335617954;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\nette\app\templates\Arrangement\added.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '2frnkjaa22')
;
// prolog NUIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb0f56ad5ead_content')) { function _lb0f56ad5ead_content($_l, $_args) { extract($_args)
?><div id='content' class='arrangement added'>
    <h1>Doplňující údaje</h1>
    <div id='back_side'>
        <div id='setup'>
            <span id='soutez'><input type='text' name='soutez' value='IV. třída' maxlength='10' /></span>
            <span id='kolo'><input type='text' name='kolo' value='22.' maxlength='3' /></span>
            <div class='cleaner'></div>
            <span id='rocnik'><input type='text' name='rocnik' value='2011/2012' maxlength='9' /></span>
            <span id='den'><input type='text' name='den' value='22.08.2012' maxlength='10' /></span>
            <span id='cas1'><input type='text' name='cas1' value='15' maxlength='2' /></span>
            <span id='cas2'><input type='text' name='cas2' value='30' maxlength='2' /></span>
            <div class='cleaner'></div>
            <div id='squad_inputs'>
                <span id='domaci'><input type='text' name='domaci' value='Sokol Březník' maxlength='40' readonly='readonly' /></span>
                <span id='hoste'><input type='text' name='hoste' value='TJ Slavia Chlístov' maxlength='40' /></span>
                <div class='cleaner'></div>
                <span id='stadion'><input type='text' name='stadion' value='Březník' maxlength='40' readonly='readonly' /></span>
                <div class='cleaner'></div>
            </div>
        </div>
        <div id='arrangement_list'>
<?php for ($i = 1; $i <= 6; $i++): ?>
            <div class='arrangement_item' rel='position_<?php echo htmlSpecialChars($i, ENT_QUOTES) ?>'></div>
<?php endfor ?>
        </div>
        <div id='trash_container'>
            <div id='trash'>
<?php $iterations = 0; foreach ($players as $player): ?>
                <div class='trash_item' id='player_<?php echo htmlSpecialChars($player->id, ENT_QUOTES) ?>'>
                    <img class='photo' src='<?php echo htmlSpecialChars($player->photo, ENT_QUOTES) ?>
' alt='<?php echo htmlSpecialChars($player->whole_name, ENT_QUOTES) ?>' height='50' />
                    <span class='number'><input type='text' name='number_<?php echo htmlSpecialChars($player->id, ENT_QUOTES) ?>
' value='<?php echo htmlSpecialChars($player->cislo_dresu, ENT_QUOTES) ?>' maxlength='2' /></span>
                    <span class='name'><?php echo NTemplateHelpers::escapeHtml($player->arrangement_name, ENT_NOQUOTES) ?></span>
                    <span class='rc'><?php echo NTemplateHelpers::escapeHtml($player->rc, ENT_NOQUOTES) ?></span>
                </div>
<?php $iterations++; endforeach ?>
            </div>
        </div>
        <div class='cleaner'></div>
    </div>
    <span id='id_squad'><?php echo NTemplateHelpers::escapeHtml($id_squad, ENT_NOQUOTES) ?></span>
    <div class='buttons'>
        <button href='<?php echo htmlSpecialChars($_control->link("Arrangement:", array('id_squad' => $id_squad)), ENT_QUOTES) ?>
' class='back left'><span>Zpět</span></button>
        <button id='submit' class='right'><span>TISK</span></button>
        <div class='cleaner'></div>
    </div>
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