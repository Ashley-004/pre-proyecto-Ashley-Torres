<?php
$email = isset($_REQUEST['email']) ? urldecode($_REQUEST['email']) : '';
$token = isset($_REQUEST['token']) ? urldecode($_REQUEST['token']) : '';


$miPDO = new PDO('sqlite:base-de-datos.sqlite');

$miConsulta = $miPDO->prepare('SELECT COUNT(*) as length FROM usuarios WHERE email = :email AND token = :token AND activo = 0;');

$miConsulta->execute([
    'email' => $email,
    'token' => $token
]);
$resultado = $miConsulta->fetch();

if ((bool) $resultado['length']) {
    
    $miActualiacion = $miPDO->prepare('UPDATE usuarios SET activo = 1 WHERE email = :email;');
    
    $miActualiacion->execute([
        'email' => $email
    ]);
   
    header('Location: identificarse.php?activada=1');
    die();
}

header('Location: identificarse.php');
die();
