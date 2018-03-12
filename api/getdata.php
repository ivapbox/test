<?php
include_once('Bitfinex.php');
include_once('Livecoin.php');
include_once('rate.php');

$delay = 60;
$pair1 = "BTC";
$pair2 = "USD";

$bfx = new Bitfinex();
$lfc = new Livecoin();
//$data = new Rate($size,$delay, $bfx->get_ticker($pair1.$pair2)['last_price']);

while (true)
{
    $bfx_lastprice = $bfx->get_ticker($pair1.$pair2)['last_price'];
    $lfc_lastprice = $lfc->get_ticker($pair1.'/'.$pair2)['last'];
    file_put_contents('out.csv', str_replace('.',',', (string)$bfx_lastprice).';'.str_replace('.',',', (string)$lfc_lastprice)."\n", FILE_APPEND);
    sleep($delay);
}


?>