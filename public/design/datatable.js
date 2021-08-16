'use strict';
var KTDatatablesDataSourceAjaxClient = function() {

	var initTable1 = function() {
		var table = $('#projects');

		// begin first table
		table.DataTable({
			responsive: true,
			ajax: {
				url: "{{ route('projects.getProjects') }}",
				type: 'get',
				data: {
					pagination: {
						perpage: 50,
					},
				},
			},
			columns: [
				{data: 'name'},
                {data: 'url'},
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
