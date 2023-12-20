<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class DiscordAuthController extends Controller
{
    public function __invoke()
    {
        $code = request()->query('code');
        if ($code == null)
        {
            // LOCAL HOST
            //return redirect('https://discord.com/api/oauth2/authorize?client_id=631951598360199188&redirect_uri=http%3A%2F%2F127.0.0.1%3A8000%2Fauth&response_type=code&scope=identify%20guilds');
            // PROD
            return redirect('https://discord.com/api/oauth2/authorize?client_id=631951598360199188&redirect_uri=https%3A%2F%2Faplikuj.infinityrp.pl%2Fauth&response_type=code&scope=identify%20guilds');
        }

        $client = new Client();
        $formParams = [
            'form_params' => [
                'client_id'     => env('DISCORD_CLIENT_ID'),
                'client_secret' => env('DISCORD_CLIENT_SECRET'),
                'grant_type'    => 'authorization_code',
                'code'          => $code,
                //'redirect_uri'  => 'http://127.0.0.1:8000/auth'
                'redirect_uri'  => 'https://aplikuj.infinityrp.pl/auth'
            ]
        ];
        $headers = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ];

        try {
            $response = $client->post('https://discordapp.com/api/v6/oauth2/token', $formParams, $headers);
        }catch (ClientException $exception) {
            return abort(403);
        }

        $responseBody = json_decode($response->getBody()->getContents());

        $token = $responseBody->access_token;
        $tokenExpiration = floor($responseBody->expires_in / 60);

        try{
            $userResp = $client->get('https://discord.com/api/users/@me', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);
            $userRespBody = json_decode($userResp->getBody()->getContents());
            try{
                $client->get('https://discord.com/api/guilds/720328695608377405/members/'.$userRespBody->id, [
                    'headers' => [
                        'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN')
                    ]
                ]);
                return redirect('/')->withCookie('token', $token, $tokenExpiration);
            } catch(ClientException $e){
                return view('errors.custom')->with('code', 'Błąd 🤬')->with('message', 'Aby aplikować na whitelistę musisz być członkiem na naszym serwerze Discord. Aby dołączyć na nasz serwer kliknij w link: https://discord.io/IRPDayZ');
            }
        } catch(ClientException $e){
            return view('errors.custom')->with('code', 'Błąd 🤬')->with('message', 'Wystąpił błąd podczas autoryzacji. Spróbuj ponownie później.');
        }
    }
}
