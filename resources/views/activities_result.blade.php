 @extends('layouts.app2')

@section('content')
 

    <div class="row" id="app">
        

    
                  <template v-if="temp1">
                    <h2 class="content">Teacher/Activities Result</h2>
                      <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
                          <div class="col-md-12 col-md-offset-0">
                              <div class="panel panel-dark" data-collapsed="0">
                                  <!-- panel head -->
                                  <div class="panel-heading">
                                      <div class="panel-title">My Classes</div>
                                     
                                      <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                                  </div>
                                  <!-- panel body -->
                                  <div class="panel-body" style="display: block;overflow-x:scroll;">
                                      
                                     <table class="table datatable" id="table-1">
                                      
                                        <thead>
                                            <th>ID</th>
                                            <th>Section</th>
                                            <th>Sbjects</th>
                                            <th>Number Of Student</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach($myClasses as $key)
                                              <tr>
                                                  <td>{{$key->class_id}}</td>
                                                  <td>{{$key->section}}</td>
                                                  <td>{{$key->subject}}</td>
                                                  <td>{{$key->number_student}}</td>
                                                  <td>
                                                    <button v-on:click="view" data-id="{{$key->class_id}}" data-subject="{{$key->subject}}" class="btn btn-info btn-sm">
                                                       View Performance Each Student
                                                    </button>
                                                  </td>
                                              </tr>                 
                                            @endforeach
                                        </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </template>

                  <template v-if="temp2">
                        
                        <h2 class="content">Teacher/Activities Result/@{{subject}}</h2>
                        <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
                          <div class="col-md-12 col-md-offset-0">
                              <div class="panel panel-dark" data-collapsed="0">
                                  <!-- panel head -->
                                  <div class="panel-heading">
                                      <div class="panel-title">My Student Performance</div>
                                     
                                      <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                                  </div>
                                  <!-- panel body -->
                                  <div class="panel-body" style="display: block;overflow-x:scroll;">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>
                                                        
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                    <tr v-for="list in my_student">
                                                        <td>@{{list.id}}</td>
                                                        <td>@{{list.name}}</td>
                                                        <td>
                                                            @{{list.email}}
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-success" href="#" :data-id="list.id" v-on:click="view_graph">
                                                                View Activies Result
                                                            </a>
                                                            
                                                        </td>
                                                    </tr>
                                               
                                            </tbody>
                                        </table>
                                     
                                  </div>
                              </div>
                          </div>
                      </div>
                  </template>

                  
         




    </div>




<script type="text/javascript">

var app = new Vue({
  el:'#app',
  data:{
    messages:[1,2,3,4],
    temp1:true,
    temp2:false,
    temp3:false,
    my_student:null,
    subject:null,
  },
  methods:{
    view:function(e){
       
       var id =e.currentTarget.getAttribute('data-id'); 
       var subject =e.currentTarget.getAttribute('data-subject'); 
       $.ajax({
          url:'/get_my_student/'+id,
          method:'get',
          dataType:'json',
          success:function(result){
            app.my_student = result;
            app.temp1 = false;
            app.temp2 = true;
            app.subject =subject;
          }
       });

    },
    view_graph:function(e){
      location.href="/view_graph/"+e.currentTarget.getAttribute('data-id')+"/"+this.subject;
    }
  
  },
    
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