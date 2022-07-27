<?php
require('config/conexao.php');
if(isset($_POST['nome_completo']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['repete_senha'])){
    if(empty($_POST['nome_completo']) or empty($_POST['email']) or empty($_POST['senha']) or empty($_POST['repete_senha']) or empty($_POST['termos'])){
        $erro_geral = "Todos os campos são obrigatórios.";
    }else{
        $nome = limpaPost($_POST['nome_completo']);
        $email = limpaPost($_POST['email']);
        $senha = limpaPost($_POST['senha']);
        $senha_cript = sha1($senha);
        $repete_senha = limpaPost($_POST['repete_senha']);
        $checkbox = limpaPost($_POST['termos']);

        if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
            $erro_nome = "São aceitos apenas letras e espaços em branco.";
          }

        

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro_email = "Formato de email inválido.";
          }

        if(strlen($senha)<6){
            $erro_senha = "A senha deve ter 6 caracteres ou mais.";
        }
        if ($senha !== $repete_senha){
            $erro_repete_senha = "A senha deve ser igual a anterior.";
        }
        if($checkbox!=="ok"){
            $erro_checkbox="Desativado";
        }
        if(!isset($erro_geral) && !isset($erro_nome) && !isset($erro_email) && !isset($erro_senha) && !isset($erro_repete_senha) && !isset($erro_checkbox)){
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? LIMIT 1");
            $sql->execute(array($email));
            $usuario = $sql->fetch();

            if(!$usuario){
                $recupera_senha="";
                $token="";
                $codigo_confirmacao = uniqid();
                $status="novo";
                $data_cadastro= date('d/m/Y');
                $sql = $pdo->prepare("INSERT INTO usuarios VALUES (null,?,?,?,?,?,?,?,?)");
                if($sql->execute(array($nome, $email, $senha_cript, $recupera_senha, $token,$codigo_confirmacao,$status,$data_cadastro))){
                    if($modo == "local"){
                        header('location: index.php?result=ok');
                    }

                    if($modo == "producao"){
                        $mail = new PHPMailer(true);
                        try{
                            $mail->setFrom('sistema@emailsistema.com', 'Sistema de login'); //email do sistema
                            $mail->addAddress($email, $nome); //email do usuário

                            //Content
                            $mail->isHTML(true);  //corpo do email construido com html
                            $mail->Subject = 'Confirme seu Cadastro'; //título do email
                            $mail->Body    = '<h1>Confirme seu email abaixo: </h1><br><br><a href="https://seusistema.com.br/confirmacao.php?cod_confirm='.$codigo_confirmacao.'">Confirmar E-mail</a> ';
                            $mail->send();
                            header('location: obrigado.php');
                        } catch (Exception $e) {
                            echo "Houve um erro ao enviar o e-mail de confirmação: {$mail->ErrorInfo}";
                        }
                    }
                    
                    
                }
            }else{
                $erro_geral = "Usuário já cadastrado.";
            }
        }
    }
}




?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link href="css/estilo.css" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
</head>
<body>
    <form method="POST">
        <h2>Cadastrar</h2>
        
        <?php if(isset($erro_geral)){?>
            <div class="erro-geral animate__animated animate__shakeX"><?php echo $erro_geral; ?></div>
        <?php } ?>


 
        <div class="input-group">
            <img class="input-icon" src="img/id-card.png" alt="">
            <input <?php if(isset($erro_geral) or isset ($erro_nome)){echo 'class="erro-input"';}?> name="nome_completo" class="erro-input" type="text" placeholder="Digite seu Nome Completo" <?php if(isset($_POST['nome_completo'])){echo "value='".$_POST['nome_completo']."'";}?> required>
            <?php if(isset($erro_nome)){ ?>
            <div class="erro"><?php echo $erro_nome; ?></div>
            <?php }?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/email.png" alt="">
            <input <?php if(isset($erro_geral)or isset ($erro_email)){echo 'class="erro-input"';}?> name="email" class="erro-input"type="email" placeholder="Digite seu Email" <?php if(isset($_POST['email'])){echo "value='".$_POST['email']."'";}?>required>
            <?php if(isset($erro_email)){ ?>
            <div class="erro"><?php echo $erro_email; ?></div>
            <?php }?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/padlock.png" alt="">
            <input <?php if(isset($erro_geral)or isset ($erro_senha)){echo 'class="erro-input"';}?> name="senha" class="erro-input"type="password" placeholder="Digite sua Senha" <?php if(isset($_POST['senha'])){echo "value='".$_POST['senha']."'";}?> required>
            <?php if(isset($senha)){ ?>
            <div class="erro"><?php echo $erro_senha; ?></div>
            <?php }?>
        </div>
        

        <div class="input-group">
            <img class="input-icon" src="img/padlock.png" alt="">
            <input <?php if(isset($erro_geral)or isset ($erro_repete_senha)){echo 'class="erro-input"';}?> name="repete_senha" class="erro-input"type="password" placeholder="Repita a senha" <?php if(isset($_POST['repete_senha'])){echo "value='".$_POST['repete_senha']."'";}?>required>
            <?php if(isset($repete_senha)){ ?>
            <div class="erro"><?php echo $erro_repete_senha ?></div>
            <?php }?>
        </div>

        <div <?php if(isset($erro_geral) or isset($erro_checkbox)){echo 'class="input-group erro-input"';}else{echo 'class="input-group"';}?> class="">
            
            <input type="checkbox" id="termos" name="termos" value="ok" required>
            <label for="termos">Ao se cadastrar você concorda com a nossa <a class="link" href="#">Política de Privacidade</a> e os <a class="link" href="#">Termos de uso</a></label>
        </div>
        
        <button class="btn-blue" type="submit">Cadastrar</button>
        <a href="index.php">Fazer Login</a>
    </form>
    
</body>
</html>