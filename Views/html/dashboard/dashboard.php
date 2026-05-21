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
            <a href="<?= SITE_URL ?>index.php?action=downloadSheet" class="btn-icon btn-sheet" title="Exportar Sheet">
                <svg viewBox="0 0 384 512">
                    <path d="M224 136V0H24C10.7 0 0 10.7 0 24V488c0 13.3 10.7 24 24 24H360c13.3 0 24-10.7 24-24V160H248c-13.3 0-24-10.7-24-24zM192 256c8.8 0 16 7.2 16 16v88l30.6-30.6c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6l-56 56c-6.2 6.2-16.4 6.2-22.6 0l-56-56c-6.2-6.2-6.2-16.4 0-22.6s16.4-6.2 22.6 0L176 360v-88c0-8.8 7.2-16 16-16z"/>
                </svg>
            </a>
            <a href="<?= SITE_URL ?>index.php?action=getFormCreateBooking" class="btn-icon btn-add" title="Nueva Reserva">
                <svg viewBox="0 0 448 512">
                    <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- TABLA CONECTADA A LA BASE DE DATOS -->
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Habitacion</th>
                    <th>Inicio</th>
                    <th>Ida</th>
                    <th>Visitantes</th>
                    <th>Estado</th>
                    <th>Total a pagar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)) { ?>

                    <?php foreach ($bookings as $booking) { ?>

                        <tr>
                            <td><?php echo $booking['Numero_de_habitacion']; ?></td>
                            <td><?php echo $booking['Fecha_de_empiezo']; ?></td>
                            <td><?php echo $booking['Fecha_de_final']; ?></td>
                            <td><?php echo $booking['Total_de_visitantes']; ?></td>
                            <td><?php echo $booking['Estado_de_reserva']; ?></td>
                            <td>$<?php echo $booking['Total_a_pagar']; ?></td>

                            <!-- ACCIONES DENTRO DEL TR -->
                            <td class="acciones">

                                <a href="<?= SITE_URL ?>index.php?action=getFormUpdateBooking&id=<?= $booking['id'] ?>" class="btn-icon btn-edit" title="Editar">
                                    <svg viewBox="-10 80 420 440">
                                        <path d="M290.74 93.24l128 128L142.06 497.94H14.06V369.94L290.74 93.24z"/>
                                    </svg>
                                </a>

                                <form action="<?= SITE_URL ?>index.php?action=cancelBooking&id=<?= $booking['id'] ?>" method="POST">
                                    <button class="btn-icon btn-delete" title="Cancelar">
                                        <svg viewBox="0 0 448 512">
                                            <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 178.7 150.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L178.7 224l-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 269.3l73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L269.3 224l73.4-73.4z"/>
                                        </svg>
                                    </button>
                                </form>

                                <a href="<?= SITE_URL ?>index.php?action=downloadPDF&id=<?= $booking['id'] ?>" class="btn-icon btn-pdf" target="_blank" rel="noopener noreferrer" title="Descargar PDF">
                                    <svg viewBox="0 0 384 512">
                                        <path d="M224 136V0H24C10.7 0 0 10.7 0 24V488c0 13.3 10.7 24 24 24H360c13.3 0 24-10.7 24-24V160H248c-13.3 0-24-10.7-24-24z"/>
                                    </svg>
                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                        <tr>
                            <td colspan="7">No hay reservas disponibles.</td>
                        </tr>

                    <?php } ?>
            </tbody>
        </table>
    </div>

</section>

</body>
</html>