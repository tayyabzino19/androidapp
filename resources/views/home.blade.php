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

                    <div class="card card-custom">

                        <div class="card-body">
                            <!--begin: Search Form-->
                            <!--begin::Search Form-->
                            <div class="mb-7">
                                <div class="row align-items-center">
                                    <div class="col-lg-9 col-xl-8">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 my-2 my-md-0">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" placeholder="Search..."
                                                        id="kt_datatable_search_query" />
                                                    <span>
                                                        <i class="flaticon2-search-1 text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 my-2 my-md-0">
                                                <div class="d-flex align-items-center">
                                                    <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                                                    <select class="form-control" id="kt_datatable_search_status">
                                                        <option value="">All</option>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 my-2 my-md-0">
                                                <div class="d-flex align-items-center">
                                                    <label class="mr-3 mb-0 d-none d-md-block">Category:</label>
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
                                    <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                                        <a href="#" class="btn btn-light-primary px-6 font-weight-bold">Search</a>
                                    </div>
                                </div>
                            </div>
                            <!--end::Search Form-->
                            <!--end: Search Form-->
                            <!--begin: Datatable-->
                            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
                            <!--end: Datatable-->
                        </div>
                    </div>


                </div>
            </div>



        </div>




    </div>





@endsection
@section('page_js')

    <script>
        "use strict";
        var KTDatatableColumnWidthDemo = function() {
            // Private functions
            var demo = function() {
                var datatable = $('#kt_datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: "http://androidapp.local/All-Videos/",
                                // sample custom headers
                                // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                                map: function(raw) {
                                    // sample data mapping
                                    var dataSet = raw;
                                    if (typeof raw.data !== 'undefined') {
                                        dataSet = raw.data;
                                    }
                                    return dataSet;
                                },
                            },
                        },
                        pageSize: 10,
                        serverPaging: true,
                        serverFiltering: true,
                        serverSorting: true,
                    },

                    // layout definition
                    layout: {
                        scroll: false,
                        footer: false,
                    },

                    // column sorting
                    sortable: true,

                    pagination: true,

                    search: {
                        input: $('#kt_datatable_search_query'),
                        key: 'generalSearch'
                    },

                    // columns definition
                    columns: [{
                            field: 'priority',
                            title: 'Priority',
                            sortable: 'asc',
                            width: 100,
                            type: 'number',
                            selector: false,
                            textAlign: 'center',
                        }, {
                            field: 'title',
                            title: 'Title',
                        },
                        {
                            field: 'category.name',
                            title: 'Category',
                        },

                        {
                            field: 'thumbnail',
                            title: 'Thumbnail',
                            template: function(field) {

                                return `<img src='{{ asset('storage/data') }}/` + field
                                    .thumbnail + `'
style='width:70px;height:70px' data-toggle='modal' class='img-thumbnail playvideo' data-target='#videoModal'
data-source1='` + field.source + `'>`;
                            },
                        },

                        {
                            field: 'status',
                            title: 'Status',


                        },
                        {

                            field: 'Actions',
                            title: 'Actions',
                            sortable: false,
                            width: 125,
                            overflow: 'visible',
                            autoHide: false,
                            template: function(field) {
                                var pid = field.id;
                                return `<a href='{{ route('videos.edit') }}/` + pid +
                                    `'>   <i class='text-warning la la-eye'></i> &nbsp;&nbsp; </a>
<a href='#' class='delete' data-toggle='modal' data-target='#delete' data-projectid='` + pid +
                                    `' onclick='deleteCat(` + pid + `)'>
<i class='text-danger la la-trash'></i>
</a>`;


                            },
                        }

                    ],

                });

                $('#kt_datatable_search_status').on('change', function() {

                    return datatable.search($(this).val().toLowerCase(), 'status');
                });

                $('#kt_datatable_search_type').on('change', function() {
                    datatable.search($(this).val().toLowerCase(), 'Type');
                });

                $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
            };

            return {
                // public functions
                init: function() {
                    demo();
                },
            };
        }();

        jQuery(document).ready(function() {
            KTDatatableColumnWidthDemo.init();
        });
    </script>




@endsection
