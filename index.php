<?php
require('config/conexao.php');
if(isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])){
    $email = limpaPost($_POST['email']);
    $senha = limpaPost($_POST['senha']);
    $senha_cript = sha1($senha);
    

    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? AND senha=? LIMIT 1");
    $sql->execute(array($email,$senha_cript));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        if($usuario['status']=="confirmado"){
            $token = sha1(uniqid().date('d-m-Y-H-i-s'));
            $sql = $pdo->prepare("UPDATE usuarios SET token=? WHERE email=? AND senha=?");
            if($sql->execute(array($token,$email,$senha_cript))){
                $_SESSION['TOKEN'] = $token;
                header('location: restrita.php');
            }   
        }else{
            $erro_login = "Por favor, confirme seu cadastro pelo email.";
        }
    }else{
        $erro_login = "Usuário e/ou senha incorretos!";
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/estilo.css" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
</head>
<body>
    <form method="post" action="">
        <h2>Login</h2>

        <?php if(isset($erro_login)){?>
            <div style="text-align:center" class="erro-geral animate__animated animate__shakeX"><?php echo $erro_login; ?></div>
        <?php } ?>

        <?php if(isset($_GET['result']) && ($_GET['result']=="ok")){?>
            <div class="sucesso animate__animated animate__shakeX">
            Cadastrado com Sucesso!
        </div>
        
        <?php }?>

        

        <div class="input-group">
            <img class="input-icon" src="img/email.png" alt="">
            <input type="email" name="email" placeholder="Digite seu Email" required>
        </div>
        

        <div class="input-group">
            <img class="input-icon" src="img/padlock.png" alt="">
            <input type="password" name="senha" placeholder="Digite sua Senha" required>
        </div>
        
        <button class="btn-blue" type="submit">Fazer Login</button>
        <a href="cadastrar.php">Ainda não tenho cadastro</a>
    </form>

    
    <?php if(isset($_GET['result']) && ($_GET['result']=="ok")){?>
            
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"> </script>
        <script>
            setTimeout(() => {
                $('.sucesso').hide();
            }, 3000);
        </script>
        <?php }?>
    
</body>
</html>