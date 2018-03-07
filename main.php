<?php
include_once('Bitfinex.php');
include_once('Livecoin.php');
include_once('rate.php');

$size = 10;
$delay = 20;
$pair1 = "BTC";
$pair2 = "USD";

$bfx = new Bitfinex();
$lfc = new Livecoin();
$data = new Rate($size,$delay, $bfx->get_ticker($pair1.$pair2)['last_price']);
$type = $pair2;
$bankUSD = 100;
$bankBTC = 0;
$k = 0;
// начало непрерывной работы скрипта
for ($i=0;$i<$size; $i++)
{
    echo "filling...".$i."\n";
    if ($bfx_lastprice = $bfx->get_ticker($pair1.$pair2)['last_price'])
        $data->refresh($bfx_lastprice);
    else
        $i--;
    sleep($delay);
}
$lastPrice = $bfx_lastprice;
$lastValue = 100;

while (true) {
    sleep($delay);
    if ($result = $bfx->get_ticker($pair1.$pair2)) {
        $bfx_lastprice = $result['last_price'];
        $bfx_ask = $result['ask'];
        $bfx_bid = $result['bid'];
        //var_dump($result);
        //$lfc_lastprice = $lfc->get_ticker($pair1.'/'.$pair2)['last'];
        echo "Bitfinex: " . $bfx_lastprice . "\n";
        //echo "LiveCoin: ".$lfc_lastprice."\n";
        $data->refresh($bfx_lastprice);
        //echo "sum_diff(".$size."): ".$data->summ(1, 0, $size-1)."\n";
        //echo "sum_diff(0-".$data->id_change_sign."): ".$data->summ(1, 0, $data->id_change_sign)."\n";
        //$pdo->query("INSERT INTO _values (`bitfinex`, `livecoin`, `ts`) VALUES ($bfx_lastprice, $lfc_lastprice, NOW())");
        //echo $data->sign."\n";

        if (strcasecmp($type,$pair2)==0)
        {
            echo "label1\n";
            if (($data->values[0]>$data->values[1]) && ($data->values[1]<=$data->values[2])) // выгодно покупать
            {
                echo "Buy: " . $bankUSD . " -> ";
                $bankBTC += ($bankUSD / $bfx_ask) * 0.9982; // перевод валюты (пока виртуальной)
                $lastValue = $bankUSD;
                $bankUSD = 0;
                echo $bankBTC . " (" . $bfx_ask . ")\n";
                $type = $pair1;
                $lastPrice = $bfx_ask;
                $k = 0.995;
            }
        }
        else
        {
            echo "label2\n";
            if ($bfx_bid<=$k*$lastPrice) // стоплосс
            {
                echo "Sell: " . $bankBTC . " -> ";
                $bankUSD += ($bankBTC * $bfx_bid) * 0.9982;
                $bankBTC = 0;
                echo $bankUSD . " (" . $bfx_bid . ")\n";
                $type = $pair2;
                $lastPrice = $bfx_bid;
            }
            else
            {
                echo "label3\n";
                if ($bfx_bid >= 1.015 * $lastPrice) // тейкпрофит
                {
                    echo "Sell: " . $bankBTC . " -> ";
                    $needToSale = $lastValue / ($bfc_bid * 0.9982);
                    $bankBTC -= $needToSale;
                    $bankUSD = $lastValue;
                    echo $bankUSD . " (" . $bfx_bid . ")\n";
                    // продать так, чтоб остаться изначально при своем + наварить мальца
                }
            }
        }

        if ($bfx_bid>=1.01*$lastPrice)
            $k = 1.0036;


        echo $pair1 . ": " . $bankBTC . " (".$bankBTC*$bfx_lastprice." $)\n";
        echo $pair2 . ": " . $bankUSD . "\n";
        echo "summ: ";
        echo $bankUSD+$bankBTC*$bfx_lastprice;
        echo "\n\n";
    }
    //file_put_contents('out.csv', str_replace('.',',', (string)$bfx_lastprice).';'.str_replace('.',',', (string)$lfc_lastprice)."\n", FILE_APPEND);

}


?>