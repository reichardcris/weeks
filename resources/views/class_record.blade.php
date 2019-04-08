 @extends('layouts.app2')

@section('content')
 <h2>Teacher/Class Record</h2>

    <div class="row">
        <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-dark" data-collapsed="0">
                    <!-- panel head -->
                    <div class="panel-heading">
                        <div class="panel-title">Percentage Each Class </div>
                        <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                    </div>
                    <!-- panel body -->
                    <div class="panel-body" style="display: block;overflow-x:scroll;">
                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                              //   var $table1 = jQuery('#table-1');
                              //   $table1.DataTable({
                              //     "aLengthMenu": [
                              //         [10, 25, 50, -1],
                              //         [10, 25, 50, "All"]
                              //     ],
                                  
                              // });
                              // Initalize Select Dropdown after DataTables is created
                              // $table1.closest('.dataTables_wrapper').find('select').select2({
                              //     minimumResultsForSearch: -1
                              // });    
                            });
                            

                        </script>
                       <table class="table datatable" id="table-1">
                        
                          <thead>
                            <th>ID</th>
                              <th>Section</th>
                              <th>Sbjects</th>
                              <th>WRITTEN WORK</th>
                              <th>PERFORMANCE TASK</th>
                              <th>QUARTERLY ASSESSEMNT</th>
                              <th>Total Percentage</th>
                              <th></th>
                          </thead>
                          <tbody>
                            @foreach($my_classes as $key)
                            <tr>
                                  <td>{{$key->class_id}}</td>
                                  <td>{{$key->section}}</td>
                                  <td>{{$key->subject}}</td>
                                  <td>25%</td>
                                  <td>50%</td>
                                  <td>25%%</td>
                                  <td>100%</td>
                                  <td>
                                    
                                    <a class="btn circle btn-primary" href="/my_class_record/{{$key->class_id}}">
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
       <li> 
            <a href="/activities_result"><i class="entypo-clipboard"></i><span class="title">Activities Result</span></a> 
        </li>
    @endsection

    @endsection