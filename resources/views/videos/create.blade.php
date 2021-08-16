@extends('layouts.master')
@section('title', 'Video Create')
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
                    <a href="#" class="text-muted">Create</a>
                </li>

            </ul>
        </div>
    </div>



    <div class="row mb-6">
        <div class="col-lg-12">


            <form method="post" action="{{ route('videos.save') }}" enctype="multipart/form-data">
                <div class="card card-custom">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">
                            Add Video
                        </h3>
                        <div class="card-toolbar">
                            <input type="hidden" name="status" value="0">
                            <span class="switch switch-icon">
                                <span class="font-weight-bold">Status &nbsp; &nbsp;</span> <label class="ml-2">
                                    <input type="checkbox" checked="checked" name="status" value="1">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <!--begin::Form-->

                    <div class="card-body">

                        <div class="form-group">
                            <label>Title </label>
                            <input type="text" class="form-control form-control-solid" name="title"
                                value="{{ old('title')}}"
                                placeholder="Enter Video Title" required="">

                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label>Select Category </label>
                            <select class="form-control form-control-solid" required name="category">
                                <option selected disabled value=""> Select Category </option>
                                @foreach ($categories as $category )
                                     <option value="{{ $category->id }}" > {{ $category->name }} </option>
                                @endforeach

                            </select>

                                @error('category')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror



                        </div>


                        <div class="form-group">
                            <label>Video Source </label>
                            <input type="file" name="video"  required class="form-control form-control-solid" accept="video/*">

                            @error('video')
                                    <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>











                    </div>
                    <div class="card-footer">


                        <a href="{{ route('videos.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary mr-2">Create</button>
                    </div>

                    <!--end::Form-->
                </div>
            </form>


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
</script>





@endsection
