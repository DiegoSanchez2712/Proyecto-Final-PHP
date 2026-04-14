<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Four Seasons Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">Four Seasons</div>
        <div class="nav-links">
            <a href="#habitaciones">Habitaciones</a>
            <a href="#contacto">Contacto</a>
            <a href="<?= SITE_URL ?>index.php?action=getFormLoginUser">Iniciar Sesión</a>
            <a href="<?= SITE_URL ?>index.php?action=getFormRegisterUser">Registrarse</a>
        </div>
    </nav>

    <!-- HERO -->
    <header class="hero">
        <h1>Bienvenido a Four Seasons</h1>
        <p>Lujo, comodidad y experiencias inolvidables</p>
    </header>

    <!-- HABITACIONES -->
    <section id="habitaciones" class="section habitaciones">
        <h2>Nuestras Habitaciones</h2>
        <div class="cards">
            <div class="card">
                <h3>Suite Deluxe</h3>
                <p>Vista al mar, cama king y jacuzzi privado.</p>
            </div>
            <div class="card">
                <h3>Habitación Premium</h3>
                <p>Comodidad y elegancia para tu descanso.</p>
            </div>
            <div class="card">
                <h3>Habitación Estándar</h3>
                <p>Ideal para una estadía acogedora.</p>
            </div>
        </div>
    </section>

    <!-- CONTACTO -->
    <section id="contacto" class="section contacto">
        <h2>Contacto</h2>
        <p>Email: buisness@fourseasons.com</p>
        <p>Teléfono: +57 300 123 4567</p>
    </section>

</body>
</html>

