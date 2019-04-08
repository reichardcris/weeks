@extends('layouts.app2')


@section('content')

<style type="text/css">
    
    .choices ul {
        list-style-type:circle;
    }

    .question {
        margin-bottom: 0.8em;
    }

    .choices > li {
        display: block;
    }

    .choices > li > span {
        display: inline-block;
        padding: 0.5em 0.9em;
        cursor: pointer;
    }

    .choices > li > .selected {
        color:#fff;
        background-color: #303641;
        font-weight: bold;
    }

    .choices > li > span:hover {
        background-color: #303641;
        border-radius: 0.3em;
        color:#fff;
    }
    

    #page-navi {
    width:50%;
    margin:40px auto;
    margin-bottom:10px;
    padding: 0px;
    overflow: hidden;
    }

    #page-navi li {
    list-style: none;
    display: inline;
    }

    #page-navi li a {
        float: left;
        display: block;
        padding: 8px 10px;
        margin-right: 10px;
        border: 1px solid #ccc;
        text-decoration: none;
        background: #fff;
        -webkit-transition: background 200ms linear;
        transition: background 200ms linear;
        border-radius: 3px;
        color:#303641;
    }

    #page-navi li:last-child a {
        margin-right: 0px;
    }

    #page-navi li a.current,
    #page-navi li a.disable,
    #page-navi li a:hover {
        background: #303641;
        color: #fff;
        border-bottom:3px solid #fff;
    }
</style>
	
	<h1>Student/{{$activity_type->name}}</h1>
    
    <div id="app-duration">
        <h2><txt style="color: red">Duration Time Left:</txt> @{{getTime}}</h2>
    </div>
  	<div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12" id="app">
       <div class="contents">


@if($status->status != 1)
<?php $number_question = 1; ?>
@foreach($questions as $question)
<div class="content xbox" timer="0">
    <h2 class="alert alert-default">Question of {{$number_question}} of {{count($questions)}}</h2>
     <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title" style="font-size:20px">
                                <b> {{ $question->question }}</b>
                                
                            </div>
                            <div class="panel-options">
                                <a href="#sample-modal" style="font-size:15px;" class="bg">
                                    <i class="entypo-back-in-time"></i>
                                    <span>@{{getTime}}</span>
                                </a>  
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-md-offset-0" >
                                    <ul class="choices assign_{{ $question->id}}" data-qid="{{ $question->id }}">
                                       <?php $letter = ["A","B","C","D","E"]; $count=0; ?>
                                       @foreach($choices as $choice)

                                            @if($question->id == $choice->question_id)
                                            
                                            <li class="test">
                                                <span style="font-size:20px;" class="choice assign_{{ $choice->question_id }}" data-aid="{{ $choice->id }}">
                                                    {{$letter[$count]}}.{{' '}} {{ $choice->answer }}
                                                </span>
                                            </li>
                                            <?php $count++; ?>
                                            @endif
                                            
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
</div>
           
        <?php $number_question++; ?>
