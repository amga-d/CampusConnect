-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 23, 2024 at 03:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campusconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `community_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `communities`
--

CREATE TABLE `communities` (
  `community_id` int(11) NOT NULL,
  `community_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `recruitment_status` enum('open','closed') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `community_type` varchar(50) DEFAULT NULL,
  `community_privacy` enum('public','private') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `communities`
--

INSERT INTO `communities` (`community_id`, `community_name`, `description`, `profile_image`, `created_by`, `recruitment_status`, `created_at`, `community_type`, `community_privacy`) VALUES
(58, '123', '123', '/public/uploads/community_images/6766bc6062e55.jpg', 40, 'open', '2024-12-21 13:02:24', 'academic', 'private'),
(59, 'HMIF UII (Himpunan Mahasiswa Informatika)', 'Himpunan Mahasiswa Informatika FTI UII\r\nSatu untuk semua, semua untuk satu!\r\n', '/public/uploads/community_images/6766be7b05c31.jpg', 41, 'open', '2024-12-21 13:11:23', 'academic', 'public'),
(60, 'LEM FTI UII (Lembaga Eksekutif Mahasiswa)', 'Lembaga Eksekutif Mahasiswa\r\nFakultas Teknologi Industri', '/public/uploads/community_images/6766c63356e30.jpg', 42, 'closed', '2024-12-21 13:44:19', 'organization', 'public'),
(61, 'DPM FTI UII (Dewan Perwakilan Mahasiswa)', 'Badan legislatif mahasiswa Fakultas Teknologi Industri UII yang bertugas memperjuangkan aspirasi mahasiswa dan menjaga tata kelola organisasi di lingkungan fakultas.', '/public/uploads/community_images/6766c84701973.jpg', 43, 'closed', '2024-12-21 13:53:11', 'organization', 'public'),
(62, 'CLI UII (Central Language Improvement)', 'CLI UII | Central Language Improvement 🌍✨ | Boosting language skills for UII students 📚💬', '/public/uploads/community_images/6766c90571ec3.jpg', 44, 'open', '2024-12-21 13:56:21', 'academic', 'public'),
(63, 'GDGoC UII (Google Developer Groups on Campus)', 'Google Developer Groups on Campus\r\nchapter Universitas Islam Indonesia', '/public/uploads/community_images/6766cb8083084.jpg', 45, 'open', '2024-12-21 14:06:56', 'technology', 'public'),
(64, 'HMTM UII (Himpunan Mahasiswa Teknik Mesin)', 'HIMPUNAN MAHASISWA TEKNIK MESI\r\nUNIVERSITAS ISLAM INDONESIA\r\n#SOLIDARITYFOREVER\r\n', '/public/uploads/community_images/6766ccbf161e7.jpg', 46, 'closed', '2024-12-21 14:12:15', 'organization', 'public'),
(65, 'HMTS UII (Himpunan Mahasiswa Teknik Sipil)', 'HMTS UII | Himpunan Mahasiswa Teknik Sipil Universitas Islam Indonesia | Wadah pengembangan diri dan aspirasi mahasiswa Teknik Sipil.', '/public/uploads/community_images/6766cd78a699f.jpg', 47, 'closed', '2024-12-21 14:15:20', 'organization', 'public'),
(66, 'Basketball UII Community', 'Sports team\r\nUniversitas Islam Indonesia\r\nYogyakarta, Indonesia', '/public/uploads/community_images/6766cf412bd3c.jpg', 48, 'open', '2024-12-21 14:22:57', 'sports', 'public'),
(67, 'Badminton UII Community', 'Sports team\r\nOfficial of Badminton Universitas Islam Indonesia\r\nLatihan rutin : Selasa dan Kamis\r\nJam: 16.00-19.00\r\nLokasi: GOR Ki Bagoes Hadikoesoemo', '/public/uploads/community_images/6766d0c0ce910.jpg', 49, 'open', '2024-12-21 14:29:20', 'sports', 'public'),
(68, 'Futsal UII Community', 'Futsal Universitas Islam Indonesia\r\nOfficial Apparel Partner : @almer.apparel', '/public/uploads/community_images/6766d2d7df3d2.jpg', 50, 'open', '2024-12-21 14:38:15', 'sports', 'public'),
(69, 'KOSMIK UII (Komunitas Musik Informatika)', 'Informatics UII Music Family\r\nMusic talents, Event planners, Family based community', '/public/uploads/community_images/6766d38b33c85.jpg', 51, 'open', '2024-12-21 14:41:15', 'arts', 'public'),
(70, 'UII Global', 'International Students Union at UII', '/public/uploads/community_images/6766d4371847f.jpg', 52, 'closed', '2024-12-21 14:44:07', 'organization', 'public'),
(71, 'UCG UII (Unisi Cyber Guards)', 'UII Cyber Security Community', '/public/uploads/community_images/6766d72e6344a.jpg', 53, 'closed', '2024-12-21 14:56:46', 'technology', 'public'),
(72, 'CENTRIS FTI UII (Center Of Islamic Engineers)', 'Lembaga Dakwah Fakultas Teknologi Industri\r\nUniversitas Islam Indonesia', '/public/uploads/community_images/6766d8c3c44da.jpg', 54, 'closed', '2024-12-21 15:03:31', 'social', 'public'),
(73, 'LABMA UII (Laboratorium Mahasiswa)', 'Laboratorium Mahasiswa UII\r\nOrg. Penelitian &amp; Pengabdian Masyarakat\r\nUniversitas Islam Indonesia', '/public/uploads/community_images/6766d98f4571b.jpg', 55, 'open', '2024-12-21 15:06:55', 'academic', 'public'),
(74, 'PIK-M Aushaf UII (Konseling Mahasiswa)', 'PIK-M Aushaf UII | Wadah konseling dan pengembangan mahasiswa Universitas Islam Indonesia.', '/public/uploads/community_images/a.png', 56, 'open', '2024-12-21 15:10:55', 'social', 'public'),
(75, 'El-Markazi (Islamic & Linguistic Clubs Center)', 'El-Markazi | Pusat aktivitas Islami dan linguistik bagi mahasiswa UII.', '/public/uploads/community_images/b.png', 57, 'closed', '2024-12-21 15:15:30', 'academic', 'public'),
(76, 'MENWA UII (Resimen Mahasiswa)', 'MENWA UII | Resimen Mahasiswa Universitas Islam Indonesia yang berdedikasi pada bela negara dan kebangsaan.', '/public/uploads/community_images/c.png', 58, 'open', '2024-12-21 15:20:10', 'organization', 'public'),
(77, 'XAVIERA UNISI (UKM Tari Kreasi & Ratoh Jaroe)', 'XAVIERA UNISI | Unit Kegiatan Mahasiswa tari kreasi dan Ratoh Jaroe di UII.', '/public/uploads/community_images/d.png', 59, 'closed', '2024-12-21 15:25:45', 'arts', 'public'),
(78, 'HIMMAH UII (Lempaga Pers Mahasiswa)', 'HIMMAH UII | Lembaga pers mahasiswa yang bergerak dalam dunia jurnalistik kampus UII.', '/public/uploads/community_images/e.png', 60, 'open', '2024-12-21 15:30:22', 'organization', 'public'),
(79, 'MAPALA UNISI (Mahasiswa Pecinta Alam)', 'MAPALA UNISI | Komunitas mahasiswa pecinta alam Universitas Islam Indonesia.', '/public/uploads/community_images/f.png', 61, 'open', '2024-12-21 15:35:10', 'sports', 'public'),
(80, 'KOPMA UII (Koperasi Mahasiswa)', 'KOPMA UII | Koperasi mahasiswa Universitas Islam Indonesia yang mendukung kegiatan kewirausahaan.', '/public/uploads/community_images/g.png', 62, 'closed', '2024-12-21 15:40:33', 'organization', 'public');

