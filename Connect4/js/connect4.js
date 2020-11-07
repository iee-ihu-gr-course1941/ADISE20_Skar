var me = { nickname: null, token: null, pawn_color: null };
var game_status = {};
var timer = null;


$(function() {
    draw_the_board();

    $('#gamepad').hide();
    $('#login_btn').click(login_to_game);
    $('#play_btn').click(do_move);
    $('#reset_btn').click(reset_game);

    update_game_status();

})


function draw_the_board() {
    var board = '<table id="connect4_board">'
    for (var i = 1; i <= 6; i++) {
        board += '<tr>';
        for (var j = 1; j <= 7; j++) {
            board += '<td class="board_square" id="square_' + i + '_' + j + '">' + i + ',' + j + '</td>';
        }
        board += '</tr>';
    }
    board += '</table>'

    $('#board').html(board);
}

function fill_board() {
    $.ajax({
        url: "connect4.php/board/",
        method: 'GET',
        dataType: 'json',
        headers: { "X-Token": me.token },
        success: fill_board_data
    });
}

function fill_board_data(data) {
    for (var i = 0; i < data.length; i++) {
        var item = data[i];
        var id = '#square_' + item.x + '_' + item.y;
        if (item.pawn_color == 'R') {
            $(id).css('background-color', 'red');
        }
        if (item.pawn_color == 'Y') {
            $(id).css('background-color', 'yellow');
        }

    }

}


function login_to_game() {
    if ($('#nickname_input').val() == '') {
        alert('Δώσε nickname πρώτα!');
        return;
    }


    $.ajax({
        url: "connect4.php/players/",
        method: 'PUT',
        dataType: 'json',
        headers: { "X-Token": me.token },
        contentType: 'application/json',
        data: JSON.stringify({ nickname: $('#nickname_input').val(), pawn_color: $('#pawn_color').val() }),
        success: login_success,
        error: login_error
    });

}

function login_success(data) {
    me = data[0]
    $('#game_initializer').hide(2000);
    update_player_info();
    update_game_status();

}


function update_player_info() {
    $('#p1').html("Nickname: " + me.nickname + "<br> Χρώμα: " + me.pawn_color + "<br> Κατάσταση παιχνιδιού: " + game_status.status + "<br> Σειρά του παίκτη με χρώμα: " + game_status.p_turn + "<br> Νικητής ο παίκτης με χρώμα: " + game_status.result);
}


function login_error(data) {
    var x = data.responseJSON;
    alert(x.errormesg);
}

function update_game_status() {
    clearTimeout(timer);
    $.ajax({
        url: "connect4.php/status/",
        headers: { "X-Token": me.token },
        success: update_status
    });
}

function update_status(data) {
    game_status = data[0];

    fill_board();
    update_player_info();

    if (game_status.status == 'aborted') {
        $('#gamepad').hide(2000);
        timer = setTimeout(function() { update_game_status(); }, 4000);
    } else if (game_status.status == 'ended') {
        $('#gamepad').hide(2000);
        timer = setTimeout(function() { update_game_status(); }, 2000);
    } else {
        if (game_status.p_turn == me.pawn_color && me.pawn_color != null) {
            $('#gamepad').show(2000);
            timer = setTimeout(function() { update_game_status(); }, 10000);
        } else {
            $('#gamepad').hide(2000);
            timer = setTimeout(function() { update_game_status(); }, 4000);
        }
    }

}

function reset_game() {

    $.ajax({
        url: "connect4.php/board/reset/",
        method: 'POST',
        headers: { "X-Token": me.token },
        success: draw_the_board
    });


    $('#game_initializer').show(2000);
    $('#nickname_input').val("");
    $('#p1').empty();
    me = { nickname: null, token: null, pawn_color: null };
    update_game_status();
}



function do_move() {

    var $move = $('#col_move').val();

    if ($move < 1 || $move > 7) {
        alert('Δώσε έγκυρη στήλη');
        return;
    }

    $.ajax({
        url: "connect4.php/board/move/",
        method: 'PUT',
        dataType: 'json',
        headers: { "X-Token": me.token },
        contentType: 'application/json',
        data: JSON.stringify({ move: $move, pawn_color: me.pawn_color }),
        success: result_move,
        error: login_error
    });

}

function result_move(data) {
    update_game_status();
    fill_board();


}