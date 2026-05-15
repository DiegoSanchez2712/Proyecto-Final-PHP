<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Reserva - Four Seasons</title>
    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Inter:wght@300;400&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="logo">Four Seasons</div>
    <div class="nav-links">
        <a href="<?= SITE_URL ?>index.php?action=getDashboard">Dashboard</a>
        <a href="<?= SITE_URL ?>index.php?action=logoutUser">Cerrar sesión</a>
    </div>
</nav>


<section class="form-reserva">

    <h2 class="title-main">Crear Reserva</h2>

    <form action="<?= SITE_URL ?>index.php?action=createBooking" method="POST" class="form-box">

        <!-- HABITACIÓN -->
        <div class="form-group">
            <label>Seleccione el tipo de habitacion</label>
            <select name="category_id" id="category_id" required>
                <option value="">Seleccionar</option>
                <?php foreach ($categories as $category){ ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php } ?>
            </select>
            <?php
                if (!empty($_SESSION['errors']['category_id'] ?? [])){
                    foreach($_SESSION['errors']['category_id'] as $error) {
                        echo '<div class="error-message"> -' . $error . '</div>';
                    }
                }
            ?>
        </div>

        <div class="form-group">
            <label>habitaciones disponibles</label>
            <select name="room_id" id="room_id" disabled required>
                <option value="">Selecciona una tipo de habitacion</option>
            </select>
            <?php
                if (!empty($_SESSION['errors']['room_id'] ?? [])){
                    foreach($_SESSION['errors']['room_id'] as $error) {
                        echo '<div class="error-message"> -' . $error . '</div>';
                    }
                }
            ?>
        </div>


        <!-- FECHA INICIO -->
        <div class="form-group">
            <label>Fecha de inicio</label>
            <input type="date" name="start_date" id="start_date" required>
            <?php
                if (!empty($_SESSION['errors']['start_date'] ?? [])){
                    foreach($_SESSION['errors']['start_date'] as $error) {
                        echo '<div class="error-message"> -' . $error . '</div>';
                    }
                }
            ?>
        </div>

        <!-- FECHA FIN -->
        <div class="form-group">
            <label>Fecha de fin</label>
            <input type="date" name="end_date" id="end_date" required>
            <?php
                if (!empty($_SESSION['errors']['end_date'] ?? [])){
                    foreach($_SESSION['errors']['end_date'] as $error) {
                        echo '<div class="error-message"> -' . $error . '</div>';
                    }
                }
            ?>
        </div>

        <div class="date-range">
            <div id="date_range"></div>
        </div>

        <!-- PERSONAS -->
        <div class="form-group">
            <label>Cantidad de personas</label>
            <input type="number" name="guest_count" id="guest_count" min="1" required disabled>
            <small id="guest_limit"> Seleccione una habitacion antes </small>
            <?php
                if (!empty($_SESSION['errors']['guest_count'] ?? [])){
                    foreach($_SESSION['errors']['guest_count'] as $error) {
                        echo '<div class="error-message"> -' . $error . '</div>';
                    }
                }
            ?>
        </div>

        <!-- MÉTODO DE PAGO -->
        <div class="form-group">
            <label>Método de pago</label>
            <select name="payment_method_id" id="payment_method_id" placeholder="Seleccione una habitacion primero" required>
                <option value="">Seleccionar</option>
                <?php foreach ($paymentMethods as $method){ ?>
                    <option value="<?= $method['id'] ?>"><?= $method['name'] ?></option>
                <?php } ?>
            </select>
            <?php
                if (!empty($_SESSION['errors']['payment_method_id'] ?? [])){
                    foreach($_SESSION['errors']['payment_method_id'] as $error) {
                        echo '<div class="error-message"> -' . $error . '</div>';
                    }
                }
            ?>
        </div>

        <div class="total-box">
            <span>Total a pagar</span>
            <h3 id="total_price">$0</h3>
        </div>

        <!-- BOTONES -->
        <div class="form-actions">
            <a href="dashboard.php" class="btn btn-gray">Cancelar</a>
            <button type="submit" class="btn btn-green" id="save_button" disabled>Guardar Reserva</button>
        </div>

    </form>

</section>
<script type="module" src="assets/js/booking/bookingForm.js"></script>

</body>
</html>