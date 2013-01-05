<?php //netteCache[01]000353a:2:{s:4:"time";s:21:"0.49506600 1356704934";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:64:"D:\stranky\!__NETTE\nette\app\templates\Arrangement\layout.latte";i:2;i:1356704925;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\nette\app\templates\Arrangement\layout.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'oskf0qlg3j')
;
// prolog NUIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb23d479f0ba_content')) { function _lb23d479f0ba_content($_l, $_args) { extract($_args)
?><div id='content' class='arrangement <?php NUIMacros::callBlock($_l, 'added_class', $template->getParameters()) ?>'>
    <div id='left_cont'>
        <h1><?php NUIMacros::callBlock($_l, 'headline', $template->getParameters()) ?></h1>
<?php NUIMacros::callBlock($_l, 'top_buttons', $template->getParameters()) ?>
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
    </div>
    <div id='arrangement_list'>
<?php for ($i = 1; $i <= 18; $i++): ?>
            <div class='arrangement_item' rel='position_<?php echo htmlSpecialChars($i, ENT_QUOTES) ?>'></div>
<?php endfor ?>
    </div>
    <div class='cleaner'></div>
    <div class='buttons'>
<?php NUIMacros::callBlock($_l, 'button_back', $template->getParameters()) ;NUIMacros::callBlock($_l, 'button_next', $template->getParameters()) ?>
        <button id='<?php NUIMacros::callBlock($_l, 'erase_button_id', $template->getParameters()) ?>
' class='erase_button right' rel='Opravdu chcete smazat tuto soupisku?'><span>Vymazat</span></button>
        <div class='cleaner'></div>
    </div>
    <p class='help'>Pro zařazení hráče na soupisku <strong>chytněte</strong> příslušný box <strong>a přetáhněte</strong> na požadovanou pozici v zápise nebo na box <strong>2x klikněte</strong>. Pro odstranění hráče postupujte obráceně. Hráče lze v zápisu <strong>libovolně posouvat</strong>.</p>
<?php NUIMacros::callBlock($_l, 'help_minula_sestava', $template->getParameters()) ?>
</div>

<?php

if (!empty($sess_arrangement)) {

    echo "
<script type='text/javascript'>
    var arrangement_list = $('#arrangement_list'); // soupiska, kam se hraci pridavaji

    var obj = eval('(" . $sess_arrangement . ")');

    for (var position in obj) {
        if (obj[position]['id'] != null) {
            appendItemFromDB(obj[position], arrangement_list);
        }
    }

    $('#last_arrangement').addClass('disabled');
</script>
    ";
}

}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = "../@layout.latte"; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
// ?>

<?php if ($_l->extends) { ob_end_clean(); return NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 