<?php

    include('../session.php');
    include('../functions_main.php');


    #-> Данни за връзка към БД
    $conn = DBConnection("portal.db.speedy.bg:portal", "SYSDBA", "SpdDB@01", "Грешка");

    #-> Отваряне на трансакция
    $transaction = ibase_trans(IBASE_READ + IBASE_COMMITTED + IBASE_REC_VERSION + IBASE_NOWAIT);


    #-> Взимане на номер на офис
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $officeId = $_POST["officeId"];

        #-> Извеждане на офис според неговия номер.
        $officeDetailsArray = getOfficeDetailsByID($transaction, $officeId);

        if ($officeDetailsArray[SubContractorAddress] == '') {
            $subContractorAddress = "<p>Спиди АД, гр. София, ул. Абагар №22, София Сити Лоджистик Парк, административна сграда Спиди</p>";
        }
        else {
            $subContractorAddress = $officeDetailsArray[SubContractorAddress];
        }

    }

    ibase_rollback($transaction);

    ibase_close($conn);



$body01 = <<<B01
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/officeSign.css">
    <script src='../jquery/3.1.1/jquery-3.1.1.min.js' type='text/javascript'></script>
    <title>Document</title>
    <script>
        $(document).ready(function() {
            $('#printButton').on('click', function() {
                window.print();
            });
        });

        
        $(document).ready(function() {
            $('.input-checkbox').on('change', function() {
              // Uncheck all checkboxes except the one that was just checked
              $('.input-checkbox').not(this).prop('checked', false);
            });
          });
        

        $(document).ready(function () {
            $('#checkbox1').change(function () {
                if (this.checked) {
                    $('#fifth-row-container').fadeIn('slow');
                    $('#sixth-row-container').fadeOut('slow');
                    $('#seventh-row-container').fadeOut('slow');
                } else{
                    $('#fifth-row-container').fadeOut('slow');
                    $('#sixth-row-container').fadeOut('slow');
                    $('#seventh-row-container').fadeOut('slow');
                }
            });
        });       
        
        $(document).ready(function () {
            $('#checkbox2').change(function () {
                if (this.checked) {
                    $('#fifth-row-container').fadeOut('slow');
                    $('#sixth-row-container').fadeIn('slow');
                    $('#seventh-row-container').fadeOut('slow');
                } else{
                    $('#fifth-row-container').fadeOut('slow');
                    $('#sixth-row-container').fadeOut('slow');
                    $('#seventh-row-container').fadeOut('slow');
                }
            });
        });      
        
        
        $(document).ready(function () {
            $('#checkbox3').change(function () {
                if (this.checked) {
                    $('#fifth-row-container').fadeOut('slow');
                    $('#sixth-row-container').fadeOut('slow');
                    $('#seventh-row-container').fadeIn('slow');
                } else{
                    $('#fifth-row-container').fadeOut('slow');
                    $('#sixth-row-container').fadeOut('slow');
                    $('#seventh-row-container').fadeOut('slow');
                }
            });
        }); 
    </script>
