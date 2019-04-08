 @extends('layouts.app2')

@section('content')
 <h2>Student/My Grades</h2>

    <div class="row">
        <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-dark" data-collapsed="0">
                    <!-- panel head -->
                    <div class="panel-heading">
                        <div class="panel-title">Grades Each Class</div>
                        <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                    </div>
                    <!-- panel body -->
                    <div class="panel-body" style="display: block;overflow-x:scroll;">
                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                var $table1 = jQuery('#table-1');
                                $table1.DataTable({
                                  "aLengthMenu": [
                                      [10, 25, 50, -1],
                                      [10, 25, 50, "All"]
                                  ],
                                  
                              });
                              Initalize Select Dropdown after DataTables is created
                              $table1.closest('.dataTables_wrapper').find('select').select2({
                                  minimumResultsForSearch: -1
                              });    
                            });
                            

                        </script>
                       <table class="table datatable" id="table-1">
                        
                          <thead>
                              <th>Section</th>
                              <th>Sbjects</th>
                              <th>Teacher</th>
                              <th>WRITTEN WORK (25%)</th>
                              <th>PERFORMANCE TASK (50%)</th>
                              <th>QUARTERLY ASSESSEMNT (25%)</th>
                              <th>Total Percentage</th>
                              <th></th>
                          </thead>
                          <tbody>
                            @foreach($grades as $key)
                                  <tr>
                                    <td>{{$key->section}}</td>
                                    <td>{{$key->subject}}</td>
                                    <td>{{$key->teacher_name}}</td>
                                    <td>{{round($key->written_work)}} %</td>
                                    <td>{{round($key->performance_task)}} %</td>
                                    <td>{{round($key->quarter_assessment)}} %</td>
                                    <td>{{round($key->total_percentage_of_all)}} %</td>
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
         <li>
            <a href="/">
                <i class="entypo-home"></i>
                <span class="title">Home</span>
            </a> 
         
        </li>
         <li >
            <a href="/my_activities">
                <i class="entypo-folder"></i>
                <span class="title">My Activity</span>
            </a> 
         
        </li>


       <li class="active">
            <a href="/my_grades">
                <i class="entypo-star-empty"></i>
                <span class="title">My Grades</span>
            </a> 
         
        </li>
       
    @endsection

    @endsection