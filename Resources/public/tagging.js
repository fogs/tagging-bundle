var tagsManagers = {};

(function ($) {
	$(document).ready(function () { 
		
		// find all tagsManager input elements 
		$("input.tagsmanager").each(function() {
			// initialize the tagsManager
			tagsManagers[this.id] = $(this).tagsManager(taggingOptions[this.id]['tagsManager']);
	
			// initialize the typeahead, if configured
			if (taggingOptions[this.id]['typeahead']) {
				$(this).typeahead(taggingOptions[this.id]['typeahead']).on('typeahead:selected', function (e, d) {
					tagsManagers[this.id].tagsManager("pushTag", d.value);
				});	
			}
			
		});
		
	});
})(jQuery);