@endforeach
            
        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title"><b>FINALIZED</b></div>
                            <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="close" class="bg"><i class="entypo-cancel"></i></a> </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 center-block" style="padding:80px">
                                    <button id="finished_button"  class="btn btn-primary btn-lg col-sm-offset-3 col-md-offset-3 col-lg-offset-3 col-xs-12 col-sm-6 col-lg-6">FINISH EXAMINITION
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
@endif
@if($status->status != 0)
    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title"><b>COMPLETE</b></div>
                            <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="close" class="bg"><i class="entypo-cancel"></i></a> </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="hidden-sm hidden-xs center-block" style="padding:50px 50px">
                                    <div class="col-md-offset-4 col-xs-offset-0 col-sm-offset-0 col-sm-12 col-xs-12">
                                        <label class="h2">
                                            <i class="fa fa-star"></i> My Score : <span class="badge badge-primary"> {{$student_score[0]->score}} </span>
                                        </label><br>
                                         <label class="h2">
                                           <i class="fa fa-times"></i>  In Correct Items : <span class="badge badge-secondary"> {{$student_mistake[0]->mistake}}</span>
                                        </label>
                                        <br>

                                        <label class="h2">
                                           <i class="fa fa-check"></i>  Correct Items : <span class="badge badge-success"> {{$student_correct[0]->correct}}</span>
                                        </label>
                                        <br>

                                        <label class="h2">
                                           <i class="fa fa-plus"></i> Total Number Of Score : <span class="badge badge-info"> {{$total_items[0]->total_items}}</span>
                                        </label>
                                        <br>
                                        <label class="h2">
                                           <i class="fa fa-clock-o"></i> Over all time : <span class="badge badge-danger"> 
                                            @{{minutes+' : '+seconds+" "+(minutes != '00'?'Min.':'Sec.')}}
                                        </label>
                                    </div>
                                </div>

                                <div class="hidden-md hidden-lg center-block" >
                                    <div class="col-md-offset-4 col-xs-offset-1 col-lg-offset-4  col-xs-12">
                                        <label class="h2" style="font-size:20px;">
                                            <i class="fa fa-star"></i> My Score : <span class="badge badge-primary"> {{$student_score[0]->score}} </span>
                                        </label><br>
                                         <label class="h2" style="font-size:20px;">
                                           <i class="fa fa-times"></i>  In Correct Items : <span class="badge badge-secondary"> {{$student_mistake[0]->mistake}}</span>
                                        </label>
                                        <br>

                                        <label class="h2" style="font-size:20px;">
                                           <i class="fa fa-times"></i>   Correct Items : <span class="badge badge-success"> {{$student_correct[0]->correct}}</span>
                                        </label>
                                        <br>

                                        <label class="h2" style="font-size:20px;">
                                           <i class="fa fa-plus"></i> Total Number Of Score : <span class="badge badge-info"> {{$total_items[0]->total_items}}</span>
                                        </label>
                                        <label class="h2" style="font-size:18px;">
                                           <i class="fa fa-clock-o"></i> Over all time : <br><span class="badge badge-danger"> 
                                            @{{minutes+' : '+seconds+" "+(minutes != '00'?'Min.':'Sec.')}}
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
@endif
       </div>
           

        
    </div>
</div>


<script type="text/javascript">
     const app2 = new Vue({
  el: '#app-duration',
  // ========================
  data: {
    timer: null,
    totalTime: (0 * 60),
    resetButton: false,
    title: "Let the countdown begin!!",

  },

  mounted(){
    <?php 

        if($status->status != 1){
            
            echo "this.totalTime = parseInt('".$activity_type->duration."')*60;"
            ."this.startTimer();";
        }else{

            echo "this.totalTime =".(0).';';

        }
    ?>
    
  },
  // ========================
  methods: {
    startTimer: function() {
      this.timer = setInterval(() => this.countdown(), 1000);
      this.resetButton = true;
      this.title = "Greatness is within sight!!"
    },
    stopTimer: function() {
      clearInterval(this.timer);
      this.timer = null;
      this.resetButton = true;
      this.title = "Never quit, keep going!!"
    },
    resetTimer: function() {
      this.totalTime = (30 * 60);
      clearInterval(this.timer);
      this.timer = null;
      this.resetButton = false;
      this.title = "Let the countdown begin!!"
    },
    padTime: function(time) {
      return (time < 10 ? '0' : '') + time;
    },
    countdown: function() {
      if(this.totalTime > 0){
        this.totalTime--
      } else{
        this.totalTime = 0;
        this.stopTimer();
        alert("TIMES UP! EXAMINITION DONE!");

      }
    }
  },
  // ========================
  computed: {
    minutes: function() {
      const minutes = Math.floor(this.totalTime / 60);
      return this.padTime(minutes);
    },
    seconds: function() {
      const seconds = this.totalTime - (this.minutes * 60);
      return this.padTime(seconds);
    },
    getTime:function(){
      return this.minutes+" : "+this.seconds;
    }
  }
});
</script>

