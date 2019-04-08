@extends('layouts.app2')
@section('sidebar')
  @if(auth()->user()->role==1)
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
    <li> 
        <a href="/scheduling"><i class="entypo-clipboard"></i><span class="title">Scheduling</span></a> 
    </li>
  @endif

  @if(auth()->user()->role==2)
      <li >
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
  @endif

  @if(auth()->user()->role==3)
     
  @endif
@endsection

@section('content')
	
	<h1>View Profile</h1>
	<div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12" id="app1">
       

        <div class="col-md-12 col-lg-12" v-show="isStudentProfileShow">
            <div class="profile-env">
                <header class="row">
                    <div class="col-sm-2">
                        <a href="#" class="profile-picture"> <img src="../../assets/images/profile-picture.png" class="img-responsive img-circle"> </a>
                    </div>
                    <div class="col-sm-7">
                        <ul class="profile-info-sections">
                            <li>
                                <div class="profile-name"> <strong> <a href="#">{{$profile->name}}</a> <a href="#" class="user-status is-online tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Online"></a> </strong> <span><a href="#">
                                    @if($profile->role == 2)

                                        Teacher
                                    @endif

                                    @if($profile->role == 3)
                                        Student
                                    @endif

                                    @if($profile->role == 1)
                                        Admin
                                    @endif
                                </a></span> </div>
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
                        

                      
                    <!-- profile stories -->
                    
                </section>
            </div>
        </div>
    </div>
</div>

  
  <script type="text/javascript">
    
  </script>
  <script type="text/javascript">

  </script>
@endsection