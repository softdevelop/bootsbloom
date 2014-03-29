// Easing equation, borrowed from jQuery easing plugin
// http://gsgd.co.uk/sandbox/jquery/easing/
jQuery.easing.easeOutQuart = function (x, t, b, c, d) {
    return -c * ((t=t/d-1)*t*t*t - 1) + b;
};

jQuery(function( $ ){
    /*FIXED HEADER*/
    var div = $('#header');
    var start = $(div).offset().top;
    $.event.add(window, "scroll", function() {
        var p = $(window).scrollTop();
        $(div).css('position',((p)>start) ? 'fixed' : 'static');
        $(div).css('top',((p)>start) ? '0px' : '');
    });
    /*FIXED HEADER*/
    /**
	 * Most jQuery.serialScroll's settings, actually belong to jQuery.ScrollTo, check it's demo for an example of each option.
	 * @see http://flesler.demos.com/jquery/scrollTo/
	 * You can use EVERY single setting of jQuery.ScrollTo, in the settings hash you send to jQuery.serialScroll.
	 */
	
    /**
	 * The plugin binds 6 events to the container to allow external manipulation.
	 * prev, next, goto, start, stop and notify
	 * You use them like this: $(your_container).trigger('next'), $(your_container).trigger('goto', [5]) (0-based index).
	 * If for some odd reason, the element already has any of these events bound, trigger it with the namespace.
	 */		
	
    /**
	 * IMPORTANT: this call to the plugin specifies ALL the settings (plus some of jQuery.ScrollTo)
	 * This is done so you can see them. You DON'T need to specify the commented ones.
	 * A 'target' is specified, that means that #screen is the context for target, prev, next and navigation.
	 */
    $('#sections').serialScroll({
        //target:'#sections',
        items:'li.target_panel', // Selector to the items ( relative to the matched elements, '#sections' in this case )
                
        /*prev:'img.prev',// Selector to the 'prev' button (absolute!, meaning it's relative to the document)
		next:'img.next',// Selector to the 'next' button (absolute too)*/
        prev:'a#back_but',// Selector to the 'prev' button (absolute!, meaning it's relative to the document)
        next:'a#next_but',// Selector to the 'next' button (absolute too)
            
        axis:'x',// The default is 'y' scroll on both ways
        navigation:'#navigation li a',
        duration:300,// Length of the animation (if you scroll 2 axes and use queue, then each axis take half this time)
        force:true, // Force a scroll to the element specified by 'start' (some browsers don't reset on refreshes)
        lazy:!1,
        lock:!1,
        cycle:!1,
		
        //queue:false,// We scroll on both axes, scroll both at the same time.
        //event:'click',// On which event to react (click is the default, you probably won't need to specify it)
        //stop:false,// Each click will stop any previous animations of the target. (false by default)
        //lock:true, // Ignore events if already animating (true by default)		
        //start: 0, // On which element (index) to begin ( 0 is the default, redundant in this case )		
        //cycle:true,// Cycle endlessly ( constant velocity, true is the default )
        //step:1, // How many items to scroll each time ( 1 is the default, no need to specify )
        //jump:false, // If true, items become clickable (or w/e 'event' is, and when activated, the pane scrolls to them)
        //lazy:false,// (default) if true, the plugin looks for the items on each event(allows AJAX or JS content, or reordering)
        //interval:1000, // It's the number of milliseconds to automatically go to the next
        //constant:true, // constant speed
		
        onBefore:function( e, elem, $pane, $items, pos ){
                    
            /*** Customized For Tab Errors ***/
            //   alert(formChanged);
            //  alert(window.location.hash);       
            if(formChanged==true){
                var r = confirmNavigation()
            
                if(r==true){
                    formChanged=false;
                    discard_changes();
                    return false;
                }else{
                    return false;
                }
                        
            }
                   
            /**
			 * 'this' is the triggered element 
			 * e is the event object
			 * elem is the element we'll be scrolling to
			 * $pane is the element being scrolled
			 * $items is the items collection at this moment
			 * pos is the position of elem in the collection
			 * if it returns false, the event will be ignored
			 */
            //those arguments with a $ are jqueryfied, elem isn't.
            $pane.height($(elem).height());
            //window.location.hash	=	$(elem).attr('href');
            //e.preventDefault();
            if( this.blur )
                this.blur();
        },
        onAfter:function( elem ){
            
			/* Customized To Show and Hide Buttons */
			tab_hash_val =window.location.hash; 
			mytab= tab_hash_val.substring(1);

			show_errors(project_id,mytab);
			if(window.location.hash=="#rewards")
			{
			   tr=280*$("#total_re").val()
			   $('#sections').height($(elem).height()+tr);
			   //alert($("#total_re").val());
			}
			
			if(window.location.hash=="#review")
			{
				$("#next_but").hide();
				$("#preview_but").show();
				$("#submit_but").show();
				$("#back_but").show();
			}
			else if(window.location.hash=="#guidelines")
			{
				$("#preview_but").hide();
				$("#next_but").show();
				$("#back_but").hide();
				$("#submit_but").hide();				
			}
			else
			{
				$("#next_but").show();
				$("#preview_but").show();
				$("#back_but").show();
				$("#submit_but").hide();
			}
                  
        //'this' is the element being scrolled ($pane) not jqueryfied
        }
    });
    $('#sections').trigger('goto',$('ul.target > li.target_panel').index($(window.location.hash+'-panel')));
       
/**
	 * No need to have only one element in view, you can use it for slideshows or similar.
	 * In this case, clicking the images, scrolls to them.
	 * No target in this case, so the selectors are absolute.
	 */
});
