<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pilkington Vistoria</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-card">
        <div class="login-logo">
            <h1>Pilkington</h1>
            <p>Sistema de Vistoria Operacional</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div style="background: rgba(220, 53, 69, 0.1); color: var(--danger-color); padding: 10px; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/login" method="POST">
            <div class="form-group">
                <label class="form-label" for="login">Login</label>
                <input type="text" id="login" name="login" class="form-control" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label" for="senha">Senha</label>
                <input type="password" id="senha" name="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 1rem;">Entrar no Sistema</button>
        </form>
    </div>
</body>
</html>
