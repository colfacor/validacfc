<?php
include 'inc/conexion.php';
?>

<!DOCTYPE html>
<html>
<head>
    <script>
        // Arreglo para llevar un registro de los códigos ya escaneados
        var codigosEscaneados = [];

        // Función para manejar la verificación del número de validación y marcar el checkbox si coincide
        function handleValidationNumber(inputId) {
            var input = document.getElementById(inputId);
            var validationNumber = input.value;

            // Verificar si el código ya fue escaneado
            if (codigosEscaneados.includes(validationNumber)) {
                alert("Este código ya ha sido escaneado anteriormente.");
            } else {
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(function(checkbox) {
                    var dataValidationNumber = checkbox.getAttribute('data-validation-number');
                    if (dataValidationNumber === validationNumber) {
                        checkbox.checked = true;
                        input.value = ''; // Limpiar el campo de entrada
                        // Registrar el código escaneado
                        codigosEscaneados.push(validationNumber);
                    }
                });
            }

            setTimeout(function() {
                input.focus(); // Enfocar nuevamente el campo de entrada después de un breve retraso
            }, 0);
        }
    </script>
</head>
<body>
    <!-- Tabla con productos y select para elegir el producto -->
    <table>
        <?php
        $registros = mysqli_query($conexion, "SELECT id, num_validacion FROM validaciones WHERE cierre = 0 AND cuit_farm = '20202602887'");
        while ($rs = mysqli_fetch_array($registros)) {
            echo '
        <tr>
            <td>' . $rs['num_validacion'] . '</td>
            <td>
                <select id="productSelect' . $rs['num_validacion'] . '">
                    <option value="' . $rs['num_validacion'] . '">' . $rs['num_validacion'] . '</option>
                    <!-- Agrega más opciones para otros productos -->
                </select>
            </td>
            <td><input type="checkbox" id="checkbox' . $rs['num_validacion'] . '" data-validation-number="' . $rs['num_validacion'] . '"></td>
        </tr>';
        } ?>
    </table>
    <input type="text" id="validationInput" oninput="handleValidationNumber('validationInput')" placeholder="Escanea Aqui" >
</body>
</html>
