<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function index()
    {
        $devices = device("GET");
        return response(["results" => $devices]);
    }

    public function show($id)
    {
        $device = device("GET", $id);
        return response(["result" => $device]);
    }

    public function store(Request $request)
    {
        $device = device("POST", $request->device);
        return response(["result" => $device]);
    }

    public function destroy($id)
    {
        $device = device("DELETE", $id);
        return response(["result" => 'Success deleted']);
    }

    public function getQRCode($id)
    {
        $QRCode = getQRCode($id);
        return response(["result" => $QRCode]);
    }

    public function getMessage($id)
    {
        $result = message("GET", $id);
        return response(compact('result'));
    }

    public function sendMessage(Request $request)
    {
        $body = $request->message;
        $phone_number = $request->phone_number;
        $message_type = $request->message_type;
        $device_id = $request->device_id;
        $result = message("POST", $body, $phone_number, $message_type, $device_id);

        return response(compact('result'));
    }
}
