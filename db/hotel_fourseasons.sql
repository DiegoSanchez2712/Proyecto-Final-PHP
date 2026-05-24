-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2026 a las 23:47:55
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hotel_fourseasons`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `guest_count` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `total_price` int(11) DEFAULT NULL,
  `payment_method_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Individual', 'Habitación con una cama'),
(2, 'Doble', 'Habitación con dos camas'),
(3, 'Suite', 'Habitación de lujo con mayor espacio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents_types`
--

CREATE TABLE `documents_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documents_types`
--

INSERT INTO `documents_types` (`id`, `name`) VALUES
(1, 'Cédula de ciudadanía'),
(2, 'Tarjeta de identidad'),
(3, 'Cédula de extranjería'),
(4, 'Pasaporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `description`) VALUES
(1, 'Efectivo', 'Pago en efectivo'),
(2, 'Tarjeta de crédito', 'Pago con tarjeta de crédito'),
(3, 'Tarjeta de débito', 'Pago con tarjeta de débito'),
(4, 'Transferencia', 'Transferencia bancaria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Administrador', 'Usuario con control total del sistema'),
(2, 'Cliente', 'Usuario que realiza reservas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `num_room` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `num_beds` int(11) NOT NULL,
  `max_people` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rooms`
--

INSERT INTO `rooms` (`id`, `num_room`, `category_id`, `num_beds`, `max_people`, `description`, `price`, `status_id`) VALUES
(22, 101, 1, 1, 1, 'Habitación sencilla con cama individual y vista interna.', 120000, 1),
(23, 102, 1, 1, 2, 'Habitación económica ideal para estancias cortas.', 125000, 1),
(24, 103, 1, 2, 2, 'Habitación doble básica con ambiente acogedor.', 135000, 1),
(25, 104, 1, 2, 3, 'Habitación estándar con buena iluminación natural.', 140000, 1),
(26, 105, 1, 1, 2, 'Habitación cómoda con escritorio y baño privado.', 145000, 1),
(27, 106, 1, 2, 4, 'Habitación familiar sencilla y funcional.', 155000, 1),
(28, 107, 1, 3, 5, 'Habitación amplia para grupos pequeños.', 170000, 1),
(29, 201, 2, 1, 2, 'Habitación superior con decoración moderna.', 220000, 1),
(30, 202, 2, 2, 3, 'Habitación ejecutiva con espacio adicional.', 235000, 1),
(31, 203, 2, 2, 4, 'Habitación premium con vista panorámica.', 250000, 1),
(32, 204, 2, 1, 2, 'Suite junior con acabados elegantes.', 265000, 1),
(33, 205, 2, 2, 4, 'Habitación deluxe con minibar incluido.', 280000, 1),
(34, 206, 2, 3, 5, 'Habitación espaciosa para familias.', 295000, 1),
(35, 207, 2, 2, 3, 'Habitación confortable con diseño minimalista.', 310000, 1),
(36, 301, 3, 1, 2, 'Suite de lujo con jacuzzi privado.', 450000, 1),
(37, 302, 3, 2, 4, 'Suite presidencial con sala privada.', 520000, 1),
(38, 303, 3, 3, 6, 'Penthouse exclusivo con terraza.', 650000, 1),
(39, 304, 3, 2, 4, 'Suite premium con vista al mar.', 580000, 1),
(40, 305, 3, 1, 2, 'Habitación VIP con servicio personalizado.', 490000, 1),
(41, 306, 3, 4, 8, 'Suite familiar de lujo con múltiples ambientes.', 720000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status_bookings`
--

CREATE TABLE `status_bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `status_bookings`
--

INSERT INTO `status_bookings` (`id`, `name`, `description`) VALUES
(1, 'Pendiente', 'En espera de confirmación'),
(2, 'Confirmada', 'Reserva confirmada'),
(3, 'Cancelada', 'Reserva cancelada'),
(4, 'Finalizada', 'Estadía completada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status_rooms`
--

CREATE TABLE `status_rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `status_rooms`
--

INSERT INTO `status_rooms` (`id`, `name`, `description`) VALUES
(1, 'Disponible', 'Habitación disponible'),
(2, 'Ocupada', 'Habitación en uso'),
(3, 'Mantenimiento', 'Habitación en mantenimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status_users`
--

CREATE TABLE `status_users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `status_users`
--

INSERT INTO `status_users` (`id`, `name`, `description`) VALUES
(1, 'Activo', 'El usuario puede acceder al sistema'),
(2, 'Inactivo', 'El usuario no puede acceder'),
(3, 'Bloqueado', 'Usuario bloqueado temporalmente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_number` varchar(30) NOT NULL,
  `name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL DEFAULT 1,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documents_types`
--
ALTER TABLE `documents_types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `num_room` (`num_room`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indices de la tabla `status_bookings`
--
ALTER TABLE `status_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `status_rooms`
--
ALTER TABLE `status_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `status_users`
--
ALTER TABLE `status_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_number` (`document_number`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `document_type_id` (`document_type_id`),
  ADD KEY `rol_id` (`rol_id`),
  ADD KEY `status_id` (`status_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `documents_types`
--
ALTER TABLE `documents_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `status_bookings`
--
ALTER TABLE `status_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `status_rooms`
--
ALTER TABLE `status_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `status_users`
--
ALTER TABLE `status_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status_bookings` (`id`),
  ADD CONSTRAINT `bookings_ibfk_4` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`);

--
-- Filtros para la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_rooms` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`document_type_id`) REFERENCES `documents_types` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
