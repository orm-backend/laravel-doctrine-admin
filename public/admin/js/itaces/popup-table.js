"use strict";
jQuery(document).ready(function() {
	var datatable = $('.itaces-datatable').ItAcesDatatable({
		data: {
			type: 'local',
			saveState: false,
			serverPaging: true,
		},
		layout: {
			scroll: true,
			footer: false
		},
		pageSize: 20,
		sortable: true,
		resizable: true,
		filterable: false,
		pagination: true,
		editable: false,
	});
	
	datatable.on('kt-datatable--before-sort', function(e, args) {
		var url = window.location.pathname + '?order[]=' + (args.sort === 'desc' ? '-' : '') + args.field;
		window.location.assign(url);
	});
	
	datatable.on('kt-datatable--on-check', function(e, args) {
		var result = {
				opener: getRequestParam('opener'),
				selected: []
		};
		
		if (Array.isArray(args)) {
			$.each(args, function(i, id) {
				var record = {}
				
				$.each(window.metadata, function(j, meta) {
					var field = meta['aliasname'].substr(meta['aliasname'].indexOf('.') + 1);
					record[field] = datatable.getRecord(id).getColumn(meta['aliasname']).getValue();
				});
				
				result.selected.push(record);
			});
		}
		
		window.opener.callBackDatatableSelectedRows(result);
		window.close();
	});
});
