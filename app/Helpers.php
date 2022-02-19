<?php

// Function for register or get device
function device($method, $device = null)
{
    $client = new GuzzleHttp\Client;

    if ($method == "GET") {

        if ($device == null) {
            $url = env('API_WA') . '/devices/';
        } else {
            $url = env('API_WA') . '/devices/' . $device;
        }

        $res = $client->request($method, $url, [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
            ],
        ]);
    }

    if ($method == "POST") {
        $res = $client->request($method, env('API_WA') . '/devices', [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
            ],
            'body' => json_encode([
                'device_id' => $device
            ])
        ]);
    }

    if ($method == "DELETE") {
        $url = env('API_WA') . '/devices/' . $device;
        $res = $client->request($method, $url, [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
            ],
        ]);
    }

    $response = json_decode($res->getBody()->getContents());
    return $response;
}

// Function for get QR Code
function getQRCode($device)
{
    $query = http_build_query(['device_id' => $device]);
    $client = new GuzzleHttp\Client;
    $url = env('API_WA') . '/qr?' . $query;

    $res = $client->request('GET', $url, [
        'headers' => [
            'Content-type' => 'application/json',
            'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
        ],
    ]);
    $response = json_decode($res->getBody()->getContents());
    return $response;
}

// Function for send message WA and get message by id
function message($method, $message = null, $phone_number = null, $message_type = null, $device = null)
{
    $client = new GuzzleHttp\Client;
    if ($method == "GET") {
        $query = http_build_query([
            'status' => 'success'
        ]);

        if ($message == null) {
            $url = env('API_WA') . '/messages?' . $query;
        } else {
            $url = env('API_WA') . '/messages/' . $message;
        }

        $res = $client->request($method, $url, [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
            ],
        ]);
    }

    if ($method == "POST") {
        $url = env('API_WA') . '/messages';
        $res = $client->request($method, $url, [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
            ],
            'body' => json_encode([
                'message' => $message,
                'phone_number' => $phone_number,
                'message_type' => $message_type,
                'device_id' => $device
            ])
        ]);
    }

    $response = json_decode($res->getBody()->getContents());
    return $response;
}
