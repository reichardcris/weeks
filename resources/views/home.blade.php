@extends('layouts.app2')

@section('content')


@if(auth()->user()->role == 1)
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
<script>
    var socket = io('http://127.0.0.1:3000');

    socket.on('channel-testing:App\\Events\\UserSign',function(data){
        console.log(data);
    }.bind(this));
</script>
<h1>Welcome Admin!</h1>
<div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12">
        <div class="panel panel-default panel-shadow" data-collapsed="0">
            <!-- to apply shadow add class "panel-shadow" -->
            <!-- panel head -->
            <div class="panel-heading">
                <div class="panel-title">Registered Users</div>
                <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-3" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
            </div>
            <!-- panel body -->
            <div class="panel-body" style="overflow-y:scroll;">
                <table class="table responsive">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key)
                        <tr>
                            <td>{{$key->id}}</td>
                            <td>{{$key->name}}</td>
                            <td>{{$key->email}}</td>
                            <td>{{ ( $key->role == 2 ? 'Teacher' : ($key->role == 3 ?' Student' : '') ) }}</td>
                            <td>
                               <a class="btn btn-primary" href="/profile/{{$key->id}}">
                                   View Profile
                               </a>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
        <div id="app_subject" class="panel panel-default panel-shadow" data-collapsed="0">
            <!-- to apply shadow add class "panel-shadow" -->
            <!-- panel head -->
            <div class="panel-heading">
                <div class="panel-title">Subjects</div>
                <div class="panel-options">
                     <a href="#" onclick="jQuery('#modal-2').modal('show');"> 
                        <i class="entypo-plus"></i>add Subject
                    </a> 
                </div>
            </div>
            <!-- panel body -->
            <div class="panel-body" style="overflow-y:scroll;">
                <table class="table responsive">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <tr v-for="list in subject">
                            <td>@{{list.id}}</td>
                            <td>@{{list.name}}</td>
                            <td>
                                <button v-on:click="edit_subject" :data="JSON.stringify({opt:'subject',id:list.id,name:list.name})" class="btn btn-success btn-md">
                                    Edit
                                </button>
                                <!-- <button type="button" class="btn btn-info">View Pointers</button> -->
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="app_section" class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
        <div class="panel panel-default panel-shadow" data-collapsed="0">
            <!-- to apply shadow add class "panel-shadow" -->
            <!-- panel head -->
            <div class="panel-heading">
                <div class="panel-title">
                    Section
                    
                </div>
                <div class="panel-options">
                     <a href="#" onclick="jQuery('#modal-1').modal('show');"> <i class="entypo-plus"></i>add section</a> 

                </div>

            </div>
            <!-- panel body -->
            <div class="panel-body" style="overflow-y:scroll;">
                <table class="table responsive">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($section) <=0)
                           <th> No Section Yet.</th>
                        @endif
                        
                        <tr v-for="key in section">
                            <td>@{{key.id}}</td>
                            <td>
                                @{{key.name}}
                            </td>
                            <td>
                                
                                <button v-on:click="edit_section" id="edit_section" :data="JSON.stringify({opt:'section',id:key.id,name:key.name})" class="btn btn-success btn-md">
                                    Edit
                                </button>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Section</h4> </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Section:</label>
                            <input type="" id="section_name" name="section_name" placeholder="Section Name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="add_section" class="btn btn-info">Add</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Subject</h4> </div>
                <div class="modal-body" id="app_pointers">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Subject:</label>
                            <input type="" id="subject_name" name="subject_name" placeholder="Subject Name" class="form-control">
                        </div>
                        
                        <div class="col-md-12">
                            <hr>
                            <label>Subject Pointers:</label>
                            <br>
                            <label>Pointers Name</label>
                            <input type="text" id="pointers_name" name="pointers_name" v-model="pointer_name" placeholder="Pointers Name" class="form-control">
                            <br>
                            <label>Percentage:</label>
                            <input type="number" id="pointer_percentage" name="pointer_percentage" v-model="percentage" placeholder="Pointer Percentage" class="form-control">
                            <br>
                            <button class="btn btn-primary col-xs-12" v-on:click="add_pointers">
                                + Add Pointers
                            </button>
                            <br><br>
                            <table class="table table-bordered">
                                <thead>
                                    <th>Pointers Name</th>
                                    <th>Percentage (@{{
                                        (data_pointer.length > 1 ?total_percentage:0)}}%)</th>
                                </thead>
                                <tbody>
                                    <tr v-for="list in data_pointer">
                                        <td>@{{list.name}}</td>
                                        <td>@{{list.percentage}}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="add_subject" class="btn btn-info">Add</button>
                </div>
            </div>
        </div>
    </div>
    
   
    <div  class="modal fade" id="modal-3">
        <div class="modal-dialog">
            <div class="modal-content" id="app_edit">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Update @{{message.opt}}</h4> </div>
                <div class="modal-body">
                    <div class="row" >
                        <div class="col-md-12">
                            <label>@{{message.opt}}:</label>
                            <input type="" v-model="message.name" name="subject_name" placeholder="Subject Name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button v-on:click="save" type="button" id="add_subject" class="btn btn-info">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
           

           //$('#edit_section').click(function(){
               // alert();
             //   console.log($(this).prop('data'));
          /// });
         

           $('#add_section').click(function(){
            var section = $('#section_name').val();
           
                if(section != ''){
                    $.ajax({
                        url:'/add_section',
                        method:'post',
                        data:{
                            name:section
                        },
                        dataType:'json',
                        success:function(result){
                            console.log(result);
                            if(result.response){
                                $('#section_name').val('');
                                $('#modal-1').modal('hide');
                                app1.section = result.section;
                            }
                        }
                    });
                }else{
                    alert('Please Enter Section Name!');
                }
           });

           $('#add_subject').click(function(){
            var subject = $('#subject_name').val();
           
                if(subject != '' && app_pointers.data_pointer.length != 0){
                    $.ajax({
                        url:'/add_subject',
                        method:'post',
                        data:{
                            name:subject,
                            pointers:app_pointers.data_pointer
                        },
                        dataType:'json',
                        success:function(result){
                            console.log(result);
                            if(result.response){
                                $('#subject_name').val('');
                                $('#modal-2').modal('hide');
                                app2.subject = result.subject;
                            }
                        }
                    });
                }else{
                    alert('Please Enter Section Name!');
                }
           });
            var app3=null;
           var app1  = new Vue({
                el: '#app_section',
                data: {
                        message: 'Hello Vue!',
                        section:<?php echo $section; ?>
                    },
                methods:{
                    edit_section:function(e){
                         console.log(e.currentTarget.getAttribute('data'));
                         app3.message = JSON.parse(e.currentTarget.getAttribute('data'));
                         $('#modal-3').modal('show');
                    }
                }
            });


           var app_pointers  = new Vue({
                el: '#app_pointers',
                data: {
                        pointer_name:'',
                        percentage:0,
                        data_pointer:[],
                    },
                methods:{
                    add_pointers:function(e){
                         this.data_pointer.push({name:this.pointer_name,percentage:this.percentage});
                    }
                },
                computed:{
                    total_percentage:function(){
                        sum = this.data_pointer.reduce(function add(b, a) {
                                    return {percentage:parseInt(b.percentage) + parseInt(a.percentage)};
                            });
                        return sum.percentage;
                    }
                }
            });

           var app2  = new Vue({
                el: '#app_subject',
                data: {
                        message: 'Hello Vue!',
                        subject:<?php echo $subjects; ?>
                    },
                methods:{

                    edit_subject:function(e){
                         console.log(e.currentTarget.getAttribute('data'));
                         app3.message = JSON.parse(e.currentTarget.getAttribute('data'));
                         $('#modal-3').modal('show');
                    }

                }
            });

           app3  = new Vue({
                el: '#app_edit',
                data: {
                        message:{name:'',id:'',opt:''},
                    },
                methods:{
                    save:function(){
                        $.ajax({
                            url:'/update_sub_sec',
                            method:'post',
                            dataType:'json',
                            data:{
                                data:app3.message
                            },
                            success:function(result){
                                if(app3.message.opt == "subject"){
                                    app2.subject = result;
                                }else{
                                    app1.section = result;
                                }
                                
                            }
                        });
                    }
                }
            });


        </script>

    @section('sidebar')
        <li class="active">
            <a href="/">
                <i class="entypo-home"></i>
                <span class="title">Home</span>
            </a> 
        </li>
         <li>
            <a href="/register">
                <i class="entypo-user-add"></i>
                <span class="title">Add User</span>
            </a> 
        </li>
        <li> 
            <a href="/enrollStudent"><i class="entypo-book"></i><span class="title">Enroll Student</span></a> 
        </li>
        <li > 
            <a href="/scheduling"><i class="entypo-clipboard"></i><span class="title">Assign Teachers</span></a> 
        </li>
    @endsection

