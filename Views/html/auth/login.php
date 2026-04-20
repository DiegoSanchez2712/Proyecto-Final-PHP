<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Four Seasons</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Inter:wght@300;400&display=swap" rel="stylesheet">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">Four Seasons</div>
        <div class="nav-links">
            <a href="<?= SITE_URL ?>index.php">Inicio</a>
        </div>
    </nav>

    <!-- LOGIN -->
    <section class="form-section">
        <div class="form-container">
            <?php
                if (isset($_SESSION['errors']['general'])) {
                    foreach($_SESSION['errors']['general'] as $error) {
                        echo '<div class="error-box">' . $error . '</div>';
                    }
                    unset($_SESSION['errors']['general']);
                }
                elseif (isset($_SESSION['success'])) {
                    echo '<div class="success-box">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                }
            ?>

            <h2>Iniciar Sesión</h2>
            <p>
                Accede a tu cuenta
            </p>

            <form action="<?= SITE_URL ?>index.php?action=loginUser" method="POST">

                <label>Correo electrónico</label>
                <input type="email" name="email" value="<?php echo $_SESSION['old']['email'] ?? ''; ?>" required>
                <?php if (!empty($_SESSION['errors']['email'] ?? [])){
                    foreach($_SESSION['errors']['email'] as $error) {
                        echo '<div class="error-message"> -' . $error . '</div>';
                    }
                } ?>

                <label>Contraseña</label>
                <input type="password" name="password" value="<?php echo $_SESSION['old']['password'] ?? ''; ?>" required>
                <?php if (!empty($_SESSION['errors']['password'] ?? [])){
                    foreach($_SESSION['errors']['password'] as $error) {
                        echo '<div class="error-message"> -' . $error . '</div>';
                    }
                } ?>

                <button type="submit" id="loginButton">Ingresar</button>

            </form>

        </div>
    </section>

</body>
</html>
