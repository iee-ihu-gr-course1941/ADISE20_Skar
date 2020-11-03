<?php

function show_players()
{
    global $mysqli;
    $sql = 'select count(*) as p from players where nickname is not null';
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    $players = $res->fetch_assoc()['p'];
    return($players);
    //header('Content-type: application/json');
    //print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function show_player($pawn_color)
{
    global $mysqli;
    $sql = 'select nickname,pawn_color from players where pawn_color=?';
    $st = $mysqli->prepare($sql);
    $st->bind_param('s', $pawn_color);
    $st->execute();
    $res = $st->get_result();
    header('Content-type: application/json');
    print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function set_up_player($input)
{

    if (!isset($input['nickname'])) {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg' => "No nickname."]);
        exit;
    }
    $nickname = $input['nickname'];
    $pawn_color = $input['pawn_color'];
    global $mysqli;
    $sql = 'select count(*) as c from players where nickname=?';
    $st = $mysqli->prepare($sql);
    $st->bind_param('s', $nickname);
    $st->execute();
    $res = $st->get_result();
    $res_count = $res->fetch_all(MYSQLI_ASSOC);
    if ($res_count[0]['c'] > 0) {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg' => "Αυτό το nickname χρησιμοποιείται ήδη, δοκίμασε κάποιο άλλο."]);
        exit;
    }

    $sql2 = 'select count(*) as c from players where pawn_color=? and nickname is not null';
    $st2 = $mysqli->prepare($sql2);
    $st2->bind_param('s', $pawn_color);
    $st2->execute();
    $res2 = $st2->get_result();
    $res_count2 = $res2->fetch_all(MYSQLI_ASSOC);
    if ($res_count2[0]['c'] > 0) {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg' => "Αυτό το χρώμα χρησιμοποιείται ήδη επέλεξε κάποιο άλλο."]);
        exit;
    }

    $sql3 = 'update players set nickname=?, token=md5(CONCAT( ?, NOW())) where pawn_color=?';
    $st3 = $mysqli->prepare($sql3);
    $st3->bind_param('sss', $nickname, $nickname, $pawn_color);
    $st3->execute();

    update_status();
    $sql4 = 'select * from players where pawn_color=?';
    $st4 = $mysqli->prepare($sql4);
    $st4->bind_param('s', $pawn_color);
    $st4->execute();
    $res4 = $st4->get_result();
    header('Content-type: application/json');
    print json_encode($res4->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function handle_player($method, $input)
{
    if ($method == 'GET') {
        show_player($input['pawn_color']);
    } else if ($method == 'PUT') {
        set_up_player($input);
    }
}
?>