<script type="text/javascript">
        const app = new Vue({
  el: '#app',
  // ========================
  data: {
    timer: null,
    totalTime: (0 * 60),
    resetButton: false,
    title: "Let the countdown begin!!",

  },

  mounted(){
   
    <?php 

        if($status->status != 1){
            echo "this.startTimer();";
        }else{

            echo "this.totalTime =".($total_time[0]->timer != null?$total_time[0]->timer:0).';';

        }
    ?>
  },
  // ========================
  methods: {
    startTimer: function() {
      this.timer = setInterval(() => this.countdown(), 1000);
      this.resetButton = true;
      this.title = "Greatness is within sight!!"
    },
    stopTimer: function() {
      clearInterval(this.timer);
      this.timer = null;
      this.resetButton = true;
      this.title = "Never quit, keep going!!"
    },
    resetTimer: function() {
      this.totalTime = (0 * 60);
      clearInterval(this.timer);
      this.timer = null;
      this.resetButton = false;
      this.title = "Let the countdown begin!!"
    },
    padTime: function(time) {
      return (time < 10 ? '0' : '') + time;
    },
    countdown: function() {
      if(this.totalTime >= 0){
        this.totalTime++;
      } else{
        this.totalTime = 0;
        this.resetTimer()
      }
    }
  },
  // ========================
  computed: {
    minutes: function() {
      const minutes = Math.floor(this.totalTime / 60);
      return this.padTime(minutes);
    },
    seconds: function() {
      const seconds = this.totalTime - (this.minutes * 60);
      return this.padTime(seconds);
    },
    getTime:function(){
      return this.minutes+" : "+this.seconds;
    }
  }
});
    var answers = null;

        $(document).ready(function() {

        function hideQuestions() {
            $('div[class*="question_"]').hide();
        }

        function showQuestion(id) {
            $('.question_'+id).show();
        }

        function getQIDs() {
            var qid = [];
            $('ul[class*="choices assign_"]').each(function() {
                var id = $(this).data('qid');
                qid.push(id);
            });

            return qid;
        }

        function getAssignedClass() {
            var assign = [];
            $('ul[class*="choices assign_"]').each(function() {
                var c = $(this).attr('class').split(" ");
                assign.push(c[1]);
            });

            return assign
        }

        function setDesignatedAnswers() {
            var assign = getAssignedClass();
            var data = {};
            assign.forEach(function(a) {
                data[a] = {'question': '', 'answer': '',timer: 0};
            });
            return data;
        }


        function shuffle(array) {
            var currentIndex = array.length, temporaryValue, randomIndex;
            // While there remain elements to shuffle...
            while (0 !== currentIndex) {
                // Pick a remaining element...
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;
                // And swap it with the current element.
                temporaryValue = array[currentIndex];
                array[currentIndex] = array[randomIndex];
                array[randomIndex] = temporaryValue;
            }

            return array;
        }


        function finished_button(){
            
           
        }

        $('#finished_button').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                url:'/finished_exam',
                method:'post',
                data:{
                    submit:answers,
                    id:'<?php echo $id ?>'
                },
                success:function(result){
                    location.reload();
                }
            }); 
        });
        // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        // $('#demo').pagination({
        //     items: 1,
        //     contents: 'contents',
        //     previous: 'Previous',
        //     next: 'Next',
        //     position: 'bottom',
        // });

        // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        hideQuestions();
        var qid = getQIDs();
        var qid_new = shuffle(qid);
        var qid_backup = qid_new;
        showQuestion(qid_backup[qid_backup.length - 1]);

         answers = setDesignatedAnswers();

        console.log(answers);

        $(document).on('click', '.choices > li > span', function() {

            var ul_classes = $(this).parent().parent().attr('class').split(" ");
            var li_classes = $(this).attr('class').split(" ");

            var question = $(this).parent().parent().data('qid');
            var answer = $(this).data('aid');

            console.log(ul_classes);

            if($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                $(this).parent().parent().removeClass('already_answered');
                answers[ul_classes[1]] = {'question': '', 'answer': ''};
            }
            else if(ul_classes[2]) {
                $('.choices > li > .'+ul_classes[1]).removeClass('selected');
                $(this).addClass('selected');

                answers[ul_classes[1]] = {'question': question, 'answer': answer,'timer':app.totalTime};
            }
            else {
                $(this).addClass('selected');
                $(this).parent().parent().addClass('already_answered');

                answers[ul_classes[1]] = {'question': question, 'answer': answer,'timer':app.totalTime};
            }
            console.log(answers);

            
        });

    });

    <?php if($status->status != 1){ ?>
        $('#demo').pagination({
            items: 1,
            contents: 'contents',
            previous: 'Previous',
            next: 'Next',
            position: 'bottom',
        });
     <?php } ?>


     var getLastIndex = 0;

$(document).on('click','#page-navi li a', function(){
    
$('.xbox').each(function(i){
        if($($('.xbox')[i]).attr('style') != undefined){
            //console.log(i);
            if($($('.xbox')[i]).prop('style').display == "block"){

                //console.log(parseInt($($('.xbox')[i]).attr('timer')));
                getLast = app.totalTime;
                app.totalTime = parseInt($($('.xbox')[i]).attr('timer'));
                $($('.xbox')[getLastIndex]).attr('timer',getLast);
                getLastIndex = i;
                
            }
        }
        
    });
});


$(window).blur(function() {
    alert("The Browser must be close by doing unfllowed rules!");
    window.close();
    //do something
});

// $(window).on('beforeunload', function(){
                  
         //  });
$('.sidebar-menu').hide();
  </script>
@endsection