</head>
<body>
    <div class="office-sign-template" xmlns="http://www.w3.org/1999/html">
        <div class="first-row-container">
            <img src="../images/logoSpeedy.png" alt="Speedy logo">
            <div class="speedy-text-number">
                <p>СПИДИ ОФИС</p>
                <p>$officeDetailsArray[OfficeID]</p>
            </div>
        </div>
        <div class="second-row-container">
            <div class="first-column">
                <div class="margin-text">
                    <p class="paragraph-bold">Име на офиса:</p>
                    <p class="result-text">$officeDetailsArray[PartnerSiteName]</p>
                </div>
                <div class="margin-text">
                    <p class="paragraph-bold">Адрес на офиса:</p>
                    <p class="result-text">$officeDetailsArray[PartnerAddress]</p>
                </div>
                <div class="margin-text">
                    <p class="paragraph-bold">Отговорник на обекта, телефон:</p>
                    <p>$officeDetailsArray[SubContractorContactName]</p>
                </div>
            </div>
            <div class="second-column">
                <p class="paragraph-bold">Данъчен адрес на фирмата:</p>
                <p>$officeDetailsArray[SubContractorPartnerName] $subContractorAddress</p>
            </div>
            <div class="third-column">
                <div>
                    <div class="margin-text">
                        <p class="paragraph-bold">Уебсайт:</p>
                        <p>www.speedy.bg</p>
                    </div>
                    <div class="margin-text">
                        <p class="paragraph-bold">Национален телефон</p>
                        <p>0 7001 7001  (от фиксирани мрежи)</p>
                        <p>1 7001 7001  (от мобилни оператори)</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="third-row-container">
            <div class="working-time-text-container">
                <p class="working-time-text-bg">Работно време</p>
                <p class="working-time-text-en">Working hours</p>
            </div>
            <div class="working-days-container">
                <div class="working-weekdays">
                    <p class="working-time-text-description">Понеделник - Петък</p>
                    <p class="working-time-text-description">Monday - Friday</p>
                </div>
                <div class="working-weekdays-time">
                    <p class="working-time-hours">$officeDetailsArray[WorkingTimeFrom] - $officeDetailsArray[WorkingTimeTo]</p>
                </div>
            </div>
            <div class="working-saturday-container">
                <div class="working-saturday">
                    <p class="working-time-text-description">Събота</p>
                    <p class="working-time-text-description">Saturday</p>
                </div>
                <div class="working-weekdays-time">
                    <p class="working-time-hours">$officeDetailsArray[WorkingTimeHalfFrom] - $officeDetailsArray[WorkingTimeHalfTo]</p>
                </div>
            </div>
            <div class="working-sunday-container">
                <div class="working-sunday">
                    <p class="working-time-text-description">Неделя</p>
                    <p class="working-time-text-description">Sunday</p>
                </div>
                <div class="working-weekdays-time">
                    <p class="working-time-hours">-</p>
                </div>
            </div>
        </div>
        <div class="fourth-row-container">
            <div class="end-time-for-dispatch-text">
                <div class="margin-text">
                    <p class="text-bold">КРАЕН ЧАС</p>
                    <p>за приемане на пратки за изпращане в същия ден</p>
                </div>
                <div class="margin-text">
                    <p class="text-bold">CUTOFF TIME</p>
                    <p>for accepting parcels for same day dispatch</p>
                </div>
            </div>
            <div class="end-time-for-dispatch-days">
                <div class="end-time-dispatch-weekdays">
                    <div>
                        <p>Понеделник - Петък</p>
                        <p>Modany - Friday</p>
                    </div>
                    <div>
                        <p>$officeDetailsArray[SameDayDepartureCutoff]</p>
                    </div>
                </div>
                <div class="end-time-dispatch-saturday">
                    <div>
                        <p>Събота</p>
                        <p>Saturday</p>
                    </div>
                    <div>
                        <p>$officeDetailsArray[SameDayDepartureCutoffhalf]</p>
                    </div>
                </div>
                <div class="end-time-dispatch-sunday">
                    <div>
                        <p>Неделя</p>
                        <p>Sunday</p>
                    </div>
                    <div>
                        <p>-</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="fifth-row-container" class="fifth-row-container">
            <div class="job-offer-title">
                <p class="job-offer-text">ПРЕДЛОЖЕНИЕ ЗА РАБОТА</p>
            </div>
            <div class="job-offer-contacts">
                <span class="job-offer-details">Куриер в офис</span>
                <span class="job-offer-details"></span>
            </div>
        </div>
        <div id="sixth-row-container" class="fifth-row-container">
            <div class="job-offer-title">
                <p class="job-offer-text">ПРЕДЛОЖЕНИЕ ЗА РАБОТА</p>
            </div>
            <div class="job-offer-contacts">
                <span class="job-offer-details">Шофьор курер</span>
                <span class="job-offer-details"></span>
            </div>
        </div>
        <div id="seventh-row-container" class="fifth-row-container">
            <div class="job-offer-title">
                <p class="job-offer-text">ПРЕДЛОЖЕНИЕ ЗА РАБОТА</p>
            </div>
            <div class="job-offer-contacts">
                <div class="job-offer-both">
                    <span class="job-offer-details">Куриер в офис</span>
                    <span class="job-offer-details">Шофьор куриер</span>
                </div>
                <p class="job-offer-details"></p>
            </div>
        </div>
    </div>
    <div class="print-page-container">
        <div class="checkboxes-section">
            <div id="checkbox-container" class="checkbox-container">
                <input type="checkbox" id="checkbox1" class="input-checkbox">
                <label for="checkbox1">Обява за работа за офис куриер</label>
            </div>
            <div id="checkbox-container" class="checkbox-container">
                <input type="checkbox" id="checkbox2" class="input-checkbox">
                <label for="checkbox2">Обява за работа за шофьор куриер</label>
            </div>
            <div id="checkbox-container" class="checkbox-container">
                <input type="checkbox" id="checkbox3" class="input-checkbox">
                <label for="checkbox3">Обява за работа за двете позиции</label>
            </div>
        </div>
        <button id="printButton" class="inputButtonSubmit">ПРИНТИРАЙ</button>
    </div>
</body>
</html>
B01;
echo $body01;