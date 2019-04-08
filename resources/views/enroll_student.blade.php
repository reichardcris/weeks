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
    <li class="active"> 
        <a href="/enrollStudent"><i class="entypo-book"></i><span class="title">Enroll Student</span></a> 
    </li>
    <li > 
        <a href="/scheduling"><i class="entypo-clipboard"></i><span class="title">Assign Teachers</span></a> 
    </li>
@endsection

@section('content')
	
	<h1>Admin/Enroll Student</h1>
	<div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12" id="app1">
        <div class="col-md-12 col-lg-12" v-show="isTableShow">
            <table class="table table-bordered datatable" id="table-1">
                <thead>
                    <tr>
                        
                        <th>ID #</th>
                        <th data-hide="phone">Name</th>
                        <th data-hide="phone">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd gradeX" v-show="studenstData != null" v-for="(key,index) in studenstData">
                        <td>@{{key.id}}</td>
                        <td>@{{key.name}}</td>
                        <td>
                            <button class="btn btn-primary" v-on:click="enroll_student_button(key.id)">
                                Enroll Student
                            </button>
                        </td>
                    </tr>
                 </tbody>
                </table>
        </div>

        <div class="col-md-12 col-lg-12" v-show="isStudentProfileShow">
          <button class="btn btn-primary" v-on:click="back_button">Back</button>
            <div class="profile-env">
                <header class="row">
                    <div class="col-sm-2">
                        <a href="#" class="profile-picture"> <img src="../../assets/images/profile-picture.png" class="img-responsive img-circle"> </a>
                    </div>
                    <div class="col-sm-7">
                        <ul class="profile-info-sections">
                            <li>
                                <div class="profile-name"> <strong> <a href="#">@{{student_data.name}}</a> <a href="#" class="user-status is-online tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Online"></a> </strong> <span><a href="#">Student</a></span> </div>
                            </li>
                           <!--  <li>
                                <div class="profile-stat">
                                    <h3>8</h3> <span><a href="#"> Subject(s)</a></span> </div>
                            </li> -->
                           <!--  <li>
                                <div class="profile-stat">
                                    <h3>108</h3> <span><a href="#">following</a></span> </div>
                            </li> -->
                        </ul>
                    </div>
                    <!-- <div class="col-sm-3">
                        <div class="profile-buttons">
                            <a href="#" class="btn btn-default"> <i class="entypo-user-add"></i> Follow
                            </a>
                            <a href="#" class="btn btn-default"> <i class="entypo-mail"></i> </a>
                        </div>
                    </div> -->
                </header>
                <section class="profile-info-tabs">
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <ul class="user-details">
                                <li>
                                    <a href="#"> <i class="entypo-location"></i> Prishtina
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <i class="entypo-suitcase"></i> Works as <span>Laborator</span> </a>
                                </li>
                                <li>
                                    <a href="#"> <i class="entypo-calendar"></i> 16 October
                                    </a>
                                </li>
                            </ul>
                            <!-- tabs for the profile links -->
                            <!-- <ul class="nav nav-tabs">
                                <li class="active"><a href="#profile-info">Profile</a></li>
                                <li><a href="#biography">Bio</a></li>
                                <li><a href="#profile-edit">Edit Profile</a></li>
                            </ul> -->
                        </div>
                    </div>
                </section>
                <section class="profile-feed">
                    <!-- profile post form -->
                        <div class="panel panel-default panel-shadow" data-collapsed="0">
                          <!-- to apply shadow add class "panel-shadow" -->
                          <!-- panel head -->
                          <div class="panel-heading">
                              <div class="panel-title">Schedules And Subjects</div>
                              <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-3" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                          </div>
                          <!-- panel body -->
                          
                                <table class=" table-bordered datatable" id="table-2">
                            <thead>
                                <tr>
                                    <th data-hide="phone">Section</th>
                                    <th data-hide="phone">Subject</th>
                                    <th data-hide="phone">Teacher</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="key in schedule">
                                    <td>@{{key.section}}</td>
                                    <td>@{{key.subject}}</td>
                                    <td>@{{key.teacher}}</td>
                                    <td>
                                        <button class="btn btn-info" v-on:click="enroll_now(key.class_id)">
                                            Enroll Now
                                        </button>
                                    </td>
                                </tr>
                             </tbody>
                            </table>    
                           
                      </div>

                      <div class="panel panel-default panel-shadow" data-collapsed="0">
                          <!-- to apply shadow add class "panel-shadow" -->
                          <!-- panel head -->
                          <div class="panel-heading">
                              <div class="panel-title">Enrolled Subjects</div>
                              <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-3" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                          </div>
                          <!-- panel body -->
                          
                                <table class=" table-bordered datatable" id="table-3">
                            <thead>
                                <tr>
                                    <th data-hide="phone">Section</th>
                                    <th data-hide="phone">Subject</th>
                                    <th data-hide="phone">Teacher</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                             </tbody>
                            </table>    
                           
                      </div>
                        
                    <!-- profile stories -->
                    
                </section>
            </div>
        </div>
    </div>
