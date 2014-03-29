function loadPage(path) {		
    var section 	= 	path.replace(WEBSITE_ADMIN_URL,'');
    var params  	= 	section.split('/');
    var parameters	=	'';
    var controller 	= 	params[0];
    if( controller	==	'' ){
        controller	= 'home';
    }

    $('td.normal div.normal')
    .empty()
    .append('<table align="center" width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td valign="top" width="10%" id="left_nav" class="left-nav"></td><td  valign="top"><table align="center" width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td  id="breadcrumb"></td></tr><tr><td id="content_for_layout" ><table align="center" width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td id="contents" valign="top"  ></td></tr></table></td></tr></table></td></tr></table>')
    .find('#left_nav')
    .load(WEBSITE_ADMIN_URL + 'left_nav/' + controller + '/ .demos-nav', function() {
        $('#left_nav a').each(function() {
					
            $(this).click(function() {
						
                return loadContent(this.getAttribute('href'));
						
            });
        });
						
        return loadContent(path );
				
    })
    .end();

}

function checkValue( o, n ) {
    if ( o.val().length ==0 || o.val()=="" ) {
        o.addClass( "ui-state-error" );
        o.focus();
        updateTips( "Please enter a value for " + n +  "." );
        return false;
    } else {
        return true;
    }
}

function updateTips( t ) {
    $( ".validateTips" )
    .text( t )
    .addClass( "ui-state-highlight" );
    setTimeout(function() {
        $( ".validateTips" ).removeClass( "ui-state-highlight", 1500 );
    }, 500 );
}

		
function loadContent(path){
    window.location.href=path;
    return false;
    if(window.location.hash){
        path = path.replace(window.location.hash,'');
    }
    window.location.hash = path.replace(WEBSITE_ADMIN_URL,'');
    var cheight = $('#contents').height();	
	
    $.get(path, function(data) {
        $('#contents')
        .empty()
        .append(data);
			
			
		
    });
	
    return false;
		
}


function updateTips( t ) {
    $( ".validateTips" )
    .text( t )
    .addClass( "ui-state-highlight" );
    setTimeout(function() {
        $( ".validateTips" ).removeClass( "ui-state-highlight", 1500 );
    }, 500 );
}


function updateAjaxTips( t ) {
    $( ".ajaxMessage" ).html( t );
	 
    $( ".ajaxMessage" ).css('display','');
    setTimeout(function() {
        $( ".ajaxMessage" ).slideUp(250,function(){});
    }, 5000 );
//$('.ajaxMessage').remove()
}


function checkLength( o, n, min, max ) {
    if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
            min + " and " + max + "." );
        return false;
    } else {
        return true;
    }
}

function checkValue( o, n ) {
    if ( o.val().length ==0 || o.val()=="" ) {
        o.addClass( "ui-state-error" );
        o.focus();
        updateTips( "Please enter a value for " + n +  "." );
        return false;
    } else {
        return true;
    }
}

function custom_error( o, n ) {
    o.addClass( "ui-state-error" );
    updateTips(  n  );
    return false;
	
}

function checkRegexp( o, regexp, n ) {
    if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        o.focus();
        updateTips( n );
        return false;
    } else {
        return true;
    }
}

function compareGreater( o1,o2, n ) {
    if ( parseFloat(o1.val()) < (parseFloat(o2.val()) +0.011) ) {
        o1.addClass( "ui-state-error" );
        o1.focus();
        updateTips( n );
        return false;
    } else {
        return true;
    }
}	

function deleteAjax(obj){
	
    $.ajax({
        url:obj.attr('href'),
        type: "GET",
        success: function(r){
			
            $("#row_"+obj.attr('id')).slideUp(250,function(){
                $("#row_"+obj.attr('id'))
            });
            $("#row_"+obj.attr('id')).remove();
            $(".successmsg").hide();
            updateAjaxTips(r);
            $( "#dialog_del" ).dialog( "close" );
            //window.location.href	=	baseurl+'universities';
            return false;
        }
    });
	
}

function checkAll()
{
    var rs = (document.getElementById('chkAll').checked)?true:false;
    for(i=0;i<(document.getElementsByName('data[usersChk][]').length/2);i++)
    {
        document.getElementById('iId_'+i).checked = rs;
    }  
}
	
function activeAll()
{
    var message=checkempty();
    if(message)
    {
        var confirmation=confirm("Are you sure, you want to change the status of selected record(s)? ");
        if(confirmation)
        {
            document.getElementById('AdminsOperation').value="active";
            document.AdminsOperateForm.submit();
        }

    }
}

