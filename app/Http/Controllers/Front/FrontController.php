<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\TempApplication;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;

class FrontController extends Controller
{
    public function __invoke()
    {
        $client = new Client();
        $headers = [
            'headers' => [
                'Authorization' => 'Bearer ' . Cookie::get('token')
            ]
        ];

        try
        {
            $response = $client->get('https://discordapp.com/api/v6/users/@me', $headers);
        }
        catch (ClientException $exception)
        {
            return abort(403);
        }

        $responseBody = json_decode($response->getBody()->getContents());
        $id = $responseBody->id;
        $profilePicture = 'https://cdn.discordapp.com/avatars/' . $responseBody->id . '/' . $responseBody->avatar . '.png';

        $applications = TempApplication::where('discord_id', $id)->orderBy('created_at', 'desc')->get();
        return view('welcome')
            ->with('profilePicture', $profilePicture)
            ->with('applications', $applications);
    }
}
