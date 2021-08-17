@extends('layouts.master')
@section('title', 'Videos')
@section('page_head')

    <link href="https://vjs.zencdn.net/7.14.3/video-js.css" rel="stylesheet" />
    <link href="{{asset('design/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

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
                    <a href="#" class="text-muted">Videos</a>
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
                    <table class="table table-bordered table-hover table-checkable  "
                        style="margin-top: 13px !important">
                        <thead>
                            <tr>
                                <th>Sorting</th>
                                <th>Title</th>
                                <th>Category</th>
                                 <th>Thumbnail</th>
                                <th>Status</th>
                                <th colspan="2" class="text-center">Action</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($videos as $video)
                                <tr>
                                    <td>
                                        {{ $video->priority }}
                                    </td>

                                    <td>
                                        {{ $video->title }}
                                    </td>

                                    <td>
                                        {{ $video->category->name }}
                                    </td>




                                    <td>
                                        <img src="{{ asset($video->thumbnail) }}"
                                            width="70" height="70" data-toggle="modal"
                                            class="img-thumbnail playvideo"
                                            data-target="#videoModal" data-source1="{{ $video->source }}"
                                            data-headtitle="{{ $video->title }}"
                                            data-poster="{{ $video->thumbnail300 }}"  />
                                    </td>


                                    <td>
                                        @if ($video->status == 'active')
                                            <span
                                                class="label label-inline label-light-success font-weight-bold">Active</span>
                                        @else
                                            <span class="label label-inline label-light-danger font-weight-bold">In
                                                Active</span>
                                        @endif

                                    </td>


                                    <td class="text-center">
                                        <a href="{{ route('videos.edit', $video->id) }}">
                                            <i class=" text-warning flaticon-eye"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <i class=" text-danger flaticon2-trash"
                                            onclick="deleteCat({{ $video->id }})"></i>
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
    <div class="modal fade" id="videoModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title head_title" id="exampleModalLabel"  > </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                <video   controls preload="auto" width="450" height="264" id="videotag"
                poster=""
                data-setup="{}">

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
        var headtitle =  $(this).data('headtitle');
        var poster =  $(this).data('poster');

        var newsrc = `{{ asset('storage/data/`+source+`') }}`;
        var postersrc = `{{ asset('`+poster+`') }}`;
        $("#videotag").html('<source src="'+newsrc+'" type="video/mp4"></source>' );
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
