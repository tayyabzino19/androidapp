@extends('layouts.master')
@section('title', 'Dashboard')
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

            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">


                <div class="card-body">

                    <div class="mb-7">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-xl-8">
                                <div class="row align-items-center">
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                                            <select class="form-control" id="kt_datatable_search_type">
                                                <option value="">All</option>
                                                <option value="1">Online</option>
                                                <option value="2">Retail</option>
                                                <option value="3">Direct</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
                    <!--end: Datatable-->
                </div>
            </div>
        </div>



    </div>




</div>




@endsection
@section('page_js')
<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>

<script src="{{asset('design/assets/js/pages/crud/ktdatatable/advanced/record-selection.js')}}  "></script>

<script>
        var datatable = $('#kt_datatable').KTDatatable(options);
</script>

@endsection
