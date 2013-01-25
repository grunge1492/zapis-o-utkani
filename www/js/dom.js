// obecna funkce pro smerove tlacitko
function click_away(action, response, location)
{
    $.post("/" + action + "/clickaway", response, function(theResponse){

        if (myIsString(theResponse)) {
            alert(theResponse);
        } else {
            window.location = location;
        }
    });
}

// udalost po kliku na edit na soupisce
function showAnonymousPlayer(item)
{
    var id = $(item).attr('id');

    if ($(item).find('.name').html() != null) {
        $(item).find('.name').html("<input type='text' value='" + $(item).find('.name').html() + "' maxlength='20' />");
        $(item).find('.rc').html("<input type='text' value='" + $(item).find('.rc').html() + "' maxlength='8' />");
    } else {
        $("<span class='number'><input type='text' value='' maxlength='2' /></span><span class='name'><input type='text' value='' maxlength='20' /></span><span class='rc'><input type='text' value='' maxlength='8' /></span>")
            .prependTo($(item));
    }

    $(item).find('.edit').addClass('save').removeClass('and_erase').html('');
    $(item).find('.erase').remove();
    $(item).addClass('empty');

    $(item).addClass('anonymous_player');


    $(item).find('.name input').focus().select();
}

// udalost po kliku na save na soupisce
function hideAndSaveAnonymousPlayer(item)
{
    $(item).find('.name').html($(item).find('.name input').val());
    $(item).find('.rc').html($(item).find('.rc input').val());

    $(item).attr('id', 'player_anonymous_' + $(item).attr('rel'));
    $(item).find('.edit').removeClass('save').addClass('and_erase').html('');

    $(item).removeClass('empty');

    $("<span class='erase'></span>")
        .prependTo($(item));
}

// udalost po kliku na vymazat na soupisce
function eraseAnonymousPlayer(item)
{
    $(item).attr('id', '');
    $(item).html('<span class="edit"></span>');
    $(item).addClass('empty');
}

// prirazeni polozky na soupisku z databaze, pri prechodu mezi strankami a pri vyvolani posledni sestavy
function appendItemFromDB(item, arrangement_list)
{
    var tmp_item = $(".arrangement_item[rel=position_" + item['position'] + "]", arrangement_list);
        html = "<img class='photo' src='" + item['photo'] + "' alt='" + item['whole_name'] + "' height='50' /><span class='number'><input type='text' name='number_" + item['id'] + "' value='" + item['number'] + "' maxlength='2' /></span><span class='name'>" + item['arrangement_name'] + "</span><span class='rc'>" + item['rc'] + "</span>";
        id = item['id'].toString().replace("player_", "");

    if (jsContains('anonymous', id)) {
        tmp_item.addClass('anonymous_player');
        html += "<span class='erase'></span><span class='edit and_erase'></span>";
    } else {
        html += "<span class='edit disabled'></span>";
    }

    $("#player_" + id).remove();


    if (item['captain'] === 'true' || item['captain'] === 1) {
        $('.captain_select[rel=position_' + item['position'] + '] input.radio').prop('checked', true);
    }

    tmp_item.attr('id', "player_" + id); // prvni prazdne polozce priradime ID puvodni polozky z kose
    tmp_item.html(html); // do prvni prazdne polozky zapiseme text z puvodni polozky z kose
    tmp_item.removeClass('empty');
    tmp_item.droppable({ disabled: true });
}

