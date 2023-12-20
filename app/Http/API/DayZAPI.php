<?php

namespace App\Http\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DayZAPI {
    private function apiURL(){
        return 'https://data.cftools.cloud';
    }

    public function authenticate(){
        $url = $this->apiURL() . '/v1/auth/register';
        $data = [
            'application_id' => env('CFTOOLS_APP_ID'),
            'secret' => env('CFTOOLS_APP_SECRET')
        ];

        $client = new Client();
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $data
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result['token'];
    }

    public function checkCFID($steamid){
        $url = $this->apiURL() . '/v1/users/lookup';
        $token = $this->authenticate();

        try {
            $client = new Client();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer '. $token,
                ],
                'query' => [
                    'identifier' => $steamid
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['cftools_id'];
        } catch (\Exception){
            return false;
        }

    }

    /**
     * @throws GuzzleException
     */
    public function whitelist($steamid, $discordID, $admin){
        $cfid = $this->checkCFID($steamid);
        if(!$cfid){
            return;
        }
        $url = $this->apiURL() . '/v1/server/ee899f9e-7bb8-4c88-85a0-0db1cc6ae985/whitelist';
        $token = $this->authenticate();

        $client = new Client();

        $request = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer '. $token,
            ],
            'json' => [
                'cftools_id' => $cfid,
                'comment' => 'System Aplikacji Whitelist. Discord ID: ' . $discordID . '. Dodany przez: ' . $admin
            ]
        ]);

        if($request->getStatusCode() == 204){
            return true;
        } else {
            return false;
        }
    }

    public function checkWhitelist($cfid){
        $url = $this->apiURL() . '/v1/server/ee899f9e-7bb8-4c88-85a0-0db1cc6ae985/whitelist?cftools_id=' . $cfid;
        $token = $this->authenticate();

        $client = new Client();
        $request = $client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer '. $token,
            ]
        ]);

        $result = json_decode($request->getBody()->getContents(), true);
        if(!empty($result['entries'])){
            return true;
        } else {
            return false;
        }
    }

    public function isBaned($steam){
        $url = $this->apiURL() . '/v1/banlist/6390e8640828de617b229f8d/bans';
        $token = $this->authenticate();
        $cfid = $this->checkCFID($steam);

        if(!$cfid){
            return false;
        }

        $client = new Client();
        $request = $client ->get($url, [
           'headers' => [
               'Authorization' => 'Bearer '. $token,
           ]
        ]);

        $result = json_decode($request->getBody()->getContents(), true);

        foreach($result['entries'] as $entry){
            if($entry['identifier'] == $cfid){
                if($entry['status'] == "Ban.ACTIVE"){
                    $timeRemaining = "";
                    if($entry['expires_at'] == null){
                        $timeRemaining = "Nigdy";
                    } else {
                        $date = new \DateTime($entry['expires_at']);
                        $now = new \DateTime();
                        if($date > $now){
                            $timeRemaining = $date->diff($now)->format("%a dni, %h godzin, %i minut");
                        }
                    }
                    return json_decode(json_encode([
                        'status' => true,
                        'reason' => $entry['reason'],
                        'timeRemaining' => $timeRemaining
                    ]));
                }
            }
        }
    }
}