function inActiveAll()
{
    var message=checkempty();
    if(message)
    {
        var confirmation=confirm("Are you sure, you want to change the status of selected record(s)? ");
        if(confirmation)
        {
            document.getElementById('AdminsOperation').value="inactive";
            document.AdminsOperateForm.submit();
        }

    }
}

function deleteAll()
{
    var message=checkempty();
    if(message)
    {
        var confirmation=confirm("Are you sure you want to delete the selected record(s) ? ");
        if(confirmation)
        {
            document.getElementById('AdminsOperation').value="delete";
            document.AdminsOperateForm.submit();
        }

    }
}

function checkempty()
{
    var ncheck=(document.getElementsByName('data[usersChk][]').length)/2;
    //var element=product.length;
    var nelement=0;


    for(i=0;i<ncheck;i++)
    {
        if(document.getElementById('iId_'+i).checked)
        {
            nelement=1;
            break;
        }
    }  
    if(nelement>0)
    {
        return true;
    }
    else
    {
        alert("Please select at least one record.");
        return false;
    }
}





$(document).ready(function(){  
      
    $("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)  
      
    $("ul.topnav li span").hover(function() { //When trigger is clicked...  
      
        //Following events are applied to the subnav itself (moving subnav up and down)  
        $(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click  
      
        $(this).parent().hover(function() {  
            }, function(){  
                $(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up  
            });  
      
    //Following events are applied to the trigger (Hover events for the trigger)  
    }).hover(function() {  
        $(this).addClass("subhover"); //On hover over, add class "subhover"  
    }, function(){  //On Hover Out  
        $(this).removeClass("subhover"); //On hover out, remove class "subhover"  
    });  
        
        
        
    /* common for all plugins */
    $(".close_success").click(function(){
        $('.successmsg').animate({
            opacity: 0
        }, 250, function(){
            $('.successmsg').slideUp(250, function(){
                $('.successmsg').remove()
            });
        });
        return false;
    });
    $(".close_error").click(function(){
        $('.errormsg').animate({
            opacity: 0
        }, 250, function(){
            $('.errormsg').slideUp(250, function(){
                $('.errormsg').remove()
            });
        });
        return false;
    });

    $("[id^=row]").mouseover(function(){

        var id	=	($(this).attr('id')).replace('row_', '');
        $('#action_row_'+id).css('visibility','visible');
    //$('#action_row_'+id).css('display','');
    //$(this).css('background-color','#DDDDDD');

    });
    $("[id^=row]").mouseout(function(){

        var id	=	($(this).attr('id')).replace('row_', '');
        $('#action_row_'+id).css('visibility','hidden');
    //$('#action_row_'+id).css('display','none');
    //$(this).css('background-color','');

    });
          
        
        
        
    //$(".uichkbox").checkbox({ text: false });
	
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
		
    $( ".edit_lnk" ).button({
        icons: {
            primary: "ui-icon-pencil"
        }
    }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
		
    $( ".delete_lnk" ).button({
        icons: {
            primary: "ui-icon-trash"
        }
    }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
	
    $( ".search_lnk" ).button({
        icons: {
            primary: "ui-icon-search"
        }
    }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
	
    $( ".comment_lnk" ).button({
        icons: {
            primary: "ui-icon-comment"
        }
    }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
	
    $( ".login_lnk" ).button({
       
        }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
	
		
    $( ".active_lnk, .inactive_lnk, .cancel_lnk" ).button({
        icons: {
            primary: ""
        }
    }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
	
	 $( ".submit_button" ).button({
        icons: {
            primary: "ui-icon-disk"
        }
    }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
	
	
    $( ".download_lnk" ).button({
        icons: {
            primary: "ui-icon-arrowthick-1-s"
        }
    }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
	
    $( ".add_more_lnk" ).button({
       
        }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
    
    // for active all
    $( ".activate_all" ).button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    }).click(function(){
        activeAll();
    });
    $( ".delete_all" ).button({
        icons: {
            primary: "ui-icon-trash"
        }
    }).click(function(){
        deleteAll();
    });
    
    
    // for inactive all
    $( ".inactivate_all" ).button({
        icons: {
            primary: "ui-icon-cancel"
        }
    }).click(function(){
        inActiveAll();
    });
	
	 $( ".next_lnk" ).button({
	 
		 icons: {
            primary: "ui-icon-seek-next"
        }
       
        }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
	
	$( ".pre_lnk" ).button({
	 
		 icons: {
            primary: "ui-icon-seek-prev"
        }
       
        }).click(function(){
			
        return true;// loadContent(this.href);
			
    });
	
	
	
      
});
