@extends('layouts.master')
@section('title', 'Videos')
@section('page_head')
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="01pJ0EdzC1g7lcjlf8TZWiezemHraNtoRwINZETE" />



    <link href="{{ asset('design/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('design/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('design/assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet"
        type="text/css" />

        <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet"
        type="text/css" />


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
                        <a href="#" class="text-muted">All Videos</a>
                    </li>

                </ul>
            </div>
        </div>



        <div class="row mb-6">
            <div class="col-lg-12">
                <div class="card card-custom gutter-b">

                    <div class="card-header">
                        <h3 class="card-title">
                            Videos
                        </h3>

                        <div class="card-toolbar">
                            <a href="{{ route('videos.create') }}" class="btn btn-primary">
                                <i class=" flaticon-technology-2"></i> Add New
                            </a>
                        </div>

                    </div>







                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 my-2 ">
                                <div class=" align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block"> <strong> Category: </strong> <br> <br/></label>
                                    <select class="form-control categories" data-column="2" id="kt_datatable_search_category">
                                        <option value="">All</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br/><br/>
                            </div>
                            {{-- <div class="col-md-4 my-2 ">
                                <div class=" align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block"> <strong> Status: </strong> <br> <br/></label>
                                    <select class="form-control videostatus" data-column="5" id="kt_datatable_search_status">
                                        <option value="">All</option>

                                        <option value="Active"> Active </option>
                                        <option value="inactive"> In Active </option>

                                    </select>
                                </div>
                                <br/><br/>
                            </div> --}}
                        </div>




                        <table class="table table-bordered table-hover table-checkable  "
                            style="margin-top: 13px !important" id="allprojects">
                            <thead>
                                <tr>
                                    <th>Priority </th>
                                    <th>Title</th>
                                    <th>Category</th>

                                    <th>Thumbnail</th>

                                    <th>Status</th>
                                    <th>Action</th>


                                </tr>
                            </thead>

                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>





        <!-- Modal-->
        <div class="modal fade" id="videoModal" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title head_title" id="exampleModalLabel"> </h5>

                    </div>
                    <div class="modal-body">
                        <video controls preload="auto" width="450" height="264" id="videotag" poster="" data-setup="{}">

                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a
                                web browser that
                                <a href="#" target="_blank">supports HTML5 video</a>
                            </p>
                        </video>

                    </div>
                    <div class="modal-footer">


                        <button type="button" class="modelClose btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>


    </div>

    <form method="post" id="deletefrom" action="{{ route('video.delete') }}">
        @csrf
        <input type="hidden" id="video_id" name="id">
    </form>


@endsection
@section('page_js')

    <script src="{{ asset('design/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>


    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script>
        var KTDatatablesDataSourceAjaxClient = function() {

            var initTable1 = function() {
                var table = $('#allprojects');

                // begin first table
                table.DataTable({
                    responsive: true,
                    ajax: {
                        url: "{{ route('videos.allvideos') }}",
                        dataSrc: "",
                        type: 'get',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'Priority', 'Title',
                                'Category', 'Thumbnail', 'Status', 'Action'
                            ],
                        },
                        data: {
                            pagination: {
                                perpage: 50,
                            },
                        },
                    },

                    columns: [{
                            data: 'priority'
                        },
                        {
                            data: 'title'
                        },
                        {

                            data: 'category.name'
                        },
                        {
                            data: function(data) {
                                return `<img src='{{ asset('storage/data') }}/` + data.thumbnail + `'
                            style='width:70px;height:70px' data-toggle='modal' class='img-thumbnail playvideo' data-target='#videoModal'
                            data-source1='` + data.source + `'>`;
                            },
                        },


                        {
                            data: function(data){
                                if(data.status == 'active'){
                                    return "<span class='label label-lg label-light-success label-inline'> Active </span>'";
                                }else{
                                    return "<span class='label label-lg label-light-danger label-inline'> In Active </span>'";
                                }
                            },


                        },
                        {


                            data: function(data) {
                                return `<a href='{{ route('videos.edit') }}/` + data.id +
                                    `'>   <i class='text-warning la la-eye'></i> &nbsp;&nbsp; </a>
                                    <a href='#' class='delete' data-toggle='modal' data-target='#delete' data-projectid='` + data.id + `' onclick='deleteCat(` + data.id + `)'>
                                         <i class='text-danger la la-trash'></i>
                                    </a>`;
                            },
                            searchable: true
                        },



                    ],







                });




            };

            return {

                //main function to initiate the module
                init: function() {
                    initTable1();
                },

            };

        }();

        jQuery(document).ready(function() {
            KTDatatablesDataSourceAjaxClient.init();
        });




        $(document).on("click", ".delete", function() {

            var projectid = $(this).data('projectid');


            $('#project_id').val(projectid);
        });

                $('.categories').on('change', function() {
                    var table = $('.table').DataTable();
                    table.column($(this).data('column')).search($(this).val()).draw();
                    // datatable.search($(this).val().toLowerCase(), 'Type');
                });

                // $('.videostatus').on('change', function() {
                //     var table = $('.table').DataTable();
                //      table.column($(this).data('column')).search($(this).val()).draw();
                //     //table.column('active').search($(this).val()).draw();
                //     // datatable.search($(this).val().toLowerCase(), 'Type');
                // });

    </script>






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

                    $('#video_id').val(id);
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



        $(document).on("click", ".playvideo", function() {
            var source = $(this).data('source1');
            var headtitle = $(this).data('headtitle');
            var poster = $(this).data('poster');

            var newsrc = `{{ asset('storage/data/`+source+`') }}`;
            var postersrc = `{{ asset('`+poster+`') }}`;
            $("#videotag").html('<source src="' + newsrc + '" type="video/mp4"></source>');
            //alert(source.setAttribute('src',newsrc));
            $('.head_title').html(headtitle);
            $('.poster_img').html(headtitle);



        });

        $(document).on("click", ".modelClose", function() {
            $('#videotag').trigger('stop');
            location.reload();
        });




    </script>






@endsection
