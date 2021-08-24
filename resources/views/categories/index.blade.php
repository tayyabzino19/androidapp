@extends('layouts.master')
@section('title', 'Categories')
@section('content')
@section("page_head")
        <link href="{{asset('design/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@show


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
                    <a href="#" class="text-muted">Categories</a>
                </li>

            </ul>
        </div>
    </div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)

            <div class="alert alert-custom alert-outline-1x alert-outline-danger fade show mb-5" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text"> {{ ucwords($error) }} !</div>
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

                <div class="card-header">
                    <h3 class="card-title">
                        Categories
                    </h3>

                    <div class="card-toolbar">
                        <button data-toggle="modal" data-target="#addCategory" class="btn btn-primary">
                            <i class="flaticon2-notepad"></i> Add New
                        </button>
                    </div>

                </div>







                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable  "
                        style="margin-top: 13px !important" id="mytable">
                        <thead>
                            <tr>
                                <th>Sorting </th>
                                <th>Name</th>
                                <th>Items</th>
                                <th>Status</th>

                                <th>Actions</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories as $category)

                                <tr>
                                    <td> {{ $category->priority }} </td>
                                    <td> {{ $category->name }} </td>
                                    <td> {{ $category->videos->count() }} </td>

                                    <td>
                                        @if ($category->status == 'active')
                                            <span
                                                class="label label-inline label-light-success font-weight-bold">Active</span>
                                        @else
                                            <span class="label label-inline label-light-danger font-weight-bold">In
                                                Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="label-inline   font-weight-bold editcategory" data-toggle="modal"
                                            data-target="#editCategory" data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}" data-status="{{ $category->status }}"
                                            data-priority="{{ $category->priority }}">
                                            <a href="#">
                                                <i class="text-warning flaticon-eye"></i>
                                            </a>
                                        </span>
                                        &nbsp;&nbsp;

                                    </td>
                                </tr>


                            @endforeach











                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>





    <!-- Modal-->
    <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form method="post" action="{{ route('category.store') }}">
                    @csrf
                    <div class="modal-body">

                        <div class="card card-custom">
                            <div class="card-header">
                                <h3 class="card-title"> Add Category </h3>
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
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Name </label>
                                    <input type="text" class="form-control form-control-solid" name="name"
                                        placeholder="Enter Category Title">
                                </div>

                                <div class="form-group">
                                    <label>Prioty Order</label>
                                    <input type="number" class="form-control form-control-solid" name="prioty"
                                        placeholder="Enter Prioty Number" value="{{ $getLastSortid->priority+1 }}">
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


    <div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form method="post" action="{{ route('category.update') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="card card-custom">
                            <div class="card-header">
                                <h3 class="card-title"> Update Category </h3>
                                <div class="card-toolbar">
                                    <input type="hidden" name="status" value="0">
                                    <span class="switch switch-icon">
                                        <span class="font-weight-bold">Status &nbsp; &nbsp;</span> <label class="ml-2">

                                            <input type="checkbox" checked="checked" name="status" value="1"
                                                id="status">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Name </label>

                                    <input type="hidden" name="id" id="editid">
                                    <input type="text" class="form-control form-control-solid" name="name" id="name">
                                </div>

                                <div class="form-group">
                                    <label>Priority Order</label>
                                    <input type="number" class="form-control form-control-solid" name="priority"
                                        id="priority">
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

<form method="post" id="deletefrom" action="{{ route('category.delete') }}">
    @csrf
    <input type="hidden" id="user_id" name="id">
</form>


@endsection
@section('page_js')

<script>
        $(document).ready( function () {
                 $('#mytable').DataTable();
        });
</script>

<script src="{{asset('design/assets/js/pages/crud/datatables/basic/basic.js')}}"></script>
<script src="{{asset('design/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script>
    function deleteCat(id) {
        Swal.fire({
            title: "Are you sure to delete ?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            customClass:{
                confirmButton: "btn-primary"
            }
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
