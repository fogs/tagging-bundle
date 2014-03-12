(function( $ ) {
 
    $.fn.fogsTagsManager = function( options ) {

        // Initialises tags manager
        // Uses taggingOptions[this.id] set in widgets.html.twig
        // Usage - $("input.tagsmanager").fogsTagsManager();
        
        var tagsManagers = {};
            
        var tags = null;    
            
        return this.each(function() {
            
            //use extra extend attribute of true to go deep
            opts = $.extend( true, {}, $.fn.fogsTagsManager.defaults, taggingOptions[this.id] );
            
            // initialize the tagsManager
            tagsManagers[this.id] = $(this).tagsManager( opts.tagsManager );
            
			// initialize the typeahead, if configured
			if (opts.suggestions)
            {
                if (tags == null)
                {
                    tags = new Bloodhound( opts.suggestions );    
                    tags.initialize();
                }
                
                opts.bloodhound.source = tags.ttAdapter();
                
                $(this).typeahead(opts.typeahead, opts.bloodhound )	
                    .on('typeahead:selected', function (e, d) {
                        tagsManagers[this.id].tagsManager("pushTag", d.name);
                    });	
            }
            
        });
    };
    
    // Plugin defaults – added as a property on our plugin function.
    $.fn.fogsTagsManager.defaults = {
        bloodhound : {
            name: 'tags',
            displayKey: 'name'
        },
        suggestions : {
            datumTokenizer: function(d) { return d; },
            queryTokenizer: function(q) { return q; }
        }
    };
 
}( jQuery ));
