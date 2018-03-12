<?php
//include_once('Bitfinex.php');
include_once('Livecoin.php');
include_once('rate.php');

$size = 3;
$delay = 3;
$pair1 = "BCH";
$pair2 = "USD";

//$lfc = new Bitfinex();
$lfc = new Livecoin();
//$data = new Rate($size,$delay, $lfc->get_ticker($pair1.$pair2)['last_price']);
$data = new Rate($size,$delay, $lfc->get_ticker($pair1.'/'.$pair2)['last']);
$type = $pair1;
$bankUSD = 100;
$bankBTC = 0;
$break = false;
// начало непрерывной работы скрипта
for ($i=0;$i<$size; $i++)
{
    echo "filling...".$i."\n";
    if ($lfc_lastprice = $lfc->get_ticker($pair1.'/'.$pair2)['last'])
        $data->refresh($lfc_lastprice);
    else
        $i--;
    sleep($delay);
}
$lastPrice = $lfc_lastprice;
$lastValue = 100;


while (true) {
    $k = false;
    sleep($delay);
    $result = $lfc->get_ticker($pair1.'/'.$pair2);
    if (count($result)==11)
    {
        $str = (string)date("Y-m-d H:i:s")."\n";
        $lfc_lastprice = $result['last'];
        $lfc_ask = $result['best_ask'];
        $lfc_bid = $result['best_bid'];
        $str.= "Livecoin: " . $lfc_lastprice . "\n";
        $data->refresh($lfc_lastprice);
        if (strcasecmp($type,$pair2)==0) // если нужно покупать
        {
            if ($data->tp-$data->current<0) // выгодно покупать
            {
                $str.= "Buy: " . $bankUSD . " -> ";
                $bankBTC += ($bankUSD / $lfc_ask) * 0.9982; // перевод валюты (пока виртуальной)
                $bankUSD = 0;
                $str.= $bankBTC . " (" . $lfc_ask . ")\n";
                $type = $pair1;
                $k = true;
            }
        }
        else
        {
            if ($data->current-$data->sl<0) // стоплосс
            {
                $str .= "Sell: " . $bankBTC . " -> ";
                $bankUSD += ($bankBTC * $lfc_bid) * 0.9982;
                $bankBTC = 0;
                $str .= $bankUSD . " (" . $lfc_bid . ")\n";
                $type = $pair2;
                $k = true;
            }
        }

        $str.= $pair1 . ": " . $bankBTC . " (".$bankBTC*$lfc_lastprice." $)\n";
        $str.= $pair2 . ": " . $bankUSD . "\n";
        $str.= "summ: ";
        $str.= $bankUSD+$bankBTC*$lfc_lastprice."\n";
        $str.= "SL-value: ".$data->sl."\n";
        $str.= "TP-value: ".$data->tp;
        $str.= "\n\n";
        echo $str;
        if ($k) {
            file_put_contents('/opt/www/api2/history.log', $str, FILE_APPEND);
            $data->refresh_sltp();
        }
    }
    else
        sleep($delay*2);
}


?>