@extends('layouts.master')
@section('title', 'Video Create')
@section('page_head')



@endsection
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
                    <a href="{{ route('videos.index') }}" class="text-muted">Videos</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="#" class="text-muted">Edit</a>
                </li>

            </ul>
        </div>
    </div>



    <div class="row mb-6">
        <div class="col-lg-12">


            <form method="post" action="{{ route('videos.update') }}" enctype="multipart/form-data">
                <div class="card card-custom">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">
                            Update Video
                        </h3>
                        <input type="hidden" value="{{ $video->id }}" name="video_id">
                        <div class="card-toolbar">
                            <input type="hidden" name="status" value="0">
                            <span class="switch switch-icon">
                                <span class="font-weight-bold">Status &nbsp; &nbsp;</span> <label class="ml-2">
                                    <input type="checkbox" @if ($video->status == 'active') checked="checked" @endif name="status"
                                        value="1">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <!--begin::Form-->

                    <div class="card-body">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Title </label>
                                    <input type="text" class="form-control form-control-solid" name="title"
                                        placeholder="Enter Video Title" required="" value="{{ $video->title }}">

                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="col-lg-6">


                                    <div class="symbol symbol-40 symbol-light-success mr-5">
                                        <label> Video </label>
                                        <br/>
                                        <span class=" " data-toggle="modal" data-target="#videoModal">
                                            <img src="{{ asset( 'storage/data/'.$video->thumbnail) }}"
                                                class="h-75 align-self-end img-thumbnail" style="width:150px" alt="">
                                        </span>
                                    </div>

                                </div>
                            </div>


                        </div>

                        <div class="form-group">
                            <label>Select Category </label>
                            <select class="form-control form-control-solid" required name="category">

                                @foreach ($categories as $category)
                                    <option @if($category->id == $video->category_id) selected @endif value="{{ $category->id }}"> {{ $category->name }} </option>
                                @endforeach

                            </select>

                            @error('category')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror



                        </div>


                        <div class="form-group">
                            <label>Video Source </label>
                            <input type="file" name="video"   class="form-control form-control-solid">

                            @error('video')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>



                        <div class="form-group">
                            <label>Priority </label>
                            <input type="number" class="form-control form-control-solid" name="priority"
                                value="{{ $video->priority }}"
                                placeholder="Enter Video Title" required="">

                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>


                    </div>
                    <div class="card-footer">


                        <a href="{{ route('videos.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                    </div>

                    <!--end::Form-->
                </div>
            </form>


        </div>
    </div>




    <!-- Modal-->
    <div class="modal fade" id="videoModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $video->title }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <video id="mysvideo"   controls preload="auto" width="450" height="264" >
                        <source src="{{ asset('storage/data/'.$video->source) }}" type="video/mp4" />
                        <source src="{{ asset('storage/data/'.$video->source) }}" type="video/webm" />
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a
                            web browser that
                            <a href="" target="_blank">supports HTML5 video</a>
                        </p>
                    </video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold modelClose"
                        data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>



    <!-- Modal-->



</div>

<form method="post" id="deletefrom" action="{{ route('category.delete') }}">
    @csrf
    <input type="hidden" id="user_id" name="id">
</form>


@endsection
@section('page_js')

<script>
    function deleteCat(id) {
        Swal.fire({
            title: "Are you sure to delete ?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {

                $('#user_id').val(id);
                $('#deletefrom').submit();


            }
        });
    }



    $(document).on("click", ".editcategory", function() {

        var id = $(this).data('id');
        var name = $(this).data('name');
        var status = $(this).data('status');
        var priority = $(this).data('priority');


        $('#editid').val(id);
        $('#name').val(name);
        $('#priority').val(priority);
        if (status == 'active') {
            $('#status').prop('checked', true);
        } else {
            $('#status').prop('checked', false);
        }

    });

    $(document).on("click", ".modelClose", function() {

        $('#mysvideo').trigger('pause');
    });


</script>





@endsection
