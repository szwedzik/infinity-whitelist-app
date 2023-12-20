<?php

namespace App\Http\Controllers\Application;

use App\Campaign;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Request;

class ApplicationController extends Controller
{
    public function create()
    {
        $data = Request::all();
        unset($data['_token']);

        $campaign = new Campaign($data);
        $campaign->save();
    }
}