// udalost po dvojkliku na polozku kose (live - kvuli vicerazovemu pouziti)
function appendItem(item, arrangement_list)
{
    item = $(item);

    var tmp_item = arrangement_list.children(':first'); // vybereme prvni polozku ze soupisky

    while (tmp_item.find('.name').html() != null) {
        if (tmp_item.next().is(':last')) { // osetreni posledni polozky
            alert('List je plný!');
            return false;
        }
    
        tmp_item = tmp_item.next(); // vybereme prvni prazdnou polozku ze soupisky (obsazene ignorujeme)
    }

    last_item_position = tmp_item.position(); // vezmu pozici posledni polozky
    position_left = last_item_position.left + 'px'; // vypocitam pozici pro vlozeni polozky (cislo znamena okraje)
    position_top  = last_item_position.top + 'px';  // vypocitam pozici pro vlozeni polozky (cislo znamena okraje)

    var completeFunction = function() { // sestavime udalost, ktera se spusti po dokonceni animace presunuti
        item.css('position', 'static'); // vratime zpet staticke pozicovani
        $(tmp_item).html($(this).html()); // do prvni prazdne polozky zapiseme text z puvodni polozky z kose
        $(tmp_item).attr('id', $(this).attr('id')); // prvni prazdne polozce priradime ID puvodni polozky z kose
        $(this).remove(); // danou polozku odstranime z kose
        tmp_item.removeClass('empty');
        tmp_item.droppable({ disabled: true });
    }

    animateToPosition(item, position_left, position_top, completeFunction); // spustime animaci z patricnymi parametry
}

// udalost po dvojkliku na polozku soupisky (live - kvuli vicerazovemu pouziti)
function bringItemBack(item, trash)
{
    item = $(item);

    if (item.text() == '' || item.hasClass('anonymous_player')) return false; // pokud vybrana polozka v soupisce neobsahuje zadny text, dale nepokracujeme

    // pokud ma kos nejake polozky
    if (trash.children().length) {
        last_item_position = trash.children(':first').position(); // vezmu pozici posledni polozky z kose
        position_left = last_item_position.left + 'px'; // vypocitam pozici pro vlozeni polozky
        position_top  = last_item_position.top + 37 + 'px';  // vypocitam pozici pro vlozeni polozky (cislo znamena okraje)
    // pokud nema kos zadne polozky
    } else {
        last_item_position = trash.position(); // vezmu pozici samotneho kose
        position_left = last_item_position.left + 21 + 'px'; // vypocitam pozici pro vlozeni polozky (cislo znamena okraje)
        position_top  = (last_item_position.top) + 21 + 'px';  // vypocitam pozici pro vlozeni polozky (cislo znamena okraje)
    }
    
    var completeFunction = function() { // sestavime udalost, ktera se spusti po dokonceni animace presunuti
        item.css('position', 'static'); // vratime zpet staticke pozicovani
        $('<div></div>')
            .addClass('trash_item') // priradime ji tridu kose
            .attr('id', item.attr('id')) // priradime ji id puvodni polozky na soupisce
            .html(item.html()) // vlozime do ni puvodni text polozky na soupisce
            .prependTo(trash) // tuto polozku pridame do kose na konec
            .draggable({ // polozku nastavime opet jako pretahovatelnou (dulezite - bez toho je to pouze jednorazova akce)
                helper: 'clone',
                revert: 'invalid' // pokud polozka neni prenesena na soupisku, polozka se dynamicky vraci na sve misto
            });
        item.html('<span class="edit"></span>'); // vynulujeme text puvodni polozky na soupisce
        item.removeAttr('id'); // odstranime parametr ID puvodni polozky na soupisce
        item.addClass('empty');
        item.droppable({ disabled: false });
    }

    animateToPosition(item, position_left, position_top, completeFunction); // spustime animaci z patricnymi parametry
}

// animace presunu polozky (fake)
function animateToPosition(item, position_left, position_top, fnc_complete)
{
    var css_set = {
        'position': 'absolute',
        'left'    : 'auto',
        'top'     : 'auto'
    }

    item
        .css(css_set) // zmenim pozicovani na absolutni, jinak se to nepohne
        .animate( // zanimuju pohyb
            {
                left: position_left, // polozka se premisti na dane souradnice
                top: position_top    // polozka se premisti na dane souradnice
            },
            400,  // rychlost pohybu
            fnc_complete // po dokonceni pohybu
        );
}

