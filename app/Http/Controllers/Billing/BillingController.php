<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Payment;
use App\TempApplication;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cookie;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use RestCord\DiscordClient;

class BillingController extends Controller
{
    public function handlePayment()
    {
        $data = request()->json()->all();
        $orderId = $data['orderId'];
        $appId = $data['appId'];

        if ($orderId === null || $appId === null) {
            return abort(500, "No order ID and/or application ID received.");
        }

        $ppClient = PayPalClient::client();
        $ppResponse = $ppClient->execute(new OrdersGetRequest($orderId));

        $dClient = new Client();
        $headers = [
            'headers' => [
                'Authorization' => 'Bearer ' . Cookie::get('token')
            ]
        ];

        try
        {
            $dResponse = $dClient->get('https://discordapp.com/api/v6/users/@me', $headers);
        }
        catch (ClientException $exception)
        {
            return abort(403);
        }

        $responseBody = json_decode($dResponse->getBody()->getContents());
        $id = $responseBody->id;

        $payment = new Payment();
        $payment->paypal_id = $ppResponse->result->id;
        $payment->discord_id = $id;
        $payment->full_name = $ppResponse->result->payer->name->given_name . ' ' . $ppResponse->result->payer->name->surname;
        $payment->email = $ppResponse->result->payer->email_address;
        $payment->ip = request()->ip();
        $payment->amount = $ppResponse->result->purchase_units[0]->amount->value;
        $payment->currency = $ppResponse->result->purchase_units[0]->amount->currency_code;

        $payment->save();

        $application = TempApplication::where('uuid', $appId)->get()->first();

        if ($ppResponse->result->purchase_units[0]->amount->value < 20.0) {
            $discord = new DiscordClient(['token' => env('DISCORD_BOT_TOKEN')]);
            $userDmChannel = $discord->user->createDm(array("recipient_id" => (int) $application->discord_id));
            $dmChannelId = $userDmChannel->id;

            $discord->channel->createMessage([
                'channel.id' => $dmChannelId,
                'file' => file_get_contents('x.png')
            ]);

            return redirect('/');
        }

        TempApplication::where('uuid', $appId)->update(['state' => 666]);
        $client = new Client();
        $headers = [
            'headers' => [
                'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN')
            ]
        ];
        try
        {
            $response = $client->get('https://discordapp.com/api/v6/users/'.$application->discord_id, $headers);
        }
        catch (ClientException $exception)
        {
            return abort(403);
        }
        $responseBody = json_decode($response->getBody()->getContents());
        $nick = $responseBody->username.'#'.$responseBody->discriminator;
        $profilePicture = 'https://cdn.discordapp.com/avatars/' . $responseBody->id . '/' . $responseBody->avatar . '.png';

        $webhook = "https://discord.com/api/webhooks/941097432845000757/D2bebhR6is1PrakrajXkgzVDpwEUPask0LvxC6v537WkscFBkwNE9sKjysSFa6C476Ga";
        $hookObject = json_encode([
            "username" => "InfinityRP.pl • System aplikacji",
            "avatar_url" => "https://cdn.discordapp.com/avatars/941097432845000757/18b2aeb9f26ac0b911abb9566006e13f.png",
            "tts" => false,
            'content' => '@everyone',
            "embeds" => [
                [
                    "type" => "rich",
                    "description" => "",
                    "timestamp" => date('Y-m-d').'T'.date("H:i:s").'.'.date("v").'Z',
                    "color" => hexdec( "FFFF00" ),
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
                            "value" => '[Kliknij, aby otworzyć podgląd...](https://aplikuj.infinityrp.pl/admin/'.$application->uuid.')',
                        ],
                        [
                            "name" => "Status:",
                            "value" => "**Priorytet**",
                        ],
                        [
                            "name" => "Kampania",
                            "value" => "InfinityRP.pl - Whitelist",
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
        dd($response);

        return redirect('/')->withSuccess('Twoja płatność przeszła pomyślnie! A twoje podanie zostało oznaczone jako Priorytetowe.');
    }
}
