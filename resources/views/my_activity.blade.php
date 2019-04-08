 @extends('layouts.app2')

@section('content')
 <h2>Student/My Activity </h2>
<hr></hr>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <th>
                       Section
                    </th>
                    <th>
                      Subject
                    </th>
                    <th>
                      Teacher
                    </th>
                    <th>
                      Activity Type
                    </th>
                    <th>
                      Duration
                    </th>

                    

                    <th>
                      Status
                    </th>

                    <th>
                        Action
                    </th>
                </thead>

                <tbody>
                  @foreach($student_activities as $key)
                    <tr>
                        <td>
                          {{$key->section}}
                        </td>
                        <td>
                          {{$key->subject}}
                        </td>
                        <td>
                          {{$key->teacher}}
                        </td>
                        <td>
                          {{$key->act_type}}
                        </td>
                        <td>
                          {{$key->duration}} Mins.
                        </td>
                       
                        <td>
                          @if($key->status == 0)
                            In Complete
                          @else
                            <p class="text-info">Complete</p>
                          @endif
                        </td>
                        <td>
                          @if($key->status == 0)
                            <a class="btn btn-info start" data-href="/student_exam/{{encrypt($key->id)}}">
                              Start
                          </a>
                          @else
                            <a class="btn btn-primary view-score" data-href="/student_exam/{{encrypt($key->id)}}">
                              View Score
                          </a>
                          @endif
                          
                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <script type="text/javascript">
        $(document).on('click','.start',function(){
            if(confirm("If you start Activity You can't open any tabs or minimize the browser otherwise the browser will closed!")){
              // location.href = $(this).attr('data-href');
              window.open($(this).attr('data-href'), '', 'fullscreen=yes, scrollbars=auto');
            }
        });

        $(document).on('click','.view-score',function(){
            window.open($(this).attr('data-href'), '', 'fullscreen=yes, scrollbars=auto');
        });
    </script>
    @section('sidebar')
         <li>
            <a href="/">
                <i class="entypo-home"></i>
                <span class="title">Home</span>
            </a> 
         
        </li>
         <li class="active">
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
       
    @endsection

    @endsection