// ulozi hodnoty promennych setup
function setSetupVariables()
{
    return {
        'contest_level'    : $('.contest_level.checked').attr('id'),
        'contest_type'     : $('.contest_type.checked').attr('id'),
        'kolo'             : $('#kolo input').val(),
        'den'              : $('#den input').val(),
        'cas1'             : $('#cas1 input').val(),
        'cas2'             : $('#cas2 input').val(),
        'pocet_poradatelu' : $('#pocet_poradatelu input').val()
    };
}

// ulozi hrace ze soupisky do objektu pro AJAX
function setPlayers(arrangement_list)
{
    var players_object = {};
        players = arrangement_list.sortable("toArray");
        response = {};
        counter = 0;

    // kapitan
    var captain = null;
    captain = $(".captain_select input.radio:checked").parents('.captain_select').attr('rel');

    for (var i in players) {
        counter += 1;
        players_object[i]                     = {};
        players_object[i]['id']               = players[i];
        players_object[i]['number']           = $("#" + players[i]).find(".number input").val();

        if ($("#" + players[i]).find(".number input").val() == undefined) {
            players_object[i]['number'] = '';
        } else {
            players_object[i]['number'] = $("#" + players[i]).find(".number input").val();
        }

        if ($("#" + players[i]).find(".photo").attr('src') == undefined) {
            players_object[i]['photo'] = null;
        } else {
            players_object[i]['photo'] = $("#" + players[i]).find(".photo").attr('src');
        }

        if ($("#" + players[i]).find(".name").text() == undefined) {
            players_object[i]['arrangement_name'] = null;
        } else {
            players_object[i]['arrangement_name'] = $("#" + players[i]).find(".name").text();
        }

        if ($("#" + players[i]).find(".photo").attr('alt') == undefined) {
            players_object[i]['whole_name'] = players_object[i]['arrangement_name'];
        } else {
            players_object[i]['whole_name'] = $("#" + players[i]).find(".photo").attr('alt');
        }

        if ($("#" + players[i]).find(".rc").text() == undefined) {
            players_object[i]['rc'] = null;
        } else {
            players_object[i]['rc'] = $("#" + players[i]).find(".rc").text();
        }

        if ($("#" + players[i]).attr('rel') == captain) {
            players_object[i]['captain'] = true;
        } else {
            players_object[i]['captain'] = false;
        }

        var position = $("#" + players[i]).attr('rel');

        if (position != undefined) {
            players_object[i]['position'] = counter;
        }
    }

    response['players']  = players_object;

    return response;
}

// zjisteni typu retezce
function myIsString(input){
    return typeof(input) == 'string' && isNaN(input);
}

// vyvolani dialogu
function fn_confirm(button)
{
    alert = button.attr('rel');

    if (!window.confirm(alert)) {
        return false;
    }

    return true;
}

// funkce na nalezeni podretezce v retezci
function jsContains(needle, haystack)
{
    pos = haystack.indexOf(needle);

    if (pos == -1) {
        return false;
    } else {
        return true;
    }
}

/**
 * Funkce filtruje ovladaci/systemove a normalni klavesy.
 *
 * @param object e Event key(down|up|press)...
 * @param array ctrl Seznam kontrolnich klaves ktere maji byt dodatecne povoleny.
 * @param string keys Regularni vyraz povolenych znaku. (Match probiha pri stisknuti klavesy)
 *
 * @return boolean
 */
