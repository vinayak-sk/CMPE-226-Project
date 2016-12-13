var all = false;
var cond1, cond2, cond3, cond4, cond5, cond6 = false;
var progressValue = 0;

$( "#inputPassword" ).keyup(function() {

	var userId = $('#inputUserId').val();
	var content = $('#inputPassword').val();

	if(/[A-Z]/.test(content)){
		//console.log("Capital Word : " + content);
		$("#cond1False").css("visibility", "hidden");
		$("#cond1True").css("visibility", "visible");
		cond1 = true;
	}
	else{
		$("#cond1False").css("visibility", "visible");
		$("#cond1True").css("visibility", "hidden");
		cond1 = false;
	}

	if(/[a-z]/.test(content)){
		//console.log("Small Word : " + content);
		$("#cond2False").css("visibility", "hidden");
		$("#cond2True").css("visibility", "visible");
		cond2 = true;
	}
	else{
		$("#cond2False").css("visibility", "visible");
		$("#cond2True").css("visibility", "hidden");
		cond2 = false;
	}

	if(/\d/.test(content) ){
		//console.log("number : " + content);
		$("#cond3False").css("visibility", "hidden");
		$("#cond3True").css("visibility", "visible");
		cond3 = true;
	}
	else{
		$("#cond3False").css("visibility", "visible");
		$("#cond3True").css("visibility", "hidden");
		cond3 = false;
	}

	if(content.length >7 && content.length <21){
		//console.log("Length : true");
		$("#cond4False").css("visibility", "hidden");
		$("#cond4True").css("visibility", "visible");
		cond4 = true;
	}
	else{
		$("#cond4False").css("visibility", "visible");
		$("#cond4True").css("visibility", "hidden");
		cond4 = false;
	}

	var specialChar = /^(?=.*?[^\w\s])/;
	if(specialChar.test(content)){
		//console.log("Special char : true");
		$("#cond5False").css("visibility", "hidden");
		$("#cond5True").css("visibility", "visible");
		cond5 = true;
	}
	else{
		$("#cond5False").css("visibility", "visible");
		$("#cond5True").css("visibility", "hidden");
		cond5 = false;
	}

	if(userId != content){
		//console.log("same as uid : false" );
		$("#cond6False").css("visibility", "hidden");
		$("#cond6True").css("visibility", "visible");
		cond6 = true;
	}
	else{
		$("#cond6False").css("visibility", "visible");
		$("#cond6True").css("visibility", "hidden");
		cond6 = false;
	}
	
	var regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{7,20}$/ ;
	if(regex.test(content)){
		console.log("All Entries : " + regex.test(content));
		all = true;
	}

	progressValue = (20 * cond1) + (20 * cond2) + (20 * cond3) + (20 * cond4) + (20 * cond5);
	$("#progressBar").val(progressValue);

	if($("#progressBar").val()>80){
		$("#weak").css("visibility", "hidden");
		$("#strong").css("visibility", "visible");
	}

});


$(document).ready(function(){
    $("form").submit(function(event){
        event.preventDefault();

alert("here");
    // Get some values from elements on the page:
   // var $form = $( this ),
      var  userId = $( "#inputUserId" ).val(),
        password = $( "#inputPassword" ).val(),
        verifyPassword = $( "#inputPassword" ).val(),
        gender = $( "#gender" ).find(":selected").text(),
        deviceType = $( "#deviceType" ).find(":selected").text(),
        paymentMethod = $( "#paymentMethod" ).find(":selected").text();
      //  url = $form.attr( "action" );

    var data = {
      		userId:userId, password:password, gender:gender, deviceType:deviceType,
      		paymentMethod:paymentMethod
    	} 

    	alert(userId);
   		$.ajax({
        type: "POST",
        url: "battles.php",
        data: { action:"registerUser", userId:userId, password:password, gender:gender, deviceType:deviceType,
      		paymentMethod:paymentMethod }
        }).done(function( data ) {
            alert(data);                
        })
        .fail(function() {
           alert( "error" );
     	});
    });



});
