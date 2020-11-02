<?php

function read_board() {
	global $mysqli;
	$sql = 'select * from board';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	return($res->fetch_all(MYSQLI_ASSOC));
}

function reset_board(){
	global $mysqli;
	$sql = 'CALL `clear_game`()';
	$mysqli->query($sql);
}



?>