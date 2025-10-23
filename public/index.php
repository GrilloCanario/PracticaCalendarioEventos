<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <h1>Generador de Eventos</h1>
    <form action="process.php" method="POST">
        <p>
        <label for="ponentes">Números de ponentes:</label>
        <input type="number" placeholder="1" name="num-ponentes">  
        </p>
        <p>
            <label for="eventos">Números de eventos:</label>
            <input type="number" placeholder="1" name="num-eventos">
        </p>
        <p>
            <p>
                <label for="fecha-inicio">Fecha de inicio del evento:</label>
                <input type="date" name="fecha-inicio">
            </p>
            <p>
                <label for="fecha-final">Fecha de fin del evento:</label>
                <input type="date" name="fecha-final">
            </p>
            <p>
                <label for="formato">Formato del calendario:</label>
                <select name="formato">
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