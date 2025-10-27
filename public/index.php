<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Eventos</title>    
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <h1>GENERADOR DE EVENTOS</h1>
    
    <form action="process.php" method="post">
        <p>
            <label for="ponentes">NÚMERO DE PONENTES</label>
            <input type="number" placeholder="1" name="num-ponentes">  
        </p>
        <p>
            <label for="eventos">NÚMERO DE EVENTOS</label>
            <input type="number" placeholder="1" name="num-eventos">
        </p>
        <p>
            <label for="fecha-inicio">FECHA DE INICIO DEL/LOS EVENTO/S</label>
            <input type="date" name="fecha-inicio">
        </p>
        <p>
            <label for="fecha-final">FECHA DE FIN DEL/LOS EVENTO/S</label>
            <input type="date" name="fecha-final">
        </p>
        <p>
            <label for="formato">FORMATO DESEADO DEL CALENDARIO</label>
            <select name="formato" id="formato">
                <option value="HTML">HTML</option>
                <option value="PDF">PDF</option>
                <option value="CSV">CSV</option>
            </select>
        </p>
        <input type="submit" value="Enviar" id="boton-enviar">
    </form>
</body>
</html>