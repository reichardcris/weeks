 @extends('layouts.app2')

@section('content')
 <h2>Teacher/My Class Record/</h2>

    
<div class="panel panel-dark" data-collapsed="0" id="app">
            <!-- panel head -->
            <div class="panel-heading">
                <div class="panel-title">Dark Panel (collapsed)</div>
                <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
            </div>
            <!-- panel body -->
            <div class="panel-body" style="display: block;">
                  <table class="table" id="table-1">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Student Name</th>
                              <th>Written Work (25%)</th>
                              <th>PERFORMANCE TASK(50%)</th>
                              <th>QUARTERLY ASSESSMENT(25%)</th>
                              <th>Total Percentage</th>
                              <th> </th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-for="(list,index) in grades">
                              <td>@{{index+1}}</td>
                              <td>@{{list.student_name}}</td>
                              <td>@{{Math.round(list.written_work)}}%</td>
                              <td>@{{list.performance_task}}</td>
                              <td>@{{list.quarter_assessment}}</td>
                              <td>@{{Math.round(list.total_percentage_of_all)}} %</td>
                              <td>
                                <button class="btn btn-success" v-on:click="modal" :data-index="index"><i class="fa fa-edit"></i></button>
                              </td>
                          </tr>
                          
                      </tbody>
                  </table>
            </div>


              <div class="modal fade" id="modal-1" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Update Each Percentage</h4> </div>
                    <div class="modal-body">
                        <div class="form-group">
                          <label>PERFORMANCE TASK(50%)</label>
                            <input class="form-control" type="text" v-model="grades[index].performance_task" name="">
                            <br>
                             <label>QUARTERLY ASSESSMENT(25%)</label>
                            <input class="form-control" type="text" v-model="grades[index].quarter_assessment" name="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" v-on:click="save" class="btn btn-info">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        </div>

        



     <script type="text/javascript">
      var app = new Vue({
          el:"#app",
          data:{
            grades:<?php echo $grades; ?>,
            index:0,
          },
          methods:{
            save:function(e){
              
              var id =this.grades[this.index].enrolled_class_id;
              performance_task = this.grades[this.index].performance_task;
              quarter_assessment = this.grades[this.index].quarter_assessment;
              if(performance_task >50 || quarter_assessment >25){
                alert("Percentage Maximum Require");
                return null;
              }
              $.ajax({
                url:'/update_percentage',
                method:'post',
                dataType:'json',
                data:{
                  performance_task:performance_task,
                  quarter_assessment:quarter_assessment,
                  id:id
                },
                success:function(result){
                    $('#modal-1').modal('hide');
                    location.reload();
                    if(!result.result){
                      alert("Something went wrong!");
                    }
                }
              });

            },
              modal:function(e){
              this.index = parseInt(e.currentTarget.getAttribute('data-index'));
              $('#modal-1').modal();
          }
          },

      });
    </script>
    <script type="text/javascript">
          jQuery(document).ready(function($) {
            var $table1 = jQuery('#table-1');
            $table1.DataTable({
              "aLengthMenu": [
                  [10, 25, 50, -1],
                  [10, 25, 50, "All"]
              ],
              
          });
          // Initalize Select Dropdown after DataTables is created
          // $table1.closest('.dataTables_wrapper').find('select').select2({
          //     minimumResultsForSearch: -1
          // });    
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
        <li class="active"> 
            <a href="/my_class_record"><i class="entypo-book"></i><span class="title">My Class Record</span></a> 
        </li>
       <!--  <li> 
            <a href="index.html#"><i class="entypo-clipboard"></i><span class="title">Scheduling</span></a> 
        </li> -->
    @endsection

    @endsection