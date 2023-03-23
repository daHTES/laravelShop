<?php

namespace App\Services;

use GuzzleHttp\Client;

class CurrencyRates{


    public static function getRates(){

        $baseCurrency = CurrencyConversion::getBaseCurrency();


        $url = config('currency_rates.api_url') . '?base=' . $baseCurrency->code;

        $client = new Client();
        $api = array( CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            "apikey: qpue77Qvjr3xUsMN5asCh050QGJy922M"
        ),);

        $response = $client->request('GET', $url, $api);

        if($response->getStatusCode() !== 200){
            throw new \Exception('Проблемы с сервисом валют');
        }
        $rates = $response->getBody()->getContents();


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/live?base=USD&symbols=EUR,GBP&date=2023-03-19",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: qpue77Qvjr3xUsMN5asCh050QGJy922M"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);

    }

}
