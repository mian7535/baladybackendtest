<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Certificate;
use Auth;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class CertificateController extends Controller
{

    public function get_certificate(Request $request)
    {

        $certificate = Certificate::with('student')->where('student_id', Auth::user()->id)->first();

        if (empty($certificate) && $certificate = "") {

            return Helper::Response(true, 'not certificate found', [], 'not certificate found');

        }

        return Helper::Response(true, 'Certificate Generated Succussfully', $certificate, false);


    }


    public function pdf(Request $request)
    {
        if (!isset($request->user_id) && empty($request->user_id)) {
            return Helper::Response(false, 'Validation Error', [], 'User ID Is Required');
        }

        $user = Certificate::with('student')->where('student_id', $request->user_id)->first();

        $lang = 'ar';

        $html = view("{$lang}_pdf", [
            'user' => $user
        ])->render();

        $path = storage_path("app/{$user->id}_{$lang}_certificate.pdf");
        Browsershot::html($html)
            // ->setNodeBinary('C:\\Program Files\\nodejs\\node.exe')
            // ->setNpmBinary('C:\\Program Files\\nodejs\\npm.cmd')
            ->setNodeBinary('/usr/bin/node')
            ->setNpmBinary('/usr/bin/npm')
            ->showBackground()
            ->landscape()
            ->save($path);

        $type = 'application/pdf';
        $headers = ['Content-Type' => $type];

        return response()->download($path, 'certificate.pdf', $headers);
    }

    public function viewCertificate(Request $request)
    {
        $user = Certificate::with('student')->where('student_id', $request->user_id)->first();

        $this->certificatePrintText($user);

    }

    public function certificatePrintText($user)
    {

        header("Content-type: image/png");

        $font = realpath('pdf_asset/fonts/FrutigerLTArabic45Light.ttf');
        $image = imagecreatefrompng(('pdf_asset/images/certificate_demo.png'));
        $color = imagecolorallocate($image, 0, 0, 0);
        $obj = new \ArPHP\I18N\Arabic('Glyphs');
        imagettftext($image, 60, 0, 1500, 1250, $color, $font, $obj->utf8Glyphs($user['student']['first_name']));
        imagejpeg($image);
        imagedestroy($image);

    }

}
