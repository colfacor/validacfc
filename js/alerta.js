function alertaeliminar(){
Swal.fire({
  title: 'Estas Seguro de Cerrar Lote?',
  text: "",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, Cerrar!'
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire(
      'Cerrado!',
      'El Producto fue Cerrado Correctamente.',
      'success'
    )
  }
})

}

function confirmacion(e) {
	if confirm("¿Esta seguro que desea eliminar este registro?"); {
		return true;
	}else{
		e.preventDefault();
	}
}

let linkDelete = document.querySelectorAll(".table__item__link");

for (var i = 0; i < linkDelete.length; i++) {
	linkDelete[i].addEventListener('click', confirmacion);
}