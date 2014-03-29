
$(function(){

		
		$("#btnAdd").click(function() {
		
			$("#SubscriberTargetMail > option:selected").appendTo("#SubscriberSelectedMail");

		});

		$("#btnAddAll").click(function() {

			$("#SubscriberTargetMail > option").appendTo("#SubscriberSelectedMail");

		});

		$("#btnRemove").click(function() {

			$("#SubscriberSelectedMail > option:selected").appendTo("#SubscriberTargetMail");

		});

		$("#btnRemoveAll").click(function() {

			$("#SubscriberSelectedMail > option").appendTo("#SubscriberTargetMail");

		});
	
		
		
});
