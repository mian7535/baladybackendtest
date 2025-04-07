<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{

    public static function Response($status, $message, $data = [], $error = false)
    {
        $userResponse['status'] = $status;
        $userResponse['message'] = $message;
        $userResponse['data'] = $data ?? [];
        $userResponse['error'] = $error;

        return response()->json($userResponse, 200);
    }

}
