$(function(){
    $( ".delete" ).click(function(){
        link = this;
      
        $( "#dialog-confirm-delete-all" ).dialog( "open");
                
        return false;// loadContent(this.href)
    });
		
    $( "#dialog-confirm-delete-all" ).dialog({
        autoOpen: false,
        resizable: true,
        height:200,
        width:600,
        modal: true,
        buttons: {
            "Delete permanently from system": function(ui) {
                $.unblockUI;
				
                $.ajax({
						
                    url: link+"/permanent",
                    type: "POST",
                    success: function(){
							
                        window.location.href=WEBSITE_ADMIN_URL+"categories";
                    }
                });
                $( this ).dialog( "close" );
            },
            "Temperory Delete": function(ui) {
                $.unblockUI;
				
                $.ajax({
						
                    url: link+"/temp",
                    type: "POST",
							
                    success: function(){
                        window.location.href=WEBSITE_ADMIN_URL+"categories";
                    }
                });
                $( this ).dialog( "close" );
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });
    	
    $( ".archieve_categories" ).button({
        icons: {
            primary: "ui-icon-contact"
        }
    }).click(function(){
	
        return true;// loadContent(this.href)
	
    });
    $( ".restore_all" ).button({
        icons: {
            primary: "ui-icon-transfer-e-w"
        }
    }).click(function(){
	
        restoreAll();
	
    });

   
    $( ".arc_delete" ).click(function(){
        link = this;
      
        $( "#arc-dialog-confirm-delete-all" ).dialog( "open");
                
        return false;// loadContent(this.href)
    });
		
    $( "#arc-dialog-confirm-delete-all" ).dialog({
        autoOpen: false,
        resizable: true,
        height:200,
        width:600,
        modal: true,
        buttons: {
            "Delete permanently from system": function(ui) {
                $.unblockUI;
				
                $.ajax({
						
                    url: link+"/permanent",
                    type: "POST",
                    success: function(){
							
                        window.location.href=WEBSITE_ADMIN_URL+"categories";
                    }
                });
                $( this ).dialog( "close" );
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });
});

function restoreAll()
{
    var message=checkempty();
    if(message)
    {
        var confirmation=confirm("Are you sure you want to delete the selected record(s) ? ");
        if(confirmation)
        {
            document.getElementById('AdminsOperation').value="restore";
            document.AdminsOperateForm.submit();
        }
    }
}
