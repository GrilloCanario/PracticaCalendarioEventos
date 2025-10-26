<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
    <style src="styles.css"></style> <!-- estilos CSS -->
    <script src="script.js" defer></script> <!-- No se si va a ser necesario pero por si acaso -->
</head>

<body>
    <h1>Generador de Eventos</h1>
    
    <!-- Formulario para recoger los datos del evento en post -->
    <form action="process.php" method="post">
        <p>
        <label for="ponentes">Números de ponentes:</label>
        <input type="number" placeholder="1" name="num-ponentes"> <!-- número de ponentes -->
        </p>
        <p>
            <label for="eventos">Números de eventos:</label>
            <input type="number" placeholder="1" name="num-eventos"> <!-- número de eventos -->
        </p>
        <p>
            <p>
                <label for="fecha-inicio">Fecha de inicio del evento:</label>
                <input type="date" name="fecha-inicio"> <!-- fecha de inicio -->
            </p>
            <p>
                <label for="fecha-final">Fecha de fin del evento:</label>
                <input type="date" name="fecha-final"> <!-- fecha de fin -->
            </p>
            <p>
            <label for="formato">Formato del calendario:</label>
                <select name="formato" id="formato"> <!-- formato del calendario -->
                    <option value="HTML">HTML</option>
                    <option value="PDF">PDF</option>
                    <option value="CSV">CSV</option>
                </select>
            </p>
        </p>
        <input type="submit" value="Enviar" id="boton-enviar">
    </form>
</body>
</html>