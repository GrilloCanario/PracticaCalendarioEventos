<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <h1>Generador de Eventos</h1>
    <form action="" method="post">
        <p>
        <label for="ponentes">Números de ponentes:</label>
        <input type="number" placeholder="1">  
        </p>
        <p>
            <label for="eventos">Números de eventos:</label>
            <input type="number" placeholder="1">
        </p>
        <p>
            <label for="fecha">Rango del evento (fecha inicio y fecha final):</label>
            <input type="date" id="fecha-inicio" name="fecha-inicio">
            <input type="date" id="fecha-final" name="fecha-final">
        </p>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>