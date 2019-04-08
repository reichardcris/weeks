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
         <li>
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
            <a href="/my_activities">
                <i class="entypo-star-empty"></i>
                <span class="title">My Grades</span>
            </a> 
         
        </li>
       <!--  <li> 
            <a href="index.html#"><i class="entypo-clipboard"></i><span class="title">Scheduling</span></a> 
        </li> -->
   
  @endif
@endsection

@section('content')
	
	<h1>Edit Profile</h1>
	<div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12" id="app1">
       

        <div class="col-md-12 col-lg-12">
            <div class="profile-env">
                <header class="row">
                    <div class="col-sm-2">
                        <a href="#" class="profile-picture"> <img src="../../assets/images/profile-picture.png" class="img-responsive img-circle"> </a>
                    </div>
                    <div class="col-sm-7">
                        <ul class="profile-info-sections">
                            <li>
                                <div class="profile-name"> <strong> <a href="#">@{{profile.name}}</a> <a href="#" class="user-status is-online tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Online"></a> </strong> <span><a href="#">
                                    @if(json_decode($profile)->role == 2)

                                        Teacher
                                    @endif

                                    @if(json_decode($profile)->role == 3)
                                        Student
                                    @endif

                                    @if(json_decode($profile)->role == 1)
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
                            <div class="user-details">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" v-model="profile.name" class="form-control" placeholder="Fullname" name="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" v-model="profile.email" class="form-control" placeholder="Email" name="">
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <input type="text" class="form-control" v-model="currentPassword" placeholder="Current Password" name="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control req" isRequired="false" v-model="newPassword" placeholder="New Password" name="">
                                        </div>

                                         <div class="form-group">
                                            <input type="text" class="form-control req" isRequired="false" v-model="confirmPassword" placeholder="Confirm Password" name="">
                                        </div>

                                        <div class="form-group">
                                            <label v-show="isError" class="col-md-12 alert alert-danger">
                                                <p>
                                                    @{{errors}}
                                                </p>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <button v-on:click="save" class="btn btn-primary">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    var app1 = new Vue({
        el:'#app1',
        data:{
            profile:<?php echo $profile; ?>,
            currentPassword:'',
            newPassword:'',
            confirmPassword:'',
            errors:'',
            isError:false,
        },
        methods:{
            save:function(){

                if(this.currentPassword != ''){
                    if(this.newPassword != '' && this.confirmPassword != ''){                        
                        this.isError=false;
                        if(this.checkPassword && this.newPassword == this.confirmPassword){

                            if(this.newPassword.length >= 6){
                                $.ajax({
                                    url:'/update_profile',
                                    method:'post',
                                    dataType:'json',
                                    data:{
                                        data:app1.profile,
                                        isChangePassword:true,
                                        newPassword:app1.newPassword
                                    },
                                    // async: false,
                                    success:function(result){
                                       
                                        location.reload();
                                        // data = result.result;
                                    },
                                    complete:function(){
                                        location.reload();
                                    }
                                });
                            }else{
                                this.errors="Password must 6 length";
                                this.isError=true;
                            }



                        }else{
                            this.errors="Invalid Password or Password Mismatch";
                            this.isError=true;
                        }
                    }else{
                        this.errors="Please Enter New Password Or Password Confirmation";
                        this.isError=true;
                    }

                }else{

                    $.ajax({
                        url:'/update_profile',
                        method:'post',
                        dataType:'json',
                        data:{
                            data:app1.profile,
                            isChangePassword:false,
                        },
                        // async: false,
                        success:function(result){
                            location.reload();
                            // data = result.result;
                        },
                        complete:function(){
                            location.reload();
                        }
                    });

                }
            }
        },
        computed:{
            checkPassword:function(){
                var data = null;
                    $.ajax({
                        url:'/check_password',
                        method:'post',
                        dataType:'json',
                        data:{
                            password:app1.currentPassword
                        },
                        async: false,
                        success:function(result){
                            data = result.result;
                        }
                    });

                    return data;
                }
        }
    });
  </script>
@endsection