</div>

  
  <script type="text/javascript">
    var $table3=null;
      jQuery(document).ready(function($) {
           $table1= jQuery('#table-1');
          var $table2 = jQuery('#table-2');
           $table3 = jQuery('#table-3');
          // Initialize DataTable
          $table1.DataTable({
              "aLengthMenu": [
                  [10, 25, 50, -1],
                  [10, 25, 50, "All"]
              ],
              "bStateSave": true,
              
          });
          // Initalize Select Dropdown after DataTables is created
          $table1.closest('.dataTables_wrapper').find('select').select2({
              minimumResultsForSearch: -1
          });

          $table2.DataTable({
              "aLengthMenu": [
                  [10, 25, 50, -1],
                  [10, 25, 50, "All"]
              ],
              "bStateSave": true
          });

           $table2.closest('.dataTables_wrapper').find('select').select2({
              minimumResultsForSearch: -1
          });

           $table3.DataTable({
              "aLengthMenu": [
                  [10, 25, 50, -1],
                  [10, 25, 50, "All"]
              ],
              "bStateSave": true
          });

           $table3.closest('.dataTables_wrapper').find('select').select2({
              minimumResultsForSearch: -1
          });
      });
  </script>
  <script type="text/javascript">

  	$('#add_schedule').click(function(){
  		// alert();
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
  				$('#modal-1').modal('hide');
  				// console.log(result.schedule);
  			}
  		});

  	});
  	
  	var StudentTable  = new Vue({
      el: '#app1',
      data: {
              data:[],
              isTableShow:true,
              isStudentProfileShow:false,
              studenstData:<?php echo $students; ?>,
              schedule:<?php echo $schedule; ?>,
              enrolledSubjectData:null,
              student_data:{
                  "id": 0, 
                  "name": "",
                  "email": "",
                  "email_verified_at": null,
                  "created_at": "",
                  "updated_at": "",
                  "role": 3
              },
          },

       methods:{  
          enroll_student_button:function(id){
              $.ajax({
                url:'get_Student?id='+id,
                method:'get',
                dataType:'json',
                success:function(result){
                   StudentTable.student_data =result.student_data;
                   StudentTable.enrolledSubjectData =result.enrolled_subject;
                   jQuery('#table-3').dataTable().fnClearTable();
                   for(i=0;i<result.enrolled_subject.length; i++){
                     jQuery('#table-3').dataTable().fnAddData([result.enrolled_subject[i].section,result.enrolled_subject[i].subject,result.enrolled_subject[i].teacher,'<button class="btn btn-primary" onclick="drop_subject('+result.enrolled_subject[i].enrolled_class_id+')">Drop</button>']);
                   }
                   console.log(result);
                }
              });            

             this.isTableShow=false;
             this.isStudentProfileShow=true;
          },
          back_button:function(){

             this.isTableShow=true;
             this.isStudentProfileShow=false;
          },
          enroll_now:function(id){
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

                 $.ajax({
                  url:'/enroll_this_student',
                  method:'post',
                  dataType:'json',
                  data:{
                    student_id:StudentTable.student_data.id,
                    class_id:id
                  },
                  success:function(result){
                     // StudentTable.enrolledSubjectData =result.enrolled_subject;
                      jQuery('#table-3').dataTable().fnClearTable();
                     for(i=0;i<result.enrolled_subject.length; i++){
                     jQuery('#table-3').dataTable().fnAddData([result.enrolled_subject[i].section,result.enrolled_subject[i].subject,result.enrolled_subject[i].teacher,'<button class="btn btn-primary" onclick="drop_subject('+result.enrolled_subject[i].enrolled_class_id+')">Drop</button>']);
                   }
                  }
              });
              
          }
       }
            });

    function drop_subject(id){
    
        if(confirm("Are you sure you want to drop this subject?")){
          
         $.ajax({
                  url:'/drop_subect',
                  method:'post',
                  dataType:'json',
                  data:{
                    student_id:StudentTable.student_data.id,
                    id:id
                  },
                  success:function(result){
                     // StudentTable.enrolledSubjectData =result.enrolled_subject;
                      jQuery('#table-3').dataTable().fnClearTable();
                     for(i=0;i<result.enrolled_subject.length; i++){
                     jQuery('#table-3').dataTable().fnAddData([result.enrolled_subject[i].section,result.enrolled_subject[i].subject,result.enrolled_subject[i].teacher,'<button class="btn btn-primary" onclick="drop_subject('+result.enrolled_subject[i].enrolled_class_id+')">Drop</button>']);
                   }
                  }
              });
        }
    }

  </script>
@endsection