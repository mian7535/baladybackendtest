<?php

namespace App\Services\Mumtathil;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class MumtatilService
{

    protected $token;

    public function __construct()
    {
        $this->token = Http::asForm()
            ->withHeaders([
                'Authorization' => 'Basic ' . base64_encode(config('service.mumtathil_user_name') . ":" . config('service.mumtathil_password'))
            ])
            ->withOptions([
                'verify' => true,
            ])
            ->post(config('service.mumtathil_base_url').'/oauth/v1/token', [
                'grant_type' => "client_credentials",
                'Username'   => config('service.mumtathil_user_name'),
                'Password'   => config('service.mumtathil_password'),
            ]);
    }


    public function pushResult($userDetail,$status)
    {
        $userinfo = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token['access_token']
        ])->post(config('service.mumtathil_base_url') . '/v1/cis-services/push-inspector-training-result', [
            'IDNumber'              => $userDetail['ID'],
            'BirthDate'             => str_replace('/','',$userDetail['DateOfBirthHijri']),
            'Email'                 => $userDetail['EmailID'],
            'MobileNumber'          => $userDetail['MobileNumber'],
            'BaladyAcademyResultID' => $status,
        ]);
        
        return $userinfo;
    }
}
