<?php

$reservas = [
    ['id' => 1, 'habitacion' => 'Suite Deluxe', 'fecha' => '2026-05-10', 'estado' => 'Confirmada'],
    ['id' => 2, 'habitacion' => 'Premium', 'fecha' => '2026-06-01', 'estado' => 'Pendiente']
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Cuenta - Four Seasons</title>
    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- FUENTES -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Inter:wght@300;400&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="logo">Four Seasons</div>
    <div class="nav-links">
        <a href="../index.php">Inicio</a>
        <a href="<?= SITE_URL ?>index.php?action=logoutUser">Cerrar sesión</a>
    </div>
</nav>

<section class="user-dashboard">

    <!-- SALUDO -->
    <div class="welcome">
        <h1 class="title-main">
            Bienvenido a tu Dashboard, <?php echo $_SESSION['user']['name']; ?>!
        </h1>
    </div>

    <!-- HEADER -->
    <div class="header-reservas">
        <h2>Mis Reservas</h2>

        <div class="acciones-header">
            <a href="#" class="btn btn-green">Descargar Sheets</a>
            <a href="crear_reserva.php" class="btn btn-dark">+ Nueva Reserva</a>
        </div>
    </div>

    <!-- TABLA -->
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Habitación</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                <tr>

                    <td><?= $reserva['id'] ?></td>
                    <td><?= $reserva['habitacion'] ?></td>
                    <td><?= $reserva['fecha'] ?></td>
                    <td><?= $reserva['estado'] ?></td>

                    <td class="acciones">

                        <!-- EDITAR -->
                        <a href="editar_reserva.php?id=<?= $reserva['id'] ?>" class="btn-icon btn-edit" title="Editar">
                            <svg viewBox="0 0 512 512">
                                <path d="M290.74 93.24l128 128L142.06 497.94H14.06V369.94L290.74 93.24z"/>
                            </svg>
                        </a>

                        <!-- ELIMINAR -->
                        <form action="eliminar_reserva.php" method="POST">
                            <input type="hidden" name="id" value="<?= $reserva['id'] ?>">
                            <button class="btn-icon btn-delete" title="Eliminar">
                                <svg viewBox="0 0 448 512">
                                    <path d="M135.2 17.7C140.9 7.1 151.9 0 164.3 0H283.7c12.4 0 23.4 7.1 29.1 17.7L328 32H432c8.8 0 16 7.2 16 16s-7.2 16-16 16h-16l-21.2 339.8C392.5 439.7 365.5 464 332.4 464H115.6c-33.1 0-60.1-24.3-62.4-60.2L32 64H16C7.2 64 0 56.8 0 48s7.2-16 16-16H120l15.2-14.3z"/>
                                </svg>
                            </button>
                        </form>

                        <!-- PDF -->
                        <a href="pdf_reserva.php?id=<?= $reserva['id'] ?>" class="btn-icon btn-pdf" title="PDF">
                            <svg viewBox="0 0 384 512">
                                <path d="M224 136V0H24C10.7 0 0 10.7 0 24V488c0 13.3 10.7 24 24 24H360c13.3 0 24-10.7 24-24V160H248c-13.3 0-24-10.7-24-24z"/>
                            </svg>
                        </a>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</section>

</body>
</html>