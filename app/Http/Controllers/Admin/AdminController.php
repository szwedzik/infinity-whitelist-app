<?php

namespace App\Http\Controllers\Admin;

use App\Campaign;
use App\Http\API\DayZAPI;
use App\Http\Controllers\Controller;
use App\ReturnedLogs;
use App\TempApplication;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use App\Classes\SteamAPI;
use RestCord\DiscordClient;
use Datetime;

class AdminController extends Controller {

    public function displayCampaignAddition() {
        return view('pages.admin.createCampaign');
    }

    public function handleCampaignAddition() {
        $data = Request::all();
        unset($data['_token']);

        $campaign = new Campaign($data);
        $campaign->form = 's';
        $campaign->save();
    }


    public function displayTempApplications() {
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

        $priorityApps = TempApplication::where('state', '666')->orderBy('created_at', 'asc')->get();
        $applications = TempApplication::where('state', '0')->orderBy('created_at', 'asc')->get();

        $toCheck = TempApplication::where('state', '=', '0')->orWhere('state', '666')->count();
        $accepted = TempApplication::where('state', '3')->count();
        $rejected = TempApplication::where('state', '1')->count();
        $returned = TempApplication::where('state', '2')->count();


        return view('pages.admin.browse')
            ->with('profilePicture', $profilePicture)
            ->with('priorityApps', $priorityApps)
            ->with('applications', $applications)
            ->with('toCheck', $toCheck)
            ->with('accepted', $accepted)
            ->with('rejected', $rejected)
            ->with('returned', $returned);
    }

    public function displayAcceptedApplications() {
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

        $applications = TempApplication::where('state', '3')->orderBy('created_at', 'desc')->get();

        $toCheck = TempApplication::where('state', '0')->count();
        $accepted = TempApplication::where('state', '3')->count();
        $rejected = TempApplication::where('state', '1')->count();
        $returned = TempApplication::where('state', '2')->count();

        return view('pages.admin.accepted')
            ->with('profilePicture', $profilePicture)
            ->with('applications', $applications)
            ->with('toCheck', $toCheck)
            ->with('accepted', $accepted)
            ->with('rejected', $rejected)
            ->with('returned', $returned);
    }

    public function displayRejectedApplications() {
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

        $applications = TempApplication::where('state', '1')->orderBy('created_at', 'desc')->get();

        $toCheck = TempApplication::where('state', '0')->count();
        $accepted = TempApplication::where('state', '3')->count();
        $rejected = TempApplication::where('state', '1')->count();
        $returned = TempApplication::where('state', '2')->count();

        return view('pages.admin.rejected')
            ->with('profilePicture', $profilePicture)
            ->with('applications', $applications)
            ->with('toCheck', $toCheck)
            ->with('accepted', $accepted)
            ->with('rejected', $rejected)
            ->with('returned', $returned);
    }

    public function displayReturnedApplications() {
        $client = new Client();
        $headers = [
            'headers' => [
                'Authorization' => 'Bearer ' . Cookie::get('token')
            ]
        ];

        try {
            $response = $client->get('https://discordapp.com/api/v6/users/@me', $headers);
        }
        catch (ClientException $exception) {
            return abort(403);
        }

        $responseBody = json_decode($response->getBody()->getContents());
        $profilePicture = 'https://cdn.discordapp.com/avatars/' . $responseBody->id . '/' . $responseBody->avatar . '.png';

        $applications = TempApplication::where('state', '2')->orderBy('created_at', 'desc')->paginate(10);

        $toCheck = TempApplication::where('state', '0')->count();
        $accepted = TempApplication::where('state', '3')->count();
        $rejected = TempApplication::where('state', '1')->count();
        $returned = TempApplication::where('state', '2')->count();

        return view('pages.admin.returned')
            ->with('profilePicture', $profilePicture)
            ->with('applications', $applications)
            ->with('toCheck', $toCheck)
            ->with('accepted', $accepted)
            ->with('rejected', $rejected)
            ->with('returned', $returned);
    }

    public function displayTempApplicationInfo($uuid) {
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

        $application = TempApplication::where('id', $uuid)->get()->first();
        $appage = new DateTime($application->age);
        $currentDate = new DateTime(date('y.m.d'));
        $diff = $currentDate->diff($appage);
        $age = $diff->y;

        if ($application == null) {
            return abort(404);
        }

        return view('pages.admin.details')
            ->with('profilePicture', $profilePicture)
            ->with('application', $application)
            ->with('age', $age);
    }

