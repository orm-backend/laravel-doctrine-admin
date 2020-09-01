"use strict";
window.callBackDatatableSelectedRows = function(data) {
	var $input = $("[name='"+data.opener+"']");
	
	if ($input.length && !$.isEmptyObject(data.selected[0])) {
		if ($input.prop('multiple')) {
			var selected = [];

			$.each(data.selected, function(i, record) {
				var title = record.name || record.title || record.code || record.id;
				title = '['+ record.id+'] ' + title;
				
				if (!$input.find("option[value='" + record.id + "']").length) {
					var newOption = new Option(title, record.id, false, false);
					$input.append(newOption);
				}
				
				selected.push(record.id);
			});
			
			var old = $input.val();
			selected = selected.concat(old).unique();
			$input.val(selected);
		} else {
			var record = data.selected[0];
			var title = record.name || record.title || record.code || record.id;
			$input.val(record.id).trigger('change');
			$input.closest('.input-group').find('.input-group-append span').html(title);
		}
	}
};

jQuery(document).ready(function() {
	$('.date input').datepicker({
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
        format: 'yyyy-mm-dd',
        orientation: "top left",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    });
	
	$('.datetime input').datetimepicker({
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
        format: 'yyyy-mm-dd hh:ii',
        pickerPosition: 'top-right'
    });
	
	$('.time input').timepicker({
		defaultTime: '',
		minuteStep: 1,
        showSeconds: true,
        showMeridian: false,
        snapToStep: true
    });
	
	$(".kt-select2").select2();
	
	$('.bootstrap-touchspin input').TouchSpin({
		buttondown_class: 'btn btn-secondary',
        buttonup_class: 'btn btn-secondary',
        min: 0,
        max: 10000000
	});
	
	$('[data-switch=true]').bootstrapSwitch();
	
	autosize($('textarea'));
	
	$('.kt-avatar').each(function() {
		new KTAvatar($(this).closest('.kt-avatar').attr('id'));
	});
	
	$('button.submit').on('click', function(e) {
		var formName = $(this).data('form');
		$("form[name='"+formName+"']").submit();
	});
	
	$('button.goto').on('click', function(e) {
		window.location.href = $(this).data('url');
	});

	$('button.show-datatable').on('click', function() {
		var $button = $(this);
		
		window.callBackDatatableRowSelected = function(id) {
			var $group = $button.closest('.input-group');
			var $input = $group.find('input').val(id);
			console.log($input);
			$group.find('.input-group-text').html('');
		}
		
		openPopupWindow($(this).data('url'), 900, 700);
	});

	$('#delete_modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var url = button.data('url'); // Extract info from data-* attributes
		$(this).find('button.btn-primary').on('click', function() {
			window.location.assign(url);
		});
	});
});
