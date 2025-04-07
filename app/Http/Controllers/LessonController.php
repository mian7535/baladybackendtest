<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\CourseComplete;
use App\Models\LessonComplete;
use App\Models\Lesson;
use App\Models\ExamSchedule;
use App\Services\Mumtathil\MumtatilService;
use Carbon\Carbon;
use Auth;

class LessonController extends Controller
{
    public function LessonComplete(Request $request)
    {
        if(!isset($request->lesson_id) && empty($request->lesson_id)){
            $validation_error[] = 'Lesson ID Is Required';
        }


        if(!isset($request->course_id) && empty($request->course_id)){
            $validation_error[] = 'Course ID Is Required';
        }

       if (!empty($validation_error)) {
            return Helper::Response(false,'Validation Error',[] ,$validation_error);
        }

        if (LessonComplete::where('lesson_id',$request->lesson_id)->where('student_id',Auth::user()->id)->exists()) {

            return Helper::Response(false,'data already exist',[] ,true);

        }

        $table = new LessonComplete();
        $table->student_id = Auth::user()->id;
        $table->lesson_id = $request->lesson_id;
        $table->course_id = $request->course_id;
        $table->is_completed = $request->is_completed;
        $table->save();


        if (LessonComplete::where('student_id',Auth::user()->id)->where('course_id',$request->course_id)->count() == Lesson::where('course_id',$request->course_id)->count()) {
            $table = new CourseComplete();
            $table->student_id = Auth::user()->id;
            $table->course_id = $request->course_id;
            $table->is_completed = $request->is_completed;
            $table->save();

            if (
                CourseComplete::where('student_id',Auth::user()->id)
            ->whereHas(
                'course',fn($q) => $q->where('type',Auth::user()->consumer_id))
            ->count() 
                == 
                Course::where('type',Auth::user()->consumer_id)->where('status','active')
                ->count()
            ) {

                $examschedule = new ExamSchedule();
                $examschedule->student_id = Auth::user()->id;
                $examschedule->start_date = Carbon::now()->format('Y-m-d');
                $examschedule->end_date = Carbon::now()->addDays(21)->format('Y-m-d');
                $examschedule->status = 'pending';
                $examschedule->save();
                return Helper::Response(true,'Schdule Test You attemp in 20 days',[] ,false);

            }


        }

        return Helper::Response(true,'Successfully Submit',[] ,false);

    }

}
