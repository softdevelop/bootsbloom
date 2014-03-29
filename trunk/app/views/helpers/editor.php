<?php

class EditorHelper extends AppHelper {

    function render($element_id) 
	{
?>

<script type="text/javascript">
	tinymce.init({ 
		selector: '#<?php echo $element_id; ?>',
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste jbimages"
		],
		relative_urls: false
	});
</script>

<?
    }

}