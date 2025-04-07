<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\SsoConfig;
use App\Models\Student;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function sso_login()
    {
        $sso = SsoConfig::find(1);

        $query = http_build_query([
            'client_id'     => $sso->client_id,
            'client_secret' => $sso->client_secret,
            'redirect_uri'  => $sso->redirect_url,
            'response_type' => 'code',
            'scope'         => 'openid',
        ]);

        return redirect($sso->url . '/authorize?' . $query);
    }

    public function call_back(Request $request)
    {

	  $accessToken = $request->headers->get('Authorization');

        $sso = SsoConfig::find(1);
        $query = http_build_query([
            'status'  => 0,
            'message' => 'Not Registered'
        ]);
        try {
            $userinfo = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])
                ->post($sso->url . '/userinfo')
                ->json();
            if (Student::where('national_id', $userinfo['id_no'])->exists()) {
                $student = Student::where('national_id', $userinfo['id_no'])->first();
                $student->api_key = $accessToken;
                $student->update();

                $query = http_build_query($this->cryptoJSAesEncrypt('e1d822ae154bfb1c02e2f2f0f2bd26be3b91cde7', $accessToken));
		$url = 'https://stgacademy.momrah.gov.sa/open-id-connect?' . $query;
                return redirect($url);
            } else {
                return redirect('https://stgacademy.momrah.gov.sa/open-id-connect?' . $query);
            }

        } catch (\Throwable $th) {
            return redirect('https://stgacademy.momrah.gov.sa/open-id-connect?' . $query);
        }
    }

    public function cryptoJSAesEncrypt($passphrase, $plain_text)
    {
        $salt = openssl_random_pseudo_bytes(256);
        $iv = openssl_random_pseudo_bytes(16);
        $iterations = 999;
        $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);
        $encryptedData = openssl_encrypt($plain_text, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

        return ["access_token" => base64_encode($encryptedData), "iv" => bin2hex($iv), "salt" => bin2hex($salt), 'status' => 1];
    }

    public function my_profile()
    {
        try {
            $user = Student::find(Auth::user()->id);
            return Helper::Response(true, 'Get my profile', $user, false);
        } catch (\Throwable $th) {
            return Helper::Response(false, 'Something Wrong', [], $th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        if (!$token = $request->bearerToken()) {
            return response(['message' => 'unauthorized'], 401);
        }

        Student::where('api_key', $token)->update([
            'api_key' => null
        ]);
        return Helper::Response(true, 'Success');
    }

    public function updateType(Request $request){

        if (!isset($request->type) && empty($request->type)) {
            $validation_error[] = 'Student type must be required';
        }

        
        if ($request->type != 'balady' && $request->type != 'mumtahil') {
            $validation_error[] = 'The type only accept balady,mumtahil';
        }

        if (!empty($validation_error)) {
            return Helper::Response(false, 'Validation Error', [], $validation_error);
        }

        Auth::user()->update([
            'consumer_id' => $request->type
        ]);

        return Helper::Response(true, 'Type Update Successfully', [], false);
    }

}
