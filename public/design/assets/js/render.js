
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

    return `<img src='storage/data/` + field
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
    return `<a href='Videos/edit/`+ pid +
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

    alert(datatable.search($(this).val().toLowerCase(), 'Status'));
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
