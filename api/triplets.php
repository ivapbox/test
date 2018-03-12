<?php
include_once('Livecoin.php');
include_once('rate.php');

$delay = 2;

$lfc = new Livecoin();

$btcusd_bid;
$btcusd_ask;
$btcrur_bid;
$btcrur_ask;
$usdrur_bid;
$usdrur_ask;

$oair = '';

while (true) {
    if ($result = $lfc->maxbid_minask($pair)["currencyPairs"])
    {
        for ($i=0;$i<sizeof($result);$i++)
        {
            if ($result[$i]["symbol"] == "BTC/USD")
            {
                $btcusd_bid = $result[$i]["maxBid"];
                $btcusd_ask = $result[$i]["minAsk"];
            }
            if ($result[$i]["symbol"] == "BTC/RUR")
            {
                $btcrur_bid = $result[$i]["maxBid"];
                $btcrur_ask = $result[$i]["minAsk"];
            }
            if ($result[$i]["symbol"] == "USD/RUR")
            {
                $usdrur_bid = $result[$i]["maxBid"];
                $usdrur_ask = $result[$i]["minAsk"];
            }
        }
        echo "BTCUSD_BID: ".$btcusd_bid."\n";
        echo "BTCUSD_ASK: ".$btcusd_ask."\n";
        echo "BTCRUR_BID: ".$btcrur_bid."\n";
        echo "BTCRUR_ASK: ".$btcrur_ask."\n";
        echo "USDRUR_BID: ".$usdrur_bid."\n";
        echo "USDRUR_ASK: ".$usdrur_ask."\n";
        echo (0.9982*0.9982*0.9982/$btcusd_ask*$btcrur_bid/$usdrur_ask)."\n";
    }
    sleep($delay);

}


?>