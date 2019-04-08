@extends('layouts.app2')
  @section('sidebar')
  
         <li >
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
        <li class="active"> 
            <a href="/scheduling"><i class="entypo-clipboard"></i><span class="title">Assign Teachers</span></a> 
        </li>
    @endsection


@section('content')
	
	<h1>Admin/Assign Teachers</h1>
	<div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12">
        <div class="panel panel-default panel-shadow" data-collapsed="0">
            <!-- to apply shadow add class "panel-shadow" -->
            <!-- panel head -->
            <div class="panel-heading">
                <div class="panel-title">Schedules</div>
                <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-3" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
            </div>
            <!-- panel body -->
            <div class="panel-body" style="overflow-y:scroll;">
                <table id="app2" class="table responsive">
                    <thead>
                        <tr>
                            <th>Section Name</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th># Of Student Enrolled</th>
                            <th>
                            	<button class="btn btn-default" onclick="$('#modal-1').modal('show')">
                            		<i class="entypo-plus-circled"></i>Assign
                            	</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <tr v-for="key,index in data">
                          <td>@{{key.section}}</td>
                          <td>@{{key.subject}}</td>
                          <td>@{{key.teacher}}</td>
                          <td>@{{key.number_student}}</td>
                          <td>
                          		<!-- <button class="btn btn-primary">Enroll Student</button> -->
                          		<a :href="'view_my_classes_by_id_admin/'+key.class_id" class="btn btn-info">View Class</a>
                              
                                <button v-if="parseInt(key.number_student) == 0" :index="index" :data-id="key.class_id" v-on:click="delete_assign" class="btn btn-danger btn-xs">
                                  <i class="entypo-trash"></i>
                                  delete
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
                    <h4 class="modal-title">Add Schedule</h4> </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Section:</label>
                            <select class="form-control" id="section_id">
                            	@foreach($section as $key)
                            		<option value="{{$key->id}}">{{$key->name}}</option>
                            	@endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                        	 <br>
                            <label>Subject:</label>
                            <select class="form-control" id="subject_id">
                            	@foreach($subject as $key)
                            		<option value="{{$key->id}}">{{$key->name}}</option>
                            	@endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                        	 <br>
                            <label>Teacher:</label>
                            <select class="form-control" id="teacher_id">
                            	@foreach($teacher as $key)
                            		<option value="{{$key->id}}">{{$key->name}}</option>
                            	@endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="app3">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" v-on:click="add_schedule" class="btn btn-info">Add</button>
                </div>
            </div>
        </div>
    </div>
  <script type="text/javascript">

  	// $('#add_schedule').click(function(){
  	// 	// alert();
  		

  	// });
  	
  	var app2  = new Vue({
                el: '#app2',
                data: {
                        data:<?php echo $schedule; ?>,
                    },
                methods:{
                  delete_assign:function(e){
                    var index = parseInt(e.currentTarget.getAttribute('index'));
                      if(confirm("Are you sure want yo delete this ?")){
                        
                          $.ajax({
                            url:'/delete_assign',
                            method:'post',
                            dataType:'json',
                            data:{
                              id:e.currentTarget.getAttribute('data-id')
                            },
                            success:function(result){
                              app2.data.splice(index,1);
                         
                            }
                          });
                      }
                  }
                }
            });

      var app3= new Vue({
                el: '#app3',
                data: {
                       
                    },
                methods:{
                  add_schedule:function(){
                    var subject_id = $('#subject_id').val();
                    var section_id = $('#section_id').val();
                    var teacher_id = $('#teacher_id').val();

                    $.ajax({
                      url:'/add_schedule',
                      method:'post',
                      dataType:'json',
                      data:{
                        subject_id:subject_id,
                        section_id:section_id,
                        teacher_id:teacher_id
                      },
                      success:function(result){
                        app2.data = result.schedule;
                        $('#teacher_id').val('');
                        $('#section_id').val('');
                        $('#subject_id').val('');
                        $('#modal-1').modal('hide');
                        // console.log(result.schedule);
                      }
                    });
                  }
                }
            });
  </script>
@endsection