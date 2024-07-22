<?php 
   
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
    $password = isset($_REQUEST['contrasenya']) ? $_REQUEST['contrasenya'] : null;
    $errores = [];

   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        
        $BD ='CRUD';
        $miPDO = new PDO("mysql:host=127.0.0.1; dbname=$BD;", 'root', '');
        
        $miConsulta = $miPDO->prepare('SELECT activo, password FROM usuarios WHERE email = :email;');
        
        $miConsulta->execute([
            'email' => $email
        ]);
        
        $resultado = $miConsulta->fetch();
        if ($resultado !== false) {
            if ((int) $resultado['activo'] !== 1) {
                $errores[] = 'Tu cuenta aún no esta activa. ¿Has comprobado tu bandeja de correo?';
            } else {
                
                if (password_verify($password, $resultado['password'])) {
                    
                    session_start();
                    $_SESSION['email'] = $email;
                   
                    header('Location: consultasBD.php');
                    die();
                } else {
                    $errores[] = 'El email o la contraseña es incorrecta.';
                }
            }
        } else {
            $errores[] = 'El email no existe en nuestra base de datos.';
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entra</title>
            <style>

p {
    text-align: center;
    color: #4A148C; /* Morado lila oscuro */
    font-family: 'Verdana', sans-serif;
}

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

input[type="text"], input[type="email"], input[type="password"], input[type="contrasenya"] {
    width: 95%;
    padding: 15px;
    margin-bottom: 20px;
    border: 2px solid #ddd;
    border-radius: 10px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    font-size: 14px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, input[type="contrasenya"]:focus {
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
    
    <?php if (count($errores) > 0): ?>
    <ul class="errores">
        <?php 
            foreach ($errores as $error) {
                echo '<li>' . $error . '</li>';
            } 
        ?> 
    </ul>
    <?php endif; ?>
    
    <?php if(isset($_REQUEST['registrado'])): ?> 
    <p>¡Gracias por registrarte! Revista tu bandeja de correo para activar la cuenta.</p>
    <?php endif; ?> 
   
    <?php if(isset($_REQUEST['activada'])): ?> 
    <p>¡Cuenta activada!</p>
    <?php endif; ?> 
   
    <form method="post">
        <p>
            <input type="text" name="email" placeholder="Email"> 
        </p> 
        <p>
            <input type="password" name="contrasenya" placeholder="Contraseña"> 
        </p>
        <p>
            <input type="submit" value="Entrar"> 
        </p>
    </form>
</body>
</html>
