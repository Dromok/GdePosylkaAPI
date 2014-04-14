<?php
/**
 * Пример получения данных и передачи их другому скрипту
 * (подобным же образом сервис ГдеПосылка информирует о новых статусах через callback)
 */

include('GdePosylkaAPI.php');

$apikey = ''; //вставьте ваш api-ключ сюда
$testurl = 'testapi.local'; //тестовый урл с этими скриптами

$gp = new GdePosylkaAPI($apikey);

$request = print_r($gp->trackStatus('CJ247232572US'),true);

// Создаем заголовки
$header[] = "Host: ".$testurl;
$header[] = "Content-type: text/xml; charset:utf-8";
$header[] = "Content-length: ".strlen($request);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://$testurl/testCallback.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_HTTPHEADER, $header );
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

$result = curl_exec($ch);
curl_close($ch);
echo $result;