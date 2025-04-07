<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Certificate;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class TestController extends Controller
{

    public function pdf(Request $request)
    {
        if (!isset($request->user_id) && empty($request->user_id)) {
            return Helper::Response(false, 'Something Wrong', [], 'User ID Requried');
        }

        $user = Certificate::with('student')->where('student_id', $request->user_id)->first();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf', [
            'user' => $user
        ]);

        $pdf->setPaper('A4', 'landscape');
        return $pdf->download();
    }


    public function push_info(Request $request)
    {
        try {
            if($request->bearerToken() !== '7$nghxqbga_WTYrn=5p5j+RYcjMa?Kx_') {
                return response(['message' => 'unauthorized'],401);
            }
            $input = $request->all();
            $validation_error = array();
     
            if (empty($input['National_ID'])) {
                $validation_error_104['code'] = 'Err_104';
                $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            }

            if ($input['National_ID']) {

                if (strlen((string)$input['National_ID']) !== 10) {
                    $validation_error_101['code'] = 'Err_101';
                    $validation_error_101['name'] = 'عفواً ,المعلومات المدخلة غير صحيحة';

                }
                if (!is_numeric($input['National_ID'])) {
                    $validation_error_101['code'] = 'Err_101';
                    $validation_error_101['name'] = 'عفواً ,المعلومات المدخلة غير صحيحة';
                }

            }


            if (isset($input['National_ID']) || !empty($input['National_ID'])) {

                $user = Student::where('national_id', $input['National_ID'])
                ->where('consumer_id',$input['Consumer_ID'])            
                ->first();

                if (isset($user->id) || !empty($user->id)) {

                    $validation_error_105['code'] = 'Err_105';
                    $validation_error_105['name'] = 'عفواً , أنت مسجل مسبقاً';
                }

            }

            if (!isset($input['Consumer_ID']) || empty($input['Consumer_ID'])) {
                $validation_error_104['code'] = 'Err_104';
                $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            }

            if ($input['Consumer_ID']) {

                if ($input['Consumer_ID'] !== "balady" && $input['Consumer_ID'] !== "mumtathil"){
                    $validation_error_101['code'] = 'Err_101';
                    $validation_error_101['name'] = 'عفواً ,المعلومات المدخلة غير صحيحةID';
                }
            }

            if (!isset($input['DateOfBirth']) || empty($input['DateOfBirth'])) {
                $validation_error_104['code'] = 'Err_104';
                $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            }


            if (!isset($input['Gender']) || empty($input['Gender'])) {
                $validation_error_104['code'] = 'Err_104';
                $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            }

            if (!isset($input['Email']) || empty($input['Email'])) {
                $validation_error_104['code'] = 'Err_104';
                $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            }

            if (!isset($input['Mobile_Number']) || empty($input['Mobile_Number'])) {
                $validation_error_104['code'] = 'Err_104';
                $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            }

            // if (!isset($input['Municipality']) || empty($input['Municipality'])) {
            //     $validation_error_104['code'] = 'Err_104';
            //     $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            // }

            // if (!isset($input['Sub_Municipality']) || empty($input['Sub_Municipality'])) {
            //     $validation_error_104['code'] = 'Err_104';
            //     $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            // }


            if (!isset($input['Observation_Type']) || empty($input['Observation_Type'])) {
                $validation_error_104['code'] = 'Err_104';
                $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            }

            if (!isset($input['Bank_Name']) || empty($input['Bank_Name'])) {
                $validation_error_104['code'] = 'Err_104';
                $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            }


            if (!isset($input['IBAN']) || empty($input['IBAN'])) {
                $validation_error_104['code'] = 'Err_104';
                $validation_error_104['name'] = 'عفواً، يلزم استكمال جميع الحقول الإجبارية.';
            }


            if (isset($input['IBAN']) || !empty($input['IBAN'])) {
                $check_word = substr($input['IBAN'], 0, 2);
                if ($check_word !== "sa" || $check_word !== "Sa") {
                    $validation_error_102['code'] = 'Err_102';
                    $validation_error_102['name'] = 'صيغة الآيبان غير سليمة.';
                }

            }

            if (isset($input['IBAN']) || !empty($input['IBAN'])) {
                if (strlen((string)$input['IBAN']) !== 24) {
                    $validation_error_102['code'] = 'Err_102';
                    $validation_error_102['name'] = 'صيغة الآيبان غير سليمة.';

                }
            }

            if (!empty($validation_error_101)) {
                $error_response[] = $validation_error_101;
            }


            if (!empty($validation_error_104)) {
                $error_response[] = $validation_error_104;
            }


            if (!empty($validation_error_102)) {
                $error_response[] = $validation_error_102;
            }


            if (!empty($validation_error_105)) {
                $error_response[] = $validation_error_105;
            }


            if (!empty($error_response)) {

                $userResponse['status'] = false;
                $userResponse['message'] = 'validation_error';
                $userResponse['data'] = [];
                $userResponse['error'] = $error_response;
                return response()->json($userResponse, 400);

            }

            $table = new Student();
            $table->national_id = $input['National_ID'];
            $table->consumer_id = $input['Consumer_ID'];
            $table->date_of_birth = date('Y/m/d', strtotime($input['DateOfBirth']));
            $table->email = $input['Email'];
            $table->first_name = $input['First_Name'];
            $table->father_name = $input['Father_Name'];
            $table->third_name = $input['Third_Name'];
            $table->family_name = $input['Family_Name'];
            $table->gender = $input['Gender'];
            $table->mobile_number = $input['Mobile_Number'];
            $table->municipality = $input['Municipality'];
            $table->sub_municipality = $input['Sub_Municipality'];
            $table->observation_type = $input['Observation_Type'];
            $table->bank_name = $input['Bank_Name'];
            $table->iban = $input['IBAN'];
            $table->save();

            return Helper::Response(true, 'Save your Info Succussfully', $table, false);
        } catch (\Throwable $th) {
            return Helper::Response(false, 'Something Wrong', [], $th->getMessage());
        }

    }

    public function get_Enquiry(Request $request)
    {
        if (!isset($request->identityNumber) || empty($request->identityNumber)) {

            return Helper::Response(false, 'Something Wrong', [], 'identityNumber Requried');
        }

        try {

            $get_result = Student::where('identityNumber', $request->identityNumber)->first();

            return Helper::Response(true, 'Get Certificate', $get_result, false);

        } catch (\Throwable $th) {

            return Helper::Response(false, 'Something Wrong', [], $th->getMessage());

        }
    }

}
