<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\CourseComplete;
use App\Models\ExamSchedule;
use Carbon\Carbon;
use DB;
use Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses =  Course::query()
            ->where('type', Auth::user()->consumer_id)
            ->where('status', 'active')
            ->with(['CourseComplete' => function ($courseComp) use ($request) {
                $courseComp->where('student_id', Auth::user()->id);
            }])->with('media')->with(['sections' => function ($q) use ($request) {
                $q->with(['lessons' => function ($lessonq) use ($request) {

                    $lessonq->with(['LessonComplete' => function ($LessonComplete) use ($request) {

                        $LessonComplete->where('student_id', Auth::user()->id);
                    }]);
                }]);
            }])->with(['CourseQuestions' => function ($courseQuestion) {

                $courseQuestion->with('QuestionOptions');
            }])->when(request('filter') == 'asc', function ($query) {

                $query->orderby('created_at', 'asc');
            })->when(request('filter') == 'desc', function ($query) {
                $query->orderby('created_at', 'desc');
            })->when(request('filterName') == 'asc', function ($query) {
                $query->orderBy('title');
            })->when(request('filterName') == 'desc', function ($query) {
                $query->orderByDesc('title');
            })->get();

        return Helper::Response(true, 'Get All Courses.', $courses, false);
    }


    public function checkProgress()
    {
        $courseCount = Course::query()->where('status', 'active')->whereDoesntHave('CourseComplete', function ($query) {
            return $query->where('student_id', auth()->id());
        })->count();
        return [
            'courseCount' => $courseCount,
        ];
    }


    public function courseGet(Request $request)
    {
        if (empty($request->course_id) && $request->course_id = "") {
            return Helper::Response(false, 'Something Wrong', [], 'Course ID Requried');
        }

        try {
            $query =  Course::where('status', 'Active')
                ->with('media')
                ->where('id', $request->course_id)->with(['sections' => function ($q) {
                $q->with(['lessons' => function ($lessonq) {
                    $lessonq->with(['images','LessonComplete' => function ($lessoncomplete) {
                        $lessoncomplete->select('is_completed');
                    }]);
                }]);
            }]);

            if (CourseComplete::where('course_id', $request->course_id)->where('student_id', Auth::user()->id)->exists()) {
                $query->with(['CourseQuestions' => function ($courseQuestion) {
                    $courseQuestion->with('QuestionOptions');
                }]);
            }

            $course = $query->first();

            return Helper::Response(true, 'Single Course Get.', $course, false);
        } catch (\Throwable $th) {
            return Helper::Response(false, 'Something Wrong', [], $th->getMessage());
        }
    }




    public function CourseComplete(Request $request)
    {

        if (!isset($request->course_id) && empty($request->course_id)) {
            $validation_error[] = 'Course ID Is Required';
        }

        if (!empty($validation_error)) {
            return Helper::Response(false, 'Validation Error', [], $validation_error);
        }

        if (CourseComplete::where('course_id', $request->course_id)->where('student_id', Auth::user()->id)->exists()) {

            return Helper::Response(false, 'data already exist', [], true);
        }

        $table = new CourseComplete();
        $table->student_id = Auth::user()->id;
        $table->course_id = $request->course_id;
        $table->is_completed = $request->is_completed;
        $table->save();

        if (
                CourseComplete::where('student_id', Auth::user()->id)->whereHas(
                    'course',fn($q) => $q->where('type',Auth::user()->consumer_id))->count() 
                    == 
                Course::query()->where('type',Auth::user()->consumer_id)->count()
            ){

            $examschedule = new ExamSchedule();
            $examschedule->student_id = Auth::user()->id;
            $examschedule->start_date = Carbon::now()->format('Y-m-d');
            $examschedule->end_date = Carbon::now()->addDays(15)->format('Y-m-d');
            $examschedule->status = 'pending';
            $examschedule->save();
            return Helper::Response(true, 'Successfully Submit', [], false);
        }

        return Helper::Response(true, 'Successfully Submit', [], false);
    }
}
