
function init() {
	$("#ticket_form").on("submit", function(e) {
		guardaryeditar(e);
		
});	

}

$(document).ready(function() {
	$('#ticket_descripcion').summernote({
			height: 150,
	});
			
	$.post("../../controller/categoria.php?op=combo",function(data, status){
		$('#cat_id').html(data);
	});
	
});

function guardaryeditar(e) {
	e.preventDefault();
	var titulo = $('#ticket_titulo').val();
	var descripcion = $('#ticket_descripcion').val();
	
	if (titulo.trim() === '' || descripcion.trim() === '<p></p>' || descripcion.trim() === '') { //Verificamos que no esten vacios
        Swal.fire({
            title: "Error",
            text: "Por favor, complete todos los campos.",
            icon: "error"
        });
        return; // Detiene la ejecución si los campos están vacíos
    }

	var formData = new FormData($("#ticket_form")[0]);
	$.ajax({
		url: "../../controller/ticket.php?op=insert",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos){
			$('#cat_id').val('');
			$('#ticket_titulo').val('');
			$('#ticket_descripcion').summernote('code', '');
			Swal.fire({
				title: "Correcto",
				text: "Ticket registrado correctamente",
				icon: "success"
			});
		},
		error: function(jqXHR, textStatus, errorThrown) {
             console.error("Error en la llamada AJAX:", textStatus, errorThrown);
             alert("Hubo un error al registrar el ticket. Por favor, inténtalo de nuevo.");
		}
	});	
}

init();