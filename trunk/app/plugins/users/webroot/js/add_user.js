$(function(){
    $( ".add_lnk" ).button({
        icons: {
            primary: "ui-icon-plus"
        }
    }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
    
    
    $( ".back_lnk" ).button({
        icons: {
            primary: "ui-icon-arrowreturnthick-1-w"
        }
    }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
    
});