@endif



<!-- Teacher -->
@if(auth()->user()->role == 2)
    <h1>Welcome Teacher!</h1>

    <div class="row">
        <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-dark" data-collapsed="0">
                    <!-- panel head -->
                    <div class="panel-heading">
                        <div class="panel-title">My Class and Schedule</div>
                        <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                    </div>
                    <!-- panel body -->
                    <div class="panel-body" style="display: block;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Section</th>
                                    <th>Subject</th>
                                    <th>Number of Student</th>
                                    <th>
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myClasses as $key)
                                    <tr>
                                        <td>{{$key->section}}</td>
                                        <td>{{$key->subject}}</td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{$key->number_student}}
                                            </span>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="/view_my_classes_by_id/{{$key->class_id}}">
                                                View
                                            </a>
                                            <a class="btn btn-info" href="/my_class_record/{{$key->class_id}}">
                                                View Class Record
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('sidebar')
         <li class="active">
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
        <li> 
            <a href="/my_class_record"><i class="entypo-book"></i><span class="title">My Class Record</span></a> 
        </li>
        <li> 
            <a href="/activities_result"><i class="entypo-clipboard"></i><span class="title">Activities Result</span></a> 
        </li>
    @endsection

@endif


<!-- Student -->
@if(auth()->user()->role == 3)
    <h1>Welcome Student!</h1>

    <div class="row">
        <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-dark" data-collapsed="0">
                    <!-- panel head -->
                    <div class="panel-heading">
                        <div class="panel-title">My Subjects</div>
                        <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                    </div>
                    <!-- panel body -->
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Section</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student_subject as $key)
                                    <tr>
                                        <td>{{$key->section}}</td>
                                        <td>{{$key->subject}}</td>
                                        <td>{{$key->teacher}}</td>
                                    </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('sidebar')
         <li class="active">
            <a href="/">
                <i class="entypo-home"></i>
                <span class="title">Home</span>
            </a> 
         
        </li>
         <li>
            <a href="/my_activities">
                <i class="entypo-folder"></i>
                <span class="title">My Activity</span>
            </a> 
         
        </li>


        <li>
            <a href="/my_grades">
                <i class="entypo-star-empty"></i>
                <span class="title">My Grades</span>
            </a> 
         
        </li>
       <!--  <li> 
            <a href="index.html#"><i class="entypo-clipboard"></i><span class="title">Scheduling</span></a> 
        </li> -->
    @endsection

@endif

@endsection

