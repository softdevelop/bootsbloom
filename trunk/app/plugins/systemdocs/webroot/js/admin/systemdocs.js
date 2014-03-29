	
function addMore()
{ 
	count	=	$("#counterdoc").val();
	
		
	$("#adddoc").append('<div id="doc_'+count+'" style=" width:500px; padding-top:10px;padding-left:0px"><input type="file" name="data[Systemdoc][doc_name][]" id="addocs_'+count+'" value="" /> <a href="#" onClick="remove('+count+')" class="remove_lnk"> Remove</a></div>');
	
	count++;
	$("#counterdoc").val(count);


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
	$("#doc_"+count+"").remove();
	$("#counterdoc").val(count);
}






