<?php

namespace src\service;

use src\exception\CoinsAPIException;
use src\model\CoinsAPI;

final class APIService
{
    public static function listCoin(): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&x_cg_demo_api_key=CG-yUbvm3JybNojZ1EnsM1G7fZM",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $listCoin = [];

        if ($err) {
            throw new CoinsAPIException("cURL Error: {$err}");
        }

        $coins = json_decode($response, true);

        if (!is_array($coins)) {
            throw new CoinsAPIException('Error decoding API response');
        }

        foreach ($coins as $key => $value) {
            $listCoin[] =
                new CoinsAPI(
                    name: $value['name'],
                    symbol: $value['symbol'],
                    image: $value['image'],
                    price: $value['current_price'],
                );
        }

        return $listCoin;
    }
}