    public function actOnTempApplication($uuid, $action) {
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

        if ($action == 'accept') {
            TempApplication::where('id', $uuid)->update(['state' => 3, 'admin' => $responseBody->username ."#".$responseBody->discriminator]);
            $application = TempApplication::where('id', $uuid)->get()->first();
            $headers = [
                'headers' => [
                    'Authorization' => 'Bot ' . 
                ]
            ];

            try {
                $client->get('https://discordapp.com/api/v6/guilds/720328695608377405/members/'.$application->discord_id, $headers, ['http_errors' => false]);
            }
            catch (ClientException $e) {
                $response = $e->getResponse();
            }
            if(!isset($response)) {
                $resp = 0;
            } else {
                $resp = $response->getStatusCode();
            }

            try {
                $client->get('https://discordapp.com/api/v6/guilds/720328695608377405/members/'.$application->discord_id, $headers, ['http_errors' => false]);
            } catch (ClientException $e) {
                $e->getResponse();
            }

            // to do: Implemet server API that adds the user to whitelist
            $added = (new \App\Http\API\DayZAPI)->whiteList($application->steam_url, $application->discord_id, $responseBody->username ."#".$responseBody->discriminator);
            if(!$added){
                return view('errors.custom')->with('code', 'Błąd.')->with('message', 'Wystąpił błąd podczas dodawania na whitelistę. (Albo osoba jest już dodana, albo wystąpił błąd podczas dodawania.)');;
            }

            $client->put('https://discordapp.com/api/v6/guilds/720328695608377405/members/'.$application->discord_id.'/roles/1060538287623770112', $headers);
            if($resp != 404){
                $bot = new DiscordClient(['token' => env('DISCORD_BOT_TOKEN')]);
                $dm = $bot->user->createDm(array("recipient_id" => intval($application->discord_id)));
                $cid = $dm->id;
                try {
                    $bot->channel->createMessage([
                        'channel.id' => $cid,
                        'embed'      => [
                            "description" => "Witaj, <@".$application->discord_id.">! \n\n Z przyjemnością informujemy ze twoja aplikacja została rozpatrzona pozytywnie!",
                            "color" => 4849408,
                            "timestamp" => date('Y-m-d').'T'.date("H:i:s").'.'.date("v").'Z',
                            "footer" => [
                                "icon_url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png",
                                "text" => "InfinityRP.pl • System aplikacji"
                            ],
                            "thumbnail" => [
                                "url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png"
                            ],
                            "author" => [
                                "name" => "InfinityRP.pl • System aplikacji",
                                "url" => "https://aplikuj.infinityrp.pl",
                                "icon_url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png"
                            ],
                            "fields" => [
                                [
                                    "name" => "Status:",
                                    "value" => "**Przyjęte**"
                                ],
                                [
                                    "name" => "**Informacje**",
                                    "value" => "Twoje podanie zostało rozpatrzone **pozytywnie**! Więc wkrótce zobaczymy się na serwerze. \nRangi oraz dostęp do serwera zostanie przyznany do 15 minut od otrzymania tej wiadomości."
                                ],
                                [
                                    "name" => "O czym warto pamiętać?",
                                    "value" => "Jeśli po upływie 15 minut od otrzymania tej wiadomości nie będziesz wstanie połączyć się z serwerem nie pisz do **Administracji** wiadomości w stylu **'Nie mogę połączyć się z serwerem'** tylko zgłoś to nam po przez ticket do odpowiedniego działu na forum. Zalecamy zapoznać się z wszelkimi poradnikami oraz [regulaminem](https://forum.infinityrp.pl/topic/6-regulamin-serwera-roleplay-infinityrppl) serwera. Do zobaczenia na serwerze powodzenia! \n\nZ poważaniem, \nZespół **InfinityRP.pl**"
                                ]
                            ]
                        ]
                    ]);
                    sleep(1);
                }
                catch(\Exception $e) {
                    $e->getResponse();
                }
            }
            return redirect('/admin');
        }
    }

