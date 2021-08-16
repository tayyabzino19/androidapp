'use strict';
var KTDatatablesDataSourceAjaxClient = function() {

	var initTable1 = function() {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
			responsive: true,
			ajax: {
				url: 'testing-url/',dataSrc:"",
				type: 'get',
				data: {
					pagination: {
						perpage: 50,
					},
				},
			},
			columns: [
				{data: 'name'},
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
