<?php //netteCache[01]000354a:2:{s:4:"time";s:21:"0.36124700 1356718699";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:65:"D:\stranky\!__NETTE\zapisy\app\templates\ClubSelect\default.latte";i:2;i:1356718654;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\zapisy\app\templates\ClubSelect\default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '5m2auqvam4')
;
// prolog NUIMacros
//
// block added_title
//
if (!function_exists($_l->blocks['added_title'][] = '_lbf6d9295235_added_title')) { function _lbf6d9295235_added_title($_l, $_args) { extract($_args)
;echo BasePresenter::STEP_2_TITLE . " — "; 
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbf27fa28084_content')) { function _lbf27fa28084_content($_l, $_args) { extract($_args)
?><div id='content' class='clubselect'>
    <h1><?php echo BasePresenter::STEP_2_TITLE ?></h1>

    <div id='rivals'>
        <div class='rival home'>
            <div class='name'>
                <div class='fake_input'><?php echo NTemplateHelpers::escapeHtml($squad_title, ENT_NOQUOTES) ?></div>
            </div>
            <div class='badge'>
                <img src='/images/teams/big_badges/brz.png' alt='Sokol Březník A' />
            </div>
        </div>
<?php

if (!empty($away_team)) {
    $value = $away_team->title;
    $badge = $away_team->badge_html;
    $rel   = " rel='{$away_team->id}'";
} else {
    $value = null;
    $badge = null;
    $rel   = null;
}
?>
        <div class='rival away'<?php echo $rel ?>>
            <div class='name'>
                <input type='text' name='rival' value='<?php echo htmlSpecialChars($value, ENT_QUOTES) ?>' />
            </div>
            <div class='badge'><?php echo $badge ?></div>
        </div>
        <div class='cleaner'></div>
    </div>

    <div class='search'>
        <div id='search_selected_item'></div>
    </div>

    <div class='buttons'>
        <button href='<?php echo htmlSpecialChars($_control->link("Homepage:"), ENT_QUOTES) ?>
' class='back left confirm' rel='Opravdu chcete smazat všechna nastavení?'><span><?php echo BasePresenter::STEP_1_TITLE ?></span></button>
        <button id='arrangement' class='forward right'><span><?php echo BasePresenter::STEP_3_TITLE ?></span></button>
        <div class='cleaner'></div>
    </div>
    <p class='help'>V pravém boxu bliká kursor. Začněte psát název požadovaného soupeře, vysune se výběr dostupných mužstev. Z kompletní nabídky lze vybírat při zadaní <strong>mezery [Mezerník]</strong>.</p>
    <p class='help'>Po kliknutí na tlačítko <strong>Start</strong> budou vymazána všechna předchozí nastavení.</p>
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