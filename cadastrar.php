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
    <form action="">
        <h2>Cadastrar</h2>
        <div class="erro-geral animate__animated animate__shakeX">Aqui vai o erro para o usuário</div>
        <div class="input-group">
            <img class="input-icon" src="img/id-card.png" alt="">
            <input class="erro-input" type="text" placeholder="Digite seu Nome Completo">
            <div class="erro">Nome inválido</div>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/email.png" alt="">
            <input class="erro-input"type="email" placeholder="Digite seu Email">
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/padlock.png" alt="">
            <input class="erro-input"type="email" placeholder="Digite sua Senha">
        </div>
        

        <div class="input-group">
            <img class="input-icon" src="img/padlock.png" alt="">
            <input class="erro-input"type="password" placeholder="Repita a senha">
        </div>

        <div class="input-group">
            
            <input type="checkbox" id="termos" name="termos" value="ok">
            <label for="termos">Ao se cadastrar você concorda com a nossa <a class="link" href="#">Política de Privacidade</a> e os <a class="link" href="#">Termos de uso</a></label>
        </div>
        
        <button class="btn-blue" type="submit">Cadastrar</button>
        <a href="index.php">Fazer Login</a>
    </form>
    
</body>
</html>