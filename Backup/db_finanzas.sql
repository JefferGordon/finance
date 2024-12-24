/*
 Navicat Premium Dump SQL

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : db_finanzas

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 23/12/2024 21:32:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for abonos
-- ----------------------------
DROP TABLE IF EXISTS `abonos`;
CREATE TABLE `abonos`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cuenta_por_cobrar_id` bigint UNSIGNED NOT NULL,
  `monto` decimal(10, 2) NOT NULL,
  `fecha_abono` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `abonos_cuenta_por_cobrar_id_foreign`(`cuenta_por_cobrar_id` ASC) USING BTREE,
  CONSTRAINT `abonos_cuenta_por_cobrar_id_foreign` FOREIGN KEY (`cuenta_por_cobrar_id`) REFERENCES `cuenta_por_cobrars` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of abonos
-- ----------------------------

-- ----------------------------
-- Table structure for cuenta_por_cobrars
-- ----------------------------
DROP TABLE IF EXISTS `cuenta_por_cobrars`;
CREATE TABLE `cuenta_por_cobrars`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `detalle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` decimal(10, 2) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `es_recurrente` tinyint(1) NOT NULL DEFAULT 0,
  `cantidad_meses` int NULL DEFAULT NULL,
  `estado` enum('pendiente','cobrado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cuenta_por_cobrars_empresa_id_foreign`(`empresa_id` ASC) USING BTREE,
  CONSTRAINT `cuenta_por_cobrars_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cuenta_por_cobrars
-- ----------------------------

-- ----------------------------
-- Table structure for cuenta_por_pagars
-- ----------------------------
DROP TABLE IF EXISTS `cuenta_por_pagars`;
CREATE TABLE `cuenta_por_pagars`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `detalle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` decimal(10, 2) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `es_recurrente` tinyint(1) NOT NULL DEFAULT 0,
  `cantidad_meses` int NULL DEFAULT NULL,
  `estado` enum('pendiente','pagado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cuenta_por_pagars_empresa_id_foreign`(`empresa_id` ASC) USING BTREE,
  CONSTRAINT `cuenta_por_pagars_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cuenta_por_pagars
-- ----------------------------

-- ----------------------------
-- Table structure for empresas
-- ----------------------------
DROP TABLE IF EXISTS `empresas`;
CREATE TABLE `empresas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('natural','juridica') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'natural',
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telefono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of empresas
-- ----------------------------
INSERT INTO `empresas` VALUES (1, 'Industrial Vega', 'juridica', 'Tomas atandagua y jose azañero', NULL, '2024-11-24 16:27:08', '2024-11-24 16:37:40');
INSERT INTO `empresas` VALUES (2, 'Jefferson Gordon', 'natural', 'Tomas atandagua y jose azañero', '0983124753', '2024-11-24 16:37:56', '2024-11-24 19:32:31');
INSERT INTO `empresas` VALUES (3, 'Santiago Vega', 'natural', 'España', NULL, '2024-12-13 02:12:48', '2024-12-13 02:12:48');
INSERT INTO `empresas` VALUES (4, 'Mauricio Vega', 'natural', 'España Murcia', NULL, '2024-12-24 02:17:48', '2024-12-24 02:17:48');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for gasto_fijos
-- ----------------------------
DROP TABLE IF EXISTS `gasto_fijos`;
CREATE TABLE `gasto_fijos`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `detalle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` decimal(10, 2) NOT NULL,
  `estado` enum('pendiente','pagado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `gasto_fijos_empresa_id_foreign`(`empresa_id` ASC) USING BTREE,
  CONSTRAINT `gasto_fijos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gasto_fijos
-- ----------------------------

-- ----------------------------
-- Table structure for letras
-- ----------------------------
DROP TABLE IF EXISTS `letras`;
CREATE TABLE `letras`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cuenta_por_cobrar_id` bigint UNSIGNED NOT NULL,
  `monto` decimal(10, 2) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `estado` enum('pendiente','pagado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `letras_cuenta_por_cobrar_id_foreign`(`cuenta_por_cobrar_id` ASC) USING BTREE,
  CONSTRAINT `letras_cuenta_por_cobrar_id_foreign` FOREIGN KEY (`cuenta_por_cobrar_id`) REFERENCES `cuenta_por_cobrars` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of letras
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2024_11_24_152142_create_transaction_types_table', 2);
INSERT INTO `migrations` VALUES (6, '2024_11_24_152203_create_months_table', 2);
INSERT INTO `migrations` VALUES (7, '2024_11_24_152220_create_transactions_table', 2);
INSERT INTO `migrations` VALUES (8, '2024_11_24_162434_create_empresas_table', 3);
INSERT INTO `migrations` VALUES (9, '2024_11_24_162510_add_empresa_id_to_transactions_table', 4);
INSERT INTO `migrations` VALUES (10, '2024_11_24_162758_assign_default_empresa_to_transactions', 4);
INSERT INTO `migrations` VALUES (11, '2024_11_24_183242_add_transaction_date_to_transactions_table', 5);
INSERT INTO `migrations` VALUES (12, '2024_11_24_193529_add_year_to_transactions_table', 6);
INSERT INTO `migrations` VALUES (15, '2024_12_06_222116_create_cuenta_por_pagars_table', 8);
INSERT INTO `migrations` VALUES (16, '2024_12_06_230630_create_gasto_fijos_table', 9);
INSERT INTO `migrations` VALUES (17, '2024_12_06_232040_create_letras_table', 10);
INSERT INTO `migrations` VALUES (18, '2024_12_06_222121_create_cuenta_por_cobrars_table', 11);
INSERT INTO `migrations` VALUES (19, '2024_12_07_004141_create_abonos_table', 12);

-- ----------------------------
-- Table structure for months
-- ----------------------------
DROP TABLE IF EXISTS `months`;
CREATE TABLE `months`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of months
-- ----------------------------
INSERT INTO `months` VALUES (1, 'Enero', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (2, 'Febrero', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (3, 'Marzo', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (4, 'Abril', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (5, 'Mayo', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (6, 'Junio', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (7, 'Julio', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (8, 'Agosto', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (9, 'Septiembre', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (10, 'Octubre', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (11, 'Noviembre', '2024-11-24 15:28:27', '2024-11-24 15:28:27');
INSERT INTO `months` VALUES (12, 'Diciembre', '2024-11-24 15:28:27', '2024-11-24 15:28:27');

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for transaction_types
-- ----------------------------
DROP TABLE IF EXISTS `transaction_types`;
CREATE TABLE `transaction_types`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of transaction_types
-- ----------------------------
INSERT INTO `transaction_types` VALUES (1, 'Ingreso', '2024-11-24 15:27:37', '2024-11-24 15:27:37');
INSERT INTO `transaction_types` VALUES (2, 'Egreso', '2024-11-24 15:27:55', '2024-11-24 15:27:55');

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_type_id` bigint UNSIGNED NOT NULL,
  `month_id` bigint UNSIGNED NOT NULL,
  `year` int NOT NULL,
  `amount` decimal(10, 2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `transaction_date` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `transactions_transaction_type_id_foreign`(`transaction_type_id` ASC) USING BTREE,
  INDEX `transactions_month_id_foreign`(`month_id` ASC) USING BTREE,
  CONSTRAINT `transactions_month_id_foreign` FOREIGN KEY (`month_id`) REFERENCES `months` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `transactions_transaction_type_id_foreign` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_types` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 81 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES (3, 1, 11, 2024, 3850.00, 'Flujo', '2024-11-24 17:32:02', '2024-11-24 18:38:44', 1, '2024-11-22');
INSERT INTO `transactions` VALUES (4, 1, 11, 2024, 280.00, 'Envio dinero para pagos de nomina', '2024-11-24 18:39:54', '2024-11-24 18:39:54', 1, '2024-11-16');
INSERT INTO `transactions` VALUES (5, 1, 11, 2024, 24.89, 'Saldo anterior', '2024-11-24 18:41:17', '2024-11-24 18:41:22', 1, '2024-11-10');
INSERT INTO `transactions` VALUES (6, 2, 11, 2024, 100.00, 'NOmina Chucho', '2024-11-24 18:42:02', '2024-11-24 18:42:02', 1, '2024-11-23');
INSERT INTO `transactions` VALUES (7, 2, 11, 2024, 175.00, 'Nomina Juan', '2024-11-24 18:42:22', '2024-11-24 18:42:22', 1, '2024-11-23');
INSERT INTO `transactions` VALUES (8, 2, 11, 2024, 510.00, 'Pago cuota Puellaro', '2024-11-24 18:42:50', '2024-11-24 18:42:50', 1, '2024-11-23');
INSERT INTO `transactions` VALUES (9, 2, 11, 2024, 200.00, 'Tranferencia Santiago', '2024-11-24 18:43:12', '2024-11-24 18:43:12', 1, '2024-11-24');
INSERT INTO `transactions` VALUES (10, 2, 11, 2024, 100.00, 'Nomina Chucho', '2024-11-24 18:54:18', '2024-11-24 18:54:18', 1, '2024-11-16');
INSERT INTO `transactions` VALUES (11, 2, 11, 2024, 175.00, 'Nomina Juan', '2024-11-24 18:54:36', '2024-11-24 18:54:36', 1, '2024-11-16');
INSERT INTO `transactions` VALUES (12, 2, 11, 2024, 100.00, 'Nomina chucho', '2024-11-30 00:55:36', '2024-11-30 00:55:36', 1, '2024-11-29');
INSERT INTO `transactions` VALUES (13, 2, 11, 2024, 180.00, 'Nomina Juan Vizacino', '2024-11-30 00:56:00', '2024-11-30 00:56:00', 1, '2024-11-29');
INSERT INTO `transactions` VALUES (14, 1, 12, 2024, 772.53, 'Rol de pagos Noviembre', '2024-12-03 00:34:52', '2024-12-03 00:34:52', 2, '2024-11-29');
INSERT INTO `transactions` VALUES (15, 1, 12, 2024, 10.00, 'devolucion prestamo andres', '2024-12-03 00:35:35', '2024-12-03 00:35:35', 2, '2024-12-02');
INSERT INTO `transactions` VALUES (16, 1, 12, 2024, 2.75, 'Pago youtube', '2024-12-03 00:35:59', '2024-12-03 00:35:59', 2, '2024-12-02');
INSERT INTO `transactions` VALUES (17, 1, 12, 2024, 50.00, '2 letra moto', '2024-12-03 00:36:38', '2024-12-03 00:36:38', 2, '2024-12-02');
INSERT INTO `transactions` VALUES (18, 2, 12, 2024, 7.00, 'KFC', '2024-12-05 01:10:50', '2024-12-05 01:10:50', 2, '2024-12-04');
INSERT INTO `transactions` VALUES (19, 2, 12, 2024, 5.23, 'NOVENA', '2024-12-05 01:11:17', '2024-12-05 01:11:17', 2, '2024-12-03');
INSERT INTO `transactions` VALUES (20, 2, 12, 2024, 12.00, 'Parrillada Pame', '2024-12-05 01:11:49', '2024-12-06 22:08:34', 2, '2024-12-04');
INSERT INTO `transactions` VALUES (21, 2, 12, 2024, 31.19, 'KFC', '2024-12-06 22:09:51', '2024-12-06 22:09:51', 2, '2024-12-04');
INSERT INTO `transactions` VALUES (22, 2, 12, 2024, 13.72, 'Menestras del negro', '2024-12-06 22:11:20', '2024-12-06 22:11:20', 2, '2024-12-06');
INSERT INTO `transactions` VALUES (23, 2, 12, 2024, 10.00, 'Prestamo Hermano', '2024-12-06 22:12:05', '2024-12-06 22:12:05', 2, '2024-12-05');
INSERT INTO `transactions` VALUES (24, 1, 12, 2024, 9.59, 'combo kfc', '2024-12-06 22:13:08', '2024-12-06 22:13:08', 2, '2024-12-04');
INSERT INTO `transactions` VALUES (25, 1, 12, 2024, 6.00, 'Youtue Premium Marlon', '2024-12-06 22:13:38', '2024-12-06 22:13:38', 2, '2024-12-05');
INSERT INTO `transactions` VALUES (26, 2, 12, 2024, 13.19, 'Youtube Premium', '2024-12-06 22:15:02', '2024-12-24 02:25:46', 2, '2024-12-02');
INSERT INTO `transactions` VALUES (27, 2, 12, 2024, 21.00, 'Peluqueria moncho', '2024-12-06 22:15:48', '2024-12-06 22:15:48', 2, '2024-12-02');
INSERT INTO `transactions` VALUES (28, 2, 12, 2024, 49.38, 'tripti', '2024-12-06 22:16:27', '2024-12-06 22:16:27', 2, '2024-12-02');
INSERT INTO `transactions` VALUES (29, 2, 12, 2024, 1.55, 'tienda', '2024-12-06 22:17:09', '2024-12-06 22:17:09', 2, '2024-12-05');
INSERT INTO `transactions` VALUES (30, 2, 12, 2024, 175.00, 'Nomina Juan Vizcaino', '2024-12-07 00:55:53', '2024-12-07 00:55:53', 1, '2024-12-06');
INSERT INTO `transactions` VALUES (31, 2, 12, 2024, 121.00, 'Nomina Chucho', '2024-12-07 00:56:17', '2024-12-07 00:56:17', 1, '2024-12-06');
INSERT INTO `transactions` VALUES (32, 2, 12, 2024, 160.00, 'Mensualidad Santiago', '2024-12-08 22:48:12', '2024-12-08 22:48:12', 1, '2024-12-08');
INSERT INTO `transactions` VALUES (33, 2, 12, 2024, 60.00, 'Pichincha Xime', '2024-12-08 22:48:33', '2024-12-08 22:48:33', 1, '2024-12-08');
INSERT INTO `transactions` VALUES (34, 1, 12, 2024, 8.00, 'Agua', '2024-12-08 22:48:53', '2024-12-08 22:48:53', 2, '2024-12-08');
INSERT INTO `transactions` VALUES (35, 2, 12, 2024, 29.89, 'Compra de trapeador,organizador', '2024-12-08 22:49:58', '2024-12-08 22:49:58', 2, '2024-12-08');
INSERT INTO `transactions` VALUES (36, 2, 12, 2024, 70.00, 'Pago tarjeta mastercard', '2024-12-08 22:50:31', '2024-12-08 22:50:31', 2, '2024-12-08');
INSERT INTO `transactions` VALUES (37, 1, 12, 2024, 160.00, 'Pago creditos Santiago', '2024-12-13 02:04:27', '2024-12-13 02:04:27', 2, '2024-12-09');
INSERT INTO `transactions` VALUES (38, 2, 12, 2024, 7.76, 'Gasolina', '2024-12-13 02:06:20', '2024-12-13 02:06:20', 2, '2024-12-09');
INSERT INTO `transactions` VALUES (39, 2, 12, 2024, 24.70, 'Comida Trabajo', '2024-12-13 02:06:50', '2024-12-13 02:06:50', 2, '2024-12-11');
INSERT INTO `transactions` VALUES (40, 2, 12, 2024, 343.07, 'Pago tarjeta visa', '2024-12-13 02:11:50', '2024-12-13 02:11:50', 2, '2024-12-12');
INSERT INTO `transactions` VALUES (41, 1, 12, 2024, 160.00, 'Pagos creditos', '2024-12-13 02:13:35', '2024-12-13 02:13:35', 3, '2024-12-09');
INSERT INTO `transactions` VALUES (42, 2, 12, 2024, 7.78, 'Spotify', '2024-12-13 02:15:45', '2024-12-13 02:15:45', 3, '2024-12-12');
INSERT INTO `transactions` VALUES (43, 2, 12, 2024, 195.00, 'Pago nomina ', '2024-12-14 16:43:37', '2024-12-14 16:43:37', 1, '2024-12-14');
INSERT INTO `transactions` VALUES (44, 2, 12, 2024, 100.00, 'Nomina Chucho', '2024-12-14 16:44:06', '2024-12-14 16:44:06', 1, '2024-12-14');
INSERT INTO `transactions` VALUES (45, 2, 12, 2024, 47.41, 'Pago etafashon', '2024-12-14 16:47:49', '2024-12-14 16:47:49', 2, '2024-12-14');
INSERT INTO `transactions` VALUES (46, 2, 12, 2024, 13.30, 'Pago luz', '2024-12-14 16:48:39', '2024-12-14 16:48:39', 2, '2024-12-14');
INSERT INTO `transactions` VALUES (47, 2, 12, 2024, 7.63, 'Pago agua', '2024-12-14 16:49:19', '2024-12-14 16:49:19', 2, '2024-12-14');
INSERT INTO `transactions` VALUES (48, 2, 12, 2024, 15.09, 'Plan movistar', '2024-12-14 16:52:41', '2024-12-14 16:52:41', 2, '2024-12-14');
INSERT INTO `transactions` VALUES (49, 2, 12, 2024, 95.10, 'Pago solidario', '2024-12-14 16:55:36', '2024-12-14 16:55:36', 3, '2024-12-14');
INSERT INTO `transactions` VALUES (50, 2, 12, 2024, 73.19, 'Pago tarjeta solidario', '2024-12-14 16:56:57', '2024-12-14 16:56:57', 2, '2024-12-14');
INSERT INTO `transactions` VALUES (51, 2, 12, 2024, 55.00, 'Pago AKI', '2024-12-14 16:59:07', '2024-12-14 16:59:07', 2, '2024-12-14');
INSERT INTO `transactions` VALUES (52, 2, 12, 2024, 15.00, 'Pizza', '2024-12-14 17:00:24', '2024-12-14 17:00:24', 2, '2024-12-13');
INSERT INTO `transactions` VALUES (53, 2, 12, 2024, 505.00, 'Pago Puellaro', '2024-12-24 01:14:31', '2024-12-24 01:14:31', 1, '2024-12-20');
INSERT INTO `transactions` VALUES (54, 2, 12, 2024, 100.00, 'Pago Nomina Chucho', '2024-12-24 01:14:54', '2024-12-24 01:14:54', 1, '2024-12-21');
INSERT INTO `transactions` VALUES (55, 2, 12, 2024, 185.00, 'Nomina Juan Viscaino', '2024-12-24 01:15:27', '2024-12-24 01:15:27', 1, '2024-12-21');
INSERT INTO `transactions` VALUES (56, 2, 12, 2024, 122.08, 'Canastas 9', '2024-12-24 01:16:09', '2024-12-24 01:16:09', 1, '2024-12-22');
INSERT INTO `transactions` VALUES (57, 2, 12, 2024, 56.00, '20 fundas de caramelos', '2024-12-24 01:16:34', '2024-12-24 01:16:34', 1, '2024-12-22');
INSERT INTO `transactions` VALUES (58, 2, 12, 2024, 900.00, 'Laptop Asus', '2024-12-24 01:16:58', '2024-12-24 01:16:58', 2, '2024-12-20');
INSERT INTO `transactions` VALUES (59, 1, 12, 2024, 500.00, 'Venta computadora', '2024-12-24 01:17:19', '2024-12-24 01:17:19', 2, '2024-12-15');
INSERT INTO `transactions` VALUES (60, 2, 12, 2024, 75.00, 'Camiseta de Liga', '2024-12-24 01:17:39', '2024-12-24 01:17:39', 2, '2024-12-21');
INSERT INTO `transactions` VALUES (61, 2, 12, 2024, 40.00, 'Mantenimiento Moto', '2024-12-24 01:18:05', '2024-12-24 01:18:05', 2, '2024-12-18');
INSERT INTO `transactions` VALUES (62, 2, 12, 2024, 30.00, 'Taxi', '2024-12-24 01:19:06', '2024-12-24 01:19:06', 2, '2024-12-22');
INSERT INTO `transactions` VALUES (63, 2, 12, 2024, 8.00, 'Taxi', '2024-12-24 01:19:19', '2024-12-24 01:19:19', 1, '2024-12-22');
INSERT INTO `transactions` VALUES (64, 2, 12, 2024, 200.00, 'Prestamo Chris', '2024-12-24 01:20:53', '2024-12-24 01:20:53', 2, '2024-12-19');
INSERT INTO `transactions` VALUES (65, 1, 12, 2024, 770.87, 'Decimo', '2024-12-24 01:22:42', '2024-12-24 01:22:42', 2, '2024-12-16');
INSERT INTO `transactions` VALUES (66, 2, 12, 2024, 28.92, 'Cena (costillas,bife )', '2024-12-24 02:05:27', '2024-12-24 02:05:27', 2, '2024-12-20');
INSERT INTO `transactions` VALUES (67, 2, 12, 2024, 10.00, 'Vino', '2024-12-24 02:07:01', '2024-12-24 02:07:01', 2, '2024-12-18');
INSERT INTO `transactions` VALUES (68, 2, 12, 2024, 2.05, 'Gastos Tranferencias terceros', '2024-12-24 02:08:05', '2024-12-24 02:08:05', 1, '2024-12-23');
INSERT INTO `transactions` VALUES (69, 2, 12, 2024, 73.79, 'Pago Tarjeta Solidario', '2024-12-24 02:14:52', '2024-12-24 02:14:52', 2, '2024-12-14');
INSERT INTO `transactions` VALUES (70, 2, 12, 2024, 64.31, 'Pago credito pichincha', '2024-12-24 02:16:05', '2024-12-24 02:16:05', 2, '2024-12-23');
INSERT INTO `transactions` VALUES (71, 2, 12, 2024, 55.00, 'Pago Credito pichincha', '2024-12-24 02:17:29', '2024-12-24 02:17:29', 3, '2024-12-16');
INSERT INTO `transactions` VALUES (72, 1, 12, 2024, 210.00, 'Dinero para pagos', '2024-12-24 02:18:31', '2024-12-24 02:18:31', 4, '2024-12-13');
INSERT INTO `transactions` VALUES (73, 2, 12, 2024, 143.03, 'Pago Margarita', '2024-12-24 02:19:56', '2024-12-24 02:19:56', 4, '2024-12-15');
INSERT INTO `transactions` VALUES (74, 2, 12, 2024, 55.00, 'Credito Pichincha', '2024-12-24 02:20:15', '2024-12-24 02:20:15', 4, '2024-12-23');
INSERT INTO `transactions` VALUES (75, 2, 12, 2024, 16.05, 'Pago tarjeta pacifico', '2024-12-24 02:20:50', '2024-12-24 02:20:50', 2, '2024-12-16');
INSERT INTO `transactions` VALUES (76, 1, 12, 2024, 10.00, 'Cobro prestamo Mauricio', '2024-12-24 02:23:10', '2024-12-24 02:23:10', 2, '2024-12-14');
INSERT INTO `transactions` VALUES (77, 2, 12, 2024, 10.00, 'Pago prestamo Andy', '2024-12-24 02:23:34', '2024-12-24 02:23:34', 4, '2024-12-14');
INSERT INTO `transactions` VALUES (78, 2, 12, 2024, 5.00, 'Prestamo Mauricio', '2024-12-24 02:23:54', '2024-12-24 02:23:54', 2, '2024-12-15');
INSERT INTO `transactions` VALUES (79, 1, 12, 2024, 30.00, 'Pago Andres comida', '2024-12-24 02:26:31', '2024-12-24 02:26:31', 2, '2024-12-17');
INSERT INTO `transactions` VALUES (80, 1, 12, 2024, 8.23, 'Alitas', '2024-12-24 02:27:57', '2024-12-24 02:27:57', 2, '2024-12-17');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Jefferson Gordon', 'jeffergordon96@gmail.com', NULL, '$2y$12$Nkgc5uoRBwPnEqcmrzCpEeF/oGSIB6Llvx275sYrAWZTpHQSm/1qK', NULL, '2024-11-24 15:31:12', '2024-11-24 15:31:12');

SET FOREIGN_KEY_CHECKS = 1;
