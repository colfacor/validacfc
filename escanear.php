<!DOCTYPE html>
<html>
<head>
    <title>Seleccionar Checkbox con Lector de Código de Barras</title>
</head>
<body>
    <form id="barcodeForm">
        <input type="checkbox" id="checkbox" name="checkbox" value="3338213446220231106"> Checkbox
        <input type="text" id="barcodeInput" placeholder="Escanear código de barras">
    </form>

    <script>
        const checkbox = document.getElementById("checkbox");
        const barcodeInput = document.getElementById("barcodeInput");
        let isChecked = false; // Variable para llevar el registro del estado del checkbox

        barcodeInput.addEventListener("input", function (event) {
            const scannedBarcode = event.target.value;

            if (scannedBarcode === "3338213446220231106") {
                isChecked = true;
            }

            checkbox.checked = isChecked;

            event.preventDefault(); // Prevenir la recarga de la página
        });
    </script>
</body>
</html>