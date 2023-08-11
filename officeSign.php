<?php

    include('../session.php');
    include('../functions_main.php');
    include('../libraries/library_gotlint.php');
    include('../functions/functions_login.php');

#-> ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    #-> Взимане на масива с правата
    if ( isset($_SESSION['operations_array']) ) { $operations_array = $_SESSION['operations_array']; }
    else { $operations_array = array(); }
    #-> Проверка дали се е логнал потребител
    if ( !isset($_SESSION['logged_user_number']) || $_SESSION['speedy_employee'] != 'Y' )
    { exit ("<br>$error05"); }
    #-> ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    #-> Ембедната картинка
    $embeddedImageDetailsArray = array(
        'embeddedImage' => '../images/logoSpeedy.png',
        'embeddedImageTitle' => 'Speedy',
        'embeddedImageCid' => 'Logo',
    );


    #-> Деклариране на променливи
    $title = 'РАБОТНО ВРЕМЕ';
    $officeId= '';
    $html = '';


    #-> Данни за връзка към БД
    $conn = DBConnection("portal.db.speedy.bg:portal", "SYSDBA", "SpdDB@01", "Грешка");

    #-> Отваряне на трансакция
    $transaction = ibase_trans(IBASE_READ + IBASE_COMMITTED + IBASE_REC_VERSION + IBASE_NOWAIT);


    #-> Взимане на номер на офис
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $officeId = $_POST["officeId"];

        #-> Извеждане на офис според неговия номер.
        $officeDetailsArray = getOfficeDetailsByID($transaction, $officeId);

    }

    ibase_rollback($transaction);

    ibase_close($conn);



$body10 = <<<B10
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/officeSign.css">
    <script src='../jquery/3.1.1/jquery-3.1.1.min.js' type='text/javascript'></script>
    <!-- jQuery UI -->
    <script src='../jquery/3.1.1/jquery-ui.min.js' type='text/javascript'></script>
    <title>$title</title>
</head>
<body>
    <div class="title">
        <h1>$title</h1>
    </div>
    <form action="officeSignResult.php" method="POST" id="office-sign">
        <div class="main-container">
            <div class="input-container">
                <p>Посочете номер на офис</p>
                <input type="text" name="officeId" class="input-field">
            </div>
            <input type="submit" name="Submit" value="ГЕНЕРИРАЙ" class="inputButtonSubmit">
        </div>
    </form>
</body>
</html>
B10;
echo $body10;
