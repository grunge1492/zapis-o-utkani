<?php //netteCache[01]000348a:2:{s:4:"time";s:21:"0.99130300 1356718779";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:59:"D:\stranky\!__NETTE\zapisy\app\templates\Added\layout.latte";i:2;i:1356712744;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"013c8ee released on 2012-02-03";}}}?><?php

// source file: D:\stranky\!__NETTE\zapisy\app\templates\Added\layout.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'pexovpu8tf')
;
// prolog NUIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb76b02af523_content')) { function _lb76b02af523_content($_l, $_args) { extract($_args)
?><div id='content' class='arrangement <?php NUIMacros::callBlock($_l, 'added_class', $template->getParameters()) ?>'>
    <h1><?php NUIMacros::callBlock($_l, 'headline', $template->getParameters()) ?></h1>
    <div id='back_side'>
        <div id='setup'>
<?php $iterations = 0; foreach ($contests as $contest_key => $contest_items): ?>
            <div class='contest_<?php echo htmlSpecialChars($contest_key, ENT_QUOTES) ?>s'>
                <?php
                    $counter = 0;

                    foreach ($contest_items as $contest_item) {
                        $counter++;

                        if (empty($sess_variables["contest_{$contest_key}"]) && $counter == 1) {
                            $checked_first = " checked";
                        } else {
                            $checked_first = null;
                        }

                        if ("contest_{$contest_key}_{$counter}" == $sess_variables["contest_{$contest_key}"]) {
                            $checked = " checked";
                        } else {
                            $checked = null;
                        }
                        echo "<div class='contest_$contest_key{$checked}{$checked_first}' id='contest_{$contest_key}_{$counter}'><span>$contest_item</span></div>";
                    } ?>
            </div>
<?php $iterations++; endforeach ?>
            <span id='soutez'><input type='text' name='soutez' value='<?php echo htmlSpecialChars($add_squad_title, ENT_QUOTES) ?>' maxlength='10' readonly='readonly' /></span>
            <span id='kolo'><input type='text' name='kolo' value='<?php echo htmlSpecialChars($sess_variables["kolo"], ENT_QUOTES) ?>' maxlength='2' onkeypress='return only_nums(event);' /></span>
            <div class='cleaner'></div>
            <span id='rocnik'><input type='text' name='rocnik' value='<?php echo htmlSpecialChars($add_season_title, ENT_QUOTES) ?>' maxlength='9' readonly='readonly' /></span>
            <span id='den'><input type='text' name='den' value='<?php echo htmlSpecialChars($sess_variables["den"], ENT_QUOTES) ?>' maxlength='10' onkeypress='return only_date(event);' /></span>
            <span id='cas1'><input type='text' name='cas1' value='<?php echo htmlSpecialChars($sess_variables["cas1"], ENT_QUOTES) ?>' maxlength='2' onkeypress='return only_nums(event);' /></span>
            <span id='cas2'><input type='text' name='cas2' value='<?php echo htmlSpecialChars($sess_variables["cas2"], ENT_QUOTES) ?>' maxlength='2' onkeypress='return only_nums(event);' /></span>
            <span id='pocet_poradatelu'><input type='text' name='pocet_poradatelu' value='<?php echo htmlSpecialChars($sess_variables["pocet_poradatelu"], ENT_QUOTES) ?>' maxlength='1' /></span>
            <div class='cleaner'></div>
            <div id='squad_inputs'>
                <span id='domaci'><input type='text' name='domaci' value='Sokol Březník' maxlength='40' readonly='readonly' /></span>
                <span id='hoste'><input type='text' name='hoste' value='<?php echo htmlSpecialChars($away_team, ENT_QUOTES) ?>' maxlength='40' readonly='readonly' /></span>
                <div class='cleaner'></div>
                <span id='stadion'><input type='text' name='stadion' value='Březník' maxlength='40' readonly='readonly' /></span>
                <div class='cleaner'></div>
            </div>
        </div>
        <div id='arrangement_list'>
<?php for ($i = 1; $i <= 6; $i++): ?>
            <div class='arrangement_item' rel='position_<?php echo htmlSpecialChars($i, ENT_QUOTES) ?>'></div>
<?php endfor ?>
            <div class='arrangement_item hl_poradatel' rel='position_7' title='Odstraňte hlavního pořadatele DVOJKLIKEM'></div>
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
    <div class='buttons'>
<?php NUIMacros::callBlock($_l, 'button_back', $template->getParameters()) ;NUIMacros::callBlock($_l, 'button_next', $template->getParameters()) ?>
        <button id='<?php NUIMacros::callBlock($_l, 'erase_button_id', $template->getParameters()) ?>
' class='erase_button right' rel='Opravdu chcete smazat tuto soupisku?'><span>Vymazat</span></button>
        <div class='cleaner'></div>
    </div>
<?php NUIMacros::callBlock($_l, 'help', $template->getParameters()) ?>
    <p class='help'>Libovolně lze přepínat mezi typy utkání (nahoře).</p>
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