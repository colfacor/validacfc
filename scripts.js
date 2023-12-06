document.getElementById('btnAnularValidacion').addEventListener('click', function() {
    // Mostrar el loader cuando se hace clic en el botón
    document.getElementById('loader').style.display = 'block';

    // Aquí colocarías el código para enviar la solicitud al servidor o realizar cualquier tarea.
    // Por ejemplo, una petición AJAX o el procesamiento del formulario.

    // Simulación de una demora para propósitos de demostración
    setTimeout(function() {
        // Ocultar el loader después de que finalice la tarea (simulada)
        document.getElementById('loader').style.display = 'none';
        // Aquí puedes realizar otras acciones después de completar la tarea.
        // Por ejemplo, redirigir a otra página o mostrar un mensaje de confirmación.
    }, 2000); // Cambiar este valor para simular una duración diferente
});