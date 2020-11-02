<?php

require_once "lib/dbconnect.php";
require_once "lib/players.php";
require_once "lib/board.php";
require_once "lib/game_status.php";

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);
if (isset($_SERVER['HTTP_X_TOKEN'])) {
    $input['token'] = $_SERVER['HTTP_X_TOKEN'];
}

switch ($r = array_shift($request)) {
    case 'players':
        switch ($r = array_shift($request)) {
            case '':
                manage_player($method, $input);
                break;
            case 'check':
                check_players();
                break;
        }
        break;
    case 'board':
        switch ($r = array_shift($request)) {
            case 'reset':
                manage_board($method);
                break;
        }
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        print json_encode(['errormsg' => "Switch problem."]);
        exit;
}

function manage_player($method, $input)
{
    handle_player($method, $input);
}


function check_players()
{
    show_players();
}

function manage_board($method){
    reset_board();
}
