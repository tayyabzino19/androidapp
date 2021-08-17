@extends('layouts.master')
@section('title', 'Categories')
@section('content')


<div class="container">
    <div class="row mb-6">
        <div class="col-lg-12">
            <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">

                <li class="breadcrumb-item">
                    <a href=""><i class="fa fa-home"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" class="text-muted">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="#" class="text-muted">Profile</a>
                </li>

            </ul>
        </div>
    </div>



    <div class="row mb-6">
        <div class="col-lg-12">
            <div class="card-body">

                <div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="first" data-wizard-clickable="true">
                    <!--begin: Wizard Nav-->

                    <!--end: Wizard Nav-->
                    <!--begin: Wizard Body-->
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                    <div class="row justify-content-center " style="background: #EEF0F8; " >

                        <div class="col-lg-3 text-center" style="margin-top:20px; ">
                            <!--begin: Wizard Form-->
                            <div class="card-body  " style="background:#fff">

                                <div class="image-input image-input-outline" id="userimage"
                                    @if($user->photo == '')
                                        style="background-image: url(https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/600px-No_image_available.svg.png)"
                                    @else
                                         style="background-image: url(' {{asset('storage/user/'.$user->photo)}} ')"
                                    @endif
                                    >
                                    <div class="image-input-wrapper" style="background-image: none;"></div>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="photo" accept=".png, .jpg, .jpeg">
                                        <input type="hidden" name="profile_avatar_remove" value="0">
                                    </label>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>



                                </div>

                                <div class="align-items-center">

                                    <div class="text-center">
                                        <hr>
                                        <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{$user->name}}</a>
                                        <div class="text-muted"> {{$user->email}}</div>
                                        <div class="mt-2">

                                            <div class="form-group mt-40">
                                                <span class="switch switch-icon text-center">
                                                    <label class="m-auto">

                                                        <br>

                                                    <span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end: Wizard Form-->
                        </div>



                        <div class="col-lg-9" style="margin-top:20px ">
                            <!--begin: Wizard Form-->
                            <div class="card-body  " style="background:#fff">
                                <h4 class="mb-10 font-weight-bold text-dark">Personal Settings</h4>
                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <div class="pb-5 text-left" data-wizard-type="step-content" data-wizard-state="current">
                                                <input type="hidden" id="UserID" name="userid" value="{{$user->id}}">
                                                <!--begin::Input-->
                                                <div class="form-group fv-plugins-icon-container">
                                                    <label>Full Name</label>
                                                    <input type="text" class="form-control" name="name"  required value="{{$user->name}}">
                                                </div>
                                                <!--end::Input-->
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control"  disabled value="{{$user->email}}">

                                                </div>


                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Enter New Password" ">

                                                </div>


                                                <div class="form-group">
                                                    <label>Auth Key</label>
                                                    <input type="text" class="form-control"   name="key"  value="{{$user->key}}" placeholder="Enter Auth Key">

                                                </div>


                                                <!--end::Input-->


                                            </div>
                                            <button class="btn btn-primary mr-2 text-right"  type="submit"> Update </button>
                                        </div>
                                        <!--begin: Wizard Step 1-->


                                    <div>

                            </div>

                                </div>
                            </div>
                            <!--end: Wizard Form-->
                        </div>





                    </div>
                    </form>
                    <!--end: Wizard Body-->
                </div>

            </div>
        </div>
    </div>





    <!-- Modal-->




</div>


@endsection
@section('page_js')


    <script>
             var avatar5 = new KTImageInput('userimage');

    </script>


@endsection
