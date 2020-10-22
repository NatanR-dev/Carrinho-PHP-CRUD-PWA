-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 22-Out-2020 às 00:03
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `id10997928_native_php_shopping_cart`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carts`
--

CREATE TABLE `carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Extraindo dados da tabela `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'EtlvF', '2019-08-26 17:52:54', '2020-10-19 17:52:54'),
(2, 'LItQO', '2019-08-26 18:40:50', '2020-10-19 18:40:50'),
(4, 'uMbxb', '2019-08-27 11:08:01', '2020-10-19 11:08:01'),
(8, 'oNgNI', '2019-08-27 19:37:44', '2020-10-19 19:37:44'),
(9, 'YFgri', '2019-08-27 20:06:54', '2020-10-19 20:06:54'),
(10, 'bLMbv', '2019-08-27 20:12:47', '2020-10-19 20:12:47'),
(12, 'Ep9MJ', '2020-10-17 23:34:50', '2020-10-20 23:34:50'),
(13, '5Lbvs', '2020-10-21 06:02:12', '2020-10-21 06:02:12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart_products`
--

CREATE TABLE `cart_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `cart_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(250) DEFAULT NULL COMMENT 'last edited category name',
  `name` varchar(250) DEFAULT NULL COMMENT 'last edited product name',
  `description` text DEFAULT NULL COMMENT 'last edited product description',
  `price` float DEFAULT NULL COMMENT 'last edited price',
  `images` text DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Extraindo dados da tabela `cart_products`
--

