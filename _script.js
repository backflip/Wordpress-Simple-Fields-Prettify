(function($){

	var selectors = { 
			wrapper	: '.simple-fields-meta-box-field-group-wrapper',
			add		: '.simple-fields-metabox-field-add',
			group 	: '.simple-fields-metabox-field-group',
			handle	: '.simple-fields-metabox-field-group-handle',
			del		: '.simple-fields-metabox-field-group-delete',
			editor	: '.simple_fields_editor_switch'
		},
		
		// Define custom CSS classes for _styles.css 
		// (otherwise both _script.js and _styles.css would have to be updated whenever a class changes)
		wrapper = $(selectors.wrapper).addClass('sfp-wrapper');

	function initFieldGroups(){
			// Add button to toggle field groups (e.g. for easier sorting)
			if (!$('.sfp-toggle').length) {
				var toggle = $('<div class="sfp-toggle">Toggle</div>');
			
				toggle.prependTo(wrapper).click(function(){
					$(this).parent().find('.sfp-inner').toggle();
					return false;
				});
			}
			
			// Wrap each field group in additional container and add standard WP classes
			$(selectors.group).each(function(){
				var group 	= $(this).addClass('sfp-group'),
					title 	= 'Field group ' + (group.index()+1),
					handle 	= $('<div class="handlediv">&nbsp;</div>');
					
				if (group.find('.sfp-inner').length > 0) {
					group.find('.sfp-handle h3').text(title);
					return true;
				}
					
				group.wrapInner('<div class="sfp-inner" />').addClass('postbox');
				group.find(selectors.handle).addClass('sfp-handle').prependTo(group).text(title).wrapInner('<h3 />');
				
				handle.prependTo(group).click(function(){
					group.find('.sfp-inner').toggle();
				});
				
				group.find(selectors.del).addClass('sfp-delete');
				group.find(selectors.editor).addClass('sfp-editor');
			});
		}
	
	initFieldGroups();
	
	// Init again after inserting new field group (timeout needed due to Simple Field's inserting effect)
	$(selectors.add).addClass('sfp-add').click(function(){
		setTimeout(function(){
			initFieldGroups();
		}, 1000);
	});

})(jQuery);