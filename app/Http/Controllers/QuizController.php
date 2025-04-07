<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Answar;
use App\Models\Certificate;
use App\Models\CourseComplete;
use App\Models\CrmConfiguration;
use App\Models\ExamSchedule;
use App\Models\LessonComplete;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\UserAttemp;
use Auth;
use App\Services\Mumtathil\MumtatilService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class QuizController extends Controller
{

    public function index(Request $request)
    {
        try {

            if (Certificate::where('student_id', Auth::user()->id)->exists()) {

                return Helper::Response(true, 'you are pass', [], false);
            }

            if (ExamSchedule::where('student_id', Auth::user()->id)->exists()) {
                $quizzes = Quiz::with(['questions' => function ($q) {
                    $q->where('type', Auth::user()->consumer_id)
                        ->with('options');
                }])->get();

                return Helper::Response(true, 'Get All Exams Data', $quizzes, false);
            } else {
                return Helper::Response(false, 'يجب ان تكمل جميع الدورات التدريبية لتتمكن من اجراء الاختبار', [], true);
            }
        } catch (\Throwable $th) {

            return Helper::Response(false, 'Something Wrong', [], $th->getMessage());
        }
    }


    public function questions(Request $request)
    {

        if (!isset($request->exam_id) || empty($request->exam_id)) {
            return Helper::Response(false, 'Something Wrong', [], 'Exam ID Requried');
        }

        try {

            $quizzes = Quiz::with(['questions' => function ($q) {
                $q->where('type', Auth::user()->consumer_id)->with('options');
            }])->first();

            return Helper::Response(true, 'Get All Exams Data', $quizzes, false);
        } catch (\Throwable $th) {
            return Helper::Response(false, 'Something Wrong', [], $th->getMessage());
        }
    }


    public function check_result(Request $request,MumtatilService $mumtatilService)
    {
        
        try {

            if (ExamSchedule::where('student_id', Auth::user()->id)->exists()) {

                foreach ($request->question as $question) {
                    foreach ($request->answar as $key => $answar) {
                        if ($key == $question) {
                            $correct_answars[] = Answar::where('question_id', $question)
                                ->where('id', $answar)
                                ->where('correct', 1)->first();
                        }
                    }
                }

                $myanswars = count($request->answar);
                $right_anwars = count(array_filter($correct_answars));
                $percentage = ($right_anwars / $myanswars) * 100;

                \Log::info($percentage);
                exit();

                if (80 <= $percentage) {

                    $status = "Your Are Pass";
                    $ar_status = "أنت تمر";
                    $ur_status = "آپ پاس ہیں۔";
                    
                    if(Auth::user()->consumer_id == 'balady'){
                        $userinfo = $this->baladyPushResult(1);
                    }else{
                        $userinfo = $this->mumtathilPushResult(1,$mumtatilService);
                    }
                    $certificate = new Certificate();
                    $certificate->student_id = Auth::user()->id;
                    $certificate->total_questions = $myanswars;
                    $certificate->total_answers = $right_anwars;
                    $certificate->percentage = $percentage;
                    $certificate->result = $status;
                    $certificate->ar_result = $ar_status;
                    $certificate->ur_result = $ur_status;
                    $certificate->issue_date = Carbon::now()->format('Y-m-d');
                    $certificate->crm_response_code =
                    (Auth::user()->consumer_id == 'balady')
                    ? $userinfo['statusDetails'][0]['code']
                    : $userinfo['statusDetails']['code'];
             $certificate->crm_response_message = $userinfo['data']['responseMessage'];
                    $certificate->status = "pass";
                    $certificate->save();
                } else {

                    $status = "Your Are Fail";
                    $ar_status = "أنت تفشل";
                    $ur_status = "آپ ناکام ہیں۔";

                    if (UserAttemp::where('student_id', Auth::user()->id)->count() == 0) {
                        $userAttempt = new UserAttemp();
                        $userAttempt->student_id = Auth::user()->id;
                        $userAttempt->status = "fail";
                        $userAttempt->attemp_step = 1;
                        $userAttempt->save();
                        LessonComplete::where('student_id', Auth::user()->id)->delete();
                        CourseComplete::where('student_id', Auth::user()->id)->delete();
                        ExamSchedule::where('student_id', Auth::user()->id)->delete();
                    } elseif (UserAttemp::where('student_id', Auth::user()->id)->count() == 1) {

                        $userAttempt = new UserAttemp();
                        $userAttempt->student_id = Auth::user()->id;
                        $userAttempt->status = "fail";
                        $userAttempt->attemp_step = 2;
                        $userAttempt->save();

                        LessonComplete::where('student_id', Auth::user()->id)->delete();
                        CourseComplete::where('student_id', Auth::user()->id)->delete();
                        ExamSchedule::where('student_id', Auth::user()->id)->delete();
                    } elseif (UserAttemp::where('student_id', Auth::user()->id)->count() == 2) {


                        
                    if(Auth::user()->consumer_id == 'balady'){
                        $userinfo = $this->baladyPushResult(1);
                    }else{
                        $userinfo = $this->mumtathilPushResult(0,$mumtatilService);
                    }

                        $certificate = new Certificate();
                        $certificate->student_id = Auth::user()->id;
                        $certificate->total_questions = $myanswars;
                        $certificate->total_answers = $right_anwars;
                        $certificate->percentage = $percentage;
                        $certificate->result = $status;
                        $certificate->ar_result = $ar_status;
                        $certificate->ur_result = $ur_status;
                        $certificate->issue_date = Carbon::now()->format('Y-m-d');
                        $certificate->status = "fail";
                        $certificate->save();

                        $userAttempt = new UserAttemp();
                        $userAttempt->student_id = Auth::user()->id;
                        $userAttempt->status = "fail";
                        $userAttempt->attemp_step = 3;
                        $userAttempt->save();

                        LessonComplete::where('student_id', Auth::user()->id)->delete();
                        CourseComplete::where('student_id', Auth::user()->id)->delete();
                        ExamSchedule::where('student_id', Auth::user()->id)->delete();

                        $user = Student::find(Auth::user()->id);
                        $user->is_lock = 1;
                        $user->update();
                    }
                }
                
                $data = [
                    'total questions' => $myanswars,
                    'percentage'      => $percentage . '%',
                    'right answars'   => $right_anwars,
                    'result'          => $status,
                    'attempt'         => $userAttempt ?? [],
                ];

                return Helper::Response(true, 'Result Get Successfully', $data, false);
            } else {
                return Helper::Response(false, 'Please Complete All Courses', [], true);
            }
        } catch (\Throwable $th) {

            return Helper::Response(false, 'Something Wrong', [], $th->getMessage());
        }
    }

    public function mumtathilPushResult($status,$mumtatilService)
    {
        $userDetail = $this->StudentDetail($status);

        return $mumtatilService->pushResult($userDetail, $status);
    }


    public function baladyPushResult($status)
    {
        $crm_config = CrmConfiguration::find(1);

        $response = Http::asForm()
            ->withHeaders([
                'Authorization' => 'Basic ' . base64_encode($crm_config->user_name . ":" . $crm_config->password)
            ])
            ->withOptions([
                'verify' => true,
            ])->post($crm_config->url . '/oauth/v1/token', [
                'grant_type' => $crm_config->grant_type,
                'Username'   => $crm_config->user_name,
                'Password'   => $crm_config->password,
            ]);


            $userDetail = $this->StudentDetail($status);



        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $response->json()['access_token']
        ])->post($crm_config->url . '/v1/social-inspectors/crm/user-creation', [
            'CustomerInformation' => $userDetail,
        ]);
    }


    public function StudentDetail($status){
        $student_info = Student::find(Auth::user()->id);

        return [
            'ID'                    => $student_info->national_id,
            'EmailID'               => $student_info->email,
            'MobileNumber'          => $student_info->mobile_number,
            'DateOfBirthHijri'      => $student_info->date_of_birth,
            'MunicipalityID'        => $student_info->municipality,
            'SubMunicipalityID'     => $student_info->sub_municipality ?? "",
            'Sub_SubMunicipalityID' => "",
            'IBANNumber'            => $student_info->iban ?? "",
            'BankName'              => $student_info->bank_name ?? "",
            'BaladyacademyresultID' => $status,
        ];
    }
}