INSERT INTO `cart_products` (`id`, `cart_id`, `product_id`, `category_id`, `category_name`, `name`, `description`, `price`, `images`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 2, 'Eletrodomesticos', 'Teste 1', '', 40000, '[\"http://192.168.1.89/shopping-cart/public/images/products/gold-mini-speaker-20190826030718-0.jpg\"]', 1, '2019-08-26 17:55:18', '2019-08-26 18:06:12'),
(2, 1, 4, 2, 'Eletronicos', 'Teste 2', '', 25000, '[\"http://192.168.1.89/shopping-cart/public/images/products/mini-fan-20190826025941-0.jpg\"]', 1, '2020-10-16 23:47:07', '2020-10-17 18:05:48'),
(4, 1, 8, 3, 'Teste', 'Teste 3', '', 40000, '[\"http://192.168.1.89/shopping-cart/public/images/products/pengupas-mie-20190826130430-0.jpg\",\"http://192.168.1.89/shopping-cart/public/images/products/pengupas-mie-20190826130430-1.jpg\"]', 1, '2019-08-26 18:06:23', '2019-08-26 18:06:23'),
(7, 2, 10, 1, 'Eletrodomesticos', 'Teste 4', '', 25000, '[\"http://192.168.1.89/shopping-cart/public/images/products/kotak-pensil-20190826130534-0.jpg\"]', 1, '2019-08-26 18:41:02', '2019-08-26 18:41:02'),
(8, 2, 9, 1, 'Eletrodomesticos', 'Teste 5', '', 120000, '[\"http://192.168.1.89/shopping-cart/public/images/products/deli-tempat-alat-tulis-20190826130511-0.jpg\"]', 1, '2019-08-26 18:41:05', '2019-08-26 18:41:05'),
(9, 1, 1, 2, 'Elektronik', 'Teste 6', 'Caddy Disk untuk external Hardisk.\r\nMenggunakan slot DVD.', 135000, '[\"http://192.168.1.89/shopping-cart/public/images/products/caddy-disk-dvd-20190826025555-0.jpg\",\"http://192.168.1.89/shopping-cart/public/images/products/caddy-disk-dvd-20190826025630-0.jpg\",\"http://192.168.1.89/shopping-cart/public/images/products/caddy-disk-dvd-20190826025630-1.jpg\",\"http://192.168.1.89/shopping-cart/public/images/products/caddy-disk-dvd-20190826025630-2.jpg\"]', 1, '2019-08-26 18:50:25', '2019-08-26 18:50:25'),
(13, 4, 9, 1, 'Eletrodomesticos', 'Teste 7', '', 120000, '[\"http://192.168.1.89/shopping-cart/public/images/products/deli-tempat-alat-tulis-20190826130511-0.jpg\"]', 1, '2019-08-27 11:08:01', '2019-08-27 11:08:13'),
(14, 4, 10, 1, 'Eletrodomesticos', 'Teste 8', '', 25000, '[\"http://192.168.1.89/shopping-cart/public/images/products/kotak-pensil-20190826130534-0.jpg\"]', 1, '2019-08-27 11:08:07', '2019-08-27 11:08:07'),
(22, 8, 9, 1, 'Eletrodomesticos', 'Teste 9', '', 120000, '[\"http://localhost/shopping-cart/public/images/products/deli-tempat-alat-tulis-20190826130511-0.jpg\"]', 1, '2019-08-27 19:37:44', '2019-08-27 19:37:44'),
(23, 9, 9, 1, 'Eletrodomesticos', 'Teste 10', '', 120000, '[\"http://192.168.1.89/shopping-cart/public/images/products/deli-tempat-alat-tulis-20190826130511-0.jpg\"]', 1, '2019-08-27 20:06:54', '2019-08-27 20:06:54'),
(24, 10, 10, 1, 'Eletrodomesticos', 'Teste 11', '', 25000, '[\"http://192.168.1.89/shopping-cart/public/images/products/kotak-pensil-20190826130534-0.jpg\"]', 1, '2019-08-27 20:12:47', '2019-08-27 20:12:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `slug` varchar(50) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `slug`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 'eletrodomesticos', 'Eletrodomésticos', 'Eletrodomésticos', '2019-08-26 02:54:39', '2020-10-18 03:41:38'),
(2, 0, 'eletronicos', 'Eletrônicos', 'Produtos Eletrônicos', '2019-08-26 02:54:51', '2020-10-18 03:37:22'),
(3, 0, 'teste', 'Teste', '', '2019-08-26 12:55:44', '2020-10-18 03:41:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(8) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL COMMENT 'User Order Name',
  `address` text DEFAULT NULL COMMENT 'User Order Address',
  `total_price` float UNSIGNED DEFAULT NULL,
  `payment` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `address`, `total_price`, `payment`, `created_at`, `updated_at`) VALUES
(3, 'Ep9MJ', 'Teste', 'endereço teste', 65000, NULL, '2020-10-17 23:28:57', '2020-10-17 23:28:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_products`
--

CREATE TABLE `order_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(250) DEFAULT NULL COMMENT 'last edited category name',
  `name` varchar(250) DEFAULT NULL COMMENT 'last edited product name',
  `description` text DEFAULT NULL COMMENT 'last edited product description',
  `price` float DEFAULT NULL COMMENT 'last edited price',
  `images` text DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Extraindo dados da tabela `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `category_id`, `category_name`, `name`, `description`, `price`, `images`, `quantity`, `created_at`, `updated_at`) VALUES
(4, 3, 4, 2, 'Eletronicos', 'Mini USB Fan', '', 25000, '[\"http://g21flix.000webhostapp.com/cart/public/images/products/mini-fan-20190826025941-0.jpg\"]', 1, '2020-10-17 23:28:57', '2020-10-17 23:28:57'),
(5, 3, 6, 2, 'Eletronicos', 'Gold Mini Speaker', '', 40000, '[\"http://g21flix.000webhostapp.com/cart/public/images/products/gold-mini-speaker-20190826030718-0.jpg\"]', 1, '2020-10-17 23:28:57', '2020-10-17 23:28:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `slug` varchar(50) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` float DEFAULT NULL,
  `images` text DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `category_id`, `slug`, `name`, `description`, `price`, `images`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 2, 'galaxy-s10-lite', 'Galaxy S10 Lite', 'Smartphone Samsung Galaxy S10 Lite - Preto', 2114000, '[\"http://g21flix.000webhostapp.com/cart/public/images/products/Samsung-Galaxy-S10-lite.jpg\",\"http://g21flix.000webhostapp.com/cart/public/images/products/Samsung-Galaxy-S10-lite-2.jpg\",\"http://g21flix.000webhostapp.com/cart/public/images/products/Samsung-Galaxy-S10-lite-3.jpg\"]', 4, '2019-08-23 11:55:56', '2020-10-18 05:24:47'),
(2, 1, 'geladeira-brastemp-frost-free-litros', 'Geladeira Brastemp Frost Free 443 Litros', 'Geladeira Brastemp Frost Free 443 Litros - BRE57 Branco', 2969010, '[\"http://g21flix.000webhostapp.com/cart/public/images/products/geladeira-brastemp.jpg\",\"http://g21flix.000webhostapp.com/cart/public/images/products/geladeira-brastemp2.jpg\"]', 10, '2019-08-23 11:57:22', '2020-10-19 06:37:24'),
(4, 1, 'smart-crystal', 'Smart TV Crystal UHD 4K LED 55”', 'Samsung - 55TU8000 Wi-Fi Bluetooth HDR 3 HDMI 2 USB', 2849050, '[\"http://g21flix.000webhostapp.com/cart/public/images/products/smart-tv-samsung-4k.jpg\"]', 9, '2019-08-26 02:59:41', '2020-10-19 07:05:29'),
(6, 1, 'fog-brastemp-bocas-bfs5vce', 'Fogão Brastemp 5 Bocas BFS5VCE', 'Com Mesa De Vidro e Turbo Chama - Preto', 2099000, '[\"http://g21flix.000webhostapp.com/cart/public/images/products/fogao-brastemp.jpg\"]', 8, '2019-08-26 03:07:18', '2020-10-19 07:20:42'),
(8, 2, 'notebook-dell-inspiron-i15-a30p', 'Notebook Dell Inspiron i15-3583-A30P', 'Intel Core i7 - 8GB 2TB 15,6” Placa de Vídeo 2GB Windows 10', 4511000, '[\"http://g21flix.000webhostapp.com/cart/public/images/products/notebook-dell-inspiron-i15-3583-A30P.jpg\",\"http://g21flix.000webhostapp.com/cart/public/images/products/pengupas-mie-20190826130430-1.jpg\"]', 8, '2019-08-26 13:04:30', '2020-10-19 07:28:03'),
(9, 2, 'monitor-gamer-quot-curvo', 'Monitor Gamer LED 49&quot; Curvo', '1ms 144hz Double Full HD Ultra Wide - Samsung', 8000000, '[\"http://g21flix.000webhostapp.com/cart/public/images/products/monitor-gamer-led-curvo.jpg\"]', 3, '2019-08-26 13:05:11', '2020-10-19 07:36:32'),
(10, 1, 'playstation-pro-preto', 'Playstation 4 Pro 1TB - Preto', 'Console Playstation 4 Pro 1TB - Preto', 3099000, '[\"http://g21flix.000webhostapp.com/cart/public/images/products/PS4-PRO-1TB.jpg\"]', 5, '2019-08-26 13:05:34', '2020-10-19 07:44:13');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cart_products`
--
ALTER TABLE `cart_products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `cart_products`
--
ALTER TABLE `cart_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
