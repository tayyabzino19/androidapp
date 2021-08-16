$(document).ready(function() {
    $(document).on('click', '.category_checkbox', function () {

        var ids = [];

        var counter = 0;
        $('#catFilters').empty();
        $('.category_checkbox').each(function () {
            if ($(this).is(":checked")) {
                ids.push($(this).attr('id'));

                counter++;
            }
        });

        $('._t-item').text('(' + ids.length + ' items)');

        if (counter == 0) {
            $('.causes_div').empty();
            $('.causes_div').append('No Data Found');
        } else {
            fetchCauseAgainstCategory(ids);
        }
    });
});

function fetchCauseAgainstCategory(id) {

    $('.causes_div').empty();

    $.ajax({
        type: 'GET',
        url: "{{ route('project.filter',['data'=>"+id+"]) }}",


        success: function (response) {
            var response = JSON.parse(response);
            console.log(response);

            if (response.length == 0) {
                $('.causes_div').append('No Data Found');
            } else {
                response.forEach(element => {
                    $('.causes_div').append(`<div href="#" class="col-lg-4 col-md-6 col-sm-6 col-xs-12 r_Causes IMGsize">

                            <div class="img_thumb">
                            <div class="h-causeIMG">
                                <img src="${element.cat_image}" alt="" />
                                </div>

                            </div>
                            <h3>${element.cat_title}</h3>

                    </div>`);
                });
            }
        }
    });
}