function filter_keys(e, ctrl, keys)
{
    /* MSIE verze < 9 dela problemy, nerozlisuje systemove/ovladaci klavesy od normalnich */
    var msie = $.browser.msie && $.browser.version <= 8.0;
    var system = !e.charCode && !msie;
    var code = msie ? e.keyCode : e.charCode;

    /* U Opery poznam systemovou klavesu podle which = 0. */
    if ($.browser.opera) {
        if (!e.which) {
            system = true;
        } else {
            code = e.keyCode;
            system = false;
        }
    }

    /* Jedna se o realne nebo ovladaci/systemove klavesy? */
    if (system) {
        var keyCode = e.keyCode ? e.keyCode : e.which;

        switch (keyCode) {
            /* Zde povolim vsechny ovladaci klavesy. */
            case 8: // Backspace.
            case 9: // Tabulator.
            case 13: // Enter.
            case 46: // Delete.
            case 37: // Left arrow.
            case 38: // Up arrow.
            case 39: // Right arrow.
            case 40: // Down arrow.
            case 36: // Home.
            case 35: // End.
                return true
            break;

            /* Pokud je klavesa definovana v parametru fce. */
            default:
                return $.inArray(keyCode, ctrl) >= 0
            break;
        }
    } else {
        /* Jedna se o klasicke klavesy. */
        var re = new RegExp(keys)

        /* Enter, delete, tabulator jako klavesa muze probublat i sem. */
        if ($.inArray(code, [8, 9, 13]) >= 0) {
            return true;
        }

        return re.test(String.fromCharCode(code))
    }
}

// filtrace pouze pro cisla
function only_nums(e)
{
    return filter_keys(e, [], '[0-9\-]')
}

// filtrace pouze pro datum
function only_date(e)
{
    return filter_keys(e, [], '[0-9.]')
}

// filtrace pouze pro pismena (slova)
function only_alpha(e)
{
    return filter_keys(e, [], '[a-žA-Ž ]')
}


