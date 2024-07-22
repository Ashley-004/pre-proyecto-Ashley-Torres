<?php
// Activa las sesiones
session_start();
// Comprueba si existe la sesión 'email', en caso contrario vuelve a la página de identificación
if (!isset($_SESSION['email'])) {
    header('Location: identificarse.php');
    die();
}
?>

<?php
    $host ='127.0.0.1';
    $BD ='CRUD';
    $usuario ='root';
    $clave ='';

    $hostPDO="mysql:host=$host; dbname=$BD;";
    $tuPDO=new PDO($hostPDO,$usuario,$clave);
    $consulta= $tuPDO->Prepare('SELECT*FROM estudiantes;');

    $consulta->execute();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BD consulta</title>
        <style>
        table {
    border-collapse: separate;
    border-spacing: 0 10px;
    width: 90%;
    margin: 30px auto;
    font-size: 16px;
    font-family: 'Verdana', sans-serif;
    color: #333;
    background-color: #f5f5f5;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

th, td {
    border: none;
    padding: 15px;
    text-align: center;
    height: 50px;
    background-color: #fff;
    border-bottom: 2px solid #E1BEE7; /* Morado lila claro */
    transition: background-color 0.3s;
}

th {
    background-color: #EDE7F6; /* Morado lila muy claro */
    font-weight: bold;
    color: #4A148C; /* Morado lila oscuro */
}

tr:hover td {
    background-color: #F3E5F5; /* Morado lila muy claro */
}

.button {
    background-color: #AB47BC; /* Morado lila */
    color: #fff;
    padding: 15px 30px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    text-decoration: none;
    font-size: 14px;
    transition: background-color 0.3s, transform 0.3s;
}

.button:hover {
    background-color: #BA68C8; /* Morado lila más claro */
    transform: scale(1.05);
}

.mis-botones {
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 20px;
    margin: 30px auto;
}


        </style>
</head>
<body>

    <div class="mis-botones">
    <p><a class="button" href="insertar.php"> Crear</a></p>
    <p><a class="button" href="logout.php"> Cerrar sesión</a></p>
    </div>
 

    <table>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDO</th>
            <th>DOCUMENTO</th>
            <th>EMAIL</th>
            <th>CIUDAD</th>
            <th colspan="2">ACCIONES</th>
        </tr>
    <?php foreach($consulta as $key =>$valor): ?>
        <tr>
            <td><?= $valor['id']; ?></td>
            <td><?= $valor['nombre']; ?></td>
            <td><?= $valor['apellido']; ?></td>
            <td><?= $valor['documento']; ?></td>
            <td><?= $valor['email']; ?></td>
            <td><?= $valor['ciudad']; ?></td>
            <td><a class="button" href="actualizar.php?id=<?=$valor['id']?>">Modificar</a></td>
            <td><a class="button" href="borrar.php?id=<?=$valor['id']?>">Borrar</a></td>
        </tr>
        <?php endforeach;?>
    </table>
</body>
</html>