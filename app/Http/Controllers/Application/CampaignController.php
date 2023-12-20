<?php

namespace App\Http\Controllers\Application;

use App\Campaign;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;

class CampaignController extends Controller
{
    public function displayCampaigns()
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
        $profilePicture = 'https://cdn.discordapp.com/avatars/' . $responseBody->id . '/' . $responseBody->avatar . '.png';

        $campaigns = Campaign::orderBy('created_at', 'asc')->get();
        return view('pages.user.campaigns')->with('profilePicture', $profilePicture)->with('campaigns', $campaigns);
    }
}
