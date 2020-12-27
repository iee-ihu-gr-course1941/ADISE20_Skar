<?php

function convert_board(&$first_board)
{
    $board = [];
    foreach ($first_board as $i => &$row) {
        $board[$row['x']][$row['y']] = &$row;
    }
    return ($board);
}


function check_winner()
{
    global $mysqli;
    $first_board = read_board();
    $board = convert_board($first_board);

    $RedCount = 0;
    $YellowCount = 0;

    //elegos gia orizontia aristera pros ta de3ia
    if ($RedCount == 0 && $YellowCount == 0) {

        for ($i = 6; $i >= 1; $i--) {
            for ($j = 1; $j <= 7; $j++) {
                if ($RedCount != 4 && $YellowCount != 4) {
                    if ($board[$i][$j]['pawn_color'] == 'R') {
                        $RedCount++;
                        $YellowCount = 0;
                    } elseif ($board[$i][$j]['pawn_color'] == 'Y') {
                        $RedCount = 0;
                        $YellowCount++;
                    }elseif ($board[$i][$j]['pawn_color'] != 'Y' || $board[$i][$j]['pawn_color'] != 'R'){
                        $RedCount = 0;
                        $YellowCount = 0;
                    }
                }
            }
            if ($RedCount == 4 || $YellowCount == 4) {
                break;
            } else {
                $YellowCount = 0;
                $RedCount = 0;
            }
        }
    }

    //elegxos gia katheta apo katw pros ta panw
    if ($RedCount == 0 && $YellowCount == 0) {
        for ($i = 7; $i >= 1; $i--) {
            for ($j = 6; $j >= 1; $j--) {
                if ($board[$j][$i]['pawn_color'] == 'R') {
                    $RedCount++;
                    $YellowCount = 0;
                } elseif ($board[$j][$i]['pawn_color'] == 'Y') {
                    $RedCount = 0;
                    $YellowCount++;
                }
            }
            if ($RedCount == 4 || $YellowCount == 4) {
                break;
            } else {
                $RedCount = 0;
                $YellowCount = 0;
            }
        }
    }

    //elegxos gia diagonia 6,1-6,4
    if ($RedCount == 0 && $YellowCount == 0) {
        $k = 6;
        for ($m = 1; $m <= 4; $m++) {
            if ($m == 1) {
                $p = 1;
                $n = 6;
            } elseif ($m == 2) {
                $p = 1;
                $n = 7;
            } elseif ($m == 3) {
                $p = 2;
                $n = 7;
            } elseif ($m == 4) {
                $p = 3;
                $n = 7;
            }
            while ($k >= $p && $m <= $n) {
                if ($board[$k][$m]['pawn_color'] == 'R') {
                    $RedCount++;
                    $YellowCount = 0;
                } elseif ($board[$k][$m]['pawn_color'] == 'Y') {
                    $YellowCount++;
                    $RedCount = 0;
                }

                $k--;
                $m++;
            }
            if ($RedCount == 4 || $YellowCount == 4) {
                break;
            } else {
                $RedCount = 0;
                $YellowCount = 0;
            }
        }
    }

    //elegxos gia diagonia 6,7-6,4
    if ($RedCount == 0 && $YellowCount == 0) {
        $k = 6;
        for ($m = 7; $m >= 4; $m--) {
            if ($m == 7) {
                $p = 1;
                $n = 2;
            } elseif ($m == 6) {
                $n = 1;
                $p = 1;
            } elseif ($m == 5) {
                $p = 2;
                $n = 1;
            } elseif ($m == 4) {
                $p = 3;
                $n = 1;
            }

            while ($k >= $p && $m >= $n) {
                if ($board[$k][$m]['pawn_color'] == 'R') {
                    $RedCount++;
                    $YellowCount = 0;
                } elseif ($board[$k][$m]['pawn_color'] == 'Y') {
                    $YellowCount++;
                    $RedCount = 0;
                }

                $k--;
                $m--;
            }
            if ($RedCount == 4 || $YellowCount == 4) {
                break;
            } else {
                $RedCount = 0;
                $YellowCount = 0;
            }
        }
    }

    //elegos gia diagonia 5,1-4,1
    if ($RedCount == 0 && $YellowCount == 0) {
        $m = 1;
        for ($k = 5; $k >= 4; $k--) {
            if ($k == 5) {
                $p = 1;
                $n = 5;
            } elseif ($k == 4) {
                $p = 1;
                $n = 4;
            }
            while ($k >= $p && $m <= $n) {
                if ($board[$k][$m]['pawn_color'] == 'R') {
                    $RedCount++;
                    $YellowCount = 0;
                } elseif ($board[$k][$m]['pawn_color'] == 'Y') {
                    $YellowCount++;
                    $RedCount = 0;
                }

                $k--;
                $m++;
            }
            if ($RedCount == 4 || $YellowCount == 4) {
                break;
            } else {
                $RedCount = 0;
                $YellowCount = 0;
            }
        }
    }

    //elegxos gia diagonia 5,7-4,7
    if ($RedCount == 0 && $YellowCount == 0) {
        $m = 7;
        for ($k = 5; $k >= 4; $k--) {
            if ($k == 5) {
                $p = 1;
                $n = 3;
            } elseif ($k == 4) {
                $p = 1;
                $n = 4;
            }
            while ($k >= $p && $m >= $n) {
                if ($board[$k][$m]['pawn_color'] == 'R') {
                    $RedCount++;
                    $YellowCount = 0;
                } elseif ($board[$k][$m]['pawn_color'] == 'Y') {
                    $YellowCount++;
                    $RedCount = 0;
                }

                $k--;
                $m--;
            }
            if ($RedCount == 4 || $YellowCount == 4) {
                break;
            } else {
                $RedCount = 0;
                $YellowCount = 0;
            }
        }
    }

    //elegxos gia to poios paikths kerdise kai enhmerwsh ths katastash tou paixnidiou
    if ($RedCount == 4) {

        $sql = "update game_status set status='ended', result='R',p_turn=null where p_turn is not null and status='started'";
        $st = $mysqli->prepare($sql);
        $r = $st->execute();
    } elseif ($YellowCount == 4) {
        $sql = "update game_status set status='ended', result='Y',p_turn=null where p_turn is not null and status='started'";
        $st = $mysqli->prepare($sql);
        $r = $st->execute();
    }
}