-- --------------------------------------------------------

--
-- Table structure for table `community_members`
--

CREATE TABLE `community_members` (
  `membership_id` int(11) NOT NULL,
  `community_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('admin','member','core_member') NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `membership` varchar(30) DEFAULT NULL,
  `membership_status` enum('approved','pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_members`
--

INSERT INTO `community_members` (`membership_id`, `community_id`, `user_id`, `role`, `joined_at`, `membership`, `membership_status`) VALUES
(61, 58, 40, 'admin', '2024-12-21 13:02:24', 'Leader', 'approved'),
(62, 59, 41, 'admin', '2024-12-21 13:11:23', 'Leader', 'approved'),
(63, 60, 42, 'admin', '2024-12-21 13:44:19', 'Leader', 'approved'),
(64, 61, 43, 'admin', '2024-12-21 13:53:11', 'Leader', 'approved'),
(65, 62, 44, 'admin', '2024-12-21 13:56:21', 'Leader', 'approved'),
(66, 63, 45, 'admin', '2024-12-21 14:06:56', 'Leader', 'approved'),
(67, 64, 46, 'admin', '2024-12-21 14:12:15', 'Leader', 'approved'),
(68, 65, 47, 'admin', '2024-12-21 14:15:20', 'Leader', 'approved'),
(69, 66, 48, 'admin', '2024-12-21 14:22:57', 'Leader', 'approved'),
(70, 67, 49, 'admin', '2024-12-21 14:29:20', 'Leader', 'approved'),
(71, 68, 50, 'admin', '2024-12-21 14:38:15', 'Leader', 'approved'),
(72, 69, 51, 'admin', '2024-12-21 14:41:15', 'Leader', 'approved'),
(73, 70, 52, 'admin', '2024-12-21 14:44:07', 'Leader', 'approved'),
(74, 71, 53, 'admin', '2024-12-21 14:56:46', 'Leader', 'approved'),
(75, 72, 54, 'admin', '2024-12-21 15:03:31', 'Leader', 'approved'),
(76, 73, 55, 'admin', '2024-12-21 15:06:55', 'Leader', 'approved'),
(77, 73, 41, 'member', '2024-12-21 15:16:17', 'member', 'approved'),
(78, 74, 56, 'admin', '2024-12-21 08:18:22', 'Leader', 'approved'),
(79, 75, 57, 'admin', '2024-12-21 08:24:36', 'Leader', 'approved'),
(80, 76, 58, 'admin', '2024-12-21 08:30:45', 'Leader', 'approved'),
(81, 77, 59, 'admin', '2024-12-21 08:36:59', 'Leader', 'approved'),
(82, 78, 60, 'admin', '2024-12-21 08:42:17', 'Leader', 'approved'),
(83, 79, 61, 'admin', '2024-12-21 08:48:30', 'Leader', 'approved'),
(84, 80, 62, 'admin', '2024-12-21 08:55:00', 'Leader', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `community_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `community_id`, `creator_id`, `event_name`, `description`, `image_path`, `created_at`) VALUES
(18, 58, 40, '123', '123', '/public/uploads/events/event_6766bc7d16d39.jpg', '2024-12-21 13:02:53'),
(20, 59, 41, 'OPEN RECRUITMENT PORSEMATIK 2024', '🚨NINUNINU🚨\r\n\r\n⚠OPEN RECRUITMENT PANITIA PORSEMATIK 2024 DIBUKA⚠\r\n\r\n✨Halo Informatika 23✨\r\nBuat teman-teman yang mau belajar kepanitiaan, nambah SKP,  bisa banget bergabung bersama kami daftar menjadi panitia PORSEMATIK 2024!\r\n\r\n📑 Syarat dan Ketentuan untuk menjadi panitia PORSEMATIK 2024 yaitu :\r\n1. Mahasiswa Aktif Informatika FTI UII Angkatan 2023\r\n2. Menyiapkan bukti SS Mahasiswa Aktif yang tertera di UII Gateway\r\n3. Berkomitmen Dalam Mengikuti Kegitan Porsematik 2023\r\n4. Mengikuti Rangkaian Alur pendaftaran\r\n\r\nLink Pendaftaran :\r\n📎 https://s.id/OprecPorsematik2024\r\n\r\n📞 CP : Fasya (081227268106)\r\n\r\n📣 Tunggu apa lagi! \r\nAyo bergabung menjadi bagian dari panitia PORSEMATIK 2024‼\r\n⚔OPEN RECRUITMENT PANITIA OC INPUT 2024 ⚔\r\n', '/public/uploads/events/event_6766c14cd1de2.jpg', '2024-12-21 13:23:24'),
(21, 59, 41, 'Open Recruitment OC INPUT 2024', 'Halo teman-teman!\r\nKami sedang mengadakan Open Recruitment Panitia OC INPUT 2024 dan kami mengundang kamu yang penuh semangat untuk bergabung! 💥\r\n\r\nSyarat : \r\n- Mahasiswa aktif jurusan Informatika FTI UII angkatan 2022 dan 2023\r\n- ⁠Mengikuti seluruh rangkaian pendaftaran \r\n- ⁠Mengisi GoogleForm yang tersedia\r\n\r\n\r\nLink Pendaftaran : \r\n🔗https://bit.ly/OprecINPUT2024\r\n\r\n\r\nContact Person:\r\n‪085215277702‬ (aura)\r\n082371307373 (tute)\r\n\r\nJangan lewatkan kesempatan ini!\r\nAyo, daftar sekarang dan jadi bagian dari OC INPUT 2024!🧚🏻‍♀', '/public/uploads/events/event_6766c221f0447.jpg', '2024-12-21 13:26:57'),
(22, 59, 41, 'AI, Chatbot, dan Solusi Masa Depan', '🔍 Pernahkah kamu penasaran bagaimana AI dan chatbot mengubah cara kita belajar, bekerja, atau bahkan berinteraksi sehari-hari? Inilah kesempatanmu untuk mengeksplorasi teknologi terkini bersama ahlinya!\r\n\r\n📅 Selasa, 17 Desember 2024\r\n⏰ 09.00 - 12.00 WIB\r\n📍 Auditorium Gedung K.H. Mas Mansur Lt. 3\r\n🎙️ Ganjar Widiatmansyah (Head of AI Team, Qiscus)\r\n\r\n🎁 Apa yang kamu dapatkan?\r\n✅ E-Certificate\r\n✅ Snack GRATIS\r\n✅ Doorprize merchandise eksklusif\r\n\r\n🌟 Slot terbatas untuk 87 peserta! 🌟\r\n🔗 Daftar sekarang: bit.ly/RegistrasiSeminarKeilmuanHMIF2024\r\n\r\n📞 Info: Fadya (+62 853-2226-1513)\r\n\r\nJangan sampai ketinggalan kesempatan belajar langsung dari ahlinya! 🚀', '/public/uploads/events/event_6766c25e9ed65.png', '2024-12-21 13:27:58'),
(23, 60, 42, 'CAREER ELEVATE \"Empowering Skills, Shaping Futures\"', 'Assalamualaikum Wr Wb\r\n\r\nSetiap langkah kecil dalam pengembangan diri merupakan investasi besar yang mengarahkan kita pada karier yang lebih gemilang.\r\n\r\nTema: Empowering Skills, Shaping Futures\r\n📅 Hari/Tanggal: Senin, 16 Desember 2024\r\n⏰ Waktu: 18.30 - 21.00 WIB\r\n📍 Tempat: Ruang Auditorium FTI UII\r\n\r\n💬 Pemateri:\r\nWalid Jumlad S.Psi, M.Psi\r\n\r\nDiskusi terbuka untuk mahasiswa FTI UII yang ingin meningkatkan kreativitas dan berbagi pemikiran. Jangan lewatkan kesempatan untuk belajar dan berkembang!\r\n\r\n🔗 Link Pendaftaran:\r\nhttps://forms.gle/yMHXKF5Mtb1bruxq5\r\n\r\nWa’alaikumussalam Wr Wb\r\n\r\n📲 Narahubung:\r\nDewi : 085726285177', '/public/uploads/events/event_6766c6941e5fd.jpg', '2024-12-21 13:45:56'),
(24, 62, 44, 'CALLING FOR ALL SWIFTIES OF UII', '🎶So, make the friendship bracelets, take the moment and taste it, you’ve got no reasons to be afraid 🎶\r\n\r\nSet you Swiftie soul free!\r\n\r\nDon’t miss out on this incredible opportunity to make language learning a joyful and melodic experience 🙆🏻‍♀️\r\n\r\nDon’t hesitate to DM us for more info!\r\nCan’t wait to see you😋', '/public/uploads/events/event_6766c957962d1.jpg', '2024-12-21 13:57:43'),
(25, 63, 45, 'Road to UII', '🚀 Join us on the Road to UII: Empowering Minds, Building Futures! 🚀\r\n\r\nAre you curious about cybersecurity and how to protect yourself in the digital world? This exciting event will focus on building awareness about phishing and sharing essential cybersecurity knowledge. With the rise of cyber threats, understanding the basics of how to identify and prevent attacks is a skill everyone needs. Whether you’re a tech enthusiast, a beginner, or simply someone who wants to stay safe online, this event is for you!\r\n\r\n🎤 Our speaker, Azmi Ridho Rinanta, a Certified Ethical Hacker (CEH v12), will guide you through real-world examples, tips, and tools to detect phishing attempts and secure your digital footprint.\r\n\r\n📅 When? Sunday, December 22, 2024\r\n⏰ Time: 12:30 - 16:00 WIB\r\n📍 Where: TBA (To be Announced)\r\n💡 Who can join? Open for ALL STUDENTS!\r\n\r\nDon’t miss this opportunity to enhance your cybersecurity knowledge and stay one step ahead of online threats! 🌐\r\n\r\nSecure your spot today by RSVPing at s.id/GDGoCRoadtoUII2024Part1', '/public/uploads/events/event_6766cbc8f2bbd.jpg', '2024-12-21 14:08:08'),
(26, 64, 46, 'RPM 2024', 'Assalamualaikum Wr. Wb.\r\n\r\n❗Salam Solidarity❗\r\n\r\nAlhamdulillah RPM tahun ini bisa dilaksanakan.\r\nSelalu semangat dan semoga diberi keberkahan oleh Allah SWT.\r\nMomen RPM apa yang paling dirindukan lur?\r\n\r\n❗Salam Solidarity❗', '/public/uploads/events/event_6766ccf805e03.jpg', '2024-12-21 14:13:12'),
(27, 65, 47, 'OPEN RECRUITMENT CIVIL LEAGUE 2023', 'Assalamualaikum Warahmatullahi Wabarakatuh\r\n\r\nTelah dibuka Open Recruitment Panitia Civil League 2023. Kepanitiaan ini dikhususkan pada angkatan 2020, 2021, 2022. Silahkan bagi teman-teman yang ingin mendaftarkan diri menjadi panitia untuk segera melengkapi data yang ada pada google formulir ini\r\n\r\nhttps://bit.ly/OprecCivilLeague2023\r\n\r\nTerimakasih atas waktunya dan sampai bertemu di Civil League 2023', '/public/uploads/events/event_6766ce89d4399.jpg', '2024-12-21 14:19:53'),
(28, 66, 48, 'Seleksi Atlet Basket untuk BEASISWA Atlet & Juara Seni UII', 'Assalamu’alaikum Warrahmatullahi Wabarakatuh.\r\n\r\nMau kuliah GRATIS di Universitas Islam Indonesia melalui jalur prestasi basket?? Bisa banget dong, Universitas Islam Indonesia sedang membuka pendaftaran seleksi beasiswa basket.\r\n\r\nSeleksi Beasiswa Basket UII 2022 akan diadakan kembali di Daerah Istimewa Yogyakarta yang bertempat langsung di GOR UII Kampus Terpadu pada Minggu 5 Juni 2022.\r\n\r\nAdapun Pembagian sesi untuk peserta :\r\nSesi 1 : 08.00-12.00 (Untuk Sesi 1 Peserta yang belum pernah mengikuti seleksi beasiswa uii)\r\n\r\nSesi 2 : 13.00-Selesai (Khusus Peserta yang Lolos tahap seleksi di Cirebon Dan yang Lolos seleksi sesi 1 pada hari yang sama)\r\n\r\nSyarat Pendaftaran:\r\n1. Pelajar putra dan putri kelas 3 SMA/Sederajat', '/public/uploads/events/event_6766d000bdc5a.jpg', '2024-12-21 14:26:08'),
(29, 67, 49, 'OPEN RECRUITMENT BADMINTON UNISI 2024/2025', '🏸 OPEN RECRUITMENT UKM BADMINTON UNISI 2024 🏸\r\n\r\nHalo Mahasiswa Baru UII! 🎓 Ingin mengasah bakat dan minatmu dalam olahraga badminton? Yuk, bergabung bersama UKM Badminton UNISI! Kami sedang membuka pendaftaran anggota baru untuk tahun 2024. Jangan lewatkan kesempatan ini untuk menjadi bagian dari tim yang solid dan penuh prestasi! 💪\r\n\r\nAlur Pendaftaran:\r\n📅 28 - 30 September 2024: Registrasi melalui form online (scan QR code)\r\n⏰ 30 September 2024, Pukul 20.00 WIB: Penutupan pendaftaran\r\n🏸 1 Oktober 2024: Agenda Oprec (Seleksi)\r\n📢 5 Oktober 2024: Pengumuman anggota baru\r\n\r\nSyarat & Ketentuan:\r\n✔️ Mahasiswa aktif UII\r\n✔️ Berminat di bidang badminton\r\n✔️ Melampirkan KTM\r\n✔️ Mengisi formulir pendaftaran\r\n✔️ Mengikuti seleksi dan membawa perlengkapan olahraga\r\n\r\nTunggu apa lagi? Segera daftar dan tunjukkan bakatmu di lapangan! 🏸✨', '/public/uploads/events/event_6766d11e40a92.jpg', '2024-12-21 14:30:54'),
(30, 68, 50, 'OPEN PRE ORDER', '[OPEN PRE ORDER JERSEY FUTSAL UII]\r\n\r\nOfficial Account\r\nInstagram : futsal.uii\r\nTik Tok : futsaluii', '/public/uploads/events/event_6766d30a2faba.jpg', '2024-12-21 14:39:06'),
(31, 69, 51, 'JAMMING BARENG', 'Mari bergabung dalam serangkaian acara yang memukau! Temukan inspirasi baru, pelajari hal-hal menarik, dan jalin koneksi baru. 💫\r\n\r\nDi sesi kali ini kami punya event “JAMMING BARENG” dengan mengundang “KAMMI BAND” untuk special performance🙌🏻✨.\r\n\r\nDisini kalian bisa belajar musik dalam sesi sharing sesion dan menikmati musik yang akan dibawakan oleh KAMMI BAND bersama-sama.\r\n\r\n📆: Sabtu, 25 November 2023\r\n📍: Tanbo coffe, Ngaglik, Sleman\r\n⏰: 17.00 - 21.00pm\r\n\r\nFREE!!\r\n\r\nTunggu apa lagi?? yukk ikutan kami di event ini🎊', '/public/uploads/events/event_6766d3b3cf901.jpg', '2024-12-21 14:41:55'),
(32, 70, 52, 'OPEN DONATION', '✨ Together for a Greater Cause ✨\r\n\r\nUII Global and CIS are working side-by-side in a meaningful collaboration to support the children at Dar Sabeel Al Huda Orphanage. 🌸\r\n\r\nThis initiative is not just about giving but about sharing love, hope, and opportunity. Every small contribution can bring a smile to a child’s face and help them dream of a brighter tomorrow. ❤\r\n\r\nWe invite YOU to join us in this mission! Your donation will directly provide essentials such as food, clothing, and education to these wonderful children. Together, let’s make sure no child feels left behind.\r\n\r\n💛 How to Donate:\r\n🏦 Bank: SeaBank\r\n💳 Account Number: 901181122612\r\n👤 Account Name: Muhammad Aldo Septiyandi\r\n\r\n📍 Every contribution counts. Let’s make a difference—together.\r\n\r\n🗓️ Deadline : 31st October\r\n\r\n💬 Spread the word and be part of this beautiful cause. Together, we can create a wave of kindness and change lives forever! 🌟', '/public/uploads/events/event_6766d46eb4572.jpg', '2024-12-21 14:45:02'),
(33, 71, 53, 'Open Recruitment UCG', 'Tunggu apa lagi nih ? yuk langsung bergabung UCG sekarang !! bakal banyak kegiatan menarik', '/public/uploads/events/event_6766d764495ab.jpg', '2024-12-21 14:57:40'),
(34, 72, 54, 'OPEN RECRUITMENT CENTRIS FTI UII', '📢✨OPEN RECRUITMENT CENTRIS FTI UII✨📢\r\n\r\nAssalamualaikum Warahmatullahi Wabarakatuh.\r\n\r\nHalo sobat FTI UII👋🏻\r\nSiap jadi bagian dari sesuatu yang keren dan berdampak besar?\r\nPendaftaran CENTRIS FTI UII telah dibuka 🎉\r\n\r\n💎 BENEFIT :\r\n- Lingkungan yang baik\r\n- Relasi & Apresiasi\r\n- Peluang beramal baik\r\n- Kegiatan menambah keimanan\r\n- Wawasan yang bermanfaat\r\n- Pengembangan diri\r\n\r\n🚨 Persyaratan :\r\n1. Mahasiswa aktif FTI UII angkatan 2022 / 2023 / 2024\r\n2. Berkomitmen mengikuti kegiatan dan menjalankan amanah yang telah ditentukan\r\n3. Ikhlas tanpa paksaan dari pihak manapun\r\n4. Bisa membaca Al-qur\'an\r\n\r\n📍 Link Pendaftaran :\r\nbit.ly/OprecCentris2024\r\n\r\n📱 Contact Us :\r\n- centrisftiuii (Instagram)\r\n- 081296805983 (Ikhwan)\r\n- 082117357534 (Akhwat)', '/public/uploads/events/event_6766d928d9553.jpg', '2024-12-21 15:05:12'),
(35, 73, 55, 'LabMa UII Open Recruitment', '[OPEN RECRUITMENT LABORATORIUM MAHASISWA UII 2024]\r\n\r\nAssalamualaikum warahmatullahi wabarakatuh\r\nHalo, Muslim Scientist!👋🏻\r\n\r\n📢We\'re looking for young people with high enthusiasm to research about what is hindering the world\'s scientific progress. So, would you be interested in joining us and becoming THE NEXT MUSLIM SCIENTIST?\r\n\r\nKabar gembira nihh, LabMayers🙌🏻\r\nLaboratorium Mahasiswa UII telah resmi membuka pendaftaran anggota baru 2024 loh!\r\n\r\nApa aja sih benefit yang akan didapatkan di LabMa?🤔💡\r\n🔅Relasi pertemanan dari berbagai disiplin ilmu\r\n🔅Mendapat pengalaman berharga dan pengabdian masyarakat\r\n🔅Mendapatkan berbagai kegiatan yang produktif\r\n🔅Pastinya wadah untuk berproses serta berprestasi🏆✨\r\n\r\n✏Syarat Pendaftaran:\r\n•Mahasiswa aktif UII angkatan 2023 dan 2024\r\n•Mengisi formulir pendaftaran\r\n•Wajib mengikuti seluruh rangkaian acara Open Recruitment Laboratorium Mahasiswa UII 2024\r\n•Menyantumkan portofolio bagi yang memilih divisi PR\r\n•Follow akun instagram @labma.uii dan mention 3 teman di postingan Open Recruitment LabMa\r\n\r\nSyaratnya juga gampang nihh, yakin ngga mau join?😳\r\nLangsung daftarkan dirimu, isi formulir, dan kirimkan CV terbaikmu 📬✨\r\n\r\n[LINK]\r\n📄 Form Pendaftaran Oprec LabMa\r\n: https://bit.ly/OprecLabMa24\r\n📄 File CV Oprec LabMa\r\n: https://bit.ly/CVTemplateLabMa24\r\n\r\n📲Our Contact Person:\r\nSelvi (081283803348) - Akhwat\r\nIzzudin (0895618065248) - Ikhwan\r\nIrhamsyah (082371702063) - Ikhwan\r\n\r\nNow its your turn, prepare yourself to become a Muslim Scientist🤩✍🏻', '/public/uploads/events/event_6766d9d26cf43.jpg', '2024-12-21 15:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `news_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `news_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_name`, `description`, `created_at`, `news_image`) VALUES
(4, 'Story Nite', 'Islamic Fantastic 1.2 dengan bangga mempersembahkan Story Nite dengan tema Cintai Pencipta-Nya Sebelum Mencintai Ciptaan-Nya yang akan diselenggarakan pada:\n\nHari/Tanggal : Sabtu, 14 Desember 2024\nWaktu : 18.30-21.30 WIB\nTempat : Auditorium Fakultas Ilmu Agama Islam\n\nTautan Pendaftaran: https://s.id/storyniteuii \n\nTerbuka untuk umum!\n\nWassalamu\'alaikum Warahmatullahi Wabarakatuh.', '2024-12-12 06:12:22', '/public/uploads/\nnews/Story_Nite.jpg'),
(5, 'Entrepreneur Competition', 'Entrepreneur Competition merupakan kompetisi bagi para mahasiwa Universitas Islam Indonesia (UII) untuk mengembangkan semangat berwirausaha agar mendorong lahirnya wirausahawan muda berbasis ilmu pengetahuan dari lingkungan perguruan tinggi. Kompetisi ini terdiri dari dua kategori yaitu Business Idea Competition dan Business Creative Competition.\nBatas pendaftaran sampai dengan 15 Desember 2024\n\nPendaftaran Business Plan Competition: bit.ly/BIC-UII24\n\nPendaftaran Business Creative Competition: bit.ly/BCC-UII24\n\nWassalamu\'alaikum Warahmatullahi Wabarakatuh.\n\nIkuti Kemahasiswaan UII di Instagram @kemahasiswaanuii\nPertanyaan terkait layanan Kemahasiswaan UII (Call Center) melalui WhatsApp +62 898444 1212', '2024-12-12 06:17:57', '/public/uploads/\nnews/Entrepreneur_Competition.jpg'),
(6, 'Festival Qur\'an UII 2024', 'Ada kabar seru nih buat kamu semua!  \n\nUniversitas Islam Indonesia dengan bangga mempersembahkan Festival Qur\'an UII 2024, ajang penuh inspirasi untuk menyalurkan bakat dan kecintaanmu pada Al-Qur\'an. Yuk, ikuti berbagai rangkaian kegiatan menarik sesuai minatmu!\n\nJadwal Kegiatan:  \n- 25 November - 13 Desember 2024: Pendaftaran & Pengumpulan Karya  \n- 14 Desember 2024: Seleksi dan Penjurian  \n- 15 Desember 2024: Pengumuman Finalis  \n- 16 Desember 2024: Technical Meeting  \n- 22 Desember 2024: Pelaksanaan Final & Acara Puncak   \n\nInformasi & Pendaftaran:  \nKlik tautan berikut  [https://linktr.ee/FestivalQuranUII2024]\nAyo daftarkan diri kamu sekarang juga dan jadilah bagian dari kemeriahan Festival Qur\'an UII 2024! Jangan lewatkan kesempatan ini, ya! \n\nWassalamu\'alaikum Warahmatullahi Wabarakatuh.\n\nPertanyaan Layanan Kemahasiswaan:  \nHubungi Call Center UII via WhatsApp di +62 898 444 1212', '2024-12-12 06:22:26', '/public/uploads/\nnews/Festival_Quran.jpg'),
(7, '10th ASIA International Conference 2024', 'Kami mengundang Bapak dan Ibu dosen serta mahasiswa Universitas Islam Indonesia untuk dapat berpartisipasi dalam 10th ASIA International Conference 2024 pada:\n\nTanggal: 20-22 Desember 2024\n\nTempat: Universiti Teknologi Malaysia (UTM), Johor Bahru, Malaysia\n\nConference Tracks:\n-Emerging Issues in Economics and Finance (EIEF 2024)\n-The Future of Marketing and Management (FMM 2024)\n-Advances in Information Technology (AIT 2024)\n-Developments in Humanities, Education and Civilization (GDHEC 2024)\n\nProses pendaftaran dapat dilakukan melalui https://www.portal.connectingasia.org/.  Biaya konferensi untuk dosen dan mahasiswa Universitas Islam Indonesia adalah MYR1000. Biaya konferensi mencakup:\n\n-Presentasi di Konferensi\n-Sertifikat setelah Konferensi\n-Makan Siang selama Konferensi\n-Gala Dinner\n-Workshop (Advance Data Analysis Using AI & Foresight for Strategic Decision Making)\n-Peluang publikasi konferensi ini mencakup:\n-Foresight (SCOPUS Rank Q2 / ESCI)\n-Journal of Management Info (HEC-Y)\n-International Journal of Energy Economics and Policy (SCOPUS Q2)\n-International Journal of Interactive Mobile Technologies (SCOPUS)\n-International Journal of Online and Biomedic\nal Engineering (iJOE) (SCOPUS, WOS)\n-Environment and Social Psychology (SCOPUS)\n-The Open Public Health Journal (SCOPUS)\n-International Journal of Industrial Engineering & Production Research (SCOPUS)\n-Journal of Optimization in Industrial Engineering (JOIE) (SCOPUS)\n-REICE-Revista Electronica de Investigacion en Ciencias Economicas (SCOPUS, WOS)\n-Conhecimento & Diversidade-Educational journal (WOS)\n-SYNESIS (WOS)\n-LEX HUMANA (WOS)\n-International Journal of Industrial Engineering and Production Research (SCOPUS)\n\nSetiap jurnal dapat mengenakan Article Processing Charge dan ketentuan lain yang diatur oleh editorial team.\n\nDemikian undangan ini kami sampaikan. Atas perhatiannya kami ucapkan terima kasih.\nWassalamu\'alaikum Warahmatullahi Wabarakatuh.\n\nNarahubung \nAndi (WA +6281328760156)\n\nEmail\ninfo@connectingasia.org', '2024-12-12 06:25:19', '/public/uploads/\nnews/International_Conference.jpg'),
(8, 'Webinar Siaga Awards 2024', 'Simpul Pemberdayaan Masyarakat untuk Ketangguhan Bencana (SPMKB)/UIIPeduli bersama Asosiasi Masyarakat Tanggap Tangguh Bencana (MaTTA Bencana Indonesia) akan melaksanakan kegiatan tahunan yaitu Siaga Awards dengan 2 (dua) kegiatan, kompetisi Karya Tulis Ilmiah Tingkat Nasional dan Webinar Siaga Awards 2024.  Adapun Tema yang diangkat pada Siaga Awards Tahun 2024 yaitu Siaga Bencana Merapi Bagian Dari Hidup Harmoni. Pelaksanaan Webinar Siaga Awards 2024 akan dilaksanakan pada :\n\nHari, Tanggal : Kamis, 12 Desember 2024\nJam : 09.00 - 12.00 WIB\nLokasi : Zoom Meeting\nLink Pendaftaran : https://uii.id/WebinarSiagaAwards2024\n\nNarasumber :\nDr. Agus Budi Santoso, M.Sc. (Kepala Balai Penyelidikan dan Pengembangan Teknologi Kebencanaan Geologi (BPPTKG)) yang akan membawakan materi dengan tema : Strategi Mitigasi Bencana Erupsi Merapi.\nProf. Ir. Sarwidi, MSCE., Ph.D., IPU., ASEAN.Eng. (Dosen Program Studi Teknik Sipil Universitas Islam Indonesia), yang akan membawakan materi dengan tema : Hidup Harmoni Berdampingan dan Bersahabat Dengan Gunung Merapi.\nDr. Ir. Dwi Handayani, S.T., M.Sc., IPU., ASEAN.Eng. (Ketua SPMKB/UIIPeduli), yang akan membawakan materi dengan tema : Mengenal Lebih Dekat Karakter Masyarakat Lereng Merapi\nWebinar terbuka untuk umum. Ada Doorpirze menarik. Peserta yang mengikuti Webinar akan mendapatkan e-certificate.\nWassalamu\'alaikum Warahmatullahi Wabarakatuh.', '2024-12-12 06:27:24', '/public/uploads/\nnews/Webinar_Siaga.jpg'),
(9, 'Undangan Sosialisasi Pemilihan wakil mahasiswa 2025', 'Sehubungan dengan berjalannya rangkaian pemilwa tahun 2025 maka, kami KPU KM UII mengundang seluruh elemen keluarga mahasiswa Universitas Islam Indonesia untuk hadir dalam acara Sosialisasi Pemilwa 2025 yang akan diselenggarakan pada:\n\nHari dan Tanggal : 10 Desember 2024\nPukul : 18.00\nTempat : Gedung Kuliah Umum, Lantai 1 bagian barat\n\nDemikian undangan ini kami sampaikan kepada seluruh keluarga mahasiswa Universitas Islam Indonesia. Harapannya seluruh undangan dapat hadir dalam acara ini.', '2024-12-12 06:30:26', '/public/uploads/\nnews/Undangan_Pemilwa.jpg'),
(10, 'Karakterisasi Analitik Microscope Electron dan Pengenalan SEM Nanos', 'Kami mengundang Anda untuk bergabung dalam webinar #Laboratorium Terpadu UII Webinar Series dengan topik menarik yang akan memperkaya wawasan Anda.\nTopik: Karakterisasi Analitik Microscope Electron dan Pengenalan SEM Nanos\nHari/Tanggal: Senin, 16 Desember 2024\nWaktu: 09.00 - 12.00 WIB\nTempat: Online via Zoom\n\nNarasumber:\n- Prof. Rudy Syah Putra, Ph.D. - Kepala Laboratorium Terpadu UII\n- Syahrir Rosihan, S.T. - Scientific Product Manager\n\nWebinar ini ak\nan membahas tentang:\nKarakterisasi analitik microscope electron\nPenggunaan SEM Nanos dalam karakterisasi material\nAcara ini GRATIS dan terbuka untuk umum, jadi pastikan Anda mendaftar segera!\n \nKeuntungan bagi peserta yang hadir:\nE-Sertifikat\n\nPendaftaran:\nKuota terbatas, batas akhir pendaftaran adalah 13 Desember 2024. Pastikan Anda mengisi formulir pendaftaran untuk mendapatkan akses ke acara ini.\nUntuk mendaftar, silakan klik link berikut: s.id/WebinarSEMNanos\n\nWassalamu\'alaikum Warahmatullahi Wabarakatuh.\n\nNarahubung:\n081268800377 (Ms. Nisrina)', '2024-12-12 06:33:11', '/public/uploads/\nnews/Karakterisasi_Analitik.jpg'),
(11, 'Bedah Buku', 'Salam, Sobat Abu.\nKami, LPM Himmah UII, mengundang Sobat Abu sekalian untuk hadir dalam acara bedah buku Subjek Sunda: Genealogi, Kelahiran, dan Kewilayahan karya Holy Rafika Dhona. Diskusi ini akan berlangsung pada:\nHari: Jum\'at, 6 Desember 2024\nPukul: 15.00 - 18.00 WIB\nLokasi: GKU Dr. Sardjito UII Lantai 1\n\nDiskusi akan dimeriahkan oleh penampilan musik Sanggar Seni Kujang. Selain itu, akan ada Bazar buku-buku dari penerbit Marjin Kiri dan Warung Sastra. Bazar buku dapat dikunjungi mulai pukul 13.00 - 18.00 WIB.\nKami menyediakan kudapan bagi 50 peserta pertama yang hadir.\n\nUntuk memastikan kehadiran, Sobat Abu dapat mendaftarkan diri melalui tautan https://bit.ly/BedahBukuSubjekSunda\n\nKami berharap Sobat Abu dapat berpartisipasi dalam acara tersebut. Demikian undangan dari kami. Kami tunggu kehadiran Sobat Abu dalam diskusi hangat pada Jum\'at sore nanti.\nTerimakasih.\nWassalamu\'alaikum Warahmatullahi Wabarakatuh.', '2024-12-12 06:36:16', '/public/uploads/\nnews/Bedah_Buku.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `birthdate` date DEFAULT NULL,
  `gender` enum('MALE','FEMALE') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `profile_image`, `bio`, `created_at`, `birthdate`, `gender`) VALUES
(40, 'AnyName', 'aaa@aaa.com', '$2y$10$s6IiDqFrOP0vwX.Zmrs/y.6niDciq6kZC0siEL3PgHNCoLJQBcbFW', '/public/uploads/profile_images/9b7b5008226e36ebd463ab11c44708aa.jpg', '', '2024-12-21 13:01:06', '2024-12-03', 'MALE'),
(41, 'Candice Richards', 'candice.richards@example.com', '$2y$10$/cEYCAyRAUeMie2JAwinTex1jKC78WPFbRDAZMJlehcUsefVqZqdC', '/public/uploads/profile_images/ed5068c9f989b0b27944856b151caaa3.jpg', '', '2024-12-21 13:07:18', '2024-12-25', 'FEMALE'),
(42, 'Dwight Alvarez', 'dwight.alvarez@example.com', '$2y$10$hI9yFYpi3B/.LSqJ207Mg.f8vbvUsXn6Y3SWKhtcILqdpne1o6zje', '/public/uploads/profile_images/55ef86fda11b8af5b69e05025059fa67.jpg', '', '2024-12-21 13:29:31', '2024-12-25', 'MALE'),
(43, 'Joan Bishop', 'joan.bishop@example.com', '$2y$10$FBv27q7eCsz5dzXyQC5MQuKPUeTBg/hU3O3PP5sPAML9J3iJR6p3i', '/public/uploads/profile_images/ec6d62ff41a60b1105d35f7e381d96c3.jpg', '', '2024-12-21 13:46:46', '2024-12-25', 'FEMALE'),
(44, 'Jennifer Simmons', 'jennifer.simmons@example.com', '$2y$10$I5TOcVCMPp1jnLhJu83xg.7AOBjGtjrHtlY/abfAGO/5e19qhuVKm', '/public/uploads/profile_images/0461d124f712f710fea4cb58b73e539d.jpg', '', '2024-12-21 13:53:58', '2024-12-25', 'FEMALE'),
(45, 'Antonio Obrien', 'antonio.obrien@example.com', '$2y$10$ew9zaKnN9LbQELfTgxRzF.ykzvtmk5VJNsZ3.XAadbVXuLXclUXaG', '/public/uploads/profile_images/7022fffb7480709a77bd6b70ab3134a3.jpg', '', '2024-12-21 14:00:27', '2024-12-25', 'MALE'),
(46, 'Joanne Riley', 'joanne.riley@example.com', '$2y$10$vztzZkBNmGsoddeploKqZeyp49KPYMum.OTh.KIek.w/3Tx8d0zl6', '/public/uploads/profile_images/7940b71e65d3c2a5beb3353bf285e137.jpg', '', '2024-12-21 14:09:40', '2024-12-25', 'FEMALE'),
(47, 'Eli West', 'eli.west@example.com', '$2y$10$eGQTZsmMbC0Injm2ltVEFeoyTQ.qQKi9FC6GEWtew2URKJtebUdMm', '/public/uploads/profile_images/c3dc83b5b91b169cc36eb1f8b738958a.jpg', '', '2024-12-21 14:14:13', '2024-12-25', 'MALE'),
(48, 'Pat Parker', 'pat.parker@example.com', '$2y$10$URd3Nl4/q4blqMQb9YKmH.w8bfKp0R2uavJnPXK4nl08rbvpM5Fym', '/public/uploads/profile_images/8364ee9f90ee5b575e26bd8354f54fa3.jpg', '', '2024-12-21 14:21:39', '2024-12-25', 'MALE'),
(49, 'Joshua Fisher', 'joshua.fisher@example.com', '$2y$10$2qRAiZOOq5eeZYb7AdxLReFatQRG55BX7sWAv2EjTC5sRBPnpqYMO', '/public/uploads/profile_images/e16ca16d837c4f0ae053a9568dd5d9b6.jpg', '', '2024-12-21 14:27:16', '2024-12-25', 'MALE'),
(50, 'Ken Snyder', 'ken.snyder@example.com', '$2y$10$Zn290HoKP.XBxjmpCTkSJ.V4p0UAYEOpdd6O5RffMyNFt0iVI1psu', '/public/uploads/profile_images/c2cd9e5c75bcfc6d6c50f8997f7c9561.jpg', '', '2024-12-21 14:32:28', '2024-12-25', 'MALE'),
(51, 'Julie Pena', 'julie.pena@example.com', '$2y$10$IMLB1Ug9./49g7TtCgnoQ.oCV5L4etDMl4KOFKB54IeYhpVbhOqhq', '/public/uploads/profile_images/bbb20bf17dabf8cc8147b5ccb9d28f5a.jpg', '', '2024-12-21 14:40:06', '2024-12-25', 'FEMALE'),
(52, 'Cathy Mitchelle', 'cathy.mitchelle@example.com', '$2y$10$4gYmDhPVvsBmhHvqTFRB0OtGr1F/R8nUoHIUUhvXTjH5AeyvqrPVK', '/public/uploads/profile_images/a1889c201a0b3b3c08d754c4ac225847.jpg', '', '2024-12-21 14:42:41', '2024-12-25', 'FEMALE'),
(53, 'Edgar Lavaden', 'edgar.lavaden@example.com', '$2y$10$ZAYcSo8JVVbftkmZ2oimWOgBLx6/oK/gqW75i0V1xdgXKpbLhfHq2', '/public/uploads/profile_images/33abc1a905c0ab4512699179a52a3f54.jpg', 'Evil Edward', '2024-12-21 14:55:12', '2024-12-25', 'MALE'),
(54, 'Ayesha Bisma', 'ayesha.bisma@example.com', '$2y$10$1E0GhN.i24SmW/6d/5Y./umTBoJSFSeVLhigAkojvrHOMHPqIMZnK', '/public/uploads/profile_images/10b42fb8f38e7c10a0482c2999af9103.png', '', '2024-12-21 15:01:01', '2024-12-25', 'FEMALE'),
(55, 'Jackson Bailey', 'jackson.bailey@example.com', '$2y$10$X1Lc3WamflrSqfrY54sv8OOti111d.cY31YyXF.y1ZkegWG.AXOke', '/public/uploads/profile_images/8b7ce3c625b28afaaa1f4ec134ad4ef6.jpg', '', '2024-12-21 15:06:00', '2024-12-25', 'MALE'),
(56, 'Sophia Green', 'sophia.green@example.com', '$2y$10$Zn290HoKP.XBxjmpCTkSJ.V4p0UAYEOpdd6O5RffMyNFt0iVI1psu', '/public/uploads/profile_images/bbb20bf17dabf8cc8147b5ccb9d28f5a.jpg', '', '2024-12-21 15:12:15', '2024-12-26', 'FEMALE'),
(57, 'Lucas Gray', 'lucas.gray@example.com', '$2y$10$Zn290HoKP.XBxjmpCTkSJ.V4p0UAYEOpdd6O5RffMyNFt0iVI1psu', '/public/uploads/profile_images/c2cd9e5c75bcfc6d6c50f8997f7c9561.jpg', '', '2024-12-21 15:18:22', '2024-12-27', 'MALE'),
(58, 'Chloe Bennett', 'chloe.bennett@example.com', '$2y$10$Zn290HoKP.XBxjmpCTkSJ.V4p0UAYEOpdd6O5RffMyNFt0iVI1psu', '/public/uploads/profile_images/a1889c201a0b3b3c08d754c4ac225847.jpg', '', '2024-12-21 15:24:36', '2024-12-28', 'FEMALE'),
(59, 'Mason Cooper', 'mason.cooper@example.com', '$2y$10$Zn290HoKP.XBxjmpCTkSJ.V4p0UAYEOpdd6O5RffMyNFt0iVI1psu', '/public/uploads/profile_images/33abc1a905c0ab4512699179a52a3f54.jpg', '', '2024-12-21 15:30:45', '2024-12-29', 'MALE'),
(60, 'Emily Brooks', 'emily.brooks@example.com', '$2y$10$Zn290HoKP.XBxjmpCTkSJ.V4p0UAYEOpdd6O5RffMyNFt0iVI1psu', '/public/uploads/profile_images/ec6d62ff41a60b1105d35f7e381d96c3.jpg', '', '2024-12-21 15:36:59', '2024-12-30', 'FEMALE'),
(61, 'James Foster', 'james.foster@example.com', '$2y$10$Zn290HoKP.XBxjmpCTkSJ.V4p0UAYEOpdd6O5RffMyNFt0iVI1psu', '/public/uploads/profile_images/55ef86fda11b8af5b69e05025059fa67.jpg', '', '2024-12-21 15:42:17', '2024-12-31', 'MALE'),
(62, 'Olivia Kelly', 'olivia.kelly@example.com', '$2y$10$Zn290HoKP.XBxjmpCTkSJ.V4p0UAYEOpdd6O5RffMyNFt0iVI1psu', '/public/uploads/profile_images/ed5068c9f989b0b27944856b151caaa3.jpg', '', '2024-12-21 15:48:30', '2025-01-01', 'FEMALE'),
(63, 'test', 'test@example.com', '$2y$10$JXNnS4b3cG8.UMsmEhEx3.IxNrue1TWMiOmgNor3m0TZuQO4JPm5C', '/public/uploads/profile_images/67cc50766582cb69a5ff9d5e7cb68a45.jpg', '123456\r\n', '2024-12-21 18:31:17', '2024-12-01', 'FEMALE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `community_id` (`community_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `communities`
--
ALTER TABLE `communities`
  ADD PRIMARY KEY (`community_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `community_members`
--
ALTER TABLE `community_members`
  ADD PRIMARY KEY (`membership_id`),
  ADD KEY `community_id` (`community_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `community_id` (`community_id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `communities`
--
ALTER TABLE `communities`
  MODIFY `community_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `community_members`
--
ALTER TABLE `community_members`
  MODIFY `membership_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`community_id`) REFERENCES `communities` (`community_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `communities`
--
ALTER TABLE `communities`
  ADD CONSTRAINT `communities_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `community_members`
--
ALTER TABLE `community_members`
  ADD CONSTRAINT `community_members_ibfk_1` FOREIGN KEY (`community_id`) REFERENCES `communities` (`community_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`community_id`) REFERENCES `communities` (`community_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`creator_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
