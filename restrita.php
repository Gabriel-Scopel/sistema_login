<?php
require('config/conexao.php');
$user = auth($_SESSION['TOKEN']);
if($user){
    echo "<h1> SEJA BEM VINDO <b style='color:red'>".$user['nome']."!</b></h1>";
    echo "<a href='logout.php'>Sair do sistema</a>";
}else{
    header('location: index.php');
}
/* $sql = $pdo->prepare("SELECT * FROM usuarios WHERE token=? LIMIT 1");
$sql->execute(array($_SESSION['TOKEN']));
$usuario = $sql->fetch(PDO::FETCH_ASSOC);
if(!$usuario){
    header('location: index.php');
}else{
    echo "<h1> SEJA BEM VINDO <b style='color:red'>".$usuario['nome']."!</b></h1>";
    echo "<a href='logout.php'>Sair do sistema</a>";
} */