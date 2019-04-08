 @extends('layouts.app2')

@section('content')
 <h2>Teacher/Create Activity</h2>
<hr></hr>
    <div class="row" id="app">
        <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12" v-if="isCreated == false">


          <div class="col-md-12">
             <div class="panel panel-dark" data-collapsed="0">
                  <!-- panel head -->
                  <div class="panel-heading">
                      <div class="panel-title">Create Activity</div>
                      <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                  </div>
                  <!-- panel body -->
                  <div class="panel-body" style="display: block;">
                      <form role="form" class="form-horizontal form-groups-bordered">

                            <div class="form-group">
                                  <label class="col-sm-3 control-label">Select Class</label>
                                  <div class="col-sm-5">
                                      <select class="form-control" v-model="class_id">
                                          @foreach($my_class as $key)
                                            <option value="{{$key->class_id}}">
                                                {{$key->section}} - {{$key->subject}}
                                            </option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>

                             <div class="form-group">
                                  <label class="col-sm-3 control-label">Select Activity Type</label>
                                  <div class="col-sm-5">
                                      <select class="form-control" v-model="act_type">
                                          @foreach($activity_type as $key)
                                            <option value="{{$key->id}}">{{$key->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>

                             <!--  <div class="form-group">
                                  <label for="field-1" class="col-sm-3 control-label">Activity Schedule</label>
                                  <div class="col-sm-5">
                                      <input type="date" v-model="act_sched" class="form-control" id="field-1" placeholder="Placeholder"> </div>
                              </div> -->
                              <div class="form-group">
                                  <label for="field-2" class="col-sm-3 control-label">Duration Of Whole Activity Per Mins.</label>
                                  <div class="col-sm-5">
                                      <input type="number" v-model="duration" class="form-control" id="field-2" placeholder="Enter Minutes"> </div>
                              </div>
                             <!--  <div class="form-group">
                                  <label for="field-2" class="col-sm-3 control-label">Activity Deadline/Submission</label>
                                  <div class="col-sm-5">
                                      <input type="date" v-model="act_submussion" class="form-control" id="field-2" placeholder="Enter Minutes"> </div>
                              </div> -->
                              <div class="form-group">
                                  <label for="field-3" class="col-sm-3 control-label">Number Of Questions</label>
                                  <div class="col-sm-5">
                                      <input type="number" v-model="no_items" class="form-control" id="field-3" placeholder="Enter a number of items"> </div>
                              </div>
                             
                             
                              
                              <div class="form-group">
                                  <div class="col-sm-offset-2 col-sm-5">
                                      <button type="button" v-on:click="create" class="btn btn-info">Create</button>
                                  </div>
                              </div>
                          </form>
                   </div>
              </div>
             
          </div>

           <div class="col-md-12">
                <hr>
                  <div class="panel panel-dark" data-collapsed="0">
                    <!-- panel head -->
                    <div class="panel-heading">
                        <div class="panel-title">Activities</div>
                        <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                    </div>
                    <!-- panel body -->
                    <div class="panel-body" style="display: block;overflow-x:scroll;">
                  
                       <table class="table datatable" id="table-1">
                        
                          <colgroup span="3"></colgroup>
                          <thead>
                           <tr>
                              <th scope="colgroup">Section</th>
                              <th scope="colgroup">Sbjects</th>
                              <th scope="colgroup">Activity Type</th>
                              <th scope="colgroup">Number Of Question</th>
                              <th scope="colgroup">Total Score</th>
                              <th scope="colgroup">Status</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                              <tr v-for="key in activities">
                                  <td>@{{key.section}}</td>
                                  <td>@{{key.subject}}</td>
                                  <td>@{{key.act_type}}</td>
                                  <td>@{{key.number_items}}</td>
                                  <td>@{{key.total_score}}</td>
                                  <td>
                                    <span v-if="key.activity_status == 0" class='text-danger'>Deactivated</span>
                                    <span v-if="key.activity_status == 1" class='text-success'>Activated</span>
                                  </td>
                                  <td>
                                    <button class="btn btn-info btn-sm" v-on:click="view_question" :data-index="key.activities_id">
                                      View
                                    </button>
                                    <button title="delete" class="btn btn-danger btn-sm" v-on:click="delete_activity" :data-id="key.activities_id">
                                      <i class="fa fa-trash"></i>
                                    </button>
                                    <button v-if="key.activity_status != 1" :title="'activate '+key.act_type" :data-id="key.activities_id" v-on:click="activate_exam" class="btn btn-warning btn-sm">
                                      Activate Exam
                                    </button>
                                  </td>
                              </tr>
                            
                          </tbody>
                        </table>
                    </div>
                </div>

           </div>


        </div>

        <div class="col-md-12" v-if="isCreated && isViewQuestion == false">
            <button v-on:click="cancel" class="btn btn-primary">
               Cancel
            </button>
            <button class="btn btn-info" v-on:click="save">
                Save
            </button>
            
            
            <h3>
                Create Questionare              
            </h3>

           

            <div class="col-md-12">

                  <div class="panel-group joined" id="accordion-test">
                        <div class="panel panel-default" v-for="(list,index,key) in question">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion-test" :href="'#collapseOne-'+key">
                                    @{{index}}
                                  </a> 
                                  </h4> 
                              </div>
                            <div :id="'collapseOne-'+key" :class="'panel-collapse'+(key == 0 ?' collapse in':' collapse') ">
                                <div class="panel-body">
                                      <button class="btn btn-success btn-sm" v-on:click="add_question" :data-index="index">
                                          <i class="fa fa-plus"></i> Add Question
                                      </button>
                                      <br><hr>
                                       <div class="form-group" v-for="(list2,index1) in question[index]">
                                            <span class="badge badge-primary">
                                              @{{x=index1+1}}
                                            </span>
                                            <label>Question</label> 
                                            <button class="btn btn-danger btn-xs" v-on:click="remove_question" :delete-index="index" :data-index="index1">
                                                <i class="fa fa-times"></i>
                                            </button>

                                            <textarea class="form-control" v-model="list2.question" placeholder="What is your Question?"></textarea>
                                            <br>
                                            <label>
                                              Points Each Item:
                                            </label>
                                            <input type="number" maxlength="1" v-model="list2.points_each" class="form-control" style="max-width:100px;" name="">
                                            <br>
                                            <label>
                                              Answer Key:
                                            </label>
                                            <ol type="A">
                                              <li v-for="(list3,key,index) in list2.choices">
                                                  
                                                    <input type="radio" :name="'optionsRadios'+index1" :id="'selectAns'+(index1)+''+(index+1)" 
                                                    v-model="list2.best_ans" :value="key">
                                                    <textarea class="form-control" v-model="list2.choices[key]" placeholder="Answer"></textarea>
                                              </li>
                                            </ol>
                                        </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
              </div>

            <button class="btn btn-info col-xs-12" v-on:click="save">
                Save
            </button>
            


        </div>

        <div class="col-md-12" v-if="isCreated && isViewQuestion == true">
            <button v-on:click="cancel" class="btn btn-primary">
               <i class="fa fa-arrow-circle-left"></i> Back
            </button>
          <!--   <button class="btn btn-success" v-on:click="add_question">
                <i class="fa fa-plus"></i> Add Question
            </button> -->
            
            <h3>
                View Questionare         
            </h3>

            <div class="form-group" v-for="(list,index1) in question_view">

              <template v-if="list.isEdit">
                  <span class="badge badge-primary">
                  @{{x=index1+1}}
                  </span>
                  <label>Question</label> 
                 <!--  <button class="btn btn-danger btn-xs" v-on:click="remove_question" :data-index="index1">
                      <i class="fa fa-trash"></i>
                  </button> -->
                  <button class="btn btn-info btn-xs" v-on:click="save_question" :data-index="index1">
                      <i class="fa fa-save"></i>
                      Save Changes
                  </button>

                  <button class="btn btn-primary btn-xs" v-on:click="cancel_question" :data-index="index1">
                      <i class="fa fa-times"></i>
                      Cancel
                  </button>

                  <textarea style="font-size:25px;" class="form-control" v-model="list.question.value" placeholder="What is your Question?"></textarea>
                  <br>
                  <label>
                    Points Each Item:
                  </label>
                  <input type="number" maxlength="1" v-model="list.points_each" class="form-control" style="max-width:100px;" name="">
                  <br>
                  <label>
                    Answer Key:
                  </label>
                  <ol type="A">
                    <li v-for="(list2,key,index) in list.choices">
                          <input v-if="list.best_ans_id == list2.id" type="radio" :name="'optionsRadios'+index1" :id="'selectAns'+(index1)+''+(index+1)" v-model="list.best_ans_id" :value="list2.id">
                          <input v-if="list.best_ans_id != list2.id" type="radio" :name="'optionsRadios'+index1" :id="'selectAns'+(index1)+''+(index+1)" v-model="list.best_ans_id" :value="list2.id">
                          <textarea class="form-control" v-model="list.choices[key].value" :value="JSON.stringify(list.choices[key].value)" placeholder="Answer"></textarea>
                    </li>
                  </ol>
              </template>

              <template v-else>
                  <span class="badge badge-primary">
                    @{{x=index1+1}}
                  </span>
                  <label>Question</label> 
                  <!-- <button class="btn btn-danger btn-xs" v-on:click="remove_question" :data-index="index1">
                      <i class="fa fa-trash"></i>
                  </button> -->
                  <button class="btn btn-success btn-xs" v-show="list.isEdit == false" v-on:click="edit_question" :data-index="index1">
                      <i class="fa fa-pencil"></i>
                  </button>

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
                          <input disabled v-if="list.best_ans_id == list2.id" type="radio" :name="'optionsRadios'+index1" :id="'selectAns'+(index1)+''+(index+1)" v-model="list.best_ans_id" :value="list2.id">
                          <input disabled v-if="list.best_ans_id != list2.id" type="radio" :name="'optionsRadios'+index1" :id="'selectAns'+(index1)+''+(index+1)" v-model="list.best_ans_id" :value="list2.id">
                          <textarea disabled class="form-control" v-model="list.choices[key].value" :value="JSON.stringify(list.choices[key].value)" placeholder="Answer"></textarea>
                    </li>
                  </ol>
              </template>
                

               <!--  <div class="radio">
                    <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">Radio Input 1
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Radio Input 2
                    </label>
                </div> -->
            </div>

           
            


        </div>

          
        </div>
    
<script type="text/javascript">
 var app1  = new Vue({
                el: '#app',
                data: { 
                        activities:<?php echo $view_activities; ?>,
                        isCreated:false,
                        act_type:null,
                        act_sched:null,
                        act_submussion:null,
                        no_items:0,
                        question:null,
                        class_id:'',
                        duration:0,
                        x:0,
                        isViewQuestion:false,
                        question_view:null,
                        question_update_data:null,
                        pointers:[],
                        count:0,
                },
                created:function(){
                                      this.question_view = [{isEdit:false,question:{id:"",value:"What is this?"},best_ans_id:20, choices:{'a':{value:"adad",id:21},b:{value:"adad",id:20},c:{value:"adad",id:""},d:{value:"adad",id:""} },points_each:"20"}]
                },
                methods:{
                  delete_activity:function(e){
                    if(confirm("Are you sure you want to delete this activity?")){
                        id = e.currentTarget.getAttribute('data-id');
                        $.ajax({
                          url:'/delete_activity',
                          method:'post',
                          dataType:'json',
                          data:{
                            id:id
                          },
                          success:function(result){
                            app1.activities =result.activities;
                          }
                        });
                    }
                    

                  },
                  view_question:function(e){
                    this.isCreated=true;
                    this.isViewQuestion = true;

                    $.ajax({
                        url:'/get_question',
                        data:{
                          id:e.currentTarget.getAttribute('data-index')
                        },
                        dataType:'json',
                        method:'post',
                        success:function(result){
                          app1.question_view = result;
                        }
                          
                        });
                  },
                  activate_exam:function(e){
                     id = e.currentTarget.getAttribute('data-id');
                     $.ajax({
                        url:'/active_exam',
                        method:'post',
                        data:{
                          id:id,
                        },
                        dataType:'json',
                        success:function(result){
                          console.log(result);
                          app1.activities = result.activities;
                        }
                     });
                  },
                  cancel_question:function(e){
                    this.question_view[e.currentTarget.getAttribute('data-index')].isEdit = false;
                  },
                  save_question:function(e){
                    this.question_view[e.currentTarget.getAttribute('data-index')].isEdit = false;
                    console.log(data = this.question_view[e.currentTarget.getAttribute('data-index')]);

                    $.ajax({
                        url:'/update_question',
                        data:{
                          data:data,
                        },
                        dataType:'json',
                        method:'post',
                        success:function(result){
                          // app1.question_view = result;
                        }
                          
                        });
                  }
                  ,
                  edit_question:function(e){
                    this.question_view[e.currentTarget.getAttribute('data-index')].isEdit = true;
                  },
                  remove_question:function(e){
                    if(this.question[e.currentTarget.getAttribute('delete-index')].length > 1){
                      if(confirm("Are you sure want to remove this question?")){
                        this.question[e.currentTarget.getAttribute('delete-index')].splice(parseInt(e.currentTarget.getAttribute('data-index')),1);
                      }
                    }else{
                      alert("Can't remove this question only 1 remain");
                    }

                      temp1 = this.question;
                      this.question = [];
                      this.question = temp1;  
                  },
                  add_question:function(e){
                   
                    this.question[e.currentTarget.getAttribute('data-index')].push({question:'',choices: {a:'',b:'',c:'',d:''},best_ans:'',points_each:'',pointers_id:this.question[e.currentTarget.getAttribute('data-index')][0].pointers_id});
                    temp1 = this.question;
                    this.question = [];
                    this.question = temp1;                  
                  },
                  create:function(){
                     this.isCreated = true;
                     this.isViewQuestion=false

                     this.question={};

                    // for(i=1;i<=parseInt(this.no_items); i++){
                    //   this.question.push({question:'',choices: {a:'',b:'',c:'',d:''},best_ans:'',points_each:''});
                    // }

                    $.ajax({
                        url:'/get_pointers/'+app1.class_id,
                        dataType:'json',
                        method:'get',
                        async:false,
                        success:function(result){

                          app1.pointers =result.result;
                        }
                          
                        });

                        for(i=0; i<this.pointers.length;i++){
                      //txt = '{"'+lds[i].name+'":'+'[]'+'}';
                      this.question[this.pointers[i].name] = []
                       for(x=1;x<=parseInt(this.no_items); x++){
                        
                          this.question[this.pointers[i].name].push({question:'',choices: {a:'',b:'',c:'',d:''},best_ans:'',points_each:'',pointers_id:this.pointers[i].id});
                       }
                           
                    }



                  },cancel:function(){
                     this.isCreated = false;
                  },
                  save:function(){
                    // alert();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var q = app1.question;

                    $.ajax({
                      url:'/create_questionare',
                      method:'post',
                      data:{
                          question:q,
                          activity_type_id:app1.act_type,
                          act_sched:app1.act_sched,
                          act_deadline:app1.act_submussion,
                          class_id:app1.class_id,
                          duration:app1.duration,
                      },
                      success:function(result){
                          alert("Question Created");
                         location.href="/create_activity";
                      }
                    });
                  },
                }
            });
</script>

    @section('sidebar')
         <li>
            <a href="/">
                <i class="entypo-home"></i>
                <span class="title">Home</span>
            </a> 
         
        </li>
         <li  class="active">
            <a href="/create_activity">
                <i class="entypo-plus-circled"></i>
                <span class="title">Create Activity</span>
            </a> 
         
        </li>
        <li> 
            <a href="/my_class_record"><i class="entypo-book"></i><span class="title">My Class Record</span></a> 
        </li>
        <li> 
            <a href="/activities_result"><i class="entypo-clipboard"></i><span class="title">Activities Result</span></a> 
        </li>
    @endsection

    @endsection