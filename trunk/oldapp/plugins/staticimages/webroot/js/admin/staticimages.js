

function addMore()
{ 
    count	=	$("#counterImage").val();
	

    $("#addImage").append('<div id="image_'+count+'" style="float:left; width:500px; padding-top:10px;padding-left:0px;"><input type="file" name="data[Staticimage][File][]" id="adImages_'+count+'" value="" /> <a href="#" onClick="remove('+count+')" class="remove_lnk"> Remove</a></div>');
		
    $("#addImage").append('<div id="caption_'+count+'" style=" width:500px; padding-top:10px;padding-left:0px;"><input type="text" name="data[Staticimage][caption][]" id="adCaption_'+count+'" value="" class="ui-widget-content ui-corner-all"/></div>');
		
    count++;
		
    $("#counterImage").val(count);
	
	
    $( ".remove_lnk" ).button({
        icons: {
            primary: "ui-icon-cancel"
        }
    }).click(function(){
			
        return true;
			
    });
	
}

function remove(count)
{	
	
    $("#image_"+count+"").remove();
    $("#caption_"+count+"").remove();
	
    $("#counterImage").val(count);
}

