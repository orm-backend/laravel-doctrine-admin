"use strict";
jQuery(document).ready(function() {
	var selectedRows = [];
	var datatable = $('.itaces-datatable').VVKDatatable({
		data: {
			type: 'local',
			saveState: false,
			serverPaging: true,
		},
		layout: {
			scroll: true,
			height: 550,
			footer: false
			//minHeight: 800, // datatable's body's fixed height
		},
		pageSize: 20,
		// column sorting
		sortable: true,
		// resize column size with mouse drag coming soon)
		resizable: true,
		// column based filtering (coming soon)
		filterable: false,
		pagination: true,
		// inline and bactch editing (cooming soon)
		editable: false,
//		rows: {
//			autoHide: false,
//		},
	});
	
	datatable.on('kt-datatable--before-sort', function(e, args) {
		var url = window.location.pathname + '?order[]=' + (args.sort === 'desc' ? '-' : '') + args.field;
		window.location.assign(url);
	});
	
	datatable.on('kt-datatable--on-check', function(e, args) {
    	selectedRows = selectedRows.concat(args).unique();
        $('#kt_datatable_group_action_form').collapse('show');
        $('#kt_datatable_selected_number').html(selectedRows.length);
    });
	
	datatable.on('kt-datatable--on-uncheck', function(e, args) {
		selectedRows = selectedRows.remove(args);
        
        if (!selectedRows.length) {
        	$('#kt_datatable_group_action_form').collapse('hide');
        }
        
        $('#kt_datatable_selected_number').html(selectedRows.length);
    });
	
	$("form[name='selected-rows']").on("submit", function(e) {
		$("input[name='selected']", $(this)).val(selectedRows.join(","));
	});
	
	$('#delete_modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var url = button.data('url'); // Extract info from data-* attributes
		$(this).find('button.btn-primary').on('click', function() {
			window.location.assign(url);
		});
	});
});
