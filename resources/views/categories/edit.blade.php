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
                    <a href="{{ route('categories')}}" class="text-muted">Categories</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="#" class="text-muted">Edit</a>
                </li>

            </ul>
        </div>
    </div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)

        <div class="alert alert-custom alert-outline-1x alert-outline-danger fade show mb-5" role="alert">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text"> {{ ucwords( $error )}} !</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                </button>
            </div>
        </div>
        @endforeach
    @endif



    <div class="row mb-6">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">







                <div class="card-body">
                    <form method="post" action="{{ route('category.update')}}">
                        @csrf
                        <div class="modal-body">

                                <div class="card card-custom">
                                    <div class="card-header">
                                        <h3 class="card-title">  Update Category   </h3>
                                        <div class="card-toolbar">
                                            <input type="hidden" name="status" value="0">
                                            <span class="switch switch-icon">
                                                <span class="font-weight-bold">Status &nbsp; &nbsp;</span> <label
                                                    class="ml-2">

                                                    <input type="checkbox"
                                                     @if($category->status == 'active') checked="checked" @endif
                                                     name="status" value="1">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>

                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Name </label>
                                            <input type="text" class="form-control form-control-solid" name="name"
                                                value="{{ $category->name }}">
                                        </div>


                                        <div class="form-group">
                                            <label>Order Sequence </label>
                                            <select class="form-control form-control-solid">
                                                <option>
                                                        1
                                                </option>
                                            </select>

                                        </div>


                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary font-weight-bold">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <!-- Modal-->
    <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form method="post" action="{{ route('category.store')}}">
                    @csrf
                    <div class="modal-body">

                            <div class="card card-custom">
                                <div class="card-header">
                                    <h3 class="card-title">  Add Category   </h3>
                                    <div class="card-toolbar">
                                        <input type="hidden" name="status" value="0">
                                        <span class="switch switch-icon">
                                            <span class="font-weight-bold">Status &nbsp; &nbsp;</span> <label
                                                class="ml-2">

                                                <input type="checkbox" checked="checked" name="status" value="1">
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>

                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label>Name </label>
                                        <input type="text" class="form-control form-control-solid" name="name"
                                            placeholder="Enter Category Title">
                                    </div>

                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>




@endsection
@section('page_js')





@endsection
