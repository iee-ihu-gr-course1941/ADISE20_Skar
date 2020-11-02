<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>ΑΔΙΣΕ: ΣΚΟΡ4</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="js/connect4.js"></script>
    <link rel="stylesheet" href="css/connect4.css">

</head>

<body>
    <div class="container-fluid" id="container">

        <div class="container-fluid">
            <div class="row justify-content-center">
                <h1>ΣΚΟΡ4</h1>
            </div>
            <div class="row justify-content-center" id="board">

            </div>
            <br>
            <div class="row justify-content-center">
                <div id='game_initializer'>
                    <div class="d-flex justify-content-center">
                        <input id='nickname_input'>
                        <select id='pawn_color'>
                            <option value='R'>R</option>
                            <option value='Y'>Y</option>
                        </select>
                        <button id='login_btn' class='btn btn-outline-danger'>ΕΙΣΟΔΟΣ</button><br>
                    </div>
                    <div id="gamepad">
                        <div class="d-flex justify-content-center">
                            Eπέλεξε την στήλη που θέλεις να τοποθετήσεις τον δίσκο:<br>
                            <select id="col_move">
                                <option value="1">Στήλη 1</option>
                                <option value="2">Στήλη 2</option>
                                <option value="3">Στήλη 3</option>
                                <option value="4">Στήλη 4</option>
                                <option value="5">Στήλη 5</option>
                                <option value="6">Στήλη 6</option>
                                <option value="7">Στήλη 7</option>
                            </select>
                            <button id="play_btn" class="btn btn-outline-danger">ΠΑΙΞΕ</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div id='game_info1' class="card mt-2">
                    <div class="card-body">
                        <p>Player</p><br>
                        <p id="p1"></p><br><br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <button id="reset_btn" class="btn btn-outline-danger">ΕΠΑΝΑΦΟΡΑ</button>
            </div>
        </div>
    </div>
</body>

</html>