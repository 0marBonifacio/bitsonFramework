$(document).ready(function()
{
	$('#form1').validate
	({
		rules: 
		{
			titulo:
			{
				required: true
			},
			cuerpo: 
			{
				required: true
			}
		},
		
		messages: 
		{
			titulo: 
			{
				required: "Debe ingresar el título"
			},
			cuerpo: 
			{
				required: "Debe ingresar el cuerpo del post"
			}
		}
	});
});