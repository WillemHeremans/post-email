jQuery(document).ready(function(){


	$( "div.details" ).hide();

	$(".fen").on('click',function(){
		$('.details').hide();
	});


	$("#fen1").on('click',function(){
		$('#det1').show("fast");

	});
	$("#fen2").on('click',function(){
		$('#det2').show("fast");

	});
	$("#fen3").on('click',function(){
		$('#det3').show("fast");

	});


	$("#fen4").on('click',function(){
		$('#det4').show("fast");

	});
	$("#fen5").on('click',function(){
		$('#det5').show("fast");

	});
	$("#fen6").on('click',function(){
		$('#det6').show("fast");

	});
});
