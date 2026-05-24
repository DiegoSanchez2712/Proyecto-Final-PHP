<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reserva - Four Seasons</title>

    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- FUENTES -->
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

    <h2 class="title-main">Editar Reserva</h2>

    <form action="<?= SITE_URL ?>index.php?action=updateBooking" method="POST" data-mode="update" class="form-box" id="form">

        <input type="hidden" name="booking_id" value="<?php echo $booking["ID_de_reserva"]; ?>">

        <!-- HABITACIÓN -->
        <div class="form-group">
            <label>Categoria Seleccionada</label>
            <input value="<?php echo $booking["Categoria_de_habitacion"]; ?>" required readonly>
            </input>
            <?php
                if (!empty($_SESSION['errors']['category_id'] ?? [])){
                    foreach($_SESSION['errors']['category_id'] as $error) {
                        echo '<div class="error-message"> -' . $error . '</div>';
                    }
                }
            ?>

            <input type="hidden" name="category_id" id="category_id" value="<?= $booking['ID_de_categoria'] ?>">
        </div>

        <div class="form-group">
            <label>habitaciones Seleccionada</label>
            <input value="<?php echo $booking["Numero_de_habitacion"]; ?>" required readonly>
            </input>
            <?php
                if (!empty($_SESSION['errors']['room_id'] ?? [])){
                    foreach($_SESSION['errors']['room_id'] as $error) {
                        echo '<div class="error-message"> -' . $error . '</div>';
                    }
                }
            ?>

            <input type="hidden" name="room_id" id="room_id"value="<?= $booking['ID_de_habitacion'] ?>">
        </div>



        <!-- FECHA INICIO -->
        <div class="form-group">
            <label>Fecha de inicio</label>
            <input type="date" name="start_date" id="start_date" value="<?php echo $booking["Fecha_de_empiezo"]; ?>" required>
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
            <input type="date" name="end_date" id="end_date" value="<?php echo $booking["Fecha_de_final"]; ?>" required>
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
            <input type="number" name="guest_count" id="guest_count" min="1" value="<?php echo $booking["Total_de_visitantes"]; ?>" required>
            <small id="guest_limit">Maximo de visitantes: <?php echo $booking["Total_de_visitantes"]; ?></small>
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
            <select name="payment_method_id" id="payment_method_id" placeholder="Seleccione una habitacion primero" ?>" required>
                <option value="">Seleccionar</option>
                <?php foreach ($paymentMethods as $method){ ?>
                    <option value="<?= $method['id'] ?>" <?= $method['id'] == $booking['ID_de_metodo_de_pago'] ? 'selected' : '' ?> ><?= $method['name'] ?></option>
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
            <h3 id="total_price">$<?php echo $booking["Total_a_pagar"]; ?></h3>
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
