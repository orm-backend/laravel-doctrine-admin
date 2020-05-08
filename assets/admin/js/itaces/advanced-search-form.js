"use strict";
window.callBackDatatableSelectedRows = function(data) {
	var $select = $("select[name='"+data.opener+"']");
	
	if ($select && $select.length) {
		var selected = [];

		$.each(data.selected, function(i, record) {
			var title = record.name || record.title || record.code || record.id;
			
			if (!$select.find("option[value='" + record.id + "']").length) {
				var newOption = new Option(title, record.id, false, false);
				$select.append(newOption);
			}
			
			selected.push(record.id);
		});

		if ($select.prop('multiple')) {
			var old = $select.val();
			selected = selected.concat(old).unique();
			$select.val(selected);
		} else if (selected.length) {
			$select.val(selected[0]);
		}
		
		if ($select.parent().hasClass('bootstrap-select')) {
			$select.selectpicker('refresh');
		}
		
		$select.trigger('change');
	}
};

function submitAdvancedSearchForm() {
	var $builder = $('.advanced-search-portlet').find('[role="tabpanel"].active').find('.query-builder');
	$builder.queryBuilder('submit');
}

jQuery(document).ready(function() {
	
	function renderTab(index, rules, title) {
		var $tablist = $('.advanced-search-portlet').find('[role="tablist"]');
		var $tabpanel = $('.advanced-search-portlet').find('[role="tabpanel"]:last');
		
		$tablist.append($('<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#search-tab_'+index+'" role="tab">'+title+'</a></li>'));
		$tabpanel.after($('<div class="tab-pane" role="tabpanel" id="search-tab_'+index+'"><div id="query-builder_'+index+'" style="display: block;"></div></div>'));
		
		var $builder = $('#query-builder_'+index).queryBuilder({
			rules: [],
			filters: QueryBuilder.metadataToQBuilderFilers(window.metadata)
		});
		
		$builder.queryBuilder('fromJson', rules);
	}
	
	function addFilterToRemoveList(index, rules, title) {
		var $list = $('form[name="list-local-filters"]').find('.kt-checkbox-list');
		$list.append($('<label class="kt-checkbox kt-checkbox--brand"><input type="checkbox" value="'+title+'">'+title+'<span></span></label>'));
	}
	
	function restoreTabs() {
		var classUrlName = $('form[name="advanced-search-form"]').data('class-url-name');
		var allTabs = window.localStorage.getItem('advansedSearchTabs');
		var index = 1;

		if (allTabs) {
			allTabs = JSON.parse(allTabs);
			
			if (!$.isEmptyObject(allTabs) && !$.isEmptyObject(allTabs[classUrlName])) {
				$.each( allTabs[classUrlName], function( title, rules ) {
					index ++;
					renderTab(index, rules, title);
					addFilterToRemoveList(index, rules, title);
				});
			}
			
			//$('.nav-link[href="#search-tab_'+index+'"]').click();
		}
	}
	
	function storeTab(title) {
		$('.advanced-search-portlet').find('[role="tablist"]');
		var $builder = $('.advanced-search-portlet').find('[role="tabpanel"].active').find('.query-builder');
		var classUrlName = $('form[name="advanced-search-form"]').data('class-url-name');
		
		if ($builder.length && classUrlName) {
			var rules = $builder.queryBuilder('getRules', { allow_invalid: true });

			if (!$.isEmptyObject(rules) && title) {
				var allTabs = window.localStorage.getItem('advansedSearchTabs');
				
				if (!allTabs) {
					allTabs = {};
				} else {
					allTabs = JSON.parse(allTabs);
				}
				
				if (!allTabs[classUrlName]) {
					allTabs[classUrlName] = {};
				}
				
				allTabs[classUrlName][title] = rules;
				window.localStorage.setItem('advansedSearchTabs', JSON.stringify(allTabs));
				
				return true;
			}
		}
		
		return false;
	}
	
	function removeTabs(tabs) {
		var classUrlName = $('form[name="advanced-search-form"]').data('class-url-name');
		var allTabs = window.localStorage.getItem('advansedSearchTabs');
		
		if (allTabs) {
			allTabs = JSON.parse(allTabs);
		}

		if (Array.isArray(tabs) && tabs.length && !$.isEmptyObject(allTabs)) {
			$.each(tabs, function( index, name ) {
				delete allTabs[classUrlName][name];
			});
			
			window.localStorage.setItem('advansedSearchTabs', JSON.stringify(allTabs));
			
			return true;
		}
		
		return false;
	}
	
	function storeLink(title) {
		if (window.location.search) {
			var url = window.location.pathname + window.location.search;
			var allLinks = window.localStorage.getItem('menuLinks');
			
			if (!allLinks) {
				allLinks = [];
			} else {
				allLinks = JSON.parse(allLinks);
			}
			
			allLinks.push({
					title: title,
					url: url
			});
			
			window.localStorage.setItem('menuLinks', JSON.stringify(allLinks));
			
			return true;
		}
		
		return false;
	}
	
	function restoreMenu() {
		var allLinks = window.localStorage.getItem('menuLinks');
		
		if (allLinks) {
			allLinks = JSON.parse(allLinks);

			$.each(allLinks, function(i, link) {
				var $li = $("<li class=\"kt-menu__item\" aria-haspopup=\"true\"><a class=\"kt-menu__link\"><i class=\"kt-menu__link-bullet kt-menu__link-bullet--dot\"><span></span></i><span class=\"kt-menu__link-text\"></span></a></li>");
				$("a", $li).attr("href", link.url).attr("title", link.title);
				$("span.kt-menu__link-text", $li).text(link.title);
				
				if (link.url == window.location.pathname + window.location.search) {
					var $asideMenu = $("#kt_aside_menu_wrapper");
					$("li.kt-menu__item", $asideMenu).removeClass("kt-menu__item--here").removeClass("kt-menu__item--active");
					$li.addClass("kt-menu__item--active");
					$("#savedMenuItems").closest("li").addClass("kt-menu__item--open kt-menu__item--here");
				}
				
				$("#savedMenuItems").append($li);
			});
		}
	}
	
	$('#query-builder_1').queryBuilder({
		rules: [],
		filters: QueryBuilder.metadataToQBuilderFilers(window.metadata)
	});

	$("form[name='store-filters-locally']").on('submit', function(e) {
		e.preventDefault();
		var title = $(this).find("input[name='name']").val();
		
		if (title) {
			if (storeTab(title)) {
				window.location.reload();
			}
		}
		
		$(this).closest('.dropdown').find('[data-toggle="dropdown"]').click();
	});
	
	$("form[name='add-menu-item']").on('submit', function(e) {
		e.preventDefault();
		var title = $(this).find("input[name='name']").val();
		
		if (title) {
			if (storeLink(title)) {
				window.location.reload();
			}
		}
		
		$(this).closest('.dropdown').find('[data-toggle="dropdown"]').click();
	});
	
	$("form[name='list-local-filters']").on('submit', function(e) {
		e.preventDefault();
		
		var tabs = $('input[type="checkbox"]:checked', this).map(function() {
			return $(this).val();
		}).get();
		
		if (Array.isArray(tabs) && tabs.length) {
			if (removeTabs(tabs)) {
				window.location.reload();
			}
		}
		
		$(this).closest('.dropdown').find('[data-toggle="dropdown"]').click();
	});
	
	$('form[name="advanced-search-form"]').on('submit', function(e) {
		e.preventDefault();
		submitAdvancedSearchForm();
	});
	
	restoreMenu();
	restoreTabs();
});
