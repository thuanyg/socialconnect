-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 24, 2023 lúc 07:12 PM
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

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertMultipleUsers1` ()   BEGIN
    DECLARE counter INT DEFAULT 1;
    DECLARE random_hour INT;
    DECLARE random_name VARCHAR(255);
    DECLARE random_last VARCHAR(255);

    WHILE counter <= 50 DO
        SET random_hour = FLOOR(RAND() * 24);

        SELECT first_name INTO random_name FROM users ORDER BY RAND() LIMIT 1;
        SELECT last_name INTO random_last FROM users ORDER BY RAND() LIMIT 1;

        INSERT INTO `users` (`userid`, `first_name`, `last_name`, `gender`, `email`, `password`, `url_address`, `date`, `cover_image`, `avatar_image`, `connection_id`, `privacy`)
        VALUES
        (
            CONCAT('25328412491290', counter),            random_name,
            random_last,
            'Male',
            CONCAT('user', counter , '@huce.edu.vn'),
            '123',
            'social@huce',
            DATE_ADD('2023-11-24 00:00:00', INTERVAL random_hour HOUR),
            '',
            'uploads/avatars/avatar_default.png',
            '0',
            'public'
        );

        SET counter = counter + 1;
    END WHILE;
END$$

DELIMITER ;

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
(10, 744177439385, 3572325399739732623, 'isFriend', '2023-10-28 06:54:05'),
(11, 3572325399739732623, 9095530094254485, 'isFriend', '2023-11-24 06:48:27');

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
(114, 3572325399739732623, 9095530094254485, 'Accepted', '2023-11-24 06:48:27');

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
(589, 3572325399739732623, 4556887516696215, 'AND Logic Gate:\nNếu bạn muốn ngõ ra là 0 khi tất cả các đầu vào đều là 0, bạn có thể sử dụng cổng AND. Công thức logic cho điều này sẽ là:\nNg\no\n˜\n ra\n=\n�\n1\n×\n�\n2\n×\n�\n3\n×\n�\n4\nNg \no\n˜\n  ra=a1×a2×a3×a4\nKết quả này chỉ sẽ là 0 khi tất cả các a1, a2, a3, a4 đều bằng 0.', '', '2023-11-14 16:39:27', 0, 0, 0),
(594, 3572325399739732623, 4556887516696215, 'haha', '', '2023-11-23 14:57:57', 0, 0, 0),
(595, 4556887516696215, 3572325399739732623, 'Ok', '', '2023-11-23 14:58:48', 0, 0, 0),
(596, 3572325399739732623, 4556887516696215, 'No', '', '2023-11-23 15:22:14', 0, 0, 0),
(597, 3572325399739732623, 4556887516696215, 'No', '', '2023-11-24 05:42:18', 0, 0, 0),
(598, 3572325399739732623, 4556887516696215, '', '[\"profile-15.jpg\"]', '2023-11-24 05:42:24', 0, 0, 0),
(599, 3572325399739732623, 4556887516696215, 'Message with images!', '[\"profile-1.jpg\"]', '2023-11-24 05:42:51', 0, 0, 0),
(600, 3572325399739732623, 4556887516696215, 'Message 2', '[\"feed-5.jpg\"]', '2023-11-24 05:43:32', 0, 0, 0),
(603, 3572325399739732623, 4556887516696215, 'Message 3', '[\"profile-4.jpg\"]', '2023-11-24 05:47:34', 0, 0, 0),
(604, 3572325399739732623, 4556887516696215, 'Message 4', '[\"feed-6.jpg\"]', '2023-11-24 05:48:20', 0, 0, 0),
(605, 4556887516696215, 744177439385, 'no', '', '2023-11-24 06:12:00', 0, 0, 0),
(606, 4556887516696215, 3572325399739732623, 'E', '', '2023-11-24 06:12:18', 0, 0, 0),
(607, 3572325399739732623, 4556887516696215, 'Hiii', '', '2023-11-24 06:12:29', 0, 0, 0),
(608, 4556887516696215, 3572325399739732623, 'How are you?', '', '2023-11-24 06:12:36', 0, 0, 0),
(609, 3572325399739732623, 4556887516696215, 'I&#039;m fine thank you', '', '2023-11-24 06:12:59', 0, 0, 0);

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
(182, 4556887516696215, 'like', '2023-11-20 03:05:18', 0, 95712400831445651, 'like'),
(183, 3572325399739732623, 'like', '2023-11-24 06:03:50', 0, 182746900562, 'like'),
(184, 3572325399739732623, 'like', '2023-11-24 06:03:51', 0, 182746900562, 'like'),
(185, 3572325399739732623, 'like', '2023-11-24 06:03:57', 0, 182746900562, 'like'),
(186, 3572325399739732623, 'like', '2023-11-24 06:03:57', 0, 182746900562, 'like'),
(187, 4556887516696215, 'like', '2023-11-24 06:10:40', 0, 182746900562, 'like'),
(188, 4556887516696215, 'like', '2023-11-24 06:10:40', 0, 182746900562, 'like');

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
(107, 2762202513447017, 'Hooo', 3572325399739732623, '2023-11-22 07:16:57', 1, 0, '[\"tong the.jpg\"]', 'Friend'),
(117, 5776063094262829438, 'My name is Teddy!!!SSS', 3572325399739732623, '2023-11-23 06:49:29', 1, 0, '[\"z3530855536056_fd6b8aa79faad2ced42c46489e07cb1d.jpg\"]', 'Public'),
(136, 8401297253147543, 'Test đăng post bên timeline', 3572325399739732623, '2023-11-23 06:47:43', 1, 0, '[\"z3530855532263_7d078d604075189ebba258a671222ccb.jpg\"]', 'Public'),
(137, 777194588208026, 'Post 1', 3572325399739732623, '2023-11-23 07:43:30', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(138, 910557953035843381, 'Post 2', 3572325399739732623, '2023-11-23 07:43:47', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(139, 77980177783, 'Post 3', 3572325399739732623, '2023-11-23 07:43:53', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(140, 6531526131957138, 'Post 4', 3572325399739732623, '2023-11-23 07:43:57', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(141, 4320226927819, 'Post 5', 3572325399739732623, '2023-11-23 07:44:01', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(142, 400740447089135, 'Post 6', 3572325399739732623, '2023-11-23 07:44:05', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(143, 405079838605759764, 'Post 7', 3572325399739732623, '2023-11-23 07:44:09', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(144, 37316671635383, 'Post 8', 3572325399739732623, '2023-11-23 07:44:13', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(145, 7009911621075133670, 'Post 9', 3572325399739732623, '2023-11-23 07:44:16', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(146, 856584142583, 'Post 10', 3572325399739732623, '2023-11-23 07:44:20', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(147, 42679150296582, 'Post 11', 3572325399739732623, '2023-11-23 07:44:24', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(148, 8447637928865315, 'Post 12', 3572325399739732623, '2023-11-23 07:44:27', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(149, 23083850604, 'Post 13', 3572325399739732623, '2023-11-23 07:44:30', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(150, 67575010962, 'Post 14', 3572325399739732623, '2023-11-23 07:44:34', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(151, 53882132807655, 'Post 15', 3572325399739732623, '2023-11-23 07:44:37', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(152, 9223372036854775807, 'Post 16', 3572325399739732623, '2023-11-23 07:44:41', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(153, 8215521464980, 'Post 17', 3572325399739732623, '2023-11-23 07:44:45', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(154, 77779784021268926, 'Post 18', 3572325399739732623, '2023-11-23 07:44:48', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(155, 9141438685695273, 'Post 19', 3572325399739732623, '2023-11-23 07:44:52', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(156, 57281462826109841, 'Post 20!\n', 3572325399739732623, '2023-11-24 05:10:44', 1, 0, '[\"facebook-class-diagram.png\"]', 'Public'),
(157, 29294069634, 'Test đăng script: \nconsole.log(\"Existing scroll events:\", $._data(window, \'events\'));\n', 4556887516696215, '2023-11-23 10:52:16', 1, 0, '', 'Public'),
(158, 84330185510258161, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\n', 4556887516696215, '2023-11-23 10:54:31', 1, 0, '', 'Public'),
(159, 562893352574, 'Đăng bài viết với ảnh\n', 4556887516696215, '2023-11-23 10:55:04', 1, 0, '[\"facebook-class-diagram.png\",\"395523956_847704387024316_2321997919254323069_n.jpg\"]', 'Public'),
(160, 89958169993, 'Video nè', 4556887516696215, '2023-11-23 10:55:27', 1, 0, '[\"test.mp4\"]', 'Public'),
(161, 132061472680893, 'Post của thuận nhé', 4556887516696215, '2023-11-23 10:55:47', 1, 0, '[\"adadadasdas.jpg\"]', 'Public'),
(165, 36358374926, 'K dc', 3572325399739732623, '2023-11-24 05:23:56', 1, 0, '', 'Public'),
(166, 83318114147, 'pl\n', 3572325399739732623, '2023-11-24 05:36:18', 1, 0, '[\"profile-3.jpg\",\"profile-9.jpg\"]', 'Public'),
(167, 213599485347330, '', 3572325399739732623, '2023-11-24 05:36:37', 1, 0, '[\"profile-14.jpg\"]', 'Public'),
(168, 182746900562, 'Test', 3572325399739732623, '2023-11-24 05:37:07', 1, 0, '[\"profile-15.jpg\"]', 'Public');

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
(10, 4556887516696215, 'Hoàng Tiến', 'Thuận', 'Male', 'cryptocard.268@gmail.com', 'htthuan2468', 'hoàng.thuận', '2023-11-24 15:31:05', 'uploads/avatars/feed-5.jpg', 'uploads/avatars/profile-8.jpg', 163, 'public'),
(31, 3572325399739732623, 'Thuan', 'Teddy', 'Male', 'thuan2682k3@gmail.com', 'htthuan6041', 'thuan.teddy', '2023-11-24 15:28:35', 'uploads/avatars/img-1.jpg', 'uploads/avatars/profile-1.jpg', 208, 'public'),
(32, 4623450327014144, 'Teddy', 'IsMe', 'Male', 'thuan0205766@huce.edu.vn', 'htthuan4902', 'teddy.isme', '2023-10-26 09:16:30', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(33, 744177439385, 'Ngô Tùng', 'Sơn', 'Male', 'aaa1@aaa.vn', '123', 'nam.vu', '2023-11-24 17:17:30', 'uploads/avatars/img-5.jpg', 'uploads/avatars/avatar-lg-4.jpg', 508, 'public'),
(34, 9095530094254485, 'Hoàng', 'Hiếu', 'Male', 'hieu0189366@huce.edu.vn', 'htthuan6807', 'ho?ng.hi?u', '2023-11-24 07:10:20', '', 'uploads/avatars/avatar_default.png', 346, 'public'),
(36, 6643068578152038928, 'Quang', 'NV', 'Male', 'thuan2682k31@gmail.com', '111', 'thu?n.n?', '2023-11-23 10:50:47', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(37, 512857291296889, 'Mạnh', 'Hùng', 'Male', 'thuan26282k3@gmail.com', '1', 'thuan.ok', '2023-11-23 10:50:56', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(38, 5128572996831, 'Nguyễn Văn', 'Quang', 'Male', 'qnt@gmail.com', '123', 'qnt@iii', '2023-11-24 06:33:12', '', 'uploads/avatars/avatar_default.png', 202, 'public'),
(39, 512857291296832, 'Nguyễn Văn', 'Anh', 'Male', 'qnt1@gmail.com', '123', 'qnt1@iii', '2023-11-23 10:50:56', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(40, 512857291296221, 'Trịnh Hùng', 'Mạnh', 'Male', 'thm@gmail.com', '123', 'thm@iii', '2023-11-23 10:50:56', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(43, 5128572912903, 'Ngô Xuân', 'Quý', 'Male', 'nxq@gmail.com', '123', 'nxq@iii', '2023-11-24 07:39:10', '', 'uploads/avatars/avatar_default.png', 448, 'public'),
(44, 5128572912904, 'Nguyễn Phương', 'Thảo', 'Male', 'nxq2@gmail.com', '123', 'nxq@iii', '2023-11-24 06:26:16', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(90, 12844124912901, 'Ngô Xuân', 'Thảo', 'Male', 'user1@example.com', '123', 'nxq@iii', '2023-11-23 09:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(91, 12844124912902, 'Hoàng Long', 'Vũ', 'Male', 'user2@example.com', '123', 'nxq@iii', '2023-11-24 06:29:42', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(92, 12844124912903, 'Trịnh', 'Long', 'Male', 'user3@example.com', '123', 'nxq@iii', '2023-11-24 06:30:05', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(93, 12844124912904, 'Quân', 'Đinh', 'Male', 'user4@example.com', '123', 'nxq@iii', '2023-11-24 06:30:18', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(94, 12844124912905, 'Ngọc', 'Lâm', 'Male', 'user5@example.com', '123', 'nxq@iii', '2023-11-24 06:30:28', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(95, 12844124912906, 'Ngân', 'Nga', 'Male', 'user6@example.com', '123', 'nxq@iii', '2023-11-24 06:30:37', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(96, 12844124912907, 'Vũ', 'Nga', 'Male', 'user7@example.com', '123', 'nxq@iii', '2023-11-24 06:30:40', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(97, 12844124912908, 'Hoàng', 'Linh', 'Male', 'user8@example.com', '123', 'nxq@iii', '2023-11-24 06:30:45', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(98, 12844124912909, 'hà', 'Hương', 'Male', 'user9@example.com', '123', 'nxq@iii', '2023-11-24 06:31:01', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(99, 128441249129010, 'Hà', 'Anh', 'Male', 'user10@example.com', '123', 'nxq@iii', '2023-11-24 06:31:03', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(100, 128441249129011, 'Vũ', 'Bình', 'Male', 'user11@example.com', '123', 'nxq@iii', '2023-11-24 06:31:09', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(101, 128441249129012, 'Minh', 'Thảo', 'Male', 'user12@example.com', '123', 'nxq@iii', '2023-11-24 06:31:12', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(102, 128441249129013, 'Đinh Minh', 'Thảo', 'Male', 'user13@example.com', '123', 'nxq@iii', '2023-11-23 04:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(103, 128441249129014, 'Giang', 'Thảo', 'Male', 'user14@example.com', '123', 'nxq@iii', '2023-11-24 06:31:20', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(104, 128441249129015, 'Ngô Xuân', 'Thảo', 'Male', 'user15@example.com', '123', 'nxq@iii', '2023-11-23 07:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(105, 128441249129016, 'Nguyễn Văn', 'Quý', 'Male', 'user16@example.com', '123', 'nxq@iii', '2023-11-23 12:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(106, 128441249129017, 'Thuan', 'Thảo', 'Male', 'user17@example.com', '123', 'nxq@iii', '2023-11-23 06:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(107, 128441249129018, 'Teddy', 'Giang', 'Male', 'user18@example.com', '123', 'nxq@iii', '2023-11-24 06:31:26', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(108, 128441249129019, 'Quyết', 'Anh', 'Male', 'user19@example.com', '123', 'nxq@iii', '2023-11-24 06:31:32', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(109, 128441249129020, 'Nguyễn Vaen', 'An', 'Male', 'user20@example.com', '123', 'nxq@iii', '2023-11-24 06:31:46', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(110, 128441249129021, 'Văn', 'Sơn', 'Male', 'user21@example.com', '123', 'nxq@iii', '2023-11-24 06:31:56', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(111, 128441249129022, 'Trần Đức', 'Đạt', 'Male', 'user22@example.com', '123', 'nxq@iii', '2023-11-24 06:32:12', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(112, 128441249129023, 'Thu', 'Uyên', 'Male', 'user23@example.com', '123', 'nxq@iii', '2023-11-24 06:32:22', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(113, 128441249129024, 'Lâm', 'Teddy', 'Male', 'user24@example.com', '123', 'nxq@iii', '2023-11-24 06:32:31', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(114, 128441249129025, 'Ánh', 'Dương', 'Male', 'user25@example.com', '123', 'nxq@iii', '2023-11-24 06:38:40', '', 'uploads/avatars/avatar_default.png', 238, 'public'),
(165, 253284124912901, 'Vũ', 'Dương', 'Male', 'user1@huce.edu.vn', '123', 'social@huce', '2023-11-24 15:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(166, 253284124912902, 'Trịnh', 'Dương', 'Male', 'user2@huce.edu.vn', '123', 'social@huce', '2023-11-24 16:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(167, 253284124912903, 'Hoàng Long', 'Hùng', 'Male', 'user3@huce.edu.vn', '123', 'social@huce', '2023-11-24 04:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(168, 253284124912904, 'Ánh', 'NV', 'Male', 'user4@huce.edu.vn', '123', 'social@huce', '2023-11-23 21:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(169, 253284124912905, 'Hoàng', 'Nga', 'Male', 'user5@huce.edu.vn', '123', 'social@huce', '2023-11-23 20:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(170, 253284124912906, 'Ngô Xuân', 'NV', 'Male', 'user6@huce.edu.vn', '123', 'social@huce', '2023-11-24 13:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(171, 253284124912907, 'Ngô Xuân', 'Lâm', 'Male', 'user7@huce.edu.vn', '123', 'social@huce', '2023-11-23 19:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(172, 253284124912908, 'Lâm', 'Bình', 'Male', 'user8@huce.edu.vn', '123', 'social@huce', '2023-11-24 02:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(173, 253284124912909, 'Lâm', 'Thảo', 'Male', 'user9@huce.edu.vn', '123', 'social@huce', '2023-11-24 04:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(174, 2532841249129010, 'Nguyễn Vaen', 'Thảo', 'Male', 'user10@huce.edu.vn', '123', 'social@huce', '2023-11-24 13:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(175, 2532841249129011, 'Hoàng Long', 'Đinh', 'Male', 'user11@huce.edu.vn', '123', 'social@huce', '2023-11-24 08:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(176, 2532841249129012, 'Vũ', 'Thảo', 'Male', 'user12@huce.edu.vn', '123', 'social@huce', '2023-11-23 18:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(177, 2532841249129013, 'Nguyễn Vaen', 'Thảo', 'Male', 'user13@huce.edu.vn', '123', 'social@huce', '2023-11-24 04:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(178, 2532841249129014, 'Nguyễn Vaen', 'Thảo', 'Male', 'user14@huce.edu.vn', '123', 'social@huce', '2023-11-23 19:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(179, 2532841249129015, 'Ngô Xuân', 'Thảo', 'Male', 'user15@huce.edu.vn', '123', 'social@huce', '2023-11-24 01:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(180, 2532841249129016, 'Nguyễn Văn', 'Thảo', 'Male', 'user16@huce.edu.vn', '123', 'social@huce', '2023-11-24 10:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(181, 2532841249129017, 'Văn', 'Thảo', 'Male', 'user17@huce.edu.vn', '123', 'social@huce', '2023-11-24 07:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(182, 2532841249129018, 'Hoàng Long', 'Lâm', 'Male', 'user18@huce.edu.vn', '123', 'social@huce', '2023-11-24 05:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(183, 2532841249129019, 'Ánh', 'An', 'Male', 'user19@huce.edu.vn', '123', 'social@huce', '2023-11-24 04:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(184, 2532841249129020, 'Hoàng', 'Thảo', 'Male', 'user20@huce.edu.vn', '123', 'social@huce', '2023-11-23 21:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(185, 2532841249129021, 'Ngô Xuân', 'Giang', 'Male', 'user21@huce.edu.vn', '123', 'social@huce', '2023-11-24 14:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(186, 2532841249129022, 'Ngô Xuân', 'Hùng', 'Male', 'user22@huce.edu.vn', '123', 'social@huce', '2023-11-24 01:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(187, 2532841249129023, 'Ngọc', 'Thảo', 'Male', 'user23@huce.edu.vn', '123', 'social@huce', '2023-11-23 18:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(188, 2532841249129024, 'Trịnh', 'Thảo', 'Male', 'user24@huce.edu.vn', '123', 'social@huce', '2023-11-24 16:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(189, 2532841249129025, 'Quang', 'Quang', 'Male', 'user25@huce.edu.vn', '123', 'social@huce', '2023-11-24 10:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(190, 2532841249129026, 'Ánh', 'Anh', 'Male', 'user26@huce.edu.vn', '123', 'social@huce', '2023-11-24 13:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(191, 2532841249129027, 'Ngô Xuân', 'Anh', 'Male', 'user27@huce.edu.vn', '123', 'social@huce', '2023-11-24 03:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(192, 2532841249129028, 'Hoàng Tiến', 'Thảo', 'Male', 'user28@huce.edu.vn', '123', 'social@huce', '2023-11-23 17:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(193, 2532841249129029, 'Ngô Xuân', 'Thảo', 'Male', 'user29@huce.edu.vn', '123', 'social@huce', '2023-11-24 11:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(194, 2532841249129030, 'Ánh', 'Đạt', 'Male', 'user30@huce.edu.vn', '123', 'social@huce', '2023-11-24 01:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(195, 2532841249129031, 'Hoàng Long', 'Thảo', 'Male', 'user31@huce.edu.vn', '123', 'social@huce', '2023-11-24 11:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(196, 2532841249129032, 'Văn', 'Anh', 'Male', 'user32@huce.edu.vn', '123', 'social@huce', '2023-11-24 09:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(197, 2532841249129033, 'Hoàng', 'Quang', 'Male', 'user33@huce.edu.vn', '123', 'social@huce', '2023-11-24 12:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(198, 2532841249129034, 'Quyết', 'Quý', 'Male', 'user34@huce.edu.vn', '123', 'social@huce', '2023-11-24 04:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(199, 2532841249129035, 'Ngô Xuân', 'Hương', 'Male', 'user35@huce.edu.vn', '123', 'social@huce', '2023-11-24 02:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(200, 2532841249129036, 'Ngô Xuân', 'Hùng', 'Male', 'user36@huce.edu.vn', '123', 'social@huce', '2023-11-24 13:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(201, 2532841249129037, 'Trịnh', 'Thảo', 'Male', 'user37@huce.edu.vn', '123', 'social@huce', '2023-11-23 19:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(202, 2532841249129038, 'Đinh Minh', 'Thảo', 'Male', 'user38@huce.edu.vn', '123', 'social@huce', '2023-11-24 08:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(203, 2532841249129039, 'Teddy', 'Teddy', 'Male', 'user39@huce.edu.vn', '123', 'social@huce', '2023-11-23 22:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(204, 2532841249129040, 'Trịnh Hùng', 'Hương', 'Male', 'user40@huce.edu.vn', '123', 'social@huce', '2023-11-24 06:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(205, 2532841249129041, 'Quyết', 'Thảo', 'Male', 'user41@huce.edu.vn', '123', 'social@huce', '2023-11-24 03:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(206, 2532841249129042, 'Hoàng Long', 'Quý', 'Male', 'user42@huce.edu.vn', '123', 'social@huce', '2023-11-24 05:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(207, 2532841249129043, 'Teddy', 'Giang', 'Male', 'user43@huce.edu.vn', '123', 'social@huce', '2023-11-23 21:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(208, 2532841249129044, 'Ánh', 'Quý', 'Male', 'user44@huce.edu.vn', '123', 'social@huce', '2023-11-24 07:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(209, 2532841249129045, 'Vũ', 'Thảo', 'Male', 'user45@huce.edu.vn', '123', 'social@huce', '2023-11-24 09:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(210, 2532841249129046, 'Đinh Minh', 'Giang', 'Male', 'user46@huce.edu.vn', '123', 'social@huce', '2023-11-23 23:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(211, 2532841249129047, 'Quang', 'Thảo', 'Male', 'user47@huce.edu.vn', '123', 'social@huce', '2023-11-24 00:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(212, 2532841249129048, 'Ngọc', 'Long', 'Male', 'user48@huce.edu.vn', '123', 'social@huce', '2023-11-24 09:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(213, 2532841249129049, 'Teddy', 'Thảo', 'Male', 'user49@huce.edu.vn', '123', 'social@huce', '2023-11-23 18:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public'),
(214, 2532841249129050, 'Lâm', 'Thuận', 'Male', 'user50@huce.edu.vn', '123', 'social@huce', '2023-11-23 21:00:00', '', 'uploads/avatars/avatar_default.png', 0, 'public');

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
(16, 4556887516696215, '2023-10-06', 'Hi xin chào mọi người lại là mình chao đây!!!', 'Bắc Ninh', 'HUCE'),
(20, 5128572912903, '0001-01-01', '', 'Hanoi VietNam', 'HUST');

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
(60, 3572325399739732623, 'offline', '2023-11-24 06:33:27'),
(70, 4556887516696215, 'online', '2023-11-24 06:13:25'),
(311, 744177439385, 'offline', '2023-11-05 14:06:21'),
(2498, 5128572912903, 'offline', '2023-11-24 07:39:52'),
(2510, 5128572996831, 'online', '2023-11-24 06:32:55'),
(2518, 128441249129025, 'offline', '2023-11-24 06:39:20'),
(2528, 9095530094254485, 'offline', '2023-11-24 07:10:53');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=610;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT cho bảng `users_about`
--
ALTER TABLE `users_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `users_status`
--
ALTER TABLE `users_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2598;

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
