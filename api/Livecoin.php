<?php
class Livecoin{

    private $apiLiveCoin_key = 'qxg8BYjfjUBrygRaFfTH8bVUXr6nGGhW';
    private  $apiLiveCoin_secret = 'gbkPSKUP2SZrAntHS1XGykSYTGQE8nXS';


    public function get_ticker($rate){
        $url = "https://api.livecoin.net/exchange/ticker";
        $params = array(
            'currencyPair'=> $rate
        );

        ksort($params);
        $fields = http_build_query($params, '', '&');
        $signature = strtoupper(hash_hmac('sha256', $fields, $this->apiLiveCoin_secret));
        $headers = array(
            "Api-Key: $this->apiLiveCoin_key",
            "Sign: $signature"
        );
        $ch = curl_init($url."?".$fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $res = json_decode($response, true);
        return $res;
    }

    public function maxbid_minask($rate){
        $url = "https://api.livecoin.net/exchange/maxbid_minask";
        $params = array(
            'currencyPair'=> $rate
        );

        ksort($params);
        $fields = http_build_query($params, '', '&');
        $signature = strtoupper(hash_hmac('sha256', $fields, $this->apiLiveCoin_secret));
        $headers = array(
            "Api-Key: $this->apiLiveCoin_key",
            "Sign: $signature"
        );
        $ch = curl_init($url."?".$fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $res = json_decode($response, true);
        return $res;
    }

    public function buymarket($rate, $qnt){
        $url = "https://api.livecoin.net/exchange/buymarket";
        $params = array(
            'currencyPair'=> $rate,
            'quantity' => $qnt
        );

        ksort($params);
        $fields = http_build_query($params, '', '&');
        $signature = strtoupper(hash_hmac('sha256', $fields, $this->apiLiveCoin_secret));
        $headers = array(
            "Api-Key: $this->apiLiveCoin_key",
            "Sign: $signature"
        );
        $ch = curl_init($url."?".$fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $res = json_decode($response, true);
        return $res;
    }


    public function sellmarket($rate, $qnt){
        $url = "https://api.livecoin.net/exchange/sellmarket";
        $params = array(
            'currencyPair'=> $rate,
            'quantity' => $qnt
        );

        ksort($params);
        $fields = http_build_query($params, '', '&');
        $signature = strtoupper(hash_hmac('sha256', $fields, $this->apiLiveCoin_secret));
        $headers = array(
            "Api-Key: $this->apiLiveCoin_key",
            "Sign: $signature"
        );
        $ch = curl_init($url."?".$fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $res = json_decode($response, true);
        return $res;
    }


    public function balance($rate){
        $url = "https://api.livecoin.net/payment/balance";
        $params = array(
            'currency'=> $rate,
        );

        ksort($params);
        $fields = http_build_query($params, '', '&');
        $signature = strtoupper(hash_hmac('sha256', $fields, $this->apiLiveCoin_secret));
        $headers = array(
            "Api-Key: $this->apiLiveCoin_key",
            "Sign: $signature"
        );
        $ch = curl_init($url."?".$fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $res = json_decode($response, true);
        return $res;
    }


}

?>