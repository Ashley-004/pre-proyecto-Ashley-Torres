<?php

function validar_requerido(string $texto): bool
{
    return !(trim($texto) == '');
}

function validar_email(string $texto): bool
{
    return filter_var($texto, FILTER_VALIDATE_EMAIL);
}

$errores = [];
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

   
    if (!validar_requerido($email)) {
        $errores[] = 'Campo Email obligatorio.';
    }

    if (!validar_email($email)) {
        $errores[] = 'Campo Email no tiene un formato válido';
    }

    
    if (!validar_requerido($password)) {
        $errores[] = 'Campo Contraseña obligatorio.';
    }

   
    $BD ='CRUD';
    $miPDO = new PDO("mysql:host=127.0.0.1; dbname=$BD;", 'root', '');
    
    $miConsulta = $miPDO->prepare('SELECT COUNT(*) as length FROM usuarios WHERE email = :email;');
   
    $miConsulta->execute([
        'email' => $email
    ]);
   
    $resultado = $miConsulta->fetch();
    
    if ((int) $resultado['length'] > 0) {
        $errores[] = 'La dirección de email ya esta registrada.';
    }

   
    if (count($errores) === 0) {
        
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $miNuevoRegistro = $miPDO->prepare('INSERT INTO usuarios (email, password, activo, token) VALUES (:email, :password, :activo, :token);');
        
        $miNuevoRegistro->execute([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'activo' => 0,
            'token' => $token
        ]);

     

       
        $headers = [
            'From' => 'curso@php.com',
            'Content-type' => 'text/plain; charset=utf-8'
        ];
       
        $emailEncode = urlencode($email);
        $tokenEncode = urlencode($token);
        
        $textoEmail = "
           Hola!\n 
           Gracias por registrate en la mejor plataforma de internet, demuestras inteligencia.\n
           Para activar entra en el siguiente enlace:\n
           http://midomino.com/verificar-cuenta.php?email=$emailEncode&token=$tokenEncode
            ";
        
        mail($email, 'Activa tu cuenta', 'Gracias por suscribirte', $headers);

        

        header('Location: identificarse.php?registrado=1');
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
  
  form {
    width: 50%;
    margin: 40px auto;
    padding: 30px;
    border: 2px solid #AB47BC; /* Morado lila */
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(171, 71, 188, 0.3);
    background-color: #fff;
    font-family: 'Verdana', sans-serif;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #4A148C; /* Morado lila oscuro */
    font-size: 14px;
}

input[type="text"], input[type="email"] {
    width: 100%;
    padding: 15px;
    margin-bottom: 20px;
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
    background-color: #4A148C; /* Morado lila oscuro */
    color: #fff;
    padding: 15px 30px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.3s;
}

input[type="submit"]:hover {
    background-color: #BA68C8; /* Morado lila más claro */
    transform: scale(1.05);
}

input[type="submit"]:active {
    background-color: #8E24AA; /* Morado lila intermedio */
}


        </style>
</head>
<body>
  
    <?php if (isset($errores)): ?>
    <ul class="errores">
        <?php 
            foreach ($errores as $error) {
                echo '<li>' . $error . '</li>';
            } 
        ?> 
    </ul>
    <?php endif; ?>
  
    <form action="" method="post">
        <div>

            <label>
                E-mail
                <input type="text" name="email">
            </label>
        </div>
        <div>
        
            <label>
                Contraseña
                <input type="text" name="password">
            </label>
        </div>
        <div>
           
            <input type="submit" value="Registrarse">
        </div>
    </form>
</body>
</html>
