 @extends('layouts.app2')

@section('content')
      
      <h2 class="content">Teacher/Activities Result/{{$subject}}/</h2>

      <h1>Student Name: <b>{{$student->name}}</b></h1>

    <div class="row" id="app">
        

                  <div v-show="isHidden">

                    
                        <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
                          <div class="col-md-12 col-md-offset-0">
                              <div class="panel panel-dark" data-collapsed="0">
                                  <!-- panel head -->
                                  <div class="panel-heading">
                                      <div class="panel-title">My Student Performance </div>
                                     
                                      <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                                  </div>
                                  <!-- panel body -->
                                  <div class="panel-body" style="display: block;overflow-x:scroll;">
                                       
                                       <div id="bar-chart" style="height: 250px"></div>
                                     
                                  </div>
                              </div>
                          </div>
                      </div>
                      

                      
                  </div>
                
                <div class="content" v-show="isHidden == false">
                   <button class="btn btn-primary" v-on:click="isHidden = true">
                      Back
                   </button>

                   <button class="btn btn-warning" v-on:click="print">
                      <i class="fa fa-print"></i> Print
                   </button>

                   <hr>

                    <div class="form-group" v-for="(list,index1) in question_view">
                        <template>
                              <h2 v-if="list.best_ans_id == list.get_answers" class="text text-success">
                                <i class="fa fa-check"></i>
                              </h2>
                              <h2 v-else class="text text-danger">
                                <i class="fa fa-times"></i>
                              </h2>
                              <h1 class="badge badge-primary">
                               Time Interval @{{setTime(list.time_interval)}}
                              </h1>
                              <br>
                              <span class="badge badge-primary">
                                @{{x=index1+1}}
                              </span>
                              <label>Question</label> 
                              <!-- <button class="btn btn-danger btn-xs" v-on:click="remove_question" :data-index="index1">
                                  <i class="fa fa-trash"></i>
                              </button> -->
                        

                                <p class="h3 alert alert-default">@{{list.question.value}}</p>

                              <br>
                              <label>
                                Points Each Item:
                              </label>
                              <p class="h4 alert alert-default">
                                @{{list.points_each}} pts.
                              </p>
                              <br>
                              <label>
                                Answer Key:
                              </label>
                              <ol type="A">
                                <li v-for="(list2,key,index) in list.choices">
                                      <input disabled v-if="list.best_ans_id == list2.id" type="radio" checked :name="'optionsRadios'+index1" :id="'selectAns'+(index1)+''+(index+1)" model="list.best_ans_id" :value="list2.id">
                                      <input disabled v-if="list.best_ans_id != list2.id" type="radio" :name="'optionsRadios'+index1" :id="'selectAns'+(index1)+''+(index+1)" model="list.best_ans_id" :value="list2.id">
                                      <textarea disabled class="form-control" model="list.choices[key].value" :value="JSON.stringify(list.choices[key].value)" placeholder="Answer"></textarea>
                                </li>
                              </ol>
                          </template>
                    </div>
                </div>




    </div>


<script type="text/javascript">
  var app = new Vue({
    el:'#app',
    data:{
      isHidden:true,
      question_view:[],
      totalTime:60
    },
    methods:{
       hide_graph:function(e){
       
          
       },
       padTime: function(time) {
        return (time < 10 ? '0' : '') + time;
      },
      setTime:function(time){
        this.totalTime = parseInt(time);
        return this.getTime;
      },
      print:function(){
        window.print();
      }
    },
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
      return this.minutes+" : "+this.seconds+" sec.";
    }
  }

  });
</script>

<script type="text/javascript">

    var barColorsArray = ['#f45342', '#1c71a5','#591ba5', '#ff2833'];
    var colorIndex = 0;
   
    Morris.Bar({
      element: 'bar-chart',
      data: <?php echo json_encode($graph);?>,
      xkey: 'device',
      ykeys: ['geekbench'],
      labels: ['Geekbench'],
      barRatio: 0.4,
      xLabelAngle: 35,
      hideHover: 'auto',
      barColors: function () {
          if(colorIndex < 3)
            return barColorsArray[++colorIndex];
          else{
              colorIndex = 0;
              return barColorsArray[++colorIndex];
          }
        },
        hoverCallback: function (index, options, content, row) {
          return row.device+ "<br> <b>Student Percentage</b> = (" + row.geekbench+"%)<br> Student Score = "+row.score+"pts.<br> Total Score = "+row.total_score+"pts. <br> <button data-index='"+row.id+"' class='review btn btn-primary'>Review</button>";
        }
    });

// startGraph();

function startGraph(){
       initMorris();
          data = <?php echo json_encode($graph);?>;
          setMorris(data);
}
$(document).on('click','.review',function(){
  console.log("wasd");
  e = $(this).attr('data-index');
   $.ajax({
          url:'/get_question_review',
          data:{
            id:e,
            student_id:<?php echo $student->id; ?>
          },
          dataType:'json',
          method:'post',
          success:function(result){
            app.question_view = result;
            app.isHidden = false;
          }
            
          });
});
</script>




    @section('sidebar')
         <li>
            <a href="/">
                <i class="entypo-home"></i>
                <span class="title">Home</span>
            </a> 
         
        </li>
         <li>
            <a href="/create_activity">
                <i class="entypo-plus-circled"></i>
                <span class="title">Create Activity</span>
            </a> 
         
        </li>
        <li >  
            <a href="/my_class_record"><i class="entypo-book"></i><span class="title">My Class Record</span></a> 
        </li>
       <li class="active"> 
            <a href="/activities_result"><i class="entypo-clipboard"></i><span class="title">Activities Result</span></a> 
        </li>
    @endsection

    @endsection