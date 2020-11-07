<?php

//epistrofh tou board json
function show_board(){
	header('Content-type: application/json');
	print json_encode(read_board(), JSON_PRETTY_PRINT);
}

//diavasma tou board
function read_board() {
	global $mysqli;
	$sql = 'select * from board';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	return($res->fetch_all(MYSQLI_ASSOC));
}

//klhsh ths procedure gia reset tou board kai olou tou paixnidiou
function reset_board(){
	global $mysqli;
	$sql = 'CALL `clear_game`()';
	$mysqli->query($sql);
}

//klhshs ths procedure gia ekxwrhsh kinhshs sto board symfwna me ton paikth kai thn sthlh 
function do_move($input){
	$col_num = $input['move'];
	$pawn_color = $input['pawn_color'];
	global $mysqli;
	$sql = 'call `do_move`(?,?);';
	$st = $mysqli->prepare($sql);
	$st->bind_param('is',$col_num,$pawn_color );
	$st->execute();

	header('Content-type: application/json');
	print json_encode(read_board(), JSON_PRETTY_PRINT);
}
