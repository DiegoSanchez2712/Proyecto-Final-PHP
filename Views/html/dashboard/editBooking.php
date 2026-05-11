<?php

/* Simulación de datos */
$reserva = [
    'categoria' => 'Premium',
    'numero_habitacion' => '203',
    'fecha_inicio' => '2026-05-10',
    'fecha_fin' => '2026-05-15',
    'huespedes' => 2
];
?>

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
        <a href="dashboard.php">Dashboard</a>
        <a href="#">Cerrar sesión</a>
    </div>
</nav>

<section class="form-reserva">

    <h1 class="title-main">
        Editar Reserva
    </h1>

    <form action="actualizar_reserva.php" method="POST" class="form-box">

        <!-- CATEGORÍA -->
        <div class="form-group">
            <label>Categoría</label>

            <input 
                type="text"
                name="categoria"
                value="<?= $reserva['categoria'] ?>"
                readonly
            >
        </div>

        <!-- HABITACIÓN -->
        <div class="form-group">
            <label>Número de habitación</label>

            <input 
                type="text"
                name="numero_habitacion"
                value="<?= $reserva['numero_habitacion'] ?>"
                readonly
            >
        </div>

        <!-- FECHA INICIO -->
        <div class="form-group">
            <label>Fecha de inicio</label>

            <input 
                type="date"
                name="fecha_inicio"
                value="<?= $reserva['fecha_inicio'] ?>"
                required
            >
        </div>

        <!-- FECHA FINAL -->
        <div class="form-group">
            <label>Fecha final</label>

            <input 
                type="date"
                name="fecha_fin"
                value="<?= $reserva['fecha_fin'] ?>"
                required
            >
        </div>

        <!-- HUÉSPEDES -->
        <div class="form-group">
            <label>Número de huéspedes</label>

            <input 
                type="number"
                name="huespedes"
                min="1"
                value="<?= $reserva['huespedes'] ?>"
                required
            >
        </div>

        <!-- BOTONES -->
        <div class="form-actions">

            <a href="dashboard.php" class="btn btn-gray">
                Cancelar
            </a>

            <button type="submit" class="btn btn-green">
                Guardar Cambios
            </button>

        </div>

    </form>

</section>

</body>
</html>
