-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Mar 2022 pada 07.22
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `chatrooms`
--

CREATE TABLE `chatrooms` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `msg` varchar(200) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `chatrooms`
--

INSERT INTO `chatrooms` (`id`, `userid`, `msg`, `created_on`) VALUES
(6, 11, 'test', '2022-02-24 05:15:43'),
(7, 12, 'halo', '2022-02-24 05:15:51'),
(23, 11, 'testing', '2022-03-04 01:42:12'),
(24, 11, 'ans', '2022-03-04 01:42:25'),
(25, 11, 'nabs', '2022-03-04 01:42:35'),
(26, 11, 'p', '2022-03-04 04:14:30'),
(27, 11, 'haloo', '2022-03-04 04:14:57'),
(28, 11, 'halo boy', '2022-03-07 07:03:19'),
(29, 11, 'halo', '2022-03-07 07:03:38'),
(30, 11, 'halo', '2022-03-07 07:06:56'),
(31, 11, 'aaa', '2022-03-07 08:46:54'),
(32, 11, 'halo', '2022-03-07 08:47:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_message`
--

CREATE TABLE `chat_message` (
  `id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `chat_message`
--

INSERT INTO `chat_message` (`id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(1, 13, 11, 'test', '2022-03-08 19:10:51', 'Yes'),
(2, 11, 13, 'haloo', '2022-03-08 19:11:10', 'Yes');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_user_table`
--

CREATE TABLE `chat_user_table` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_profile` varchar(100) NOT NULL,
  `user_created_on` datetime NOT NULL,
  `user_verification_code` varchar(100) NOT NULL,
  `user_login_status` enum('Logout','Login') NOT NULL,
  `user_token` varchar(255) NOT NULL,
  `user_connection_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `chat_user_table`
--

INSERT INTO `chat_user_table` (`user_id`, `user_name`, `user_email`, `user_password`, `user_profile`, `user_created_on`, `user_verification_code`, `user_login_status`, `user_token`, `user_connection_id`) VALUES
(11, 'farhan', 'farhan.fcbar@gmail.com', 'handymany', 'images/74177483.jpg', '2022-02-24 04:37:49', '9178b0b41f20579df7b6dc07bc753eed', 'Login', '6f25d2ce3d8c2b5ff8aaa2efb82416f0', 706),
(12, 'hahan', 'hahan@gmail.com', 'zxcvbnm', 'images/1645674701.png', '2022-02-24 04:51:41', 'f10a95bed2892e4ffd37a7e9992fc0dd', 'Logout', '9dc1903d08eed80028af75612b9d32c1', 466),
(13, 'farhan', 'farhanannanaa@gmail.com', 'poiuytrewq', 'images/1646210614.png', '2022-03-02 09:43:34', '28851be185e3e494687700534690bc8e', 'Login', '5d40ff7f0868b4c92d7360dc7cb02ff9', 474),
(14, 'farhan', 'muhammad.ananto@students.amikom.ac.id', 'asdfghjkl', 'images/1646210660.png', '2022-03-02 09:44:20', 'a26e91ecda6c81c631a88c7c0acba3e7', 'Logout', '', 0),
(15, 'nana', 'gaga@gmail.com', 'qwertyuiop', 'images/1646626947.png', '2022-03-07 05:22:27', 'a9afa1b22b75abb55f2293da46897b43', 'Logout', '32f3c751da765d05df1bb0636a559d10', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `chatrooms`
--
ALTER TABLE `chatrooms`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `chat_user_table`
--
ALTER TABLE `chat_user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chatrooms`
--
ALTER TABLE `chatrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `chat_user_table`
--
ALTER TABLE `chat_user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
