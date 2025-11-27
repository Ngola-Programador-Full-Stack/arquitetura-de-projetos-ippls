-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Nov-2025 às 22:52
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `arquitetura_de_projetos_ippls`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `templates_arquitetura`
--

CREATE TABLE `templates_arquitetura` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `nivel` enum('base','padrao','avancado') NOT NULL,
  `descricao` text NOT NULL,
  `estrutura_diretorios` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`estrutura_diretorios`)),
  `arquivos_base` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`arquivos_base`)),
  `dependencias` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dependencias`)),
  `instrucoes_uso` text DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `templates_arquitetura`
--

INSERT INTO `templates_arquitetura` (`id`, `nome`, `nivel`, `descricao`, `estrutura_diretorios`, `arquivos_base`, `dependencias`, `instrucoes_uso`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 'Arquitetura Base - MVC Básico', 'base', 'Estrutura MVC básica com organização fundamental de diretórios (models, views, controllers)', '\"{\\\"projeto_base\\\\\\/\\\":{\\\"0\\\":\\\"index.php\\\",\\\"config\\\\\\/\\\":[\\\"database.php\\\"],\\\"1\\\":\\\"models\\\\\\/\\\",\\\"2\\\":\\\"views\\\\\\/\\\",\\\"3\\\":\\\"controllers\\\\\\/\\\",\\\"assets\\\\\\/\\\":[\\\"css\\\\\\/\\\",\\\"js\\\\\\/\\\",\\\"images\\\\\\/\\\"],\\\"4\\\":\\\"README.md\\\"}}\"', '\"[\\\"index.php\\\",\\\"config\\\\\\/database.php\\\",\\\"README.md\\\"]\"', NULL, 'Template básico para projetos MVC iniciantes. Configure a base de dados em config/database.php.', 1, '2025-09-17 11:32:59', '2025-09-17 11:32:59'),
(2, 'Arquitetura Padrão - MVC Intermediário', 'padrao', 'Estrutura MVC intermediária com helpers, configurações avançadas e separação de camadas', '\"{\\\"projeto_padrao\\\\\\/\\\":{\\\"0\\\":\\\"index.php\\\",\\\"config\\\\\\/\\\":[\\\"database.php\\\",\\\"app.php\\\"],\\\"app\\\\\\/\\\":[\\\"models\\\\\\/\\\",\\\"views\\\\\\/\\\",\\\"controllers\\\\\\/\\\",\\\"helpers\\\\\\/\\\"],\\\"public\\\\\\/\\\":[\\\"css\\\\\\/\\\",\\\"js\\\\\\/\\\",\\\"assets\\\\\\/\\\"],\\\"1\\\":\\\"storage\\\\\\/\\\",\\\"2\\\":\\\"vendor\\\\\\/\\\"}}\"', '\"[\\\"index.php\\\",\\\"config\\\\\\/database.php\\\",\\\"config\\\\\\/app.php\\\"]\"', NULL, 'Template intermediário com estrutura organizada. Use o autoloader para classes.', 1, '2025-09-17 11:32:59', '2025-09-17 11:32:59'),
(3, 'Arquitetura Avançada - MVC Completo', 'avancado', 'Estrutura MVC completa com middleware, services, testes e configuração para Docker', '\"{\\\"projeto_avancado\\\\\\/\\\":{\\\"0\\\":\\\"index.php\\\",\\\"1\\\":\\\"config\\\\\\/\\\",\\\"app\\\\\\/\\\":[\\\"Core\\\\\\/\\\",\\\"Models\\\\\\/\\\",\\\"Views\\\\\\/\\\",\\\"Controllers\\\\\\/\\\",\\\"Middleware\\\\\\/\\\",\\\"Services\\\\\\/\\\"],\\\"2\\\":\\\"public\\\\\\/\\\",\\\"3\\\":\\\"storage\\\\\\/\\\",\\\"4\\\":\\\"tests\\\\\\/\\\",\\\"5\\\":\\\"vendor\\\\\\/\\\",\\\"6\\\":\\\"docker\\\\\\/\\\"}}\"', '\"[\\\"index.php\\\",\\\"composer.json\\\",\\\"Dockerfile\\\"]\"', '\"[\\\"PHP 8.0+\\\",\\\"Composer\\\",\\\"MySQL\\\\\\/PostgreSQL\\\"]\"', 'Template avançado com arquitetura robusta. Use composer install para dependências.', 1, '2025-09-17 11:33:00', '2025-09-17 11:33:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `templates_arquitetura`
--
ALTER TABLE `templates_arquitetura`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `templates_arquitetura`
--
ALTER TABLE `templates_arquitetura`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
