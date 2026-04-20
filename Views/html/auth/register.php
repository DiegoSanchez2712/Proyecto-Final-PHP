<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Four Seasons</title>
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

    <!-- FORMULARIO -->
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
            <h2>Crear Cuenta</h2>
            <form action="<?= SITE_URL ?>index.php?action=registerUser" method="POST">

                <div class="form-group">
                    <label>Tipo de documento</label>
                    <select name="document_type_id" id="document_type_id" required>
                        <option value="" <?php if (isset($_SESSION['old']['document_type_id']) && $_SESSION['old']['document_type_id'] === '') echo 'selected'; ?>>Seleccione una opcíon</option>
                        <option value="1" <?php if (isset($_SESSION['old']['document_type_id']) && $_SESSION['old']['document_type_id'] === '1') echo 'selected'; ?>>Cédula de Ciudadanía</option>
                        <option value="2" <?php if (isset($_SESSION['old']['document_type_id']) && $_SESSION['old']['document_type_id'] === '2') echo 'selected'; ?>>Tarjeta de Identidad</option>
                        <option value="3" <?php if (isset($_SESSION['old']['document_type_id']) && $_SESSION['old']['document_type_id'] === '3') echo 'selected'; ?>>Cédula de Extranjería</option>
                    </select>
                    <?php if (!empty($_SESSION['errors']['document_type_id'] ?? [])){
                        foreach($_SESSION['errors']['document_type_id'] as $error) {
                            echo '<div class="error-message"> -' . $error . '</div>';
                        }
                    } ?>
                </div>

                <div class="form-group">
                    <label>Número de documento</label>
                    <input type="text" name="document_number" placeholder="Ingrese su número de documento" value="<?php echo $_SESSION['old']['document_number'] ?? ''; ?>" id="document_number" required>
                    <?php if (!empty($_SESSION['errors']['document_number'] ?? [])){
                        foreach($_SESSION['errors']['document_number'] as $error) {
                            echo '<div class="error-message"> -' . $error . '</div>';
                        }
                    } ?>
                </div>

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="name" placeholder="Ingrese su nombre" value="<?php echo $_SESSION['old']['name'] ?? ''; ?>" id="name" required>
                    <?php if (!empty($_SESSION['errors']['name'] ?? [])){
                        foreach($_SESSION['errors']['name'] as $error) {
                            echo '<div class="error-message"> -' . $error . '</div>';
                        }
                    } ?>
                </div>

                <div class="form-group">
                    <label>Apellido</label>
                    <input type="text" name="last_name" placeholder="Ingrese su apellido" value="<?php echo $_SESSION['old']['last_name'] ?? ''; ?>" id="last_name" required>
                    <?php if (!empty($_SESSION['errors']['last_name'] ?? [])){
                        foreach($_SESSION['errors']['last_name'] as $error) {
                            echo '<div class="error-message"> -' . $error . '</div>';
                        }
                    } ?>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="tel" name="phone" placeholder="Ingrese su teléfono" value="<?php echo $_SESSION['old']['phone'] ?? ''; ?>" id="phone" required>
                    <?php if (!empty($_SESSION['errors']['phone'] ?? [])){
                        foreach($_SESSION['errors']['phone'] as $error) {
                            echo '<div class="error-message"> -' . $error . '</div>';
                        }
                    } ?>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Ingrese su email" value="<?php echo $_SESSION['old']['email'] ?? ''; ?>" id="email" required>
                    <?php if (!empty($_SESSION['errors']['email'] ?? [])){
                        foreach($_SESSION['errors']['email'] as $error) {
                            echo '<div class="error-message"> -' . $error . '</div>';
                        }
                    } ?>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="Ingrese su contraseña" value="<?php echo $_SESSION['old']['password'] ?? ''; ?>" id="password" required>
                    <?php if (!empty($_SESSION['errors']['password'] ?? [])){
                        foreach($_SESSION['errors']['password'] as $error) {
                            echo '<div class="error-message"> -' . $error . '</div>';
                        }
                    } ?>
                </div>

                <button type="submit" id="submitButton" disabled>Registrarse</button>

            </form>
        </div>
    </section>
    <script src="assets/js/registerActions.js"></script>
</body>
</html>

