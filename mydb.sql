-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 22, 2023 lúc 10:20 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mydb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `postid` bigint(19) NOT NULL,
  `comment_userid` bigint(19) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `friendships`
--

CREATE TABLE `friendships` (
  `id` int(11) NOT NULL,
  `user1_id` bigint(19) NOT NULL,
  `user2_id` bigint(19) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `friendships`
--

INSERT INTO `friendships` (`id`, `user1_id`, `user2_id`, `status`, `date`) VALUES
(7, 3572325399739732623, 4556887516696215, 'isFriend', '2023-10-28 06:54:05'),
(8, 744177439385, 4556887516696215, 'isFriend', '2023-10-28 06:54:05'),
(9, 4556887516696215, 4623450327014144, 'isFriend', '2023-10-28 06:54:05'),
(10, 744177439385, 3572325399739732623, 'isFriend', '2023-10-28 06:54:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `sender_id` bigint(19) NOT NULL,
  `receiver_id` bigint(19) NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Pending, Accepted, Declined, Canceled, Blocked',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_id`, `receiver_id`, `status`, `date`) VALUES
(104, 3572325399739732623, 4556887516696215, 'Accepted', '2023-10-26 10:38:54'),
(105, 744177439385, 3572325399739732623, 'Accepted', '2023-10-27 13:05:03'),
(106, 744177439385, 4556887516696215, 'Accepted', '2023-10-26 11:03:45'),
(108, 4556887516696215, 4623450327014144, 'Accepted', '2023-10-26 13:25:47'),
(114, 3572325399739732623, 9095530094254485, 'Pending', '2023-11-15 15:40:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` bigint(19) NOT NULL,
  `receiver_id` bigint(19) NOT NULL,
  `text` varchar(500) NOT NULL,
  `media` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_by_sender` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_by_receiver` tinyint(1) NOT NULL DEFAULT 0,
  `read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `text`, `media`, `date`, `deleted_by_sender`, `deleted_by_receiver`, `read`) VALUES
(208, 744177439385, 4556887516696215, 'ddd', '', '2023-11-01 08:20:36', 0, 0, 0),
(256, 744177439385, 4556887516696215, 'ttt', '', '2023-11-02 11:01:18', 0, 0, 0),
(382, 744177439385, 4556887516696215, 'hhhh', '', '2023-11-03 01:46:17', 0, 0, 0),
(398, 3572325399739732623, 4556887516696215, 'ddd', '', '2023-11-03 16:51:41', 0, 0, 0),
(405, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-03 17:26:17', 0, 0, 0),
(406, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-03 17:26:17', 0, 0, 0),
(407, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-03 17:26:17', 0, 0, 0),
(408, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-03 17:26:17', 0, 0, 0),
(409, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-03 17:26:17', 0, 0, 0),
(410, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-03 17:26:18', 0, 0, 0),
(411, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-03 17:26:18', 0, 0, 0),
(412, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-03 17:26:18', 0, 0, 0),
(413, 3572325399739732623, 4556887516696215, 'ab', '', '2023-11-03 17:26:19', 0, 0, 0),
(414, 3572325399739732623, 4556887516696215, 'c', '', '2023-11-03 17:26:19', 0, 0, 0),
(415, 3572325399739732623, 4556887516696215, 'd', '', '2023-11-03 17:26:20', 0, 0, 0),
(416, 3572325399739732623, 4556887516696215, 'g', '', '2023-11-03 17:26:20', 0, 0, 0),
(417, 3572325399739732623, 4556887516696215, 'h', '', '2023-11-03 17:26:21', 0, 0, 0),
(418, 3572325399739732623, 4556887516696215, 'ẻ', '', '2023-11-03 17:26:21', 0, 0, 0),
(419, 3572325399739732623, 4556887516696215, 'u', '', '2023-11-03 17:26:21', 0, 0, 0),
(420, 3572325399739732623, 4556887516696215, 'ưetw', '', '2023-11-03 17:26:22', 0, 0, 0),
(421, 3572325399739732623, 4556887516696215, 'jr', '', '2023-11-03 17:26:22', 0, 0, 0),
(422, 3572325399739732623, 4556887516696215, 'hẻ', '', '2023-11-03 17:26:24', 0, 0, 0),
(423, 3572325399739732623, 4556887516696215, 'hả', '', '2023-11-03 17:26:25', 0, 0, 0),
(424, 3572325399739732623, 4556887516696215, 'ả', '', '2023-11-03 17:26:31', 0, 0, 0),
(425, 3572325399739732623, 4556887516696215, 'hả', '', '2023-11-03 17:26:33', 1, 0, 0),
(426, 3572325399739732623, 4556887516696215, 'ha', '', '2023-11-03 17:26:34', 1, 0, 0),
(427, 3572325399739732623, 4556887516696215, 'trhar', '', '2023-11-03 17:26:35', 1, 0, 0),
(428, 3572325399739732623, 4556887516696215, 'hả', '', '2023-11-03 17:26:36', 1, 0, 0),
(461, 3572325399739732623, 4556887516696215, 'adada', '', '2023-11-03 19:29:29', 1, 0, 0),
(464, 3572325399739732623, 4556887516696215, 'vo', '', '2023-11-03 20:06:01', 1, 0, 0),
(483, 3572325399739732623, 4556887516696215, 'htthuan.id.vn', '', '2023-11-04 16:32:36', 1, 0, 0),
(494, 744177439385, 4556887516696215, 'https://htthuan.id.vn', '', '2023-11-04 18:30:29', 0, 0, 0),
(547, 3572325399739732623, 4556887516696215, 'đúng&#039;', '', '2023-11-05 14:01:56', 0, 0, 0),
(551, 3572325399739732623, 4556887516696215, 'ừ', '', '2023-11-05 14:05:57', 0, 0, 0),
(557, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-05 14:07:15', 0, 0, 0),
(558, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-05 14:07:16', 0, 0, 0),
(559, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-05 14:07:16', 0, 0, 0),
(560, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-05 14:07:16', 0, 0, 0),
(561, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-05 14:07:17', 0, 0, 0),
(562, 3572325399739732623, 4556887516696215, 'a', '', '2023-11-05 14:07:17', 0, 0, 0),
(563, 3572325399739732623, 4556887516696215, 'v', '', '2023-11-05 14:07:18', 0, 0, 0),
(564, 3572325399739732623, 4556887516696215, 'v', '', '2023-11-05 14:07:18', 0, 0, 0),
(565, 3572325399739732623, 4556887516696215, 'bg', '', '2023-11-05 14:07:19', 0, 0, 0),
(566, 3572325399739732623, 4556887516696215, 'nhy c', '', '2023-11-05 14:07:21', 0, 0, 0),
(567, 3572325399739732623, 4556887516696215, 'nh', '', '2023-11-05 14:07:22', 0, 0, 0),
(568, 3572325399739732623, 4556887516696215, 'chan', '', '2023-11-05 14:07:24', 0, 0, 0),
(569, 3572325399739732623, 4556887516696215, 'chan vai o\\', '', '2023-11-05 14:07:28', 0, 0, 0),
(570, 3572325399739732623, 4556887516696215, 'ok ', '', '2023-11-05 14:07:30', 0, 0, 0),
(571, 3572325399739732623, 4556887516696215, 'ok', '', '2023-11-05 14:07:31', 0, 0, 0),
(572, 3572325399739732623, 4556887516696215, 'o\\', '', '2023-11-05 14:07:31', 0, 0, 0),
(573, 3572325399739732623, 4556887516696215, 'ok', '', '2023-11-05 14:07:32', 0, 0, 0),
(574, 3572325399739732623, 4556887516696215, 'ok', '', '2023-11-05 14:07:33', 0, 0, 0),
(575, 3572325399739732623, 4556887516696215, 'ok\\', '', '2023-11-05 14:07:34', 0, 0, 0),
(576, 3572325399739732623, 4556887516696215, 'ok', '', '2023-11-05 14:07:34', 0, 0, 0),
(577, 3572325399739732623, 4556887516696215, 'oko', '', '2023-11-05 14:07:35', 0, 0, 0),
(587, 3572325399739732623, 9095530094254485, 'e', '', '2023-11-09 11:37:45', 0, 0, 0),
(588, 3572325399739732623, 744177439385, 'e', '', '2023-11-09 11:38:06', 0, 0, 0),
(589, 3572325399739732623, 4556887516696215, 'AND Logic Gate:\nNếu bạn muốn ngõ ra là 0 khi tất cả các đầu vào đều là 0, bạn có thể sử dụng cổng AND. Công thức logic cho điều này sẽ là:\nNg\no\n˜\n ra\n=\n�\n1\n×\n�\n2\n×\n�\n3\n×\n�\n4\nNg \no\n˜\n  ra=a1×a2×a3×a4\nKết quả này chỉ sẽ là 0 khi tất cả các a1, a2, a3, a4 đều bằng 0.', '', '2023-11-14 16:39:27', 0, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `userid` bigint(19) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isRead` tinyint(1) NOT NULL DEFAULT 0,
  `related_object_id` bigint(19) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `userid`, `content`, `date`, `isRead`, `related_object_id`, `type`) VALUES
(83, 3572325399739732500, 'like', '2023-11-19 16:41:54', 0, 95712400831445651, 'like'),
(84, 3572325399739732500, 'like', '2023-11-19 16:41:55', 0, 95712400831445651, 'like'),
(85, 3572325399739732500, 'like', '2023-11-19 16:41:55', 0, 95712400831445651, 'like'),
(86, 3572325399739732500, 'like', '2023-11-19 16:41:56', 0, 95712400831445651, 'like'),
(87, 3572325399739732500, 'like', '2023-11-19 16:41:56', 0, 95712400831445651, 'like'),
(88, 3572325399739732500, 'like', '2023-11-19 16:41:57', 0, 95712400831445651, 'like'),
(89, 3572325399739732500, 'like', '2023-11-19 16:41:57', 0, 95712400831445651, 'like'),
(90, 3572325399739732500, 'like', '2023-11-19 16:41:57', 0, 95712400831445651, 'like'),
(91, 3572325399739732500, 'like', '2023-11-19 16:41:57', 0, 95712400831445651, 'like'),
(92, 3572325399739732500, 'like', '2023-11-19 16:41:57', 0, 95712400831445651, 'like'),
(93, 3572325399739732500, 'like', '2023-11-19 16:41:58', 0, 95712400831445651, 'like'),
(94, 3572325399739732500, 'like', '2023-11-19 16:41:58', 0, 95712400831445651, 'like'),
(95, 3572325399739732500, 'like', '2023-11-19 16:41:58', 0, 95712400831445651, 'like'),
(96, 3572325399739732500, 'like', '2023-11-19 16:41:58', 0, 95712400831445651, 'like'),
(97, 3572325399739732500, 'like', '2023-11-19 16:41:58', 0, 95712400831445651, 'like'),
(98, 3572325399739732500, 'like', '2023-11-19 16:42:01', 0, 95712400831445651, 'like'),
(99, 3572325399739732500, 'like', '2023-11-19 16:42:02', 0, 95712400831445651, 'like'),
(100, 3572325399739732500, 'like', '2023-11-19 16:42:02', 0, 95712400831445651, 'like'),
(101, 3572325399739732500, 'like', '2023-11-19 16:42:03', 0, 95712400831445651, 'like'),
(102, 3572325399739732500, 'like', '2023-11-19 16:42:03', 0, 95712400831445651, 'like'),
(103, 3572325399739732500, 'like', '2023-11-19 16:42:05', 0, 95712400831445651, 'like'),
(104, 3572325399739732500, 'like', '2023-11-19 16:42:07', 0, 95712400831445651, 'like'),
(105, 3572325399739732500, 'like', '2023-11-19 16:42:07', 0, 95712400831445651, 'like'),
(106, 3572325399739732500, 'like', '2023-11-19 16:42:07', 0, 95712400831445651, 'like'),
(107, 3572325399739732500, 'like', '2023-11-19 16:43:38', 0, 95712400831445651, 'like'),
(108, 3572325399739732500, 'like', '2023-11-19 16:43:38', 0, 95712400831445651, 'like'),
(109, 3572325399739732500, 'like', '2023-11-19 16:43:39', 0, 95712400831445651, 'like'),
(110, 3572325399739732500, 'like', '2023-11-19 16:43:39', 0, 95712400831445651, 'like'),
(111, 3572325399739732500, 'like', '2023-11-19 16:43:45', 0, 95712400831445651, 'like'),
(112, 4556887516696215, 'like', '2023-11-19 16:44:16', 0, 5293014911651357439, 'like'),
(113, 4556887516696215, 'like', '2023-11-19 16:44:26', 0, 10380118642591, 'like'),
(114, 4556887516696215, 'like', '2023-11-19 16:44:31', 0, 10380118642591, 'like'),
(115, 4556887516696215, 'like', '2023-11-19 16:44:32', 0, 10380118642591, 'like'),
(116, 4556887516696215, 'like', '2023-11-19 16:44:32', 0, 10380118642591, 'like'),
(117, 4556887516696215, 'like', '2023-11-19 16:44:32', 0, 10380118642591, 'like'),
(118, 4556887516696215, 'like', '2023-11-19 16:44:32', 0, 10380118642591, 'like'),
(119, 4556887516696215, 'like', '2023-11-19 16:44:35', 0, 10380118642591, 'like'),
(120, 4556887516696215, 'like', '2023-11-19 16:44:35', 0, 10380118642591, 'like'),
(121, 4556887516696215, 'like', '2023-11-19 16:44:36', 0, 10380118642591, 'like'),
(122, 4556887516696215, 'like', '2023-11-19 16:44:36', 0, 10380118642591, 'like'),
(123, 4556887516696215, 'like', '2023-11-19 16:44:36', 0, 10380118642591, 'like'),
(124, 3572325399739732500, 'like', '2023-11-19 16:44:49', 0, 95712400831445651, 'like'),
(125, 3572325399739732500, 'like', '2023-11-19 16:44:50', 0, 95712400831445651, 'like'),
(126, 3572325399739732500, 'like', '2023-11-19 16:44:50', 0, 95712400831445651, 'like'),
(127, 3572325399739732500, 'like', '2023-11-19 16:44:50', 0, 95712400831445651, 'like'),
(128, 3572325399739732500, 'like', '2023-11-19 16:44:50', 0, 95712400831445651, 'like'),
(129, 3572325399739732500, 'like', '2023-11-19 16:44:50', 0, 95712400831445651, 'like'),
(130, 3572325399739732500, 'like', '2023-11-19 16:44:51', 0, 95712400831445651, 'like'),
(131, 3572325399739732500, 'like', '2023-11-19 16:44:51', 0, 95712400831445651, 'like'),
(132, 3572325399739732500, 'like', '2023-11-19 16:44:51', 0, 95712400831445651, 'like'),
(133, 3572325399739732500, 'like', '2023-11-19 16:44:51', 0, 95712400831445651, 'like'),
(134, 3572325399739732500, 'like', '2023-11-19 16:44:51', 0, 95712400831445651, 'like'),
(135, 3572325399739732500, 'like', '2023-11-19 16:44:51', 0, 95712400831445651, 'like'),
(136, 3572325399739732500, 'like', '2023-11-19 16:44:51', 0, 95712400831445651, 'like'),
(137, 3572325399739732500, 'like', '2023-11-19 16:44:52', 0, 95712400831445651, 'like'),
(138, 3572325399739732500, 'like', '2023-11-19 16:44:52', 0, 95712400831445651, 'like'),
(139, 3572325399739732500, 'like', '2023-11-19 16:44:52', 0, 95712400831445651, 'like'),
(140, 3572325399739732500, 'like', '2023-11-19 16:44:52', 0, 95712400831445651, 'like'),
(141, 3572325399739732500, 'like', '2023-11-19 16:44:52', 0, 95712400831445651, 'like'),
(142, 3572325399739732500, 'like', '2023-11-19 16:44:52', 0, 95712400831445651, 'like'),
(143, 3572325399739732500, 'like', '2023-11-19 16:44:53', 0, 95712400831445651, 'like'),
(144, 3572325399739732500, 'like', '2023-11-20 02:28:38', 0, 95712400831445651, 'like'),
(145, 3572325399739732500, 'like', '2023-11-20 02:30:39', 0, 95712400831445651, 'like'),
(146, 3572325399739732500, 'like', '2023-11-20 02:32:14', 0, 95712400831445651, 'like'),
(147, 3572325399739732500, 'like', '2023-11-20 02:35:01', 0, 95712400831445651, 'like'),
(148, 3572325399739732500, 'like', '2023-11-20 02:35:04', 0, 95712400831445651, 'like'),
(149, 3572325399739732500, 'like', '2023-11-20 02:35:08', 0, 95712400831445651, 'like'),
(150, 3572325399739732500, 'like', '2023-11-20 02:35:42', 0, 95712400831445651, 'like'),
(151, 3572325399739732500, 'like', '2023-11-20 02:35:45', 0, 95712400831445651, 'like'),
(152, 3572325399739732500, 'like', '2023-11-20 02:36:34', 0, 95712400831445651, 'like'),
(153, 3572325399739732500, 'like', '2023-11-20 02:36:36', 0, 95712400831445651, 'like'),
(154, 3572325399739732500, 'like', '2023-11-20 02:36:40', 0, 95712400831445651, 'like'),
(155, 3572325399739732500, 'like', '2023-11-20 02:36:40', 0, 95712400831445651, 'like'),
(156, 3572325399739732500, 'like', '2023-11-20 02:36:43', 0, 95712400831445651, 'like'),
(157, 3572325399739732500, 'like', '2023-11-20 02:36:43', 0, 95712400831445651, 'like'),
(158, 3572325399739732500, 'like', '2023-11-20 02:36:43', 0, 95712400831445651, 'like'),
(159, 3572325399739732500, 'like', '2023-11-20 02:37:10', 0, 95712400831445651, 'like'),
(160, 3572325399739732500, 'like', '2023-11-20 02:37:12', 0, 95712400831445651, 'like'),
(161, 3572325399739732500, 'like', '2023-11-20 02:37:27', 0, 95712400831445651, 'like'),
(162, 3572325399739732500, 'like', '2023-11-20 02:37:49', 0, 95712400831445651, 'like'),
(163, 3572325399739732500, 'like', '2023-11-20 02:38:47', 0, 95712400831445651, 'like'),
(164, 3572325399739732500, 'like', '2023-11-20 02:39:19', 0, 95712400831445651, 'like'),
(165, 3572325399739732500, 'like', '2023-11-20 02:39:25', 0, 95712400831445651, 'like'),
(166, 3572325399739732500, 'like', '2023-11-20 02:39:33', 0, 95712400831445651, 'like'),
(167, 3572325399739732500, 'like', '2023-11-20 02:39:33', 0, 95712400831445651, 'like'),
(168, 3572325399739732500, 'like', '2023-11-20 02:39:33', 0, 95712400831445651, 'like'),
(169, 3572325399739732500, 'like', '2023-11-20 02:39:33', 0, 95712400831445651, 'like'),
(170, 3572325399739732500, 'like', '2023-11-20 02:39:34', 0, 95712400831445651, 'like'),
(171, 3572325399739732500, 'like', '2023-11-20 02:39:34', 0, 95712400831445651, 'like'),
(172, 3572325399739732500, 'like', '2023-11-20 02:39:34', 0, 95712400831445651, 'like'),
(173, 3572325399739732500, 'like', '2023-11-20 02:39:34', 0, 95712400831445651, 'like'),
(174, 3572325399739732500, 'like', '2023-11-20 02:39:34', 0, 95712400831445651, 'like'),
(175, 3572325399739732500, 'like', '2023-11-20 02:39:34', 0, 95712400831445651, 'like'),
(176, 4556887516696215, 'like', '2023-11-20 02:39:52', 0, 10380118642591, 'like'),
(177, 3572325399739732500, 'like', '2023-11-20 02:41:28', 0, 95712400831445651, 'like'),
(178, 3572325399739732500, 'like', '2023-11-20 02:53:10', 0, 95712400831445651, 'like'),
(179, 4556887516696215, 'like', '2023-11-20 02:53:36', 0, 10380118642591, 'like'),
(180, 4556887516696215, 'like', '2023-11-20 02:54:36', 0, 10380118642591, 'like'),
(181, 3572325399739732500, 'like', '2023-11-20 02:55:56', 0, 95712400831445651, 'like'),
(182, 4556887516696215, 'like', '2023-11-20 03:05:18', 0, 95712400831445651, 'like');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(19) NOT NULL,
  `postid` bigint(19) NOT NULL,
  `post` varchar(1000) NOT NULL,
  `userid` bigint(19) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `has_image` tinyint(1) NOT NULL,
  `has_video` tinyint(1) NOT NULL,
  `media` text NOT NULL,
  `privacy` varchar(20) NOT NULL COMMENT 'public, private, ...'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `postid`, `post`, `userid`, `date`, `has_image`, `has_video`, `media`, `privacy`) VALUES
(104, 9759241934775442, 'Oke ne\n', 3572325399739732623, '2023-11-22 06:46:44', 1, 0, '[\"cpu1.jpg\",\"cpu2.jpg\",\"z3530855532263_7d078d604075189ebba258a671222ccb.jpg\",\"z3530855536056_fd6b8aa79faad2ced42c46489e07cb1d.jpg\"]', ''),
(106, 58011754869, 'Testfrined', 3572325399739732623, '2023-11-22 07:00:29', 1, 0, '', 'Friend'),
(107, 2762202513447017, 'Hooo', 3572325399739732623, '2023-11-22 07:16:57', 1, 0, '[\"tong the.jpg\"]', 'Friend'),
(117, 5776063094262829438, 'My name is Teddy!!!SSS', 3572325399739732623, '2023-11-22 21:10:08', 1, 0, '[\"z3530855536056_fd6b8aa79faad2ced42c46489e07cb1d.jpg\"]', 'Public'),
(136, 8401297253147543, 'Test đăng post bên timeline', 3572325399739732623, '2023-11-22 20:36:55', 1, 0, '[\"z3530855536056_fd6b8aa79faad2ced42c46489e07cb1d.jpg\"]', 'Friend');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `recent_searches`
--

CREATE TABLE `recent_searches` (
  `id` int(11) NOT NULL,
  `userid` bigint(19) NOT NULL,
  `query` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `relatedobjects`
--

CREATE TABLE `relatedobjects` (
  `id` int(11) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `object_id` bigint(19) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `share`
--

CREATE TABLE `share` (
  `id` int(11) NOT NULL,
  `postid` bigint(19) NOT NULL,
  `share_userid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `userid` bigint(19) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `url_address` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cover_image` varchar(100) NOT NULL,
  `avatar_image` varchar(500) NOT NULL DEFAULT 'uploads/avatars/avatar_default.png',
  `connection_id` int(5) NOT NULL,
  `privacy` varchar(20) NOT NULL DEFAULT 'public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `userid`, `first_name`, `last_name`, `gender`, `email`, `password`, `url_address`, `date`, `cover_image`, `avatar_image`, `connection_id`, `privacy`) VALUES
(10, 4556887516696215, 'Hoàng', 'Thuận', 'Male', 'cryptocard.268@gmail.com', 'htthuan2468', 'hoàng.thuận', '2023-11-20 03:09:02', '', 'uploads/avatars/avatar_default.png', 443, 'public'),
(31, 3572325399739732623, 'Thuan', 'Teddy', 'Male', 'thuan2682k3@gmail.com', 'htthuan6041', 'thuan.teddy', '2023-11-22 03:06:25', '', 'uploads/avatars/avatar_default.png', 405, 'public'),
(32, 4623450327014144, 'Teddy', 'IsMe', 'Male', 'thuan0205766@huce.edu.vn', 'htthuan4902', 'teddy.isme', '2023-10-26 09:16:30', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(33, 744177439385, 'Hihi', 'KKK', 'Male', 'aaa@aaa.vn', '123', 'hihi.kkk', '2023-11-05 14:06:11', '', 'uploads/avatars/avatar_default.png', 508, 'public'),
(34, 9095530094254485, 'Hoàng', 'Hiếu', 'Male', 'hieu0189366@huce.edu.vn', 'htthuan6807', 'ho?ng.hi?u', '2023-10-30 04:45:39', '', 'uploads/avatars/avatar_default.png', 83, 'public'),
(36, 6643068578152038928, 'Thuận', 'Nè', 'Male', 'thuan2682k31@gmail.com', '111', 'thu?n.n?', '2023-11-01 13:22:39', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(37, 512857291296889, 'Thuan', 'Ok', 'Male', 'thuan26282k3@gmail.com', '1', 'thuan.ok', '2023-11-20 04:48:26', '', 'uploads/avatars/avatar_default.png', 0, 'public');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_about`
--

CREATE TABLE `users_about` (
  `id` int(11) NOT NULL,
  `userid` bigint(19) NOT NULL,
  `birthday` date DEFAULT NULL,
  `desc` varchar(300) NOT NULL,
  `address` varchar(200) NOT NULL,
  `edu` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users_about`
--

INSERT INTO `users_about` (`id`, `userid`, `birthday`, `desc`, `address`, `edu`) VALUES
(8, 3572325399739732623, '2003-08-26', 'My name is Thuannnne', 'Hanoi Vietnam', 'HUCE'),
(16, 4556887516696215, '2023-10-06', 'H', 'thuan@gmail.com', 'HUCE');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_status`
--

CREATE TABLE `users_status` (
  `id` int(11) NOT NULL,
  `userid` bigint(19) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users_status`
--

INSERT INTO `users_status` (`id`, `userid`, `status`, `date`) VALUES
(60, 3572325399739732623, 'offline', '2023-11-20 03:13:29'),
(70, 4556887516696215, 'offline', '2023-11-20 03:13:28'),
(311, 744177439385, 'offline', '2023-11-05 14:06:21');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postid` (`postid`,`comment_userid`),
  ADD KEY `comment_userid` (`comment_userid`);

--
-- Chỉ mục cho bảng `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user1_id_2` (`user1_id`,`user2_id`),
  ADD KEY `user1_id` (`user1_id`,`user2_id`),
  ADD KEY `user2_id` (`user2_id`);

--
-- Chỉ mục cho bảng `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sender_id_2` (`sender_id`,`receiver_id`),
  ADD UNIQUE KEY `sender_id_4` (`sender_id`,`receiver_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `sender_id_3` (`sender_id`,`receiver_id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`,`receiver_id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `postid` (`postid`),
  ADD KEY `postid_2` (`postid`),
  ADD KEY `userid` (`userid`);

--
-- Chỉ mục cho bảng `recent_searches`
--
ALTER TABLE `recent_searches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`),
  ADD KEY `userid_2` (`userid`);

--
-- Chỉ mục cho bảng `relatedobjects`
--
ALTER TABLE `relatedobjects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `share`
--
ALTER TABLE `share`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postid` (`postid`,`share_userid`),
  ADD KEY `share_userid` (`share_userid`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid_2` (`userid`),
  ADD KEY `userid` (`userid`,`first_name`,`last_name`,`gender`,`email`,`url_address`,`date`);

--
-- Chỉ mục cho bảng `users_about`
--
ALTER TABLE `users_about`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid_2` (`userid`),
  ADD KEY `userid` (`userid`);

--
-- Chỉ mục cho bảng `users_status`
--
ALTER TABLE `users_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid_2` (`userid`),
  ADD UNIQUE KEY `userid_3` (`userid`),
  ADD KEY `userid` (`userid`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=594;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT cho bảng `recent_searches`
--
ALTER TABLE `recent_searches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `relatedobjects`
--
ALTER TABLE `relatedobjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `share`
--
ALTER TABLE `share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `users_about`
--
ALTER TABLE `users_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `users_status`
--
ALTER TABLE `users_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2246;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `posts` (`postid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`comment_userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `friendships`
--
ALTER TABLE `friendships`
  ADD CONSTRAINT `friendships_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friendships_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friend_requests_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `recent_searches`
--
ALTER TABLE `recent_searches`
  ADD CONSTRAINT `recent_searches_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `share`
--
ALTER TABLE `share`
  ADD CONSTRAINT `share_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `posts` (`postid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `share_ibfk_2` FOREIGN KEY (`share_userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `users_about`
--
ALTER TABLE `users_about`
  ADD CONSTRAINT `users_about_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `users_status`
--
ALTER TABLE `users_status`
  ADD CONSTRAINT `users_status_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
