 @extends('layouts.app2')

@section('content')
 <h2>{{ ( auth()->user()->role == 2 ? 'Teacher' : (auth()->user()->role == 1 ?' Admin' : '') ) }}/View Class/{{$myClasses->subject}}</h2>

    @if(auth()->user()->role == 1 && $teacher != null)
        <h4 class="alert alert-info">
            Teacher: {{ strtoupper($teacher->teacher)}}
        </h4>
    @endif

    <div class="row">
        <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-dark" data-collapsed="0">
                    <!-- panel head -->
                    <div class="panel-heading">
                        <div class="panel-title">
                            @if(auth()->user()->role == 1)

                                Students

                            @endif
                            @if(auth()->user()->role == 2)
                                My Students
                            @endif
                        </div>

                        <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
                    </div>
                    <!-- panel body -->
                    <div class="panel-body" style="display: block;">
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
                                @foreach($my_student as $key)
                                    <tr>
                                        <td>{{$key->id}}</td>
                                        <td>{{$key->name}}</td>
                                        <td>
                                            {{$key->email}}
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="/profile/{{$key->id}}">
                                                View
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

@if(auth()->user()->role == 2)
    @section('sidebar')
        <li class="active">
            <a href="/">
                <i class="entypo-home"></i>
                <span class="title">Home</span>
            </a> 
        </li>
         <li>
            <a href="/register">
                <i class="entypo-plus-circled"></i>
                <span class="title">Create Activity</span>
            </a>   
        </li>
        <li> 
            <a href="index.html#"><i class="entypo-book"></i><span class="title">My Class Record</span></a> 
        </li>
       <!--  <li> 
            <a href="index.html#"><i class="entypo-clipboard"></i><span class="title">Scheduling</span></a> 
        </li> -->
    @endsection
@endif

@if(auth()->user()->role == 1)
    @section('sidebar')
        <li>
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
    @endsection