    public function actOnTempApplicationDenyReturn($action){
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
        $data = Request::all();

        if($action == 'return') {
            TempApplication::where('id', $data['id'])->update(['state' => 2, 'admin' => $responseBody->username ."#".$responseBody->discriminator]);
            $application = TempApplication::where('id', $data['id'])->get()->first();
            $log = new ReturnedLogs();
            $log->app_uuid = $application->id;
            $log->reason = $data['reason'];
            $log->admin = $responseBody->username ."#".$responseBody->discriminator;
            $log->action = 'returned';
            $log->save();

            $headers = [
                'headers' => [
                    'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN')
                ]
            ];
            try {
                $client->get('https://discordapp.com/api/v6/guilds/720328695608377405/members/'.$application->discord_id, $headers, ['http_errors' => false]);
            } catch (ClientException $e) {
                $response = $e->getResponse();
            }

            if(!isset($response)) {
                $resp = 0;
            } else {
                $resp = $response->getStatusCode();
            }
            try {
                $client->get('https://discordapp.com/api/v6/guilds/720328695608377405/members/'.$application->discord_id, $headers, ['http_errors' => false]);
            } catch (ClientException $e) {
                $response = $e->getResponse();
            }

            if(!isset($response)) {
                $resp = 0;
            } else {
                $resp = $response->getStatusCode();
            }

            if($resp != 404) {
                $bot = new DiscordClient(['token' => env('DISCORD_BOT_TOKEN')]);
                $dm = $bot->user->createDm(array("recipient_id" => intval($application->discord_id)));
                $cid = $dm->id;
                try {
                    $bot->channel->createMessage([
                        'channel.id' => $cid,
                        'embed' => [
                            "description" => "Witaj, <@" . $application->discord_id . ">! \n\n Twoje podanie nie spełniło naszych oczekiwań, ale to jeszcze nie koniec! Masz okazję je poprawić.",
                            "color" => 15183119,
                            "timestamp" => date('Y-m-d') . 'T' . date("H:i:s") . '.' . date("v") . 'Z',
                            "footer" => [
                                "icon_url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png",
                                "text" => "InfinityRP.pl • System aplikacji"
                            ],
                            "thumbnail" => [
                                "url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png"
                            ],
                            "author" => [
                                "name" => "InfinityRP.pl • System aplikacji",
                                "url" => "https://aplikuj.infinityrp.pl",
                                "icon_url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png"
                            ],
                            "fields" => [
                                [
                                    "name" => "Status:",
                                    "value" => "**Zwrócone do poprawy**"
                                ],
                                [
                                    "name" => "Nasze uwagi",
                                    "value" => $data['reason'] . "\n\nZ poważaniem, \n Zespół **InfinityRP.pl**"
                                ]
                            ]
                        ]
                    ]);
                    sleep(1);
                } catch (Exception $e) {
                    $e->getResponse();
                }
            }
            return redirect('/admin');
        } else {
            TempApplication::where('id', $data['id'])->update(['state' => 1, 'admin' => $responseBody->username ."#".$responseBody->discriminator]);
            $application = TempApplication::where('id', $data['id'])->get()->first();
            $log = new ReturnedLogs();
            $log->app_uuid = $application->id;
            $log->reason = $data['reason'];
            $log->admin = $responseBody->username ."#".$responseBody->discriminator;
            $log->action = 'denied';
            $log->save();
            $headers = [
                'headers' => [
                    'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN')
                ]
            ];
            try {
                $client->get('https://discordapp.com/api/v6/guilds/720328695608377405/members/'.$application->discord_id, $headers, ['http_errors' => false]);
            } catch (ClientException $e) {
                $response = $e->getResponse();
            }

            if(!isset($response)) {
                $resp = 0;
            } else {
                $resp = $response->getStatusCode();
            }
            try {
                $client->get('https://discordapp.com/api/v6/guilds/720328695608377405/members/'.$application->discord_id, $headers, ['http_errors' => false]);
            } catch (ClientException $e) {
                $response = $e->getResponse();
            }

            if(!isset($response)) {
                $resp = 0;
            } else {
                $resp = $response->getStatusCode();
            }

            if($resp != 404){
                $bot = new DiscordClient(['token' => env('DISCORD_BOT_TOKEN')]);
                $dm = $bot->user->createDm(array("recipient_id" => intval($application->discord_id)));
                $cid = $dm->id;
                try {
                    $bot->channel->createMessage([
                        'channel.id' => $cid,
                        'embed'      => [
                            "description" => "Witaj, <@".$application->discord_id.">! \n\n Z przykrością informujemy że twoje podanie zostąło rozpatrzone negatywnie.",
                            "color" => 16711680,
                            "timestamp" => date('Y-m-d').'T'.date("H:i:s").'.'.date("v").'Z',
                            "footer" => [
                                "icon_url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png",
                                "text" => "InfinityRP.pl • System aplikacji"
                            ],
                            "thumbnail" => [
                                "url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png"
                            ],
                            "author" => [
                                "name" => "InfinityRP.pl • System aplikacji",
                                "url" => "https://aplikuj.infinityrp.pl",
                                "icon_url" => "https://cdn.discordapp.com/avatars/631951598360199188/82792e1cb090e8726a625339976ec647.png"
                            ],
                            "fields" => [
                                [
                                    "name" => "Status:",
                                    "value" => "**Odrzucone**"
                                ],
                                [
                                    "name" => "Powód:",
                                    "value" => $data['reason']
                                ],
                                [
                                    "name" => "O czym warto pamiętać?",
                                    "value" => "Po otrzymaniu tej wiadomości pamiętaj aby nie pisać do **Administracji** z pytaniami ponieważ otrzymałeś powód odrzucenia twojej aplikacji, tylko odczekaj 7 dni i złóż kolejne podanie a może wkrótce zobaczymy się na serwerze powodzenia! \n\n Z poważaniem, \n Zespół **InfinityRP.pl**"
                                ]
                            ]
                        ]
                    ]);
                    sleep(1);
                } catch(Exception $e) {
                    $e->getResponse();
                }
            }
            return redirect('/admin');
        }
    }
}
