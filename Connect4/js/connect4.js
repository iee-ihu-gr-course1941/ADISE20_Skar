var me = { token: null, pawn_color: null };
var me1 = { token: null, pawn_color: null };
var game_status = {};
var board = {};
var last_update = new Date().getTime();
var timer = null;


$(function() {
    draw_the_board();

    $('#login_btn').click(login_to_game);
    $('#play_btn').click(do_move);

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
    check_num_players();
}

function check_num_players() {
    $.ajax({
        url: "connect4.php/players/check/",
        method: 'GET',
        headers: { "X-Token": me.token },
        dataType: "json",
        success: go_login,

    });

}

function go_login(data) {
    me = data[0];
    me1 = data[1];
    if (data[1] != null) {
        $('#game_initializer').hide(2000);
        $('#gamepad').show(2000);

    }
    update_player_info();

}

function update_player_info() {
    $('#p1').html("Nickname: " + me.nickname + "<br> Χρώμα: " + me.pawn_color);
    $('#p2').html("Nickname: " + me1.nickname + "<br> Χρώμα: " + me1.pawn_color);

}


function login_error(data) {
    var x = data.responseJSON;
    alert(x.errormesg);
}



function do_move() {

}