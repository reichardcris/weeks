<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Events\UserSign;
class HomeController extends Controller
{

    private $activity_id;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
         $activity_id=null;
    }

   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        event(new UserSign('Richard'));

        $users = DB::table('users')->select('*')
        ->where('role','!=','1')
        ->get();

        $subjects = DB::table('subject')->select('*')
        // ->where('role','!=','1')
        ->get();

        $section = DB::table('section')->select('*')
        // ->where('role','!=','1')
        ->get();

        $my_classes = DB::table('class')
        ->join('users', 'users.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->select('subject.name as subject' , 
                'users.name as teacher' ,
                'section.name as section',
                'class.id as class_id',
                DB::raw('(SELECT COUNT(*) FROM enrolled_class WHERE enrolled_class.class_id = class.id) as number_student')
         )
        ->where('class.teacher_id',auth()->user()->id)
        ->get();

        $student_subject = 
        DB::table('view_student_subject')
        ->select('*')
        ->where('student_id',auth()->user()->id)
        ->get();
        

        return view('home',
            [
                'users'=>$users,
                'subjects'=>$subjects,
                'section'=>$section,
                'myClasses'=>$my_classes,
                'student_subject'=>$student_subject
            ]
        );
    }

    public function add_section(Request $data){
        db::table('section')
        ->insert([ 'name'=> strtoupper($data['name']) ]);

        $section = DB::table('section')->select('*')
        ->get();

        return json_encode(array('response'=>true,'section'=>$section));
    }

    public function add_subject(Request $data){

       $subject_id =  db::table('subject')
        ->insertGetId([ 'name'=> strtoupper($data['name']) ]);

        $subject = DB::table('subject')->select('*')
        ->get();

        foreach ($data->pointers as $key) {
            db::table('pointers')
                ->insert(['name'=>$key['name'],
                  'percentage'=>$key['percentage'],
                  'subject_id'=>$subject_id,
                ]);            # code...
        }


        // echo json_encode($data->pointers);

        return json_encode(array('response'=>true,'subject'=>$subject));
    }

    public function add_schedule(Request $data){
        
        DB::table('class')
        ->insert([ 
            'subject_id'=>$data['subject_id'],
            'teacher_id'=>$data['teacher_id'],
            'section_id'=>$data['section_id'], 
        ]);

        $schedule = DB::table('class')
        ->join('users', 'users.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->select('subject.name as subject' , 
                'users.name as teacher' ,
                'section.name as section',
                DB::raw('(SELECT COUNT(*) FROM enrolled_class WHERE enrolled_class.class_id = class.id) as number_student'))->get();

        return json_encode(array('schedule' => $schedule ));

    }

    public function scheduling(Request $data){
        $teacher = DB::table('users')->select('*')
        ->where('role','2')
        ->get();

        $subjects = DB::table('subject')->select('*')
        // ->where('role','!=','1')
        ->get();

        $section = DB::table('section')->select('*')
        // ->where('role','!=','1')
        ->get();

        
        $schedule = DB::table('class')
        ->join('users', 'users.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->select('class.id as class_id'
                ,'subject.name as subject' , 
                'users.name as teacher' ,
                'section.name as section',
                DB::raw('(SELECT COUNT(*) FROM enrolled_class WHERE enrolled_class.class_id = class.id) as number_student')
         )
        ->get();

        return view('schedule',['section'=>$section,'subject'=>$subjects,'teacher'=>$teacher,'schedule'=>$schedule]);
    }   

    public function update_sub_sec(Request $data){

        if($data->data['opt'] == "subject"){

            DB::table('subject')
            ->where('id',$data->data['id'])
            ->update(['name'=>$data->data['name'] ]);

            $result = DB::table('subject')
            ->select("*")
            ->get();

            return json_encode($result);

        }else{
            DB::table('section')
            ->where('id',$data->data['id'])
            ->update(['name'=>$data->data['name'] ]);

            $result = DB::table('section')
            ->select("*")
            ->get();

            return json_encode($result);
            
        }

        

    }

    public function enrollStudent(Request $data) {

        $students = DB::table('users')
        ->select('*')
        ->where('role','3')
        ->get();

        $schedule = DB::table('class')
        ->join('users', 'users.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->select('class.id as class_id',
                 'subject.name as subject' , 
                'users.name as teacher' ,
                'section.name as section',
                DB::raw('(SELECT COUNT(*) FROM enrolled_class WHERE enrolled_class.class_id = class.id) as number_student')
         )
        ->get();

        return view('enroll_student',['students'=>$students,'schedule'=>$schedule]);
    }

    public function getEnrolled_subject(Request $data){

        $enroll_class = DB::table('class')
        ->join('users', 'users.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->join('enrolled_class', 'enrolled_class.class_id', '=', 'class.id')
        ->select('enrolled_class.id,subject')
        ->get();


    }

    public function delete_assign(Request $data){
        DB::table('total_percentage')
        ->where('class_id',$data->id)
        ->delete();

        DB::table('class')
        ->where('id',$data->id)
        ->delete();

        return json_encode(['result'=>true]);
    }

    public function get_Student(Request $data){
        $student = User::where(['id'=>$data->id,'role'=>3])->first();
        $enrolled_subject = DB::table('class')
        ->join('users as teacher', 'teacher.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->join('enrolled_class', 'enrolled_class.class_id', '=', 'class.id')
        ->join('users as student', 'student.id', '=', 'enrolled_class.student_id')
        ->select('section.name as section',
            'subject.name as subject' ,
            'teacher.name as teacher',
            'student.id as std_id',
            'enrolled_class.id as enrolled_class_id'
         )
        ->where('student.id',$data->id)
        ->get();

        return json_encode(['student_data'=>$student,'enrolled_subject'=>$enrolled_subject]);
    }


    public function enroll_this_student(Request $data){


        DB::table('enrolled_class')
        ->insert($data->all());

        $enrolled_subject = DB::table('class')
        ->join('users as teacher', 'teacher.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->join('enrolled_class', 'enrolled_class.class_id', '=', 'class.id')
        ->join('users as student', 'student.id', '=', 'enrolled_class.student_id')
        ->select('section.name as section',
            'subject.name as subject' ,
            'teacher.name as teacher',
            'student.id as std_id',
            'enrolled_class.id as enrolled_class_id'
         )
        ->where('student.id',$data['student_id'])
        
        ->get();


        return json_encode(['enrolled_subject'=>$enrolled_subject]);

    }


   public function view_my_classes_by_id(Request $data){

        $my_classes = DB::table('class')
        ->join('users', 'users.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->select('subject.name as subject' , 
                'users.name as teacher' ,
                'section.name as section',
                'class.id as class_id',
                DB::raw('(SELECT COUNT(*) FROM enrolled_class WHERE enrolled_class.class_id = class.id) as number_student')
         )
        ->where(['class.id'=>$data->id])
        ->first();

        $my_student = DB::table('class')
        ->join('enrolled_class', 'enrolled_class.class_id', '=', 'class.id')
        ->join('users', 'users.id', '=', 'enrolled_class.student_id')
        ->select('users.*')
        ->where('class.id',$data->id)
        ->get();
        return view('view_class',['myClasses'=>$my_classes,'my_student'=>$my_student]);

   }
   
      public function view_my_classes_by_id_admin(Request $data){

        $my_classes = DB::table('class')
        ->join('users', 'users.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->select('subject.name as subject' , 
                'users.name as teacher' ,
                'section.name as section',
                'class.id as class_id',
                DB::raw('(SELECT COUNT(*) FROM enrolled_class WHERE enrolled_class.class_id = class.id) as number_student')
         )
        ->where(['class.id'=>$data->id])
        ->first();

        $my_student = DB::table('class')
        ->join('enrolled_class', 'enrolled_class.class_id', '=', 'class.id')
        ->join('users', 'users.id', '=', 'enrolled_class.student_id')
        ->select('users.*')
        ->where('class.id',$data->id)
        ->get();

        $teacher = DB::table('admin_view_class')
        ->where('id',$data->id)
        ->first();

        if(auth()->user()->role != 1){
            return view('view_class',['myClasses'=>$my_classes,'my_student'=>$my_student]);
        }

              return view('view_class',['myClasses'=>$my_classes,'my_student'=>$my_student,'teacher'=>$teacher]);  

   }
   public function profile(Request $data){

        $profile = User::where('id',$data->id)
        ->first();

        return view('profile',['profile'=>$profile]);
   }

    public function profile_edit(Request $data){

        

        try{
            $id = decrypt($data->id);
            $profile = DB::table('users')
            ->where('id',$id)
            ->select("*")
            ->first();
        }catch(Exception $e){
            return redirect('404');
        }

        if($id != auth()->user()->id){
            return redirect('/');
        }

        // $profile->id = encrypt($profile->id);
        $profile->idd = encrypt($profile->id);
        $profile->id = 0;
       
        return view('profile_edit',['profile'=> json_encode($profile)]);

   }

   public function check_password(Request $data){

        if(Hash::check($data->password, auth()->user()->password)){
            return json_encode(['result'=>true]);
        }else{
            return json_encode(['result'=>false]);
        }
     // print_r();
    // $pw = 123456;
    // $hashed = Hash::make($pw);
    // print_r(Hash::check($data->password, $hashed));
    // return $hashed;
   }

   public function update_profile(Request $data){

        if($data->isChangePassword == "true"){

            DB::table('users')
            ->where('id',auth()->user()->id)
            ->update([
                'name'=>$data->data['name'],
                'email'=>$data->data['email'],
                'password'=> Hash::make($data->newPassword)
            ]);


            return $data->data['name'];
        }else{
            DB::table('users')
            ->where('id',auth()->user()->id)
            ->update([
                'name'=>$data->data['name'],
                'email'=>$data->data['email'],
            ]);
            return $data->data['name'];
        }
        
   }

   public function my_class_record_by_section(Request $data){
        $grades = DB::table('get_grades')
        ->where('class_id',$data->id)
        ->select('*')
        ->get();
        return view('my_class_record',['grades'=>$grades]);
   }

   public function my_class_record(Request $data){
        $my_classes = DB::table('class')
        ->join('users', 'users.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->select('subject.name as subject' , 
                'users.name as teacher' ,
                'section.name as section',
                'class.id as class_id',
                DB::raw('(SELECT COUNT(*) FROM enrolled_class WHERE enrolled_class.class_id = class.id) as number_student')
         )
        ->where('class.teacher_id',auth()->user()->id)
        ->get();

        // $my_classes[0]->;
        
        foreach ($my_classes as $key) {
           $percentages = DB::table('total_percentage')
            ->where('class_id',$key->class_id)
            ->join('activity_type','activity_type.id','=','total_percentage.activity_type_id')
            ->select("activity_type.name as type",'total_percentage.percentage')
            ->get();
            $key->percentages=$percentages;
        }
           // print_r($my_classes);
        return view ('class_record',['my_classes'=>$my_classes]);  
   }


   public function create_activity(Request $data){

        $activity_type  = DB::table('activity_type')
        ->select('*')
        ->get();
        
        $view_activities  = DB::table('view_activities')
        ->select('*')
        ->where('teacher_id',auth()->user()->id)
        ->get();

        $my_classes = DB::table('class')
        ->join('users', 'users.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        // ->join('', 'total_percentage.class_id', '=', 'class.id')
        ->select('subject.name as subject' , 
                'users.name as teacher' ,
                'section.name as section',
                'class.id as class_id',
                DB::raw('(SELECT COUNT(*) FROM enrolled_class WHERE enrolled_class.class_id = class.id) as number_student')
         )
        ->where('class.teacher_id',auth()->user()->id)
        ->get();

        return view('create_activity',['activity_type'=>$activity_type,'view_activities'=>$view_activities,'my_class'=>$my_classes]);

   }

   public function create_questionare(Request $data){

        $activity_id = DB::table('activities')
        ->insertGetId([
            'activity_type_id'=>$data->activity_type_id,
            'act_schedule'=>$data->act_sched,
            'act_deadline'=>$data->act_deadline,
            'duration'=>$data->duration,
            'status'=>0
            // 'class_id'=>$data->class_id
        ]);

        $get_enrolled_class = DB::select(DB::raw('
            SELECT enrolled_class.id as enrolled_class_id, class.id as class_id FROM class
            INNER JOIN enrolled_class ON enrolled_class.class_id = class.id
            WHERE class.id = '.$data->class_id.''));
        

        foreach ($get_enrolled_class as $key) {

            DB::table('class_records')
            ->insert([
                'enrolled_class_id'=>$key->enrolled_class_id,
                'activities_id'=>$activity_id,
                'status'=>0
            ]);
            # code...
        }

        foreach ($data->question as $key) {
                // if($key['best_ans'] != ){

                // }



            

            // print_r($key['choices'][$key['best_ans']]);
            
                // print_r($key['choices']);            
            # code...
        }

        foreach ($data->question as $key => $value) {

            foreach ($value as $key ) {

                $question_id = DB::table('question')
            ->insertGetId([
                'question'=>$key['question'],
                'points_each'=>$key['points_each'],
                'activity_id'=>$activity_id,
                'pointers_id'=>$key['pointers_id']

            ]);

            $best_ans_id = DB::table('answers')
            ->insertGetId([
                'answer'=>$key['choices'][$key['best_ans']],
                'question_id'=>$question_id

            ]);

            DB::table('question')
            ->where('id',$question_id)
            ->update(['right_answer_id'=>$best_ans_id]);
                # code...

            foreach ($key['choices'] as $keys => $value) {
                  
                  if($key['best_ans'] != $keys){
                      
                      DB::table('answers')
                     ->insertGetId([
                        'answer'=>$key['choices'][$keys],
                        'question_id'=>$question_id

            ]);
                 }
            }
               
            }
            # code...
        }
        // print_r($data->question[0]['choices'][$data->question[0]['best_ans']]);
        // return json_encode($data->question);
   }

   public function student_exam(Request $data){
     
     try{
        $activity_id = decrypt($data->id);
     
     }catch(Exception $e){
       
        return redirect('/');
     }


     $activity_type = DB::table('activities')
                     ->join('activity_type', 'activity_type.id', '=', 'activities.activity_type_id')
                     ->where('activities.id',$activity_id)->first();

     $questions = $this->shuffle($this->getQuestions($activity_id));
     $choices = $this->shuffle($this->getChoices($activity_id));
     $get_status = DB::select(
        DB::raw('SELECT class_records.* from enrolled_class
        INNER JOIN class_records ON class_records.enrolled_class_id = enrolled_class.id
        WHERE enrolled_class.student_id = '.auth()->user()->id.' AND class_records.activities_id = '.$activity_id.'
        '));

     $student_score = DB::select(DB::raw('
        SELECT SUM(question.points_each) as score from enrolled_class
        INNER JOIN users as student ON student.id = enrolled_class.student_id
        INNER JOIN class_records ON class_records.enrolled_class_id = enrolled_class.id
        INNER JOIN student_answer ON student_answer.class_record_id = class_records.id
        INNER JOIN question ON  question.id = student_answer.question_id
        INNER JOIN answers ON answers.question_id = question.id

        WHERE student.id ='.auth()->user()->id.' AND 
        class_records.activities_id = '.$activity_id.' AND 
        student_answer.question_id = question.id AND 
        student_answer.anwers_id = question.right_answer_id AND 
        answers.id = student_answer.anwers_id '));

     $student_mistake = DB::select(DB::raw('
        SELECT COUNT(*) as mistake from enrolled_class
        INNER JOIN users as student ON student.id = enrolled_class.student_id
        INNER JOIN class_records ON class_records.enrolled_class_id = enrolled_class.id
        INNER JOIN student_answer ON student_answer.class_record_id = class_records.id
        INNER JOIN question ON  question.id = student_answer.question_id
        INNER JOIN answers ON answers.question_id = question.id

        WHERE student.id ='.auth()->user()->id.' AND 
        class_records.activities_id = '.$activity_id.' AND 
        student_answer.question_id = question.id AND 
        student_answer.anwers_id != question.right_answer_id AND 
        answers.id = student_answer.anwers_id '));

     $student_correct = DB::select(DB::raw('
        SELECT COUNT(*) as correct from enrolled_class
        INNER JOIN users as student ON student.id = enrolled_class.student_id
        INNER JOIN class_records ON class_records.enrolled_class_id = enrolled_class.id
        INNER JOIN student_answer ON student_answer.class_record_id = class_records.id
        INNER JOIN question ON  question.id = student_answer.question_id
        INNER JOIN answers ON answers.question_id = question.id

        WHERE student.id ='.auth()->user()->id.' AND 
        class_records.activities_id = '.$activity_id.' AND 
        student_answer.question_id = question.id AND 
        student_answer.anwers_id = question.right_answer_id AND 
        answers.id = student_answer.anwers_id '));

     $total_items = DB::select(DB::raw('
        SELECT SUM(question.points_each) as total_items from enrolled_class
        INNER JOIN class_records ON class_records.enrolled_class_id = enrolled_class.id
        INNER JOIN question ON question.activity_id = class_records.activities_id

        WHERE enrolled_class.student_id = '.auth()->user()->id.'
        AND class_records.activities_id = '.$activity_id.'

        '));

     $total_timer = DB::select(DB::raw('
        SELECT SUM(student_answer.time_interval) as timer from enrolled_class
        INNER JOIN users as student ON student.id = enrolled_class.student_id
        INNER JOIN class_records ON class_records.enrolled_class_id = enrolled_class.id
        INNER JOIN student_answer ON student_answer.class_record_id = class_records.id
        INNER JOIN question ON  question.id = student_answer.question_id
        INNER JOIN answers ON answers.question_id = question.id

        WHERE student.id ='.auth()->user()->id.' AND 
        class_records.activities_id = '.$activity_id.' AND 
        student_answer.question_id = question.id AND 
        student_answer.anwers_id = question.right_answer_id AND 
        answers.id = student_answer.anwers_id '));
    
    if($student_score[0]->score == null){
        $student_score[0]->score = 0;
    }
   
    return view('student_exam',
            [
                'questions'=>$questions,
                'choices'=>$choices,
                'id'=>$data->id,
                'status'=>$get_status[0],
                'student_score'=>$student_score,
                'student_mistake'=>$student_mistake,
                'student_correct'=>$student_correct,
                'total_items'=>$total_items,
                'activity_type'=>$activity_type,
                'total_time'=>$total_timer,
                'act_id'=>$activity_id,
            ]);
   }




    function shuffle($my_array = array()) {
        $copy = array();
        while (count($my_array)) {
            // takes a rand array elements by its key
            $element = array_rand($my_array);
            // assign the array and its value to an another array
            $copy[$element] = $my_array[$element];
            //delete the element from source array
            unset($my_array[$element]);
        }

        return $copy;
    }

    public function getQuestions($activity_id) {
        $std_id = auth()->user()->id;
        $questions = DB::select(DB::raw(
            'SELECT question.*
            from class
            INNER JOIN subject ON subject.id = class.subject_id
            INNER JOIN section ON section.id = class.section_id
            INNER JOIN enrolled_class ON enrolled_class.class_id = class.id
            INNER JOIN class_records on class_records.enrolled_class_id = enrolled_class.id
            INNER JOIN activities ON activities.id = class_records.activities_id
            INNER JOIN activity_type ON activity_type.id = activities.activity_type_id
            INNER JOIN users as teacher ON teacher.id = class.teacher_id
            INNER JOIN question ON question.activity_id = activities.id
            WHERE enrolled_class.student_id = '.auth()->user()->id.' AND activities.id = '.$activity_id.''

        ));

        return $questions;
    }
   
    public function getChoices($activity_id) {
        $choices = Db::select(DB::raw(
            'SELECT answers.*
                from class
                INNER JOIN subject ON subject.id = class.subject_id
                INNER JOIN section ON section.id = class.section_id
                INNER JOIN enrolled_class ON enrolled_class.class_id = class.id
                INNER JOIN class_records on class_records.enrolled_class_id = enrolled_class.id
                INNER JOIN activities ON activities.id = class_records.activities_id
                INNER JOIN activity_type ON activity_type.id = activities.activity_type_id
                INNER JOIN users as teacher ON teacher.id = class.teacher_id
                INNER JOIN question ON question.activity_id = activities.id
                INNER JOIN answers ON answers.question_id = question.id
                WHERE enrolled_class.student_id = '.auth()->user()->id.' AND activities.id = '.$activity_id.''
        ));

        return $choices;
    }


 public function my_activity(Request $data){

    $student_activities = 
    DB::table('view_activities_by_student')
    ->select('*')
    ->where([['student_id',auth()->user()->id],['activities_status',1]])
    ->get();
    
    return view('my_activity',['student_activities'=>$student_activities]);
   }

public function finished_exam(Request $data){

    $id = decrypt($data->id);
    $class_records_id = DB::select(DB::raw(
    'SELECT enrolled_class.id,class_records.id as class_records_id,
            enrolled_class.student_id

            from class
            INNER JOIN subject ON subject.id = class.subject_id
            INNER JOIN section ON section.id = class.section_id
            INNER JOIN enrolled_class ON enrolled_class.class_id = class.id
            INNER JOIN class_records on class_records.enrolled_class_id = enrolled_class.id
            INNER JOIN activities ON activities.id = class_records.activities_id
            INNER JOIN activity_type ON activity_type.id = activities.activity_type_id
            WHERE enrolled_class.student_id = '.auth()->user()->id.' AND activities.id ='.$id.'
            '
    ));

    foreach ($data->submit as $key => $value) {
        # code...
        DB::table('student_answer')
        ->insert([
            'student_id'=>auth()->user()->id,
            'anwers_id'=>$value['answer'],
            'question_id'=>$value['question'],
            'time_interval'=>$value['timer'],
            'class_record_id'=>$class_records_id[0]->class_records_id
        ]);
        // print_r($value['question'].' => '.$value['answer'].'<br>');
    }
        DB::table('class_records')
        ->where('id',$class_records_id[0]->class_records_id)
        ->update(['status'=>1]);


    return json_encode(['id'=>encrypt($id)]);

}

public function get_question_review(Request $data){
  

     $array = Array (
        // [
        // // get_question
        // 'points_each' => 20, 
        // 'isEdit' => false , 
        // 'question' => ['id' => 10,'value' => 'What is this?' ], 
        // 'best_ans_id' => 20, 
        // // get_answers
        // 'choices' => Array ( 
        // 'a' => Array ( 'value' => 'adad','id' => 21 ),
        // 'b' => Array ( 'value' => 'adad', 'id' => 20 ), 
        // 'c' => Array ( 'value' => 'adad' ,'id' => 23),
        // 'd' => Array ( 'value' =>' adad', 'id' => 25), ),
        // ] 
    );

  $questions = DB::select(DB::raw('SELECT  question.* , student_answer.anwers_id,student_answer.time_interval FROM student_answer
INNER JOIN question ON question.id = student_answer.question_id

WHERE question.activity_id = '.$data->id.' AND student_answer.student_id = '.$data->student_id.''));
    // ->get();

    // print_r($questions);
$index=0;
    foreach ($questions as $key) {

        array_push($array,[
            'points_each' => $key->points_each, 
            'isEdit' => false , 
            'question' => ['id' => $key->id,'value' => $key->question ], 
            'best_ans_id' => $key->right_answer_id, 
            'get_answers'=> $key->anwers_id,
            'time_interval'=>$key->time_interval,
            'choices' => Array (),
        ]);

        $ans =DB::table('answers')
        ->select('answer','id','question_id')
        ->where('question_id',$key->id)
        ->get();


        foreach ($ans as $key2 =>$value) {
            if($value->question_id == $array[$index]['question']['id']){
               // array_push($array[$index]['choices'], [range('a','z')[$key2]=>array(['value'=>$value->answer,'id'=>$value->id])]); 
               $array[$index]['choices'][range('a','z')[$key2]]=['value'=>$value->answer,'id'=>$value->id]; 
            }
            // echo  $array[$index]['question']['id'].'/<br>';
            // echo $key2;
            // array_push($array[$index]['choices'],$an)
        }

        # code...
        $index++;
    }

    return json_encode($array);
}

public function get_question(Request $data){

    $array = Array (
        // [
        // // get_question
        // 'points_each' => 20, 
        // 'isEdit' => false , 
        // 'question' => ['id' => 10,'value' => 'What is this?' ], 
        // 'best_ans_id' => 20, 
        // // get_answers
        // 'choices' => Array ( 
        // 'a' => Array ( 'value' => 'adad','id' => 21 ),
        // 'b' => Array ( 'value' => 'adad', 'id' => 20 ), 
        // 'c' => Array ( 'value' => 'adad' ,'id' => 23),
        // 'd' => Array ( 'value' =>' adad', 'id' => 25), ),
        // ] 
    );

$questions = DB::table('question')
    ->select('id','question','points_each','right_answer_id')
    ->where('activity_id',$data->id)
    ->get();
$index=0;
    foreach ($questions as $key) {

        array_push($array,[
            'points_each' => $key->points_each, 
            'isEdit' => false , 
            'question' => ['id' => $key->id,'value' => $key->question ], 
            'best_ans_id' => $key->right_answer_id, 
        // get_answers
            'choices' => Array (),
        ]);

        $ans =DB::table('answers')
        ->select('answer','id','question_id')
        ->where('question_id',$key->id)
        ->get();


        foreach ($ans as $key2 =>$value) {
            if($value->question_id == $array[$index]['question']['id']){
               // array_push($array[$index]['choices'], [range('a','z')[$key2]=>array(['value'=>$value->answer,'id'=>$value->id])]); 
               $array[$index]['choices'][range('a','z')[$key2]]=['value'=>$value->answer,'id'=>$value->id]; 
            }
            // echo  $array[$index]['question']['id'].'/<br>';
            // echo $key2;
            // array_push($array[$index]['choices'],$an)
        }

        # code...
        $index++;
    }

    return json_encode($array);
    // print_r() ;
}

public function update_question(Request $data){
    DB::table('question')
    ->where('id',$data->data['question']['id'])
    ->update([
        'question'=> $data->data['question']['value'],
        'right_answer_id' => $data->data['best_ans_id'],
        'points_each'=>$data->data['points_each']
    ]);

    foreach ($data->data['choices'] as $key => $value) {
        // print_r($value);
            DB::table('answers')
            ->where('id',$value['id'])
            ->update([
                'answer'=>$value['value']
                ]
            );


        # code...
    }
    // print_r($data->data['choices']);

}

public function active_exam(Request $data){

    DB::table('activities')
    ->where('id',$data->id)
    ->update(['status'=>1]);

    $view_activities  = DB::table('view_activities')
        ->select('*')
        ->where('teacher_id',auth()->user()->id)
        ->get();

   return json_encode(['result'=>true,'activities'=>$view_activities]);


}

public function delete_activity(Request $data){

    $get_question_id = DB::table('question')
    ->select()
    ->where('activity_id',$data->id)
    ->get();


    foreach ($get_question_id as $key) {
        DB::table('student_answer')
        ->where('question_id',$key->id)
        ->delete();
        DB::table('answers')
        ->where('question_id',$key->id)
        ->delete();
        # code...
    }

    DB::table('question')
    ->where('activity_id',$data->id)
    ->delete();

    DB::table('class_records')
    ->where('activities_id',$data->id)
    ->delete();

    DB::table('activities')
    ->where('id',$data->id)
    ->delete();

    $view_activities  = DB::table('view_activities')
        ->select('*')
        ->where('teacher_id',auth()->user()->id)
        ->get();

    return json_encode(['activities'=>$view_activities]);
    // DB::table('student_answer')->
    // where('question_id',$data->)
}

public function delete_each_question(Request $data){    

    DB::table('student_answer')
        ->where('question_id',$data->id)
        ->delete();

    DB::table('answers')
    ->where('question_id',$data->id)
    ->delete();

    

}

public function get_pointers(Request $data){

    $pointers = DB::table('get_pointers_by_class')
    ->select('*')
    ->where('class_id',$data->id)
    ->get();

    return json_encode(['result'=>$pointers]);
}

public function activities_result(Request $data){

    $my_classes = DB::table('class')
        ->join('users', 'users.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->select('subject.name as subject' , 
                'users.name as teacher' ,
                'section.name as section',
                'class.id as class_id',
                DB::raw('(SELECT COUNT(*) FROM enrolled_class WHERE enrolled_class.class_id = class.id) as number_student')
         )
        ->where('class.teacher_id',auth()->user()->id)
        ->get();



    return view('activities_result',['myClasses'=>$my_classes]);
}

public function get_my_student(Request $data)
{
    $my_student = DB::table('class')
        ->join('enrolled_class', 'enrolled_class.class_id', '=', 'class.id')
        ->join('users', 'users.id', '=', 'enrolled_class.student_id')
        ->select('users.*')
        ->where('class.id',$data->id)
        ->get();

    return json_encode($my_student); 
}

public function view_graph(Request $data){
   $graph = DB::select(DB::raw('SELECT * FROM `get_graph_value` WHERE student_id = '.$data->student_id.' AND teacher_id = '.auth()->user()->id.' AND subject = "'.$data->subject.'" '));

    $array = array();
    if ($graph != null) {
        foreach ($graph as $key) {
            if($key->student_score == null){
                $key->student_score = 0;
            }
            $percentage = round(($key->student_score/$key->total_score) * 100);
            array_push($array,['device'=>$key->act_type.''.$key->activities_id,'geekbench'=>$percentage,'score'=>$key->student_score,'total_score'=> $key->total_score,'id'=>$key->activities_id]);
            # code...
         }    
     }else{
             array_push($array,['device'=>'','geekbench'=>0]);
     }
   
    $student_name =User::where('id',$data->student_id)
    ->select()
    ->first();


  
    return view('graph',['graph'=>$array,'subject'=>$data->subject,'student'=>$student_name]);
}

public function update_percentage(Request $data){
    DB::table('enrolled_class')
    ->where('id',$data->id)
    ->update(['performance_task'=>$data->performance_task,
        'quarter_assessment'=>$data->quarter_assessment]);

    return json_encode(['result'=>true]);
}

public function my_grades(Request $data){
   $grades = DB::table('get_grades')
    ->select()
    ->where('student_id',auth()->user()->id)
    ->get();
    return view('my_grades',['grades'=>$grades]);
}

public function drop_subect(Request $data){

    $activities_id_s = DB::table('enrolled_class')
    ->join('class_records','class_records.enrolled_class_id','=','enrolled_class.id')
    ->where('enrolled_class.id',$data->id)
    ->select()
    ->get();

    foreach ($activities_id_s as $key) {
          $get_question_id = DB::table('question')
            ->select()
            ->where('activity_id', $key->activities_id)
            ->get();


            foreach ($get_question_id as $key2) {
                DB::table('student_answer')
                ->where('question_id',$key2->id)
                ->delete();
                DB::table('answers')
                ->where('question_id',$key2->id)
                ->delete();
                # code...
            }

            DB::table('question')
            ->where('activity_id',$key->activities_id)
            ->delete();

            DB::table('class_records')
            ->where('activities_id',$key->activities_id)
            ->delete();

            DB::table('activities')
            ->where('id',$key->activities_id)
            ->delete();

            // $view_activities  = DB::table('view_activities')
            //     ->select('*')
            //     ->where('teacher_id',auth()->user()->id)
            //     ->get();
        # code...
    }
 DB::table('enrolled_class')
 ->where('id',$data->id)
 ->delete();

  $student = User::where(['id'=>$data->student_id,'role'=>3])->first();
        $enrolled_subject = DB::table('class')
        ->join('users as teacher', 'teacher.id', '=', 'class.teacher_id')
        ->join('subject', 'subject.id', '=', 'class.subject_id')
        ->join('section', 'section.id', '=', 'class.section_id')
        ->join('enrolled_class', 'enrolled_class.class_id', '=', 'class.id')
        ->join('users as student', 'student.id', '=', 'enrolled_class.student_id')
        ->select('section.name as section',
            'subject.name as subject' ,
            'teacher.name as teacher',
            'student.id as std_id',
            'enrolled_class.id as enrolled_class_id'
         )
        ->where('student.id',$data->student_id)
        ->get();

        return json_encode(['student_data'=>$student,'enrolled_subject'=>$enrolled_subject]);
   
}
}