// READY
$(document).ready(function(){
    var trash            = $('#trash'); // kos, z ktereho se hraci vybiraji
    var arrangement_list = $('#arrangement_list'); // soupiska, kam se hraci pridavaji

    // zachovani cisla u hrace i pri premistovani
    $(".arrangement_item .number input").live('focusout', function(){
        $(this).attr('value', this.value);
    });

    // rozdeleni soupisky (zakladni sestava - nahradnici - vetsi mezera)
    $(".arrangement_item:nth-child(12)").addClass("added");

    // polozky kose umoznime chytit mysi
	$(".trash_item", trash).draggable({
        helper: 'clone', // polozka se naklonuje (jde videt 2x)
        revert: 'invalid' // pokud polozka neni prenesena na soupisku, polozka se dynamicky vraci na sve misto
    });

    // do soupisky povolime pretahovat polozky z kose
	$(".arrangement_item", arrangement_list).droppable({
        accept: "#trash > .trash_item", // akceptovane jsou prave jen polozky z kose
        hoverClass: "highlighted", // trida pri presouvani
        drop: function(event, ui) { // udalost po polozeni polozky na soupisku
            $(this).html(ui.draggable.html()); // prenesu text z puvodni polozky do polozky nove
            $(this).removeClass('empty'); // prenesu text z puvodni polozky do polozky nove
            this.id = $(ui.draggable).attr('id'); // prenesu id z puvodni polozky do polozky nove
            ui.draggable.remove(); // uvodni polozku z kose smazu
            $(this).droppable({ disabled: true }); // do polozky uz nelze ukladat
		}
    });

    // do kose povolime pretahovat polozky zpet ze soupisky
 	trash.droppable({
        accept: "#arrangement_list > .arrangement_item:not(.anonymous_player)", // akceptovane jsou prav jen polozky ze soupisky
        drop: function(event, ui) { // udalost po polozeni polozky do kose
            var ud_text = ui.draggable.html(); // zjistime, jestli pretahovana polozka obsahuje text (je neprazdna)

            if (ud_text != '') { // pokud je pretahovana polozka neprazdna, prejdeme na samotne polozeni polozky do kose
                $("<div></div>") // vytvorime novou prazdnou polozku
                    .addClass('trash_item') // priradime ji tridu kose
                    .attr('id', ui.draggable.attr('id')) // priradime ji id puvodni polozky na soupisce
                    .html(ud_text) // vlozime do ni puvodni text polozky na soupisce
                    .prependTo(trash) // tuto polozku pridame do kose na konec
                    .draggable({ // polozku nastavime opet jako pretahovatelnou (dulezite - bez toho je to pouze jednorazova akce)
                        helper: 'clone', // polozka se naklonuje (jde videt 2x)
                        revert: 'invalid' // pokud polozka neni prenesena na soupisku, polozka se dynamicky vraci na sve misto
                    });

                ui.draggable.html('<span class="edit"></span>'); // vynulujeme text puvodni polozky na soupisce
                ui.draggable.removeAttr('id'); // odstranime parametr ID puvodni polozky na soupisce
                $(ui.draggable).droppable({ disabled: false }); // povolime upustit
                ui.draggable.addClass('empty'); // prenesu text z puvodni polozky do polozky nove
            }
		}
    });

    // povolime razeni v ramci soupisky
	arrangement_list.sortable({
        helper: 'clone', // polozka se naklonuje (jde videt 2x)
        placeholder: "arrangement_item highlighted", // za co je mozne polozku chytat
        revert: true, // polozku neni mozne nikam jinam umistit
        cancel: ".empty, .edit, .erase, .number input, .name input, .rc input" // za co neni mozne polozku chytat
    });

    // udalost po dvojkliku na polozku kose (live - kvuli vicerazovemu pouziti)
	$(".trash_item", trash).live('dblclick', function() {
        appendItem(this, arrangement_list); // prenese polozku na soupisku
    });

    // udalost po dvojkliku na polozku soupisky (live - kvuli vicerazovemu pouziti)
	$(".arrangement_item", arrangement_list).live('dblclick', function() {
        bringItemBack(this, trash); // prenese polozku zpet do kose
    });

    // udalost po kliku na edit na soupisce
 	$(".arrangement_item .edit:not(.disabled):not(.save)", arrangement_list).live('click', function() {
        showAnonymousPlayer($(this).parent('.arrangement_item'));
    });

    // udalost po kliku na save na soupisce
	$(".arrangement_item .edit.save:not(.disabled)", arrangement_list).live('click', function(){
        hideAndSaveAnonymousPlayer($(this).parent('.arrangement_item'));
    });

    // udalost po kliku na vymazat na soupisce
 	$(".arrangement_item .erase", arrangement_list).live('click', function(){
        eraseAnonymousPlayer($(this).parent('.arrangement_item'));
    });

    // kliknuti na button
    $('button').click(function(){
        var alert= '';
        var href  = $(this).attr('href');

        if ($(this).hasClass('confirm')) {
            if (!fn_confirm($(this))) {
                return false;
            }
        }

        if (href != '' && href != undefined) {
            window.location = href;
        }
    });

    /** SMEROVA TLACITKA **/

    // homepage - start
	$(".start_button").live('click', function() { // udalost po kliku na tl. Muzstva
        var response = {
            'id_squad'       : $(this).attr('rel'), // ID squad
            'ignore_warnings': $('input#ignore_warnings').is(':checked') // ignore warnings
        }

        $.post("/homepage/ajax", response, function(theResponse){
            window.location = "/clubselect";
        });
    });

    // clubselect - soupiska domaci
	$("#arrangement").live('click', function() {
        if ($('#rivals .away').attr('rel') == undefined) {
            alert("Nebyl vybrán soupeř!");
            return false;
        } else {
            var response = {'id_away_team': $('#rivals .away').attr('rel')} // ID away tymu

            $.post("/clubselect/ajax", response, function(theResponse){
                window.location = "/arrangement";
            });
        }
    });

    // arrangement - vyber soupere
	$("#select_rival").live('click', function() {
        var response = setPlayers(arrangement_list);

        click_away("arrangement", response, "/clubselect");
    });

    // arrangement - soupiska hoste
	$("#arrangement_away").live('click', function() {
        var response = setPlayers(arrangement_list);

        click_away("arrangement", response, "/arrangement2");
    });

    // arrangement2 - soupiska domaci
	$("#arrangement_home").live('click', function() {
        var response = setPlayers(arrangement_list);

        click_away("arrangement2", response, "/arrangement");
    });

    // arrangement2 - zadni strana domaci
	$("#added").live('click', function() {
        var response = setPlayers(arrangement_list);

        click_away("arrangement2", response, "/added");
    });

    // added - soupiska hoste
	$("#select_rival_back").live('click', function() {
        var response = setPlayers(arrangement_list);

        // promenne
        response['variables'] = setSetupVariables();

        click_away("added", response, "/arrangement2");
    });

    // added - zadni strana hoste
	$("#added2").live('click', function() {
        var response = setPlayers(arrangement_list);

        // promenne
        response['variables'] = setSetupVariables();

        click_away("added", response, "/added2");
    });

    // added2 - zadni strana domaci
	$("#added_back").live('click', function() {
        var response = setPlayers(arrangement_list);

        // promenne
        response['variables'] = setSetupVariables();

        click_away("added2", response, "/added");
    });

    // added2 - tisk
	$("#final_print").live('click', function() {
        var response = setPlayers(arrangement_list);

        // promenne
        response['variables'] = setSetupVariables();

        $.post("/added2/print", response, function(theResponse){
            if (myIsString(theResponse)) {
                alert(theResponse);
            } else {
                window.location = "/pdf";
            }
        });
    });

    // minulá sestava
	$("#last_arrangement:not(.disabled)").live('click', function() { // udalost po kliku na tl. Minulá sestava
        var response = {};

        $.post("/arrangement/lastarrangement", response, function(theResponse){
            if (theResponse == '') {
                alert("Pro toto mužstvo v této sezóně ještě nebyla uložena žádná sestava.");
            } else {
                var obj = eval('(' + theResponse + ')');

                for (var position in obj) {
                    if (obj[position]['id'] != null) {
                        appendItemFromDB(obj[position], arrangement_list);
                    }
                }

                $("#last_arrangement").addClass('disabled');
            }
        });
    });

    // vymazat
	$(".erase_button").click(function(){ // udalost po kliku na tl. Vymazat
        if (!fn_confirm($(this))) {
            return false;
        }

        var response = {'erase_id': $(this).attr('id')};

        $.post("/arrangement/eraseArrangement", response, function(theResponse){
            window.location = self.location;
        });
    });

    /* autocomplete - vyber soupere */
	$(function() {
		$("#rivals .away input").autocomplete({
        	source: function( request, response ) {
                $.ajax({
                    url: "/livesearch",
                    data: {
                        table: 'tymy',
                        searched_phrase: request.term
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                img: item.badge_html,
                                label: item.label,
                                value: item.title,
                                id: item.id
                            }
                        }));
                    }
                });
            },
            html: true,

            select: function( event, ui ) {
                $('#rivals .away .badge').html(ui.item.img);
                $('#rivals .away').attr('rel', ui.item.id);
            }
		});
	});

    // zatrhavani typu zapasu
    $('.contest_levels .contest_level').click(function() {
        $('.contest_levels .contest_level').removeClass('checked');

        if (!($(this).hasClass('checked'))) {
            $(this).addClass('checked');
        }
    });
    $('.contest_types .contest_type').click(function() {
        $('.contest_types .contest_type').removeClass('checked');

        if (!($(this).hasClass('checked'))) {
            $(this).addClass('checked');
        }
    });

    // po najeti na stranku se souperi, prideli se focus na vyber soupere
    $('#rivals .rival .name input').focus();

    // do cisla dresu a ID lze zapsat pouze cisla
    $('.arrangement_item .number input, .arrangement_item .rc input').live('keypress', function(event) {
        return only_nums(event);
    });

    // do jmeno lze zapsat pouze pismena a mezeru
    $('.arrangement_item .name input').live('keypress', function(event) {
        return only_alpha(event);
    });

});
