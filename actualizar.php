<?php
    $host ='127.0.0.1';
    $BD ='CRUD';
    $usuario ='root';
    $clave ='';
    $id=isset($_REQUEST['id']) ? $_REQUEST['id']: null;
    $nombre=isset($_REQUEST['nombre']) ? $_REQUEST['nombre']: null;
    $apellido=isset($_REQUEST['apellido']) ? $_REQUEST['apellido']: null;
    $documento=isset($_REQUEST['documento']) ? $_REQUEST['documento']: null;
    $email=isset($_REQUEST['email']) ? $_REQUEST['email']: null;
    $ciudad=isset($_REQUEST['ciudad']) ? $_REQUEST['ciudad']: null;

    $hostPDO="mysql:host=$host;dbname=$BD;";
    $tuPDO=new PDO($hostPDO,$usuario,$clave);

    if($_SERVER['REQUEST_METHOD'] == "POST" ) {
        $actualizar = $tuPDO-> prepare('UPDATE estudiantes SET nombre = :nombre, apellido = :apellido, documento = :documento, email = :email, ciudad = :ciudad WHERE id = :id');

        $actualizar->execute (
            [
                'id' => $id,
                'nombre'=>$nombre,
                'apellido'=>$apellido,
                'documento'=>$documento,
                'email'=>$email,
                'ciudad'=>$ciudad
            ]
            );
            header('Location:consultasBD.php');
    } else {
        
        $consulta = $tuPDO -> prepare(
            'SELECT * FROM estudiantes WHERE id = :id;'
        );
        
        $consulta-> execute(
            [
                'id' => $id
            ]);
        }

        $resultado = $consulta->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar</title>
    <style>
 
 form {
    width: 60%;
    margin: 50px auto;
    padding: 25px;
    border: 2px solid #AB47BC; /* Morado lila */
    border-radius: 20px;
    box-shadow: 0 0 15px rgba(171, 71, 188, 0.3);
    background-color: #fff;
    font-family: 'Verdana', sans-serif;
}

label {
    display: block;
    margin-bottom: 15px;
    font-weight: bold;
    color: #4A148C; /* Morado lila oscuro */
    font-size: 14px;
}

input[type="text"], input[type="email"] {
    width: 100%;
    padding: 15px;
    margin-bottom: 25px;
    border: 2px solid #ddd;
    border-radius: 10px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    font-size: 14px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

input[type="text"]:focus, input[type="email"]:focus {
    border-color: #AB47BC; /* Morado lila */
    box-shadow: 0 0 10px rgba(171, 71, 188, 0.6);
    outline: none;
}

input[type="submit"] {
    background-color: #AB47BC; /* Morado lila */
    color: #fff;
    padding: 15px 30px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s, transform 0.3s;
}

input[type="submit"]:hover {
    background-color: #BA68C8; /* Morado lila más claro */
    transform: translateY(-2px);
}

input[type="submit"]:active {
    background-color: #AB47BC; /* Morado lila */
}


  </style>
</head>
<body>
    <form method="post">
            <label for ="nombre">Nombre</label>
            <input id="nombre" type="text" name="nombre" value="<?=$resultado['nombre']?>">
            <label for ="apellido">Apellido<label>
            <input id="apellido" type="text" name="apellido" value="<?=$resultado['apellido']?>">
            <label for ="documento">Documento<label>
            <input id="documento" type="text" name="documento" value="<?=$resultado['documento']?>">
            <label for ="email">Email<label>
            <input id="email" type="email" name="email" value="<?=$resultado['email']?>">
            <label for ="ciudad">Ciudad<label>
            <input id="ciudad" type="text" name="ciudad" value="<?=$resultado['ciudad']?>">
            <input type="hidden" id="id" name="id" value="<?=$resultado['id']?>">
            <input type="submit" value="Guardar">
    </form>
</body>
</html>