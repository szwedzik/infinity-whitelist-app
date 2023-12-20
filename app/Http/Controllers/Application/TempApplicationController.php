<?php


namespace App\Http\Controllers\Application;


use App\Http\API\DayZAPI;
use App\Http\Controllers\Auth\AuthController;
use App\TempApplication;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use DateTime;
use Invisnik\LaravelSteamAuth\SteamAuth;
use MongoDB\Driver\Session;

class TempApplicationController
{
    public function displayApplicationCreation()
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

        $steam = \Illuminate\Support\Facades\Session::get('steam');
        $isBanned = (new \App\Http\API\DayZAPI)->isBaned($steam);
        if($isBanned){
            return view('errors.custom')->with('code', 'Zostałeś zbanowany 😥')->with('message', 'Zostałeś zbanowany na serwerze. Przez to twój dostęp do składania aplikacji został cofnięty. Powód blokady: ' . $isBanned->reason .' Pozostało: ' . $isBanned->timeRemaining);
        }

        $activeApp = TempApplication::where('discord_id', $responseBody->id)->where('state', 0)->first();
        $returnedApp = TempApplication::where('discord_id', $responseBody->id)->where('state', 2)->first();
        $lastCreated = TempApplication::where('discord_id', $responseBody->id)->where('state', 1)->orderBy('created_at', 'desc')->first();
        $canCreate = TempApplication::where('discord_id', $responseBody->id)->where('state', 3)->first();

        if($activeApp || $returnedApp){
            return redirect('/')->withFail('Posiadasz już jedną aktywną aplikację na whitelistę. Nie możesz zrobić nowej.');
        }
        if($lastCreated != null) {
            $lastCreatedAt = new DateTime($lastCreated->created_at);
            $currentDate = new DateTime(date('y.m.d'));
            $diff = $currentDate->diff($lastCreatedAt);
            $lastCreatedAt->add(new \DateInterval('P7D'));
            $test = $lastCreatedAt->diff($currentDate);

            if ($diff->d <= 7) {
                return redirect('/')->withFail('Przed napisaniem kolejnej aplikacji, musisz odczekać: ' . $test->format("%a dni, %h godzin, %i minut, %s sekund"));
            }
        }

        if($canCreate != null){
            return redirect('/')->withFail('Twoja aplikacja została już przyjęta. Nie możesz zrobić nowej aplikacji.');
        }


        return view('pages.user.composeTemp')->with('profilePicture', $profilePicture);
    }

    public function handleApplicationCreation()
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

        $data = Request::all();
        unset($data['_token']);

        $tempApp = new TempApplication($data);
        $tempApp->discord_id = $id;
        $tempApp->discord_username = $responseBody->username ."#".$responseBody->discriminator;
        $tempApp->discord_avatar = $profilePicture;
        $tempApp->state = 0;
        $tempApp->save();

        $client = new Client();
        $headers = [
            'headers' => [
                'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN')
            ]
        ];

        try
        {
            $response = $client->get('https://discordapp.com/api/v6/users/'.$tempApp->discord_id, $headers);
        }
        catch (ClientException $exception)
        {
            return abort(403);
        }


        $responseBody = json_decode($response->getBody()->getContents());
        $nick = $responseBody->username.'#'.$responseBody->discriminator;

        $webhook = "https://discord.com/api/webhooks/1069676054593155073/5QN5UWbjsxNaubYbGJ3GUn3vGOiHwEOKSpK0ZxUnzMrPtkzXvsmv9a_Cxxe8ASvlhLiU";
        $hookObject = json_encode([
            "username" => "InfinityRP.pl • System aplikacji",
            "avatar_url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png",
            "tts" => false,
            "embeds" => [
                [
                    "type" => "rich",
                    "description" => "",
                    "timestamp" => date('Y-m-d').'T'.date("H:i:s").'.'.date("v").'Z',
                    "color" => hexdec( "000000" ),
                    "footer" => [
                        "text" => "InfinityRP.pl • System aplikacji",
                    ],
                    "image" => [
                        "url" => ""
                    ],
                    "thumbnail" => [
                        "url" => ""
                    ],
                    "author" => [
                        "name" => $nick,
                        "icon_url" =>  $profilePicture
                    ],
                    "fields" => [
                        [
                            "name" => "Nowa aplikacja",
                            "value" => '[Kliknij, aby otworzyć podgląd...](https://aplikuj.infinityrp.pl/admin/'.$tempApp->id.')',
                        ],
                        [
                            "name" => "Status:",
                            "value" => "**W trakcie sprawdzania**",
                        ]
                    ]
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        $ch = curl_init( $webhook );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $hookObject);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );
        curl_close( $ch );

        return redirect('/')->withSuccess('Twoje podanie zostało wysłane!');
    }

    public function displayApplicationEdit($id){
        $client = new Client();
        $headers = [
            'headers' => [
                'Authorization' => 'Bearer ' . Cookie::get('token')
            ]
        ];

        try {
            $response = $client->get('https://discordapp.com/api/v6/users/@me', $headers);
        } catch (ClientException $exception) {
            return abort(403);
        }

        $responseBody = json_decode($response->getBody()->getContents());
        $profilePicture = 'https://cdn.discordapp.com/avatars/' . $responseBody->id . '/' . $responseBody->avatar . '.png';
        $application = TempApplication::where('id', $id)->get()->first();
        if($application->discord_id != $responseBody->id){
            return abort(403);
        }
        if ($application == null) {
            return abort(404);
        }

        if($application->state != 2){
            return redirect('/')->withFail('Nie możesz edytować tej aplikacji...');
        }

        return view('pages.user.edit')
            ->with('profilePicture', $profilePicture)
            ->with('application', $application);

    }

    public function handleApplicationEdit(){
        $data = Request::all();
        unset($data['_token']);
        $app = TempApplication::where('id', $data['id'])->first();
        $app->state = 0;
        $app->created_at = date('Y-m-d H:i:s');
        $app->update($data);
        $app->save();

        $client = new Client();
        $headers = [
            'headers' => [
                'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN')
            ]
        ];

        try
        {
            $response = $client->get('https://discordapp.com/api/v6/users/'.$app->discord_id, $headers);
        }
        catch (ClientException $exception)
        {
            return abort(403);
        }


        $responseBody = json_decode($response->getBody()->getContents());
        $nick = $responseBody->username.'#'.$responseBody->discriminator;
        $profilePicture = 'https://cdn.discordapp.com/avatars/' . $responseBody->id . '/' . $responseBody->avatar . '.png';

        $webhook = "https://discord.com/api/webhooks/1069676054593155073/5QN5UWbjsxNaubYbGJ3GUn3vGOiHwEOKSpK0ZxUnzMrPtkzXvsmv9a_Cxxe8ASvlhLiU";
        $hookObject = json_encode([
            "username" => "InfinityRP.pl • System aplikacji",
            "avatar_url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png",
            "tts" => false,
            "embeds" => [
                [
                    "type" => "rich",
                    "description" => "",
                    "timestamp" => date('Y-m-d').'T'.date("H:i:s").'.'.date("v").'Z',
                    "color" => hexdec( "000000" ),
                    "footer" => [
                        "text" => "InfinityRP.pl • System aplikacji",
                    ],
                    "image" => [
                        "url" => ""
                    ],
                    "thumbnail" => [
                        "url" => ""
                    ],
                    "author" => [
                        "name" => $nick,
                        "icon_url" =>  $profilePicture
                    ],
                    "fields" => [
                        [
                            "name" => "Poprawiona aplikacja",
                            "value" => '[Kliknij, aby otworzyć podgląd...](https://aplikuj.infinityrp.pl/admin/'.$app->id.')',
                        ],
                        [
                            "name" => "Status:",
                            "value" => "**W trakcie sprawdzania**",
                        ]
                    ]
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        $ch = curl_init( $webhook );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $hookObject);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );
        curl_close( $ch );

        return redirect('/')->withSuccess('Twoje podanie zostało zaktualizowane!');

    }
}
