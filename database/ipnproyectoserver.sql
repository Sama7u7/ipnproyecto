
CREATE TABLE `deshidratadores` (
  `id` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `germinadores`
--

CREATE TABLE `germinadores` (
  `id` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Alberto Samayoa Ramos', 'rockaletito333@gmail.com', NULL, '$2y$12$koQ0YttxwyJ62.aonDQPYefQAb3YfLrgKLD8zmlLjwZR3nembRlwq', NULL, '2024-11-07 04:35:31', '2024-11-07 05:25:51'),
(2, 'Rubén Vázquez Medina', 'ruvazquez@ipn.mx', NULL, '$2y$12$y5aosCCzyKiCKL/y8VPWdOJ6ouNxT3N8APSJGEhQAoanFjkNbQcI6', NULL, '2024-11-07 20:06:38', '2024-11-07 20:06:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deshidratadores`
--
ALTER TABLE `deshidratadores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `germinadores`
--
ALTER TABLE `germinadores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deshidratadores`
--
ALTER TABLE `deshidratadores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `germinadores`
--
ALTER TABLE `germinadores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;


