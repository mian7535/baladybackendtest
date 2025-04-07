<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\ExamSchedule;
use App\Models\CourseComplete;
use App\Models\LessonComplete;
use App\Models\Student;
use Carbon\Carbon;
class ExamScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'exam:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command Run to Exam Schedul';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

     
    public function handle()
    {

        $todayDate=Carbon::now()->format('Y-m-d');
        $todayschdules=ExamSchedule::where('end_date',$todayDate)->get();
        foreach($todayschdules as $todayschdule){
            LessonComplete::where('student_id',$todayschdule->student_id)->delete();
            CourseComplete::where('student_id',$todayschdule->student_id)->delete();
            ExamSchedule::where('student_id',$todayschdule->student_id)->delete();

            $user = Student::find($todayschdule->student_id);
            $user->is_lock = 1;
            $user->update();
            
        }   

        $this->info('Successfully sent daily quote to everyone.');
    }
}
