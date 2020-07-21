-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2020 at 03:26 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boardgame`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `Password`, `Role`) VALUES
('admin', 'admin', 'Admin'),
('manager', 'manager1', 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `ID` int(11) NOT NULL,
  `Image` text CHARACTER SET utf8 NOT NULL,
  `Link` text CHARACTER SET utf8 NOT NULL,
  `Position` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`ID`, `Image`, `Link`, `Position`) VALUES
(1, 'offer-banner-7.jpg', '#', 'Offer-Section'),
(2, 'offer-banner-8.jpg', '#', 'Offer-Section'),
(3, 'offer-banner-9.jpg', '#', 'Offer-Section'),
(4, 'slider1.jpg', '#', 'Slider-Section'),
(5, 'slider2.jpg', '#', 'Slider-Section'),
(6, 'slider3.jpg', '#', 'Slider-Section'),
(7, 'slider4.jpg', '#', 'Slider-Section'),
(8, 'offer-banner-4.jpg', '#', 'Slider-Deals-Section'),
(9, 'offer-banner-5.jpg', '#', 'Slider-Deals-Section'),
(10, 'offer-banner-6.jpg', '#', 'Slider-Deals-Section'),
(11, 'offer-banner-10.jpg', '#', 'Slider-Deals-Section');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `ID` int(11) NOT NULL,
  `User` varchar(100) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` float NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Address` text NOT NULL,
  `Time` date NOT NULL,
  `Note` text NOT NULL,
  `Status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`ID`, `User`, `Quantity`, `Total`, `Name`, `Phone`, `Address`, `Time`, `Note`, `Status`) VALUES
(1, 'test123@gmail.com', 5, 6800000, 'Test Name', '0911111111', 'test địa chỉ', '2020-06-01', '', 3),
(2, '', 1, 1700000, 'test', '0911111111', 'test', '2020-06-04', '', 2),
(3, 'test123@gmail.com', 6, 665000, 'test', '0911111111', 'test địa chỉ', '2020-06-06', '', 2),
(4, 'test123@gmail.com', 4, 960000, 'test', '0911111111', 'test địa chỉ', '2020-06-09', '', 1),
(5, 'test123@gmail.com', 4, 5650000, 'test', '0911111111', 'test địa chỉ', '2020-06-11', '', 2),
(6, '', 4, 2430000, 'Nguyễn Văn A', '0922222222', '273 An Dương Vương, Phường 3, Quận 5, Hồ Chí Minh', '2020-06-13', '', 1),
(7, '', 6, 1400000, 'Nguyễn Văn B ', '0933333333', '273 An Dương Vương, Phường 3, Quận 5, Hồ Chí Minh', '2020-06-14', '', 3);

--
-- Triggers `bill`
--
DELIMITER $$
CREATE TRIGGER `update_quantity_product_after_cancel_bill` AFTER UPDATE ON `bill` FOR EACH ROW IF(NEW.Status = '3') THEN
    	UPDATE product 
        SET Quantity = Quantity + ( SELECT Quantity FROM billdetail WHERE BillID = NEW.ID AND ProductID = product.ID) 
        WHERE ID IN (SELECT ProductID FROM billdetail WHERE BillID = NEW.ID);
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `billdetail`
--

CREATE TABLE `billdetail` (
  `BillID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `billdetail`
--

INSERT INTO `billdetail` (`BillID`, `ProductID`, `Quantity`, `Price`) VALUES
(1, 39, 1, 2500000),
(1, 40, 2, 1700000),
(1, 42, 1, 750000),
(1, 43, 1, 150000),
(2, 40, 1, 1700000),
(3, 16, 1, 190000),
(3, 24, 1, 100000),
(3, 26, 3, 65000),
(3, 27, 1, 180000),
(4, 17, 1, 450000),
(4, 18, 1, 180000),
(4, 19, 1, 130000),
(4, 31, 1, 200000),
(5, 8, 1, 1250000),
(5, 39, 1, 2500000),
(5, 41, 1, 150000),
(5, 44, 1, 1750000),
(6, 4, 1, 380000),
(6, 34, 1, 550000),
(6, 35, 1, 350000),
(6, 36, 1, 1150000),
(7, 11, 1, 200000),
(7, 12, 1, 400000),
(7, 13, 1, 120000),
(7, 14, 1, 50000),
(7, 16, 1, 190000),
(7, 38, 1, 440000);

--
-- Triggers `billdetail`
--
DELIMITER $$
CREATE TRIGGER `update_quantity_product` AFTER INSERT ON `billdetail` FOR EACH ROW BEGIN
   UPDATE product SET 
   Quantity = Quantity - NEW.Quantity
   WHERE ID = NEW.ProductID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Category_name` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category`, `Category_name`) VALUES
('2x2', 'Rubik 2x2'),
('3x3', 'Rubik 3x3'),
('Cardgame', 'Trò chơi thẻ'),
('Deduction', 'Suy luận'),
('Horror', 'Kinh dị'),
('Other', 'Rubik khác'),
('Roleplaying', 'Nhập vai'),
('Stragery', 'Chiến thuật'),
('Wargame', 'Chiến tranh');

--
-- Triggers `category`
--
DELIMITER $$
CREATE TRIGGER `update_category` AFTER UPDATE ON `category` FOR EACH ROW IF !(NEW.Category <=> OLD.Category) THEN
      UPDATE product
      SET product.Category = NEW.Category 
      WHERE product.Category = OLD.Category;
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `ID` int(11) NOT NULL,
  `ProductID` int(20) NOT NULL,
  `Image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`ID`, `ProductID`, `Image`) VALUES
(35, 31, 'f295f6e48ad6e6bf9d8e9e4f7ea4f9b5.jpg'),
(36, 31, 'eeb2e577ffaec441aeabe37364e0ca0d.jpg'),
(37, 31, '60f9ad1e60d2f8a27ea41382ce048786.jpg'),
(38, 31, 'dafdb4306a712e8a4d13eee9a8388cb9.jpg'),
(39, 31, '517f5a03eb520c64674b2257768cec26.jpg'),
(40, 31, 'ffbf6ce202ad039ffd166dfc3944a4c4.jpg'),
(41, 31, '2030bdb4c0bfb90eee09126a62ce4106.jpg'),
(42, 31, '22cd3ee140203b31f4fb3b2c2f56bb43.jpg'),
(44, 1, 'adcbe76fc2dc75e472bada341856fba0.jpg'),
(45, 1, 'a44b40f8ae9902d758832c85a61dfa1b.jpg'),
(53, 2, 'eafc9229b2b002893cc008eeabcfd0c8.jpg'),
(54, 2, '782122edb1cb53f19fc18fe5b12b6d34.jpg'),
(55, 2, 'a8e78a6cff591bee10944fa248e3f4de.jpg'),
(56, 2, 'b3b796bc5a5b21f051682792dc2c357b.jpg'),
(57, 4, '59a5584564658f062d8a865cfb5e0aeb.png'),
(58, 4, 'a14f2c873d1c6b9d4d538f434960ea90.png'),
(59, 4, 'f94fc288601fbdbd939b867bb5f5a572.png'),
(60, 4, 'b6ac76b0ad6de29031cd7dcb297ff070.png'),
(61, 5, '9c34422e8897b7bd7219343946b83f12.jpg'),
(62, 5, 'e94e527c032435bb4ad788830afb4440.jpg'),
(63, 5, '57869400cc931b1719da964ea7567c02.jpg'),
(64, 5, '15826e2ce3935128ace9f0f3fc5e9ecb.jpg'),
(65, 6, '67ef3418bf158553e5ca867453cfc36f.jpg'),
(66, 6, '7220add6c191265f67476832bd620d7d.jpg'),
(67, 6, '39ef76959510b1babcd92e77f7d26318.jpg'),
(68, 7, 'e14df65c80b1d6c37d0d44047c1de147.jpg'),
(69, 7, '6a5e0facabcbb600c4c89d9f2e137276.jpg'),
(70, 9, '8c3ac55c51706d7b8436c26740b9b9a7.jpg'),
(71, 9, '6892490f6492b6a3719d1428ab8c71c4.jpg'),
(72, 9, 'ec53d6bd8541d842fced663b9ba98ac6.jpg'),
(73, 10, '8f197a3df5841b08a1d191f7d4f9e756.jpg'),
(74, 10, '02904ec7da7f6f240ff8ba917c6f3c42.jpg'),
(75, 11, 'a8574322517b07d284d6846205c33d0f.jpg'),
(76, 11, '9689ccbdb0cad97215d3ffaf86f6815b.jpg'),
(77, 12, 'b134d5cf886895f4dccd266fe676d255.jpg'),
(78, 12, 'c7e4d94997cd20eea5e0ede12c0f53bf.jpg'),
(79, 12, '001de00b49c039742e0e4f3fbb7cbf68.jpg'),
(80, 32, 'c05a901b917ba8e0f9186d430c2bc695.jpg'),
(81, 32, 'd85e14a597ceee7f781bf2cb18543e0c.jpg'),
(82, 32, '6d216b7ae5c4d7a48af03e8ccd52a597.jpg'),
(83, 33, '730ca6fe5cb556d51c240e2d2b61cc8e.jpg'),
(84, 33, '4bef94e703e7bd933b4f1eda3c0c23b4.jpg'),
(85, 33, '25237d3913bdb8edf3b7b627cc1fd0ff.jpg'),
(86, 33, '86b055333117fe325a478d5afd7cbbfd.jpg'),
(87, 34, 'e8c202bff4eded176ada91d997bf9ff3.jpg'),
(88, 34, '48b9d3310a01fa99751404058b0633a9.jpg'),
(89, 34, 'a05b67028240799af83ff21e4e464a3c.jpg'),
(90, 35, '6b680244d9a73d7da3bd7be0519707cc.jpg'),
(91, 35, '7e0db036b1511108888433bd1cf6a93d.jpg'),
(92, 36, 'c15868d7e27738d0a6212979640ffac1.jpg'),
(93, 36, 'd86ad53ea5e54f5a737dfbd3dbb6117d.jpg'),
(94, 36, '7c333de439f0d2b3915a1e7fcdf4d1cc.jpg'),
(95, 37, '93acb2293ce458515ed5eca04a2e7dd5.jpg'),
(96, 37, 'b535bdc6f2ba29213a7c65fa1ab59bc1.jpg'),
(97, 37, '5605ee067444a2a65489eada77785bb2.jpg'),
(98, 38, '3f0258313990bf00231e5653f1d216de.jpg'),
(99, 38, 'e907bc2a96f761658de4b5b9b0bff344.jpg'),
(100, 38, '9255853d2694c67559b9134f9b75f383.jpg'),
(101, 38, 'c4dae9202d8a6873456917e29c8e76d6.jpg'),
(102, 38, '403a8bb1145446b0d06efc147acf8489.jpg'),
(103, 38, '7177c52d21f8a788e04ccc03f5f9171c.jpg'),
(104, 38, 'c18fcde33f46e0440d8a852b3d8a825b.jpg'),
(105, 38, 'ba00a47b6750baaaa80cf8d047698fae.jpg'),
(106, 39, 'b9ba8aa437f89b659f591ecd78c3d88e.jpg'),
(107, 39, '332d287fd22fd0ca58c9bd808c28aaad.jpg'),
(108, 39, '172cfbc928e18ba83ae409ec1ffd6b25.jpg'),
(109, 40, '7b78d901cbeb429e43b7d1f6fb5bc5bc.jpg'),
(110, 40, 'e31f397a69348cc494838e5d1918f4a8.jpg'),
(111, 40, '6c40b5541a8e6b232db6deadf6566a04.jpg'),
(112, 40, '4c70159c92c2f2b3438cec7335973543.jpg'),
(113, 42, 'b045fe8aebad78cc66f3530d4358a8f9.jpg'),
(114, 42, '33249a28f66c7b41dbfd15311825a9b7.jpg'),
(115, 42, '33a39558061a1c25cf06eb9663af874a.jpg'),
(116, 43, 'a114b3bc2b22b248258f2bd71d922b82.jpg'),
(117, 43, 'f362895cb3e3c1ea9921b472a04432d9.jpg'),
(118, 43, '62d40fc13bb00b9685b9d43802b8ec38.jpg'),
(119, 43, '1590c0ea5959828ea53dec7d173f9ea3.jpg'),
(120, 13, 'c3ee6a271444f8d308e9feb586117d21.jpeg'),
(121, 13, 'a6203444236d757d4ed5d19a277f4d68.jpg'),
(122, 15, 'b80171e963ad6b9b1750d6536f058cdf.jpg'),
(123, 15, 'e6aff874ab0cd375e58ff5922f4f3dd8.jpg'),
(124, 17, '7d286380e24e3d6672e27fc91fb9f51a.jpg'),
(125, 17, '091c05f855c930d4f3a4c9db3202b0a8.jpg'),
(126, 17, 'b8b2fdf23b36fd6d6fc581980d1f3a25.jpg'),
(127, 18, '96daf7a7bfe795ae604d2b9bb65d1e2e.jpg'),
(128, 18, '6a4338c27d28c0ef0f9c8f608d831772.jpg'),
(129, 19, '2c96beaab6cacffd6d2db144b3800fa2.jpg'),
(130, 19, 'b1b54fdcc13cc42fe2cc8cd1e799dfcd.jpg'),
(131, 20, '4c2e7cf577ab1c8dbefd5f8c57629f2f.jpg'),
(132, 20, 'b1ab328f37ad46dbf3d1c4ec0720ac99.jpg'),
(133, 21, '720f8224b28b6031e4ed297ac7828c90.jpg'),
(134, 21, '42aaec65ce21ad9a15dd310f8c219fcf.jpg'),
(135, 21, '7ea2ceeb7491b67e5ab0f3d21b9f5c78.jpg'),
(136, 22, '5936ba6f8298fda3a13bc9463b53a18d.jpg'),
(137, 22, '1cb527871e1d86a41bef4fb904ca3d40.jpg'),
(138, 22, '2ac5e7120fe90f49a14f1299a3760d8a.jpg'),
(139, 23, 'e180fd6046a3b9592a032f1c3ccb2b1d.jpg'),
(140, 23, '33d7d9be4b5c59510457bb922cb39677.jpg'),
(141, 23, '8a3a42893480969686da118720d8174f.jpg'),
(142, 24, 'a008ae2270e3414aa25e1704df6c5c49.jpg'),
(143, 24, 'f644fb7b6dd4aef9ccfbea415ac930c0.jpg'),
(144, 24, 'f60439ac4fec44178a1292885ba319de.jpg'),
(145, 25, 'dfade0afc29d74400f64d56fb7d8860f.jpg'),
(146, 25, 'fa527f544cb8b2097d6f273006efc01b.jpg'),
(147, 26, 'c1e0183af22bf17326a7cd3ea73247f3.jpg'),
(148, 26, '2ba348e5a49430d54b764e8fc929e543.jpg'),
(149, 27, 'abbc48edd7fa416b86a3d1241b3083cd.jpg'),
(150, 27, '7b949c752fb7b72ddcd835b795dd3e11.jpg'),
(151, 27, 'aeef0cc423cead7c98a0cc25823c23da.jpg'),
(152, 28, 'ea474fb1f9adbf33575b99737669350a.jpg'),
(153, 28, '0c2fb7d95503c203652ce0c6b19b1032.jpg'),
(154, 28, 'f74d5ac6d86aea04e68b288868e20e93.jpg'),
(155, 29, '971b29b6cfb603b3b1c867b19e504349.jpg'),
(156, 29, 'f95a4a21681434c534684ae485fa1844.jpg'),
(157, 29, '940a951d44c88b037fd8fe925f753c52.jpg'),
(158, 30, 'a1d28639a610f44be8f937be52055bca.jpg'),
(159, 30, '0660b478bf94cfc7bdd02d9b0af87bf0.jpg'),
(160, 30, '577873f464c0d30cdc7765eaf833c21e.jpg'),
(161, 8, '4b8b37153069b1eb8144b50c804a8196.jpg'),
(162, 8, '782bff0dc6de39925acff392c3a22e26.jpg'),
(163, 41, '6f1e544d68a65df194a566cc3073061b.jpg'),
(164, 41, '603a2cb5f533fa2808b8e4acfa1ac753.jpg'),
(165, 44, '093e056eb648907e9d900b7889cf3034.jpg'),
(166, 44, '46b294e014de04ac20ab6bdd53096212.jpg'),
(167, 44, '567267582d61d25fb70d86680dc8d98f.jpg'),
(168, 45, 'e79dc05207afd0b20896c87cbf7a1bd3.jpg'),
(169, 45, '0ac7e809f29586fc48834c9c6eec8892.jpg'),
(170, 45, 'a1fd8c197ef67748fd6f937874f28999.jpg'),
(171, 46, '785d85c7c5f29d00d3f9f597a014a8c9.jpg'),
(172, 46, 'edc70f0ad9352d4d89b3639de41fa84f.jpg'),
(173, 46, '526ec6189a6a1b087dfe7466200d3bce.jpg'),
(174, 46, 'c737f7b69e7b2a8ab82298a8ae7a4c7c.jpg'),
(175, 46, 'f5325eb958938a7cc5a9a6e61a3c858c.jpg'),
(176, 46, 'c8d42f23df50257eef871cfc6144c9f0.jpg'),
(177, 47, '10752882c30ba5d4acae233590467bbd.jpg'),
(178, 47, 'ae2daef6533860ded1eb4aae14973cf1.jpg'),
(180, 47, '646e5bae115cb1fad08a64b16c128f82.jpg'),
(181, 48, '1de10f1851b49a6e3f51fc977085313d.jpg'),
(182, 49, '84dd0be612e0f6250e9611f402d46eca.jpg'),
(183, 49, '7a93103ca76e3929247af2b127e7c62c.jpg'),
(184, 49, 'ce866613b070dceeb3cc20d96eb8fc07.jpg'),
(185, 50, 'baffa7673760b9e913f92932814117c2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `menu_first`
--

CREATE TABLE `menu_first` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_first`
--

INSERT INTO `menu_first` (`ID`, `Name`, `Link`) VALUES
(1, 'Board Game', 'product.php?code=BG'),
(2, 'Rubik', 'product.php?code=RB'),
(3, 'Các loại cờ', 'product.php?code=CO');

-- --------------------------------------------------------

--
-- Table structure for table `menu_second`
--

CREATE TABLE `menu_second` (
  `ID` int(11) NOT NULL,
  `MenuIDFirst` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_second`
--

INSERT INTO `menu_second` (`ID`, `MenuIDFirst`, `Name`, `Link`) VALUES
(1, 1, 'Chiến thuật', 'product.php?code=BG&category=stragery'),
(2, 1, 'Kinh dị', 'product.php?code=BG&category=horror'),
(3, 1, 'Suy luận', 'product.php?code=BG&category=deduction'),
(4, 1, 'Trò chơi bài', 'product.php?code=BG&category=cardgame'),
(5, 1, 'Nhập vai', 'product.php?code=BG&category=roleplaying'),
(6, 2, 'Rubik 2x2', 'product.php?code=RB&category=2x2'),
(7, 2, 'Rubik 3x3', 'product.php?code=RB&category=3x3'),
(8, 2, 'Các loại khác', 'product.php?code=RB&category=other'),
(9, 3, 'Các loại cờ', 'product.php?code=CO');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ID` int(10) NOT NULL,
  `Name` text NOT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `Price` int(10) NOT NULL,
  `NoP` varchar(10) NOT NULL,
  `NoPsg` varchar(10) NOT NULL,
  `Time` varchar(10) NOT NULL,
  `Age` varchar(5) NOT NULL,
  `Description` text NOT NULL,
  `Type` varchar(5) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Pic` varchar(255) NOT NULL,
  `Status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ID`, `Name`, `Category`, `Price`, `NoP`, `NoPsg`, `Time`, `Age`, `Description`, `Type`, `Quantity`, `Pic`, `Status`) VALUES
(1, 'Ma Sói Mini', 'Horror', 60000, '8 - 22', '11 - 15', '30', '10+', 'Ma Sói Mini là phiên bản trò chơi ma sói được nhiều người yêu thích, mang đầy đủ chức năng của phiên bản Characters.\nBộ ma sói mini có thiết kế dạng hình tròn mang lại cảm giác khác lạ so với những lá bài vuông góc cạnh thông thường.\nSản phẩm được thiết kế nhỏ gọn, có thể dễ dàng mang đi để chơi cùng bạn bè tại những nơi yêu thích như lớp học hay đi du lịch.\nTrò chơi có tính giải trí cao sẽ mang cho bé cảm giác thoải mái, thích thú và giảm stress sau giờ học căng thẳng.', 'BG', 15, 'sp00.jpg', 0),
(2, 'Dozen War - Tử Chiến Đế Đô', 'Stragery', 650000, '2', '2', '10 - 40', '3+', 'Dozen War (Thập Nhị Chiến) là một board game chiến thuật  được sáng tạo bởi người Việt, lấy bối cảnh một thế giới giả tưởng có tên là Mativen cùng với cuộc chiến giữa 12 vị anh hùng.\nGame có 2 mode chơi riêng biệt:\nĐối đầu : dành cho 2 người chơi với thời lượng 5-15 phút\nChiến thần (full): dành cho từ 3- 4 người chơi ( có thể chơi Free for all hoặc Co-op)  với thời lượng chơi từ 1,5h – 2,5h', 'BG', 0, 'sp01.jpg', 0),
(3, 'Board game là gì?', 'Cardgame', 310000, '2 - 10', '2 - 10', '15 - 30', '6+', 'đây là mô tả', 'BG', 15, 'sp02.jpg', 0),
(4, 'Lớp Học Mật Ngữ - Cuộc đua sao chổi', 'Roleplaying', 380000, '2 - 6', '4', '30', '10+', 'Board Game Lớp Học Mật Ngữ - Cuộc đua sao chổi - BOARD GAME HOT NHẤT 2018\nLớp Học Mật Ngữ là một trò chơi cực kỳ dễ thương và đặc sắc được sáng tạo từ chính nhóm tác giả B.R.O, bộ board game được chuyển thể từ truyện tranh cùng tên, Best Seller 2016-2018 tại Fahasa và là một trong 10 tựa sách được yêu thích nhất 2018. Được phát hành bởi BoardgameVN và Review bởi Time Sun See Studio, Toy Station, Comicola, Thơ Nguyễn\nBạn muốn trở thành anh hùng cứu cả hành tinh? Bạn muốn sở hữu một sức mạnh siêu nhiên như các siêu anh hùng Avengers?\n\nCòn chờ gì nữa mà không nhập vai ngay vào chính cung hoàng đạo của mình với kỹ năng rất đặc biệt để bắt đầu cuộc chiến giải cứu Hành tinh Cầu Vồng xinh đẹp thoát khỏi thảm họa sao chổi nha.', 'BG', 14, 'sp03.png', 0),
(5, 'Blood Rage (US)', 'Stragery', 2000000, '2 - 4', '3 - 4', '60 - 90', '14+', 'Nội dung cốt truyện của Blood Rage vô cùng tuyệt vời khi đưa bạn trở về với thần thoại của những vị thần Bắc Âu, thời điểm mà Ragnarok đang đến gần và bạn sẽ trở thành một trong 4 tộc người Viking với nhiệm vụ điều khiển các chiến binh, thủ lĩnh và các con tàu của người Viking chiến đấu, cướp bóc, nghiền nát đối thủ trong các  trận chiến hoặc hoàn thành các nhiệm vụ, tăng chỉ số cho tộc người của mình hay cũng có thể là chết một cách vinh quang trong các trận chiến hoặc ragnarok. Tất cả chỉ vì một mục đích duy nhất - tạo ra vinh quang cuối cùng của đế chế Viking.\n\n \n\nĐối với các Viking: “ Cuộc sống là Trận chiến; Trận chiến là Vinh quang; Vinh quang là TẤT CẢ\"\n\n ', 'BG', 15, 'sp04.jpg', 0),
(6, 'Codenames Words (US)', 'Deduction', 590000, '2 - 8', '6', '15', '14+', 'Trong Codenames, hai đội sẽ thi nhau xem ai triệu tập được toàn bộ đặc vụ của phe mình trước. Đội trưởng sẽ đưa ra 1 từ gợi ý, từ này có thể dẫn đến nhiều đáp án khác nhau. Các đồng đội của anh ta phải cố tìm cho ra đặc vụ được gợi ý mà không nhầm với màu của bên kia. Ngoài ra, tất cả đều phải tránh xa Assassin nếu không muốn thảm bại ngay lập tức.\n\nCodenames: Không sợ đối thủ lợi hại, chỉ ngại đồng đội phá team!!!', 'BG', 15, 'sp05.jpg', 0),
(7, 'Arcadia Quest (US)', 'Stragery', 2350000, '2 - 4', '2 - 4', '60', '13+', 'Bộ Arcadia Quest cơ bản', 'BG', 15, 'sp06.jpg', 0),
(8, 'Battle for Rokugan (US)', 'Wargame', 1250000, '2-5', '5', '60 - 90', '14+', 'Chinh phục vương quốc và mang lại danh dự cho bang hội của bạn trong Battle for Rokugan! Trò chơi chiến thuật chinh phục và lộn xộn theo lượt này đặt người chơi vào vai Rokugan daimyō đấu tranh để giành quyền kiểm soát vùng đất giàu có của Đế chế Emerald. Các nhà lãnh đạo phải cân bằng tài nguyên của họ, lên kế hoạch tấn công và đánh lừa kẻ thù để đảm bảo chiến thắng của gia tộc họ. Đất là có để lấy. Daimyō danh dự nhất sẽ giành chiến thắng trong ngày!', 'BG', 14, 'sp07.jpg', 0),
(9, 'Bài UNO Đại Chiến', 'Cardgame', 80000, '2 - 10', '4 - 6', '30', '6+', '-	Trò chơi tập thể vui nhộn\nUno rất đơn giản, dễ chơi, nhanh và vui, thích hợp với một nhóm đông người, càng đông trò chơi càng trở nên vui nhộn hơn. Bạn có thể tạo nên một bữa tiệc Uno rộn ràng với những tràng cười ngả nghiêng, những giờ phút mà sẽ còn nhớ mãi như một kỷ niệm vui với bạn bè mình. Trò chơi thích hợp cho 2 – 10 người, từ 5 tuổi trở lên.\n-	Giúp người chơi rèn luyện nhiều kỹ năng\nTrò Chơi Boardgame sẽ giúp người chơi rèn luyện khả năng phản xạ nhanh nhẹn, giúp nhận biết các con số, hình ảnh một cách chính xác, biết luật chơi và phát huy tư duy logic. Không những thế trò chơi còn giúp mình trở nên hoạt bát, và hòa nhập tốt với đám đông, bạn bè.', 'BG', 15, 'sp08.JPG', 0),
(10, 'Ma Sói Ultimate Deluxe ', 'Horror', 240000, '5 - 75', '11 - 15', '30 - 90', '8+', 'Trò Chơi Board Game Ma Sói Ultimate Deluxe là trò chơi ma sói phiên bản đặc biệt, bạn có thể chơi ở bất cứ đâu, từ 5 đến 75 người chơi. Mỗi người chơi sẽ có 1 vai trò khác nhau: nếu là dân làng, hãy tìm ra các con sói; nếu là sói, hãy thuyết phục những người khác rằng bạn vô tội, cùng lúc đó bí mật ăn thịt dân làng vào các đêm. Ngoài ra còn rất nhiều chức năng đặc biệt khác trong trò chơi, sẽ giúp dân làng có thêm thông tin, và giúp các con sói ẩn mình, đạt được mục đích.\r\nTrò chơi bao gồm hơn 40 chức năng đặc biệt, 18 kịch bản khác nhau để setup, một bộ gồm 78 lá bài, một tờ giấy ghi chú giúp cho quản trò dễ dàng theo dõi trò chơi, một bộ luật chi tiết về nhân vật, chiến thuật nâng cao. Trò chơi bao gồm tất cả những gì bạn cần để có thể chơi với một nhóm nhỏ, hoặc tụ tập một nhóm người chơi rất lớn giữa quảng trường, hay là một hoạt động tập thể trong giờ sinh hoạt.\r\n\r\nLuật chơi\r\nGame Ma Sói gồm hai giai đoạn:\r\nGiai đoạn ban đêm: Mọi người nhắm mắt, Quản Trò gọi vai trò đặc biệt nào thì vai trò ấy mở mắt và thực hiện chức năng của mình trong yên lặng.\r\nGiai đoạn ban ngày: Quản trò ra hiệu mọi người mở mắt, thông báo những ai đã chết đêm qua. Sau đó, bình bầu treo cổ một người bị nghi ngờ là Ma Sói trong ban ngày (Có thể hoãn không treo). Nếu có 2 người cùng có số phiếu bầu treo như nhau thì không ai bị treo cả.\r\nGồm có 78 lá nhân vật, có thể chơi đến 75 người\r\nThời gian chơi: 30 phút\r\nKhối lượng	300g\r\nKích thước	16.8 x 12.7 x 3.5 cm\r\nChất liệu	Giấy', 'BG', 15, 'sp09.JPG', 0),
(11, 'Mèo Nổ - Exploding Kittens', 'Cardgame', 200000, '2 - 5', '4 - 5', '15', '7+', '1. Cốt truyện\r\nMột tựa game từng gây sóng gió trên Kickstarter khi đạt được 2 triệu đô chỉ trong vòng 24h. Trong game, nếu rút trúng lá Exploding Kitten bạn sẽ thua, bạn tránh rút và ép những người chơi khác phải rút lá đó. Với artwork độc đáo, siêu bựa, cách chơi đơn giản, hấp dẫn, những tràng cười sảng khoái cùng bạn bè là những gì bạn nhận được từ Exploding Kittens.\r\nBạn không thể dừng phấn khích vì độ bựa của bộ game này cũng như khuôn mặt của chúng bạn khi bị: lật ngay lá \"Nổ\" trong lần rút bài đầu tiên hay lúc bất khả kháng với cả vạn tấn thuốc nổ dưới chồng bài và hàng ngàn tình huống khác cũng \"vi diệu\" chả kém!!!\r\n\r\n2.Luật chơi sơ lược\r\n- Người chơi sẽ thay phiên nhau rút bài cho đến khi một người chơi rút phải lá Exploding Kitten và bị loại khỏi trò chơi.\r\n- Bộ bài bao gồm các lá giúp bạn tránh được lá bài nổ, xem trước các lá bài sẽ phải rút, ép người chơi khác phải rút nhiều bài... Trò chơi sẽ càng ngày càng gay cấn vì mỗi lá bạn rút thì chồng bài sẽ càng ngày càng ít và tỉ lệ bạn bị nổ sẽ càng ngày càng cao.\r\nĐể sở hữu một trong những siêu phẩm bựa nhất quả đất, nhanh tay đặt hàng ngay nào!\r\n\r\n', 'BG', 15, 'sp10.jpg', 0),
(12, 'Odd - Phiên bản tiếng Việt', 'Deduction', 400000, '4 - 30', '6 - 8', '30', '18+', 'Card game bựa nhất thế giới đã xuất hiện tại Việt Nam trong một phiên bản mang tên Odd!\nOdd được dựa trên trò chơi nổi tiếng Cards Agains Humanity, nhưng được Việt hóa và sáng tạo nên cho phù hợp với văn hóa và óc hài hước của người Việt. Odd có nghĩa là lạ lùng, kỳ quặc – đúng như cái tên đó, trong trò chơi này bạn sẽ không lường trước được những gì xảy ra, và nó luôn gây bất ngờ cho bạn.\nMột người chơi đọc lớn chủ đề ở lá bài màu đen, thường là một câu hỏi hay một câu khuyết cần điền vào. Những người khác bí mật chọn câu trả lời trong các lá bài màu trắng. Sau đó cùng lúc tiết lộ, người nào có câu trả lời khớp, và hài hước, bựa nhất sẽ nhận được điểm chiến thắng.\nOdd được khuyến cáo nên chơi với người từ 18 tuổi trở lên bởi sức bựa không giới hạn của nó. Hãy cẩn thận, bạn có thể bị cười đến sái quai hàm ở trò chơi này. Bạn đã được cảnh báo!\n*Odd bao gồm 500 lá bài: 350 lá Màu Trắng và 150 lá Màu Đen. Các dòng chữ trên bài hoàn toàn bằng tiếng Việt', 'BG', 15, 'sp11.jpg', 0),
(13, 'Rubik 3x3 Speed Cube ShengShou', '3x3', 120000, '1', '1', '15', '4+', 'Rubik là đồ chơi trí tuệ được giáo sư điêu khắc và kiến trúc sư người Hungary Erno Rubik sáng chế ra năm 1974 và đã trở thành món đồ chơi quen thuộc kể từ những năm 1980 đến nay. Cách chơi trò chơi này cũng rất đơn giản, người chơi chỉ cần xoay cho đến khi tất các mặt của rubik đều cùng 1 màu. Rubik 3x3x3 có mang các tính năng sau:\n\nGóc cạnh nhẫn để không gây nguy hiểm\nXoay trơn để giải nhanh\n3x3x3 speed cube\nHãng: Shenshou\n\nKích thước: 56.0mm x 56.0mm x 56.0mm ', 'RB', 15, 'sp12.jpg', 0),
(14, 'Rubik 2x2 Speed Cube ShengShou', '2x2', 50000, '1', '1', '15', '4+', 'Rubik là đồ chơi trí tuệ được giáo sư điêu khắc và kiến trúc sư người Hungary Erno Rubik sáng chế ra năm 1974 và đã trở thành món đồ chơi quen thuộc kể từ những năm 1980 đến nay. Cách chơi trò chơi này cũng rất đơn giản, người chơi chỉ cần xoay cho đến khi tất các mặt của rubik đều cùng 1 màu. Rubik 3x3x3 của BoardgameVN mang các tính năng sau:\nGóc cạnh nhẫn để không gây nguy hiểm\nXoay trơn để giải nhanh', 'RB', 15, 'sp13.jpg', 0),
(15, 'Rubik Megaminx ShengShou', 'Other', 250000, '1', '1', '...', '4+', 'Thiết kế với cấu trúc mới giúp giải nhanh, giải tốc độ (thích hợp trong thi đấu).\nRubik Megaminx Biến Thể 12 Mặt Xoay trơn, không kẹt, không rít, độ bền cao\nChất liệu: nhựa ABS an toàn, không độc hại.\nBề mặt trơn và góc cạnh đều được làm nhẵn\nBao gồm 50 mảnh ghép có thể tháo rời\nKích thước: 83.0mm x 83.0mm x 70.0m', 'RB', 15, 'sp14.jpg', 0),
(16, 'Rubik Mirror 3x3 Silver ShengShou', '3x3', 190000, '1', '1', '...', '4+', 'Rubik Mirror 3x3x3 Silver ShengShou loại đẹp\nĐồ chơi Rubik không chỉ giúp người chơi có những giây phút thư giãn, giải trí với những vòng xoay tùy ý quanh chiếc rubik mà nó còn giúp người chơi, đặc biệt là trẻ em nâng cao khả năng tư duy và phát triển trí não.\nRubik là đồ chơi phù hợp với trẻ ở mọi độ tuổi để trẻ có thể chơi mọi lúc mọi nơi bởi kích cỡ và kiểu dáng nhỏ gọn, những chi tiết được xoay dễ dàng và cách chơi cũng vô cùng đơn giản. Đồ chơi Rubik có những lợi ích tiềm tàng vượt trội hơn những loại đồ chơi trí tuệ khác để bố mẹ có thể sẵn sàng mua cho con mình để phát triển trí não một cách tối đa.\n\n- Thiết kế với cấu trúc mới giúp giải nhanh, giải tốc độ.\n- Rubik xoay trơn, không kẹt, không rít\n- Độ bền cao\n- Chất liệu nhựa ABS an toàn, không độc hại\n- Rèn luyện trí nhớ, sự thông minh, sáng tạo và khéo léo. không chỉ giúp người chơi có những giây phút thư giãn, giải trí với những vòng xoay tùy ý quanh chiếc rubik mà nó còn giúp người chơi, đặc biệt là trẻ em nâng cao khả năng tư duy và phát triển trí não.\nRubik là đồ chơi phù hợp với trẻ ở mọi độ tuổi để trẻ có thể chơi mọi lúc mọi nơi bởi kích cỡ và kiểu dáng nhỏ gọn, những chi tiết được xoay dễ dàng và cách chơi cũng vô cùng đơn giản. Đồ chơi Rubik có những lợi ích tiềm tàng vượt trội hơn những loại đồ chơi trí tuệ khác để bố mẹ có thể sẵn sàng mua cho con mình để phát triển trí não một cách tối đa.\nThiết kế với cấu trúc mới giúp giải nhanh, giải tốc độ.\n\n- Rubik xoay trơn, không kẹt, không rít\n- Độ bền cao\n- Chất liệu nhựa ABS an toàn, không độc hại\n- Rèn luyện trí nhớ, sự thông minh, sáng tạo và khéo léo.', 'RB', 14, 'sp15.jpg', 0),
(17, 'Rubik Ghost 2x2 FangCun', '2x2', 450000, '1', '1', '...', '4+', 'Rubik là đồ chơi trí tuệ được giáo sư điêu khắc và kiến trúc sư người Hungary Erno Rubik sáng chế ra năm 1974 và đã trở thành món đồ chơi quen thuộc kể từ những năm 1980 đến nay. Cách chơi trò chơi này cũng rất đơn giản, người chơi chỉ cần xoay cho đến khi tất các mặt của rubik đều cùng 1 màu. Rubik Ghost 2x2 FangCun các tính năng sau:\n- Góc cạnh nhẵn để không gây nguy hiểm\n- Xoay trơn để giải nhanh\n- Hãng: FangCun\nKích thước: 60.0mm x 60.0mm x 60.0mm ', 'RB', 14, 'sp16.jpg', 0),
(18, 'Rubik Mirror Gold 2x2 ShengShou', '2x2', 180000, '1', '1', '...', '4+', 'Rubik là đồ chơi trí tuệ được giáo sư điêu khắc và kiến trúc sư người Hungary Erno Rubik sáng chế ra năm 1974 và đã trở thành món đồ chơi quen thuộc kể từ những năm 1980 đến nay. Rubik Mirror của BoardgameVN là phiên bản mới với cách chơi độc đáo, không chơi theo màu mà chơi theo hình dạng:\n\nMỗi khi xoay rubik, hình dạng của rubik sẽ thay đổi\nChỉ thành công khi rubik trở về hình dạng hình hộp ban đầu\nHãng: ShengShou', 'RB', 14, 'sp17.jpg', 0),
(19, 'Rubik Cylinder 3x3', '3x3', 130000, '1', '1', '...', '4+', 'Rubik là đồ chơi trí tuệ được giáo sư điêu khắc và kiến trúc sư người Hungary Erno Rubik sáng chế ra năm 1974 và đã trở thành món đồ chơi quen thuộc kể từ những năm 1980 đến nay. Cách chơi trò chơi này cũng rất đơn giản, người chơi chỉ cần xoay cho đến khi tất các mặt của rubik đều cùng 1 màu. Rubik Fisher của BoardgameVN mang các tính năng sau:\n\nGóc cạnh nhẵn để không gây nguy hiểm\nXoay trơn để giải nhanh\nCách chơi tương tự Rubik 3x3\nKích thước: đường kính 68.00mm', 'RB', 14, 'sp18.jpg', 0),
(20, 'Rubik Pyraminx - ShengShou', 'Other', 250000, '1', '1', '...', '4+', 'Cấu tạo của khối gồm 4 khối đỉnh có thể xoay độc lập với nhau, 6 khối cạnh và 4 khối cầu nối đỉnh và cạnh. Những khối cầu nối này đều có dạng bát diện đều và có 3 mặt lộ ra ngoài. Chúng kết nối với nhau tạo nên một khung cố định tại tâm của cả khối.', 'RB', 15, 'sp19.jpg', 0),
(21, 'Rubik Rhombohedron', 'Other', 350000, '1', '1', '...', '4+', 'Rubik là đồ chơi trí tuệ được giáo sư điêu khắc và kiến trúc sư người Hungary Erno Rubik sáng chế ra năm 1974 và đã trở thành món đồ chơi quen thuộc kể từ những năm 1980 đến nay. Cách chơi trò chơi này cũng rất đơn giản, người chơi chỉ cần xoay cho đến khi tất các mặt của rubik đều cùng 1 màu. Rubik Fisher của BoardgameVN mang các tính năng sau:\n\nGóc cạnh nhẫn để không gây nguy hiểm\nXoay trơn để giải nhanh\nHãng: Windtalker\n\nKích thước: 70.0mm x 70.0mm x 70.0mm ', 'RB', 15, 'sp20.jpg', 0),
(22, 'Rubik Rex Cube', 'Other', 220000, '1', '1', '...', '4+', 'Rubik là đồ chơi trí tuệ được giáo sư điêu khắc và kiến trúc sư người Hungary Erno Rubik sáng chế ra năm 1974 và đã trở thành món đồ chơi quen thuộc kể từ những năm 1980 đến nay. Cách chơi trò chơi này cũng rất đơn giản, người chơi chỉ cần xoay cho đến khi tất các mặt của rubik đều cùng 1 màu. Rubik Rex Cube của BoardgameVN mang các tính năng sau:\n\nGóc cạnh nhẫn để không gây nguy hiểm\nXoay trơn để giải nhanh\nBiến thể của Rubik 3x3\nHãng: Windtalkers\n\nKích thước: 60.0mm x 60.0mm x 60.0mm ', 'RB', 15, 'sp21.jpg', 0),
(23, 'Cờ Checkers Nam Châm (Cờ Đam)', 'Stragery', 240000, '2', '2', '60', '8+', 'Cờ đam hoặc checkers (tiếng Anh Mỹ) là một nhóm các trò chơi chiến lược trên bàn đối kháng cho hai người. Hai người lần lượt di chuyển các quân giống hệt nhau theo đường chéo và bắt quân đối phương bằng cách nhảy qua quân đó. Cờ đam phát triển từ cờ alquerque. Tên draughts của loại cờ này có nguồn gốc từ động từ mang nghĩa di chuyển.\nCác hình thức phổ biến nhất của cờ đam là cờ đam quốc tế, chơi trên một bàn cờ 10×10 và cờ đam Anh, còn được gọi là American checkers, chơi trên một bàn cờ 8×8, nhưng có rất nhiều biến thể khác chơi trên một bảng 12×12.\nChi tiết về cờ Checkers Nam Châm \nQuân cờ vây với hai màu đỏ trắng, kích thước vừa tay, cho bạn cảm giác cầm thoải mái cùng kích thước nhỏ gọn nên bạn có thể mang theo trong những chuyến đi chơi.\n\nBàn cờ kích thước 10x10 và gồm 40 quân cờ\nSản phẩm giúp trẻ định hình về tư duy logic đơn giản và phân biệt cơ bản về các trò chơi dân gian\nSản phẩm nhỏ gọn tiện lợi và dễ mang theo bên mình\nLà món quà vô cùng ý nghĩa để bạn dành tặng cho những người thân yêu xung quanh mình', 'CO', 15, 'sp22.jpg', 0),
(24, 'Cờ Tướng Nam Châm bỏ túi', 'Stragery', 100000, '2', '2', '60', '8+', 'Cờ Tướng là môn thể thao trí tuệ khá phổ biến ở Việt Nam, làm tăng khả năng tư duy logic của người chơi. Bất kỳ ai cũng nên hiểu về cách chơi để hiểu thêm về cờ tường, bởi cờ tướng có các chiến thuật di chuyển các quân cờ; qua đó giúp ta có nhiều chiêm nghiệm trong kinh doanh và cuộc sống.\n\n \n\nTrước đây cờ tướng chỉ giành cho các bậc cha chú có tuổi, tuy nhiên mấy năm gần đây giới trẻ đang tìm hiểu thêm về cờ tướng để học hỏi và giải trí. Bàn cờ tướng mini chính hãng Amalife tiện lợi, có thể giúp mọi người mang bất cứ đâu khi đi du lịch, đi chơi, hay rảnh rỗi; giúp thời gian của họ có giá trị hơn; đặc biệt là cho các fan của bộ môn trí tuệ này.!', 'CO', 14, 'sp23.jpg', 0),
(25, 'Cờ Vua Nam Châm Chất Lượng Cao', 'Stragery', 240000, '2', '2', '60', '8+', 'Cờ Vua Nam Châm Chất Lượng Cao \n- Bàn cờ vua nam châm là trò chơi giải trí đơn giản nhưng vui nhộn và trí tuệ, phù hợp với mọi lứa tuổi. Bộ sản phẩm sẽ giúp bạn có thể giải trí với môn cờ thú vị này. \nNhững quân cờ được cất bên trong bàn cờ khi gấp lại thành hộp, có khóa cài giúp bạn bảo quản tốt, tránh thất lạc.\nVới trò chơi vô cùng đơn giản nhưng cũng vô cùng hấp dẫn này bạn sẽ có những giây phút thoải mái. Trò chơi phù hợp với nhiều đối tượng và bạn có thể chơi trong bất cứ thời gian rãnh rỗi của mình.\n32 quân cờ đế nam châm hút chặt, tránh bị rơi rớt hay dịch chuyển khi chơi.\nĐược chạm khắc sắc nét gồm 2 màu vàng bạc nổi bật.\nThiết kế bàn cờ nhỏ gọn, dạng hộp gập để đựng quân cờ.\nĐộ bền chắc chắn, phù hợp chơi lâu dài.\nSản phẩm là trò chơi giải trí đơn giản nhưng vui nhộn và trí tuệ, phù hợp với mọi lứa tuổi.\n#Bàn #cờ làm bằng nhựa cứng HIPS\nMở ra làm bàn, đóng lại là hộp đựng\n#Quân #cờ có nam châm bàn từ tính giúp quân cờ không bị xê dịch\nBề mặt màu được xử lý không bị bong tróc, phai mờ\nKích thước :\n????Bàn TO 4912A \n- KT: 2.2(Dày) × 36(Rộng) × 36(Dài) cm \n- Bàn nặng : 0.8kg \n????Bàn TB 4812A :\n- KT: 2.2(Dày) × 32(Rộng) × 32(Dài) cm \n- Bàn nặng : 0.8kg \n- Quân cờ cao : 6cm\n????Bàn NHỎ MINI 3810A \n- KT :2.2(Dày) × 25.5Rộng) × 25(Dài) cm\n- Bàn nặng : 0.5kg \n- Quân cờ cao : 5cm\n????Bàn nhỏ mini: 1510A\n- KT :1.8(Dày) × 16.5Rộng) × 16.5(Dài) cm\n- Bàn nặng : 0.2kg\nHộp nhựa khá dày dặn và nặng. Từ 440gram - 820 gram', 'CO', 15, 'sp24.jpg', 0),
(26, 'Cờ Domino đen cao cấp', 'Stragery', 65000, '2 - 4', '4', '60', '5+', 'Cờ Domino là một trò chơi đơn giản và phổ biến trên thế giới dành cho 2 – 4 người chơi. Quân cờ được làm bằng nhựa đen cao cấp và được phủ lớp sơn bóng bảo vệ bên ngoài. Kiểu dáng sang trọng, có hộp nhựa bảo quản trong suốt.\nMang đến cho bạn những giây phút vui chơi thỏa thích cùng bạn bè, người thân.\nKích thước nhỏ gọn, giúp bạn có thể mang theo trong những chuyến đi chơi.\nDomino là trò chơi nổi tiếng trên thế giới bởi luật chơi đơn giản nhưng lại mang đầy tính trí tuệ, rất phù hợp với các bạn dân văn phòng. Hãy sở hữu ngay Bộ cờ Domino bằng gỗ phít xinh xắn mà BoardgameVN mang đến hôm nay để có những giây phút thư giãn thật thoải mái sau một ngày làm việc vất vả bên gia đình và người thân bạn nhé!\nBộ cờ gồm 28 quân cờ, mỗi quân cờ có kích thước (4 x 2 x 0.3 cm) nhỏ gọn, cho bạn dễ dàng chơi cùng người thân, bạn bè. Quân cờ được làm bằng nhựa đen cao cấp và phủ lớp sơn bóng bảo vệ bên ngoài rất bền đẹp, với cách chạm khắc tinh xảo, đẹp mắt. Kiểu dáng sang trọng, hộp đựng bằng nhựa trong suốt bền đẹp. Domino có luật chơi đơn giản, mang đến cho bạn và người thân những giây phút thư giãn thật thoải mái, vui tươi.', 'CO', 12, 'sp25.jpg', 0),
(27, 'Connect 4 - Cờ Thả', 'Stragery', 180000, '2', '2', '15', '6+', 'Connect Four là một biến thể của cờ Caro, phiên bản 3D và thú vị hơn nhiều. Luật chơi đơn giản có thể học trong 15 giây nhưng có thể chơi hàng giờ đồng hồ! Bàn cờ được đặt thẳng đứng theo chiều dọc. Người chơi thả các quân cờ vào một trong 7 hàng dọc, mỗi hàng chứa được 6 quân. Người nào đạt được 4 quân cờ nối liền nhau theo chiều ngang, dọc hoặc chéo sẽ chiến thắng. Trò chơi trí tuệ thú vị dành cho 2 người ở  mọi lứa tuổi.', 'CO', 14, 'sp26.jpg', 0),
(28, 'Cờ Shogi', 'Stragery', 220000, '2', '2', '60', '8+', '“Cầm, kì, thi, họa” là những thú vui tao nhã của các bậc hiền triết xưa. Trong 3 thú vui đó, chỉ riêng cờ là làm người ta nhất định phải phân thắng bại, có thể khiến người ta cay cú khi thua và vui mừng khi chiến thắng. Đặc biệt, ở Nhật, cờ shougi là loại phổ biến từ xưa đến nay. Với lối chơi độc đáo và luật có- một – không- hai, shougi thực sự đã hút rất nhiều sự quan tâm của tất cả mọi người Nhật ở mọi lứa tuổi.\n\nCách chơi shougi về cơ bản cũng giống với cờ tướng, tuy nhiên vẫn có vài điểm khác biệt.\n\nMỗi người chơi có một bộ quân gồm 20 quân kích cỡ gần giống nhau, bao gồm: 1 Vua, 1 Xe, 1 Giác, 2 Kim, 2 Ngân, 2 Mã, 2 Hương xa và 9 Tốt. Quân của 2 người chơi không khác nhau về màu sắc, thay vì vậy mỗi quân có hình dạng như mũi tên và hướng về phía trước, đối diện với đối phương. Nhìn hướng của quân sẽ biết quân đó thuộc bên nào.\n\nCách đi của các quân cờ như sau:\n\n- Vua có thể đi một ô theo mọi hướng.\n\n- Kim đi được một ô theo hình dấu cộng và 2 ô chéo phía trước.\n\n- Ngân đi được một ô theo hình dấu nhân và 1 ô thẳng phía trước.\n\n- Giác có thể đi bốn hướng đường chéo cho đến khi gặp một quân cản.\n\n- Xe có thể đi ngang dọc tùy ý cho đến khi gặp 1 quân cản.\n\n- Mã nhảy theo hình chữ L dọc về phía trước (chỉ có 2 hướng đi), có thể nhảy qua các quân khác.\n\n- Hương xa chỉ có thể tiến tùy ý theo hàng dọc trước khi gặp 1 quân cản.\n\n- Tốt chỉ đi thẳng 1 ô về phía trước.\n\nĐặc biệt, các quân Tốt, Hương xa, Mã, Xe, Giác, Ngân khi đến hàng thứ 3 bên đối phương thì sẽ được phong cấp thành Kim, tức là các quân đó sẽ đi như quân Kim. Còn Xe và Giác thì phong cấp thành Rồng: giữ cách đi cũ và thêm cách đi của Vua.\n\nTrong shougi thì các quân đi như thế nào thì ăn như thế. Các quân bị ăn có thể được thả lại vào trong bàn cờ như là một quân của người đã bắt nó. Khi đến lượt, thay vì đi quân hiện có trên bàn cờ, người chơi có thể đưa một quân bị bắt từ trước và đặt chúng (dưới dạng chưa phong cấp) ở bất kỳ ô nào còn trống. Quân được thả, kể từ đó, trở thành một quân của người chơi đó. Đây cũng là một luật độc đáo của shougi: thả quân.\n\nKhi một kỳ thủ đi một nước dọa bắt Vua đối phương ở nước đi tiếp theo, nước đi đó gọi là nước \"chiếu”. Nếu một Vua đang bị chiếu và không có nước đi hợp lệ nào để thoát khỏi thì nước chiếu đó được gọi là \"chiếu hết\" và người chiếu hết thắng ván cờ.\n\nCảm giác khi chơi shougi rất mới lạ. Ban đầu bạn sẽ phải vắt hết chất xám để có thể nhớ hết mặt các quân cờ. Nhớ được quân cờ, còn phải nhớ về “phong cấp” của nó và hướng đi. Nhất là cách đi của Kim và Ngân rất dễ gây nhầm lẫn vì thực chất 2 quân đó đi trái ngược nhau. Sau giai đoạn thử thách trí nhớ đó, chơi thử vài ván thì bạn sẽ chợt nhận ra mình bị cuốn vào shougi lúc nào không hay. “Thế cờ vậy vì mình biết đi thế nào?”, “Sao đối phương lại đi như vậy?”,... Bạn sẽ phải suy tính mọi khả năng cùng đường đi nước bước của đối thủ, thậm chí còn phải để ý cả tù binh vì shougi còn có luật “thả quân”. Trông có vẻ dễ đấy, nhưng chỉ cần một phút lơ đễnh là bạn cầm chắc chiến bại. Vì vậy phải cẩn thận đến từng li từng tí, đi một bước phải suy được các bước tiếp theo. Đó cũng là điểm hấp dẫn, thu hút người chơi của shougi.\n\nCuộc chiến trên bàn cờ shougi thực chất là cuộc tranh đoạt vàng (kim) với bạc (ngân). Thắng 1 ván cờ như giành được cả thiên hạ vào tay. Vậy bạn đã sẵn sàng đương đầu với kẻ thù để thâu tóm về tay mình kho báu cùng thiên hạ chưa?', 'CO', 15, 'sp27.JPG', 0),
(29, 'Cờ Tỷ Phú Việt Nam', 'Roleplaying', 530000, '2 - 6', '4', '60 - 120', '6+', 'Cờ Tỷ Phú là một trò chơi truyền thống lâu đời ở Việt Nam, như một món ăn tinh thần không thể thiếu của mỗi gia đình. Vào những lúc rảnh rỗi, mọi người bày Cờ Tỷ Phú ra chơi, vừa có được niềm vui, vừa gắn kết các mối quan hệ nhiều hơn. Cờ Tỷ Phú được đánh giá là 1 trong 10 trò chơi mang lại nhiều trí tưởng tượng và phát triển tư duy cho người chơi.\n\nĐặc biệt, Đối với bố mẹ thì đây là món quà rất ý nghĩa trong việc dạy trẻ tự lập, rèn cho trẻ trí thông minh để khởi đầu một tương lai mới. Kích thích tư duy, huấn luyện trí óc nhanh nhạy, thông minh cho trẻ. Nhờ đó trẻ sẽ bước đầu học được cách đầu tư làm giàu từ chính bộ cờ này.\nTrên thị trường hiện nay có rất nhiều phiên bản Cờ Tỷ Phú xuất hiện, song vì còn nhiều bất cập ở chúng như việc sai luật, hình ảnh không bản quyền, chất lượng thành phần, vẫn chưa đáp ứng thực sự nhu cầu người chơi. Đó cũng chính là động lực để BoardgameVN nghiên cứu, tạo nên một bộ Cờ Tỷ Phú hoàn thiện nhất có thể!\n\nPhiên bản Cờ Tỷ Phú Việt Nam mới nhất này mang đậm nét văn hóa của Việt Nam, khi đưa các địa danh thân yêu của chúng ta vào mỗi cạnh của bàn cờ. Người chơi như du lịch một vòng của đất nước hình chữ S xinh đẹp để chiêm ngưỡng thắng cảnh. Những Phố Cổ, Chợ Đồng Xuân, Tháp Rùa, Vịnh Hạ Long, Sơn Đòong, Hội An, Chợ Bến Thành, đều được thể hiện sống động trên từng ô vuông và các lá bài rõ nét.\n\nChất lượng thành phần trong bộ đặc biệt này đạt chất lượng tốt và đã được kiểm duyệt hoàn hảo. Bạn sẽ không cần phải lo lắng về độ an toàn của sản phẩm nữa.\n\nVới Cờ Tỷ Phú, người chơi sẽ phải biết đầu tư mua đất, xây nhà hay kinh doanh để kiếm thu nhập từ số vốn ban đầu. Rồi những cơ hội may mắn như được thưởng tiền, lãnh tiền lãi ngân hàng hay thu tiền phạt người khác hoặc những dịp không may như bị ở tù, đóng phạt khi vào đất người khác, bị thu thuế… Chơi “cờ tỷ phú” không đòi hỏi người ta phải thắng tuyệt đối mà nó cần trí tuệ để thắng đối phương 1 cách “đẹp” theo đúng nghĩa, tức là khôn khéo khi chơi. Nó yêu cầu người chơi phải tư duy, tính toán cẩn thận và cộng thêm may mắn, nếu không sẽ “sạt nghiệp” đấy. Cờ Tỷ Phú Việt Nam giúp bạn và trẻ trở thành giàu có tích luỹ được nhiều tài sản và sử dụng đồng tiền mặt hiệu quả.\n\nTHÀNH PHẦN:\n\n- Bàn cờ\n\n- 6 huy hiệu\n\n- 28 thẻ đất\n\n- 16 thẻ cơ hội\n\n- 16 thẻ khí vận\n\n- 32 nhà\n\n- 12 khách sạn\n\n- 2 xúc xắc\n\n- Tiền: Rất nhiều tiền\n\nCờ Tỷ Phú Việt Nam\n\nCÁCH CHƠI CƠ BẢN:\n\n- Trải bàn đồ, chọn huy hiệu đại diện người chơi, đặt tại ô BẮT ĐẦU\n\n- Chìa tiền: Mỗi người 1,500đ gồm có: 5 từ 1đ, 1 tờ 5đ, 2 tờ 10đ, 1 tờ 20đ, 1 tờ 50đ, 4 tờ 100đ, 2 tờ 500đ, phần tiền còn lại dùng làm ngân hàng, nếu bạn muốn chơi nhanh thì setup chia mỗi người 2,500đ\n\n- Trộn thẻ Khí Vận và đặt úp xuống trên bản đồ\n\n- Trộn thẻ Cơ Hội và đặt úp xuống trên bản đồ\n\n- Chọn 1 người làm ngân hàng để quản lý Tiền ngân hàng, Nhà, Khách sạn, Giấy đất đấu giá. Người làm ngân hàng vẫn có thể  chơi cùng và sẽ có tiền riêng để chơi như người chơi bình thường.\n\n- Sử dụng xúc xắc để chơi và xác định số ô di chuyển: Di chuyển trên bàn cờ và mua càng nhiều đất càng tốt, có nhiều đất bạn sẽ có khả năng thu tiền phạt  cao hơn. Khi di chuyển đến ô đất, dựa trên số tiền bạn đang có, bạn quyết định mua ô đất đó thì nó sẽ thành tái sản sở hữu của bạn, khi người chơi khác đi vào đất của bạn, họ phải trả thuế đất theo số tiền hiện thị trên ô đất đó.\n\n-  Trò chơi kết thúc khi chỉ còn duy nhất một người không bị phá sản.\n\nLưu ý: Để ván chơi được nhanh gọn thì không nên dùng luật tự chế nhé.\n\nGiá sản phẩm trên Tiki đã bao gồm thuế theo luật hiện hành. Tuy nhiên tuỳ vào từng loại sản phẩm hoặc phương thức, địa chỉ giao hàng mà có thể phát sinh thêm chi phí khác như phí vận chuyển, phụ phí hàng cồng kềnh, ...', 'CO', 15, 'sp28.jpg', 0),
(30, 'Cờ Vây To Nam Châm', 'Stragery', 240000, '2', '2', '30 - 45', '8+', 'Cờ Vây là một trong những trò chơi board game cổ xưa nhất của nhân loại. Cờ vây có luật chơi đơn giản và chiến thuật cực kỳ sâu sắc. Mỗi lượt bạn đặt một viên cờ vào một giao điểm trên bàn cờ. Nếu vây bắt được quân của đối thủ, bạn ăn tất cả chúng và được điểm tương ứng. Cuối trò chơi người nào có nhiều điểm nhất thắng.\n\nVới Cờ Vây phiên bản to bạn có thể dễ dàng thoải mái đặt từng viên cờ mà không cần lo lắng chúng chạm vào nhau gây xáo trộn. ', 'CO', 15, 'sp29.jpg', 0),
(31, 'Yêu Nhầm F.A', 'Cardgame', 200000, '3 - 8', '5 - 8', '10 - 20', '13+', 'Yêu nhầm FA - Board game tình yêu đầu tiên mà FA là TRÙM cuối!\n \n \nYêu Nhầm F.A là  board game nhập vai, người chơi sẽ là những người đang yêu, phải cùng nhau vượt qua các Thử Thách trên con đường tình yêu. \nTuy nhiên Thử thách không phải là điều duy nhất cản trở các cặp đôi, mà đó chính là F.A. Ai bắt cặp với F.A, người đó cũng sẽ có số phận hẩm hiu như họ. Vậy, ai là F.A? \nCùng đoán xem..!\n \nThành phần game:\n- 85 Card Tài nguyên\n- 18 card action \n- 36 card thử thách\n- 8 card nhân vật\n- 104 token tim (Mỗi màu có 13 tim)\n- Sách hướng dẫn\n \nTrong game, người chơi sẽ cùng nhau giải quyết các lá bài thử thách  từ khó đến dễ dựa trên những lá bài tài nguyên của mình và của đồng đội. Game kết thúc khi người chơi giải quyết được lá bài ở  giữa của cột thử thách cuối cùng hoặc người chơi hết lá bài tài nguyên. \n \nDự trên điểm chơi để tính ra người thắng cuộc và phe thắng cuộc. Nếu bàn chơi có ít nhất 2 người đủ hoặc nhiều hơn số điểm yêu cầu thì phe người đang yêu thắng, nếu không FA thắng.\n \nNhiệm vụ của FA là ngăn cản người chơi vượt qua thử thách cuối cùng do hết tài nguyên để bốc hoặc hết cả tài nguyên trên tay hoặc người thường giải quyết được thử thách cuối cùng như không có ai đủ điểm yêu cầu để chiến thắng. \nFA được tham gia tối đa 7 thử thách, nếu tham gia quá 7 thử thác thì từ thử thách thứ 8  thì phe người đang yêu vẫn được tính điểm bình thường. Trong 7 thử thách đầu, phe người đang yêu sẽ bị mất điểm khi đi chung cùng FA\n \nCó 3 Mode chơi:\n- Mode tính điểm\n- Mode tình thân\n- Mode đối kháng\n \nCùng trải nhiệm ngay board game mới nhất siêu hot này!', 'BG', 14, 'sp30.jpg', 0),
(32, 'Ma Sói Pikalong', 'Horror', 150000, '8 - 40', '11 - 15', '30 - 60', '10+', 'Chào mừng Pikalong gia nhập vũ trụ Ma Sói!\nMột siêu phẩm kết hợp đặc biệt từ Board Game VN và Thăng Fly Comics.\n\nPhiên bản giới hạn đặc biệt, có sự góp mặt của 12 nhân vật đến từ thế giới Pikalong có chức năng vô cùng bá đạo, mạnh mẽ: Pikalong, Long nữ, Mập, Heo Hồng, Mẹ Pikalong, Thầy Hổ... Trận chiến không có hồi kết giữa Dân Làng và Sói có thêm rất nhiều sức mạnh và chia đều cho cả 2 bên: Pikalong - Gà Con Lớp Trưởng - Thầy Hổ - ..v...v tăng cường sức mạnh cho dân làng trong việc tranh luận, và tiêu diệt Sói. Ngược lại, Mập, Công Tím, Gấu Ngậu hỗ trợ cho những con Sói, bắt nạt những người dân hiền lành tốt bụng.\n\nLiệu rằng cái thiện sẽ dành chiến thắng, hay những kẻ bắt nạt, xấu xa sẽ xóa sổ ngôi làng này?\n\nChính các bạn là người quyết định số phận của ngôi làng bằng những phiếu bầu quan trọng.\n\nTrò chơi cũng bao gồm phiên bản Ma Sói gốc: 48 lá nhân vật và 36 lá sự kiện. Bộ Ma Sói này đầy đủ và độc đáo hơn bất kỳ bộ Ma Sói nào mà các bạn từng biết.\n\nQuà đặc biệt cho các bạn: 1 Sticker 12 nhật vật Pikalong đi kèm bộ Game khi mua!', 'BG', 15, 'sp31.jpg', 0),
(33, 'Harry Potter - Hogwarts Battle (ENG)', 'Wargame', 750000, '2 - 4', '4', '30 - 60', '11+', 'Thế lực hắc ám đang đe dọa tấn công ngôi trường phù thủy Hogwarts trong bộ boardgame Harry Potter: Hogwarts Battle. Sự an nguy của ngôi trường nằm trong tay bốn phù thủy sinh bằng cách đánh bại những kẻ xấu và củng cố lớp phòng ngự của trường. Trong trò chơi, người chơi đóng vai một phù thủy sinh: Harry, Ron, Hermione hoặc Neville, mỗi nhân vật có một bộ thẻ bài riêng biệt có thể sử dụng để thu thập các tài nguyên.\n\n\n\nBằng cách giành ảnh hưởng của mình, người chơi nhận thêm thẻ bài vào bộ bài dưới dạng các nhân vật nổi tiếng, các bùa chú và các vật phẩm ma thuật. Những  thẻ bài khác cho phép họ tăng thêm sức mạnh hoặc chiến đấu với kẻ thù. Đội quân kẻ xấu luôn tìm cách cản trở người chơi bằng sức mạnh và nghệ thuật hắc ám của chúng. Chỉ khi phối hợp cùng nhau, những người chơi mới có thể đánh bại tất cả kẻ thù, bảo vệ thành công ngôi trường của mình khỏi thế lực hắc ám', 'BG', 15, 'sp32.jpg', 0),
(34, 'Betrayal At House On The Hill (ENG)', 'Horror', 550000, '3 - 6', '5 - 6', '60', '14+', 'Betrayal at house on the hill là một game thuộc thể loại nhập vai, co-op mang hơi hướng phiêu lưu, sinh tồn. Nhiệm vụ của bạn là khám phá 1 căn nhà bỏ hoang ở trên đồi, nơi chứa bao điều bí ẩn khủng khiếp mà mỗi lần chơi lại là một câu chuyện khác nhau. Bạn không biết điều gì sẽ xảy đến với mình, vì mỗi lần chơi, thứ tự các căn phòng lại khác nhau, cũng như những lá bài Sự kiện, Điềm báo hay Vật Phẩm cũng không giống như trước.\n\n \n\nNgoài ra, game đã kết hợp nhuần nhuyễn những yếu tố kinh dị đã làm nên thương hiệu của điện ảnh Hollywood những năm 90 cho đến nay như những câu chuyện ma báo thù, quái vật không gian, những tên sát nhân khát máu hay một thảm họa chết người,... vì thế nếu là fan của thể loại này thì đây là game mà bạn không thể bỏ qua.\n\n \n\nGame được sáng tạo bởi nhà phát hành Avalon Hill, nhà phát hành nổi tiếng với các tựa game Axis&Allies, Aquire,... Được sáng tạo bởi Mike Selinker, game ra mắt lần đầu tiên vào năm 2004, sau đó một bản update reprint đã được phát hành vào năm 2010, điều chỉnh lại và thay đổi một số cốt truyện để game được hoàn thiện hơn.\n\n \n\nAvalon Hill đã phát hành thêm bản mở rộng cho game có tên: Widow’s walk vào năm 2016 và 1 bản game mới theo phong cách Legacy: Betrayal Legacy vào năm 2018.', 'BG', 14, 'sp33.jpeg', 0),
(35, 'Unstable Unicorns', 'Cardgame', 350000, '2 - 8', '4 - 5', '30 - 45', '14+', 'Xây dựng một đội quân kỳ lân. Phản bội bạn bè của bạn. Kỳ lân là bạn của bạn bây giờ.\n\nKỳ lân không ổn định là một trò chơi bài chiến lược về tất cả mọi người Hai điều yêu thích: Phá hủy và Kỳ lân!\n\nTừ mặt sau của hộp:\n\nTìm hiểu làm thế nào không ổn định tình bạn của bạn thực sự là.\n\nBạn bắt đầu với một con Kỳ lân trong chuồng ngựa của bạn. VÌ CẮT!\n\nNhưng đừng quá gắn bó, bởi vì ngay cả Baby Unicorns cũng không an toàn trong trò chơi này! Có hơn 20 Kỳ lân phép thuật để thu thập, và mỗi người có một sức mạnh đặc biệt. Xây dựng Quân đội Kỳ lân của bạn nhanh nhất có thể, hoặc bị phá hủy bởi một trong những người bạn được gọi là của bạn! Tìm cách trả thù hoặc bảo vệ sự ổn định của bạn bằng Phép thuật của bạn! Nghe có dễ không? Không quá nhanh. Ai đó có thể có Thẻ Neigh (Nhận nó? Neigh?) Và gửi trò chơi vào MADNESS! Người đầu tiên hoàn thành Quân đội Kỳ lân của họ sau đây sẽ được gọi là Người cai trị chính nghĩa của tất cả mọi thứ phép thuật ... ít nhất là cho đến trò chơi tiếp theo. Chúc may mắn.\n\nBộ bài bao gồm: 135 thẻ và sách quy tắc', 'BG', 14, 'sp34.jpg', 0),
(36, 'King of Tokyo (US)', 'Stragery', 1150000, '2 - 6', '4 - 5', '30', '8+', 'Trong King of Tokyo, bạn sẽ đóng vai những quái vật đột biến, rô bốt khổng lồ hay những người ngoài hành tinh – tất cả những kẻ đang phá hủy thành phố Tokyo và tìm cách tiêu diệt đối thủ của mình để trở thành vị vua duy nhất của Tokyo!\n\nĐầu mỗi lượt, bạn sẽ tung 6 xúc xắc, với 6 biểu tượng: 1, 2, 3 điểm chiến thắng, năng lượng, máu và tấn công. Trong 3 lượt tiếp đó, chọn giữ hoặc bỏ mỗi xúc xắc để tăng điểm chiến thắng, tăng năng lượng, hồi máu hoặc tấn công người chơi khác – khẳng định rằng Tokyo là lãnh thổ của riêng bạn.\n\nNgười chơi hung tợn nhất sẽ chiếm được Tokyo, giành thêm điểm chiến thắng, nhưng không được hồi máu và phải đối mặt với toàn bộ quái vật khác một mình.\n\nĐiều hay nhất trong trò chơi này là những thẻ bài đặc biệt bạn có thể mua được với năng lượng của mình. Các thẻ bài sẽ đem lại những năng lực tức thời hoặc vĩnh viễn, ví dụ như mọc thêm một đầu quái vật – cho phép bạn có thêm 1 xúc xắc, giáp bảo hộ, tia hủy diệt, và nhiều điều khác nữa.\n\nĐể trở thành người chiến thắng trong King of Tokyo, bạn sẽ phải hủy diệt thành phố này bằng việc đạt được 20 điểm chiến thắng, hoặc là con quái vật duy nhất còn sống khi cuộc chiến kết thúc!', 'BG', 14, 'sp35.jpg', 0),
(37, 'Bài UNO Mini', 'Cardgame', 45000, '2 - 10', '2 - 8', '20 - 30', '6+', 'Bộ bài có 108 lá, nặng 0.2kg\nLá bài dày, màu sắc đẹp\nGiá rẻ\nLuật chơi đơn giản, dễ hiểu, hứa hẹn nhiều thú vị.\nCó thể chơi từ 2-10 người, mỗi lượt chơi khoảng 30 phút', 'BG', 15, 'sp36.png', 0),
(38, 'Tam Quốc Sát - Quốc Chiến - Yokagames', 'Stragery', 440000, '4 - 12', '6 - 8', '30 - 60', '10+', 'TAM QUỐC SÁT - QUỐC CHIẾN PHIÊN BẢN VIỆT HÓA TỪ YOKAGAMES\nTrong thời kỳ tam quốc, loạn thế liên miên, chiến tranh không dứt. Các đại thế lực đã bắt đầu hình thành, các tiểu thế lực cũng bắt đầu tìm đến nhau, nhen nhóm thay đổi trật tự thế giới. Thời thế tạo anh hùng, các vị kiêu vương mãnh tướng bắt đầu xuất hiện tạo nên một thế giới Tam Quốc Diễn Nghĩa đầy màu sắc oanh liệt và bi tráng. Những mãnh tướng như Quan Vũ, Lữ Bố, Trương Phi, Triệu Vân,... Những người nắm trong tay vận mệnh đế vương Lưu Bị, Tào Tháo, Tôn Quyền,... đều trở nên sống động trong một card game cực nổi tiếng - Tam Quốc Sát.\n\n \n1. Tam Quốc Sát - Hiện tượng Card game 2015.\n \nTam Quốc Sát là một card game được tác giả Kayak ra mắt vào năm 2010 và do Yokagames phát triển tiếp. Năm 2015, trò chơi bắt đầu được mọi người hưởng ứng và trở nên nổi tiếng đồng thời được độc giả bình chọn danh hiệu Board Game hay nhất năm.\nTam Quốc Sát du nhập vào Việt Nam năm 2015, nhanh chóng trở nên nổi tiếng bởi cách chơi khá giống Bang! nhưng ẩn sâu trong đó là tính chiến thuật cực cao khiến người chơi vô cùng kích thích bởi tính gây nghiện của nó.\n\nTam Quốc Sát - Quốc Chiến.\nPhiên bản Quốc Chiến là phiên bản mới nhất của TQS và được việt hóa 100% cực chuẩn bởi BoardgameVN, bao gồm cả bản mở rộng “Quân lâm thiên hạ - Biến”.\n\n2. CỐT TRUYỆN.\n\n Tam Quốc Sát - Quốc CHiến lấy bối cảnh thời kì chiến tranh loạn lạc sau khi nhà Hán bị suy tàn, các thế lực nổi lên tranh dành thiên mệnh, thống nhất thiên hạ. Các thế lực chính vẫn được giữ nguyên như Tam Quốc Diễn Nghĩa của La Quán Trung: Ngụy - Ngô - Thục - Quần Hùng.\nDù là mục tiêu thống nhất thiên hạ hay phục hưng nhà Hán thì cũng chỉ có 1 cách, “sát” hết tất cả thế lực khác mình. “Mưu sự tại nhân - Thành sự tại thiên”, “kẻ thắng làm vua kẻ thua làm giặc” đơn giản nhưng mưu lược vô cùng.\nGame sẽ tái hiện chân thực nhất cho bạn những cuộc chiến thư hùng thời tam quốc diễn nghĩa.', 'BG', 15, 'sp37.jpg', 0),
(39, 'Scythe (US)', 'Stragery', 2500000, '1 - 5', '4', '90 - 115', '14+', 'Đó không phải là tuyết, đó là tro tàn. Tro tàn rơi xám xịt, phủ kín những vùng đất lạnh giá. Tro tàn từ cuộc chiến tranh vĩ đại giữa các cường quốc vừa kết thúc, để lại một một khung cảnh đổ nát, tan hoang. Thành phố trung tâm, nơi được gọi là Nhà máy, đã “bế quan tỏa cảng”, trở thành mục tiêu của các quốc gia xung quanh. Nơi đây chứa đựng nhiều kỹ thuật công nghệ tân tiến, và kẻ nào đặt chân được tới đây trước sẽ là người sở hữu chúng, giúp ích đắc lực cho công cuộc cải tạo đất nước sau chiến tranh và vươn lên trong cuộc chạy đua vũ trang cam go hậu Thế chiến này.\nNhưng hậu quả của chiến tranh rất khốc liệt, và giờ đây, với cương vị là người lãnh đạo quốc gia, bạn có rất nhiều việc phải làm, không chỉ tiến về nhà máy. Bạn phải cố gắng vực dậy tinh thần người dân, để họ tiếp tục làm việc và sản xuất, đẩy mạnh công cuộc cải tiến công nghệ và chạy đua vũ trang để sẵn sàng cho những cuộc đụng độ “không mong muốn” với những quốc gia hàng xóm không mấy thân thiện. \nVới sự giúp đỡ từ lực lượng Mech - những robot cơ khí to lớn, vừa có thể hoạt động như một phương tiện di chuyển, vừa được vũ trang để phục vụ mục tiêu quân sự nếu cần - quá trình phục hồi sẽ diễn ra nhanh chóng thôi. Quốc gia của bạn sẽ sớm có được những vùng đất mới để canh tác, lương thực và vũ khí sẵn sàng, và trên hết, ngân khố rủng rỉnh.\nNhưng điều quan trọng là làm thế nào để duy trì được trạng thái đó mới là một bài toán khó, khi bạn luôn phải vừa giữ được mến mộ của dân chúng, vừa cố gắng mở rộng tầm ảnh hưởng của mình. Bạn là một người lãnh đạo yêu hòa bình, một kẻ bạo chúa hay một nhà ngoại giao xảo quyệt… điều đó tùy thuộc vào bạn, miễn là cho đến cuối cùng, quốc gia của bạn vẫn có tiềm lực kinh tế mạnh nhất trong khu vực, thì bạn là người chiến thắng!', 'BG', 18, 'sp38.png', 0),
(40, 'Cry Havoc (US)', 'Stragery', 1700000, '2 - 4', '4', '90', '10+', 'Hãy tưởng tượng một hành tinh xa xôi đặt trong một vũ trụ viễn tưởng tương lai. Ba phe phái riêng biệt đã đến hành tinh để tìm kiếm các tinh thể có giá trị của nó, trong khi phe thứ tư cố gắng bảo vệ thế giới tự chế của mình khỏi những kẻ xâm lược xa xôi này. Thông qua chiến đấu và chiến thuật cơ động mỗi người chơi cố gắng giành quyền kiểm soát các vùng giàu tinh thể, và giành càng nhiều đất càng tốt.\nCry Havoc là một trò chơi kiểm soát vùng bằng thẻ với bốn phe phái không cân xứng. Máy móc, con người, những người hành hương, và những con Trogs bản địa. Mỗi phe có một đặc điểm khác nhau từ các khả năng, các đội quân, đến các cấu trúc có thể xây dựng, và như một lối chơi khác nhau.', 'BG', 23, 'sp39.jpg', 0),
(41, 'The Sea Battle', 'Wargame', 150000, '2', '2', '30', '8+', 'THE SEA BATTLE hay Battle Ship là trò chơi đối kháng dành cho 2 người chơi, trong trò chơi người chơi sẽ sắp xếp các chiến hạm trên biển sau đó sẽ phán đoán vị trí chiến hạm của đối phương để bắn hạ. Người chơi nào bắn hạ toàn bộ chiến hạm đối phương sẽ giành chiến thắng.\r\n\r\nThành phần:\r\n\r\n2 bảng người chơi có thể lật lên.\r\n\r\n2 Bộ chiến hạm\r\n\r\n2 Bộ đánh dấu màu cam\r\n\r\n4 Bộ đánh dấu màu trắng', 'BG', 14, 'sp40.jpg', 0),
(42, 'Monopoly Game of Thrones (ENG)', 'Stragery', 750000, '2 - 6', '4 - 6', '60', '18+', 'Cuộc đua giành quyền kiểm soát Westeros đang diễn ra với trò chơi Monopoly đặc biệt hoàn toàn mới này. Với tác phẩm nghệ thuật từ các bộ phim truyền hình ăn khách và các làng và làng chơi được chế tác đẹp mắt, đó là một trò chơi dành cho bất kỳ người sành chơi nào trong bảy vương quốc.\r\n\r\nXin lưu ý rằng đây là \'phiên bản tiêu chuẩn\' không phải là phiên bản Deluxe của trò chơi cờ này', 'BG', 19, 'sp41.jpg', 0),
(43, 'Bài Tỷ Phú', 'Cardgame', 150000, '2 - 5', '3 - 5', '15', '8+', 'Bài Tỷ Phú đã trở lại với phiên bản card game vừa quen thuộc mà vừa mới mẻ! Trong Bài Tỷ Phú, mục tiêu của bạn là hoàn thành 3 bộ khu đất khác màu nhau, người nào hoàn thành trước sẽ thắng. Mỗi lượt bạn chơi tối đa 3 lá bài trên tay, có thể để tạo ra khu đất hoặc tăng tiền trong ngân hàng hoặc chơi lá bài Action. Nếu bạn hoàn thành một khu đất, bạn có thể thu tiền những người chơi khác nếu có lá Action thích hợp. Bên cạnh đó còn nhiều thẻ chức năng thú vị khác như lấy một bộ khu đất của người chơi khác, trao đổi đất, sinh nhắt thu mỗi người tiền, thu thuế một người,... \n\nBạn cần cân bằng giữa tiền trong ngân hàng và mục tiêu mua khu đất, mỗi lá bài trên tay sẽ mang đến một chiến thuật nhất định. Nhiều chiến thuật hơn, nhiều lựa chọn hơn, nhiều tương tác hơn - Monopoly Deal là một sự cải cách thành công của phiên bản trước nó. Nếu bạn yêu thích Monopoly, bạn không thể bỏ qua Monopoly Deal được!\n\nBài Tỷ Phú là một trò chơi mà thế trận có thể xoay chuyển chỉ bằng 1 lá bài.', 'BG', 19, 'sp42.jpg', 0),
(44, 'Battlestar Galactica (US)', 'Roleplaying', 1750000, '3 - 6', '4 - 6', '120 - 300', '14+', 'Battlestar Galactica: The Board Game là một trò chơi thú vị về sự ngờ vực, mưu mô và cuộc đấu tranh sinh tồn. Dựa trên sê-ri Sci Fi Channel hoành tráng và được hoan nghênh rộng rãi, Battlestar Galactica: The Board Game đưa người chơi vào vai một trong mười nhân vật yêu thích của họ từ chương trình. Mỗi nhân vật có thể chơi được đều có những khả năng và điểm yếu riêng, và tất cả phải hợp tác với nhau để nhân loại có bất kỳ hy vọng sống sót nào. Tuy nhiên, một hoặc nhiều người chơi trong mọi trò chơi bí mật bên cạnh các Trụ. Người chơi phải cố gắng vạch trần kẻ phản bội trong khi tình trạng thiếu nhiên liệu, ô nhiễm thực phẩm và tình trạng bất ổn chính trị có nguy cơ xé nát hạm đội.\r\n\r\nSau cuộc tấn công của Cylon vào thuộc địa, tàn dư của loài người đang chạy trốn, liên tục tìm kiếm các biển chỉ dẫn tiếp theo trên đường đến Trái đất. Họ phải đối mặt với mối đe dọa tấn công Cylon từ bên ngoài, và sự phản bội và khủng hoảng từ bên trong. Nhân loại phải làm việc cùng nhau nếu họ có hy vọng sống sót, nhưng làm thế nào họ có thể, trong thực tế, có thể là một đặc vụ Cylon?\r\n\r\nBattlestar Galactica: The Board Game là một trò chơi bán hợp tác dành cho 3-6 người chơi từ 10 tuổi trở lên có thể chơi trong 2-3 giờ. Người chơi chọn từ phi công, lãnh đạo chính trị, lãnh đạo quân sự hoặc kỹ sư cho phi hành đoàn Galactica. Họ cũng được chia một thẻ khách hàng thân thiết khi bắt đầu trò chơi để xác định xem họ là người hay Cylon cùng với một loại thẻ kỹ năng dựa trên khả năng của nhân vật. Người chơi sau đó có thể di chuyển và thực hiện các hành động trên Galactica, trên Thuộc địa 1 hoặc trong Viper. Họ cần thu thập thẻ kỹ năng, chống đỡ tàu Cylon và giữ cho Galactica và hạm đội nhảy lên. Mỗi lượt chơi cũng mang đến một Thẻ Khủng hoảng, nhiều nhiệm vụ khác nhau mà người chơi phải vượt qua. Người chơi cần chơi các thẻ kỹ năng phù hợp để chống lại các vấn đề; thẻ kỹ năng không phù hợp cản trở thành công của người chơi. Số phận có thể đang làm việc chống lại phi hành đoàn, hoặc có thể có một Cylon phản bội! Khi người chơi tiến gần hơn và tiến gần hơn tới Trái đất của họ, một vòng thẻ khách hàng thân thiết khác sẽ được đưa ra và nhiều trụ có thể xuất hiện. Nếu người chơi có thể duy trì cửa hàng thực phẩm, mức nhiên liệu, tinh thần tàu thủy và dân số và họ có thể giữ Galactica trong một mảnh đủ lâu để đến Trái đất, Con người chiến thắng trò chơi. Nhưng nếu người chơi Cylon bộc lộ bản thân vào đúng thời điểm và hạ gục Galactica, loài Người đã thua cuộc.\r\n', 'BG', 14, 'sp43.jpg', 0),
(45, 'MALL OF HORROR : Survival Is In The Betrayal', 'Horror', 400000, '3 - 6', '6', '30', '14+', 'Mall Of Horror kể về một thế giới suy tàn trong tương lai, nơi thây ma thống tr ị trái đất. Tại một thương xá nhỏ bé trong lòng thành phố, những người sống sót đứng cạnh nhau, biết rằng chẳng bao lâu nữa đám zombie ngoài kia sẽ tràn vào và sẽ chẳng còn mấy ai sống sót.Thế giới luôn tàn nhẫn và lạnh lùng, đặc biệt là thế giới nơi người chết đi lại giữa kẻ sống. Bạn sẽ làm gì để sống sót, tại nơi thế giới sụp đổ còn lòng người thì buốt giá này đây?\n', 'BG', 15, 'sp44.jpg', 0),
(46, 'Lầy', 'Cardgame', 65000, '2 - 10', '4 - 8', '10 - 20', '6+', '1. Giới thiệu bài Lầy: \n\nMột bộ bài Lầy bao gồm 113 lá bài \n\n+ 4 màu: Đỏ, Xanh dương, Xanh lá và Vàng. \n\n+ Mỗi màu sẽ có những con số từ 1 - 9 và những lá bài có chức năng đặc biệt và siêu cấp lầy lội. \n\n \n\n2. Luật chơi \n\n- Party game phù hợp chơi từ 2 - 10 người. \n\n- Đầu game, chia đều cho mỗi người chơi 6 lá bài, phần còn lại để ở giữa. \n\n- Bóc một lá ở giữa và bắt đầu chơi. \n\n- Lần lượt người chơi bỏ 1 lá bài theo nguyên tắc: \n\n+ Cùng màu hoặc cùng số hoặc cùng kí hiệu.\n\n+ Những lá bài màu đen (lá bài tự do hoặc lá bài +4). \n\n- Khi còn 2 lá trên tay, trước khi bỏ 1 lá xuống, bạn phải kêu \"LẦY\" để báo hiệu cho người khác biết bạn còn 1 lá. Nếu quên, bạn sẽ phải bốc thêm 2 lá. \n\n- Trò chơi kết thúc khi có người bỏ được hết bài, ai nhiều bài nhất là thua cuộc. \n\n \n\n3. Những lá bài sở hữu chức năng đặc biệt \n\n- Tạo nghiệp: Tượng trưng cho tất cả các màu. Chuyển lượt cho 1 người chơi khác, chỉ định người chơi đó phải đánh \"+2\" hoặc \"+4\" lên người chơi tiếp theo của vòng. Nếu người chơi đó không thể đánh (kiểm tra bài trên tay), bạn phải rút 2 lá \n\n- Vận đổi sao dời: Tượng trưng cho tất cả các màu. Chọn đổi toàn bộ bài với người có ít bài nhất. Bạn phải là người có ít nhất 6 lá trên tay để thực hiện hành động này \n\n- Lầy: Yêu cầu mọi người bỏ xuống một lá có màu bạn chọn. Nếu có người không thực hiện được, bạn bỏ toàn bộ tài, chỉ giữ trên tay 3 lá. Ngược lại, bạn bốc 5 lá \n\n- Nín: Tượng trung cho tất cả các màu. Người đánh chọn 1 số, không ai được nói gì cho đến khi có số này được đánh ra. Kết thức khi có người vi phạm, người này phải bốc 2 lá \n\n- Cười bò: Từ giờ đến lượt kế của bạn, không ai được cười. Kết thúc khi có người vi phạm, người này bốc 2 lá \n\n- Nghiệp quật: Chỉ được sử dụng khi tấn công bởi lá +4. Người đánh lá +4 đấy phải bốc 4 lá \n\n- Wild card: Tượng trưng cho tất cả các màu. Có thể dùng với tất cả các màu và được chọn màu cho lượt đánh kế tiếp \n\n- Cộng 2x2: Khi đánh lá này, 2 người bên cạnh bạn phải bốc 2 lá \n\n \n\nBoardgame party lầy nhất hệ mặt trời, hứa hẹn những cú lật mặt cười ra nước mắt, những giây phút cực kỳ sảng khoái cùng bạn bè.\n\n>> Còn chần chừ gì nữa mà không thử nào!!!! ', 'BG', 15, 'sp45.jpg', 0);
INSERT INTO `product` (`ID`, `Name`, `Category`, `Price`, `NoP`, `NoPsg`, `Time`, `Age`, `Description`, `Type`, `Quantity`, `Pic`, `Status`) VALUES
(47, 'Coup (US)', 'Deduction', 500000, '3 - 6', '5', '15', '10+', 'Coup lấy bối cảnh nơi có một vương triều đổ nát, không giúp ích gì được cho người dân. Mọi người đều vươn lên tranh giành nhau quyền lực để thống trị nơi này. Xung quanh không ai đáng tin cả, chỉ toàn là kẻ thù. Ai sẽ là người chiến thắng trong cuộc chiến tranh giành quyền lực này đây? Hãy cùng xem nhé!\r\n\r\nTrong game, bạn sẽ chiến thắng nếu là người cuối cùng còn sống trên bàn chơi. Luật chơi đơn giản, dễ nhớ, lượt chơi kết thúc nhanh và mỗi hành động bạn đưa ra sẽ gây ảnh hưởng lớn đến người chơi xung quanh. Mỗi người sẽ bắt đầu game với 2 lá bài ngẫu nhiên, có thể giống hoặc khác nhau và 2 đồng tiền. Chồng bài 15 lá bao gồm 3 lá giống nhau của 5 nhân vật với nhiều chức năng khác nhau\r\nTrong lượt của bạn, bạn có thể sử dụng 1 trong những chức năng của bất kì nhân vật nào, kể cả khi bạn có hay không. Hoặc bạn có thể dùng 1 trong 3 hành động sau:\r\n\r\nThu nhập: lấy 1 xu từ ngân hàng, không thể bị chặn\r\nViện trợ: lấy 2 xu từ ngân hàng, có thể bị chặn\r\nCoup: trả 7 xu để giết 1 nhân vật trên bàn chơi, không thể bị chặn\r\n          Nếu bạn có hơn 10 xu. bạn bắt buộc phải thực hiện hành động này\r\n\r\nThành phần\r\n\r\n15 lá bài nhân vật ( đã được nêu ở trên)\r\n6 lá tóm tắt cách chơi\r\n20 đồng 1 xu\r\n10 đồng 5 xu\r\n \r\nMột số board game cơ chế tương tự: \r\n\r\nMa sói\r\nSecret Hitler\r\nAvalon', 'BG', 15, 'sp46.jpg', 0),
(48, 'Avalon (US)', 'Deduction', 510000, '5 - 10', '7 - 10', '30', '12+', 'Câu chuyện về các Hiệp Sĩ Bàn Tròn (Knights of the Round Table) là nguồn cảm hứng cho rất nhiều các tác phẩm kinh điển trong các lĩnh vực, và chắc chắn những nhà phát triển board game cũng không bỏ qua nguồn cảm hứng dạt dào đến từ sự tích này.\n\nNhắc đến các board game xoay quanh sự tích này, có thể kể tới những Shadows over Camelot, Merlin, Lancelot...nhưng chắc chắn cái tên nổi tiếng nhất và cũng nhận được sự yêu thích lớn nhất đến từ người chơi board game chắc chắn là Avalon, một tựa game mang đầy đủ các yếu tố của truyền thuyết, cả các nhân vật, và cả các tích vật.\n\nTrong tất cả các game, Avalon là cái tên nổi bật bậc nhất.\nTên của trò chơi, được lấy từ hòn đảo Avalon, nơi Nữ Thần của Hồ (Lady of the Lake) đã trao thanh gươm Excalibur cho vua Arthur, và cũng là nơi chôn cất vua Arthur sau trận chiến với Mordred tại Camlann. Trên vỏ hộp của trò chơi, mọi người có thể nhìn thấy khung cảnh của đảo Avalon được phác họa, bên cạnh ánh mắt và khuôn mặt chẳng tỏ nghĩ suy của nữ hoàng Guinevere, người đã khiến Lancelot phản bội vua Arthur, khơi mào chiến tranh và đánh dấu cho sự sụp đổ của cả vương triều. Lancelot cũng đã được nhà phát hành đưa vào như một bản mở rộng riêng sau đó.\nCũng giống như tất cả mọi chế độ, sẽ luôn có những người bất mãn, những kẻ luôn chực chờ cơ hội để lật đổ cướp quyền, và thời kỳ của vua Arthur cũng như vậy. Trong trò chơi, người chơi sẽ chia thành hai phe, phe những hiệp sĩ trung thành được dẫn đầu bởi pháp sư Merlin, Sir Percival, và những kẻ phản bội, được chỉ đạo bởi Mordred, và phù thủy Morgana.\nTất cả những người chơi sẽ tham gia vào các nhiệm vụ nhằm tìm kiếm Chén Thánh (Holy Grail) cho vua Arthur. Tuy nhiên việc nhiệm vụ thành công hay thất bại phụ thuộc vào việc trong nhóm những người được cử đi có kẻ phản bội hay không, đòi hỏi mọi người cần phải lựa chọn 1 cách kỹ càng nhằm tìm ra những người có khả năng tin tưởng nhất. Pháp sư Merlin, đã biết tất cả sự thật về những kẻ đang có gian ý trà trộn kia, nhưng ông không thể quá lộ liễu, bởi sát thủ của Mordred đang chờ đợi một cơ hội để có thể hạ sát ông, và khi đó thành Camelot và vua Arthur sẽ mất đi lá chắn bảo vệ cuối cùng, Mordred có thể thực hiện âm mưu giết vua Arthur của mình!\nMỗi khi có các nhiệm vụ thất bại bị lộ ra, mọi người sẽ dần nhận ra đâu là kẻ phản bội, từ đó dần có những manh mối cho riêng mình. Mỗi một lần bỏ phiếu chọn team, đều là những lần mà Merlin có thể đưa ra gợi ý của mình mà Percival cần phải tinh ý nắm bắt, nhưng cũng là manh mối giúp cho những kẻ phản bội có thể nhận ra đâu là vị phù thủy tối cao của thành Camelot. Do đó mà những phiếu bầu, dù là đến từ những hiệp sĩ trung thành đơn giản, không có khả năng đặc biệt, cũng trở nên rất quan trọng trong trò chơi này.\nSau khi đã thu thập đủ thông tin và ván chơi đi dần về những thời khắc quyết định, sẽ là lúc những người chơi đưa ra những toan tính cuối cùng. Đó là những pha “hack-não” sẵn sàng hi sinh thay cho Merlin để đem về chiến thắng cho phe trung thành, và lùng soát manh mối tìm Merlin hay trà trộn để khiến nhiệm vụ thất bại ở những lượt cuối cùng.\nVà để ván chơi mang đậm tính nhập vai vào thời kỳ của vua Arthur hơn, nhà phát hành đã khéo léo tặng kèm cũng như phát hành thêm các bản mở rộng thêm, với những nhân vật quen thuộc: Nữ Thần của Hồ, Lancelot, thanh gươm Excalibur. Tất cả giúp cho những suy luận thêm phần cơ sở cho những người tốt, và cũng là cơ hội để màn chơi thêm hỗn loạn cho phe xấu.\nNếu như là một fan của dòng game suy luận nói chung, hay là fan của game ma sói nói riêng, thì nhất định Avalon sẽ là một tựa game mà bạn nhất định không nên bỏ lỡ. Và tựa game đang đứng thứ 6 trong danh sách party game hay nhất mọi thời đại nhất định sẽ không làm bạn thất vọng!', 'BG', 15, 'sp47.jpg', 0),
(49, 'Twilight Struggle', 'Wargame', 1720000, '2', '2', '180', '13+', 'Vào năm 1945, các nước đồng minh khó có thể lật đổ chế độ của Hitler, trong khi vũ khí tàn khốc nhất của nhân loại đã buộc Đế quốc Nhật phải quỳ gối trong bão lửa. Thế giới với các thế lực hùng mạnh ngày nào nay chỉ còn lại hai quốc gia đối đầu. Không giống như các cuộc chiến vĩ đại những thập kỷ trước, cuộc đấu này được tiến hành không phải bởi binh lính và xe tăng mà bởi các điệp viên và chính trị gia, bởi các nhà khoa học và tầng lớp trí thức, bởi các nghệ sĩ và những kẻ phản bội.\n \nTwilight Struggle dành cho 2 người chơi, mô phỏng lại 45 năm đầy mưu mô, xung đột đôi khi là chiến tranh giữa hai quốc gia hùng mạnh nhất trong lịch sử thế giới từng biết. Người chơi điều khiển các mô hình trên bản đồ và gây ảnh hưởng với mục đích lôi kéo đồng minh và kiểm soát sức mạnh của họ. Việc đưa ra được những quyết định đúng đắn là một thách thức, bạn phải cân nhắc làm sao để sử dụng tốt nhất các lá bài và đơn vị mình có với lượng tài nguyên giới hạn. Trò chơi bắt đầu giữa đống đổ nát của châu  u khi hai cường quốc mới nổi tranh giành đống đổ nát từ sau Thế chiến 2, mỗi lượt tương ứng với khoảng thời gian thực tế là từ 3 đến 5 năm và kết thúc vào năm 1989, khi chỉ còn Hoa Kỳ giữ vững vị thế của mình.', 'BG', 15, '909578a0b5c6709c22ef99510a69a988.jpg', 0),
(50, 'Secret Hitler (US)', 'Wargame', 1250000, '5 - 10', '10', '45', '13+', 'Secret Hitler là một trò chơi kịch tính về mưu đồ chính trị và sự phản bội lấy bối cảnh ở Đức năm 1930. Người chơi được bí mật chia thành hai đội - những người tự do và phát xít. Chỉ được biết đến với nhau, những kẻ phát xít phối hợp để gieo rắc sự ngờ vực và cài đặt thủ lĩnh máu lạnh của chúng. Những người tự do phải tìm và ngăn chặn Hitler bí mật trước khi nó quá muộn.\r\n\r\nMỗi vòng, người chơi bầu ra một Chủ tịch và một Thủ tướng, những người sẽ làm việc cùng nhau để ban hành luật từ một cỗ bài ngẫu nhiên. Nếu chính phủ thông qua luật phát xít, người chơi phải cố gắng tìm hiểu xem họ có bị phản bội hay đơn giản là không may mắn. Secret Hitler cũng có các quyền lực của chính phủ phát huy tác dụng khi chủ nghĩa phát xít tiến bộ. Những kẻ phát xít sẽ sử dụng những sức mạnh đó để tạo ra sự hỗn loạn trừ khi những người tự do có thể kéo quốc gia trở lại từ bờ vực chiến tranh.', 'BG', 15, '178d574f1ac086bcf2e66c79cb3bbaca.png', 0);

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `delete_all_image_before_delete_product` BEFORE DELETE ON `product` FOR EACH ROW BEGIN
    DELETE FROM images WHERE ProductID = OLD.ID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `TypeID` varchar(10) NOT NULL,
  `TypeName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`TypeID`, `TypeName`) VALUES
('BG', 'Board Game'),
('CO', 'Các loại cờ'),
('RB', 'Rubik');

--
-- Triggers `type`
--
DELIMITER $$
CREATE TRIGGER `update_type` AFTER UPDATE ON `type` FOR EACH ROW IF !(NEW.TypeID <=> OLD.TypeID) THEN
      UPDATE product
      SET product.Type = NEW.TypeID 
      WHERE product.Type= OLD.TypeID;
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Email`, `Password`, `Name`, `Phone`, `Address`, `Status`) VALUES
('test123@gmail.com', '123123123', 'test', '0911111111', 'test địa chỉ', 0),
('testUser@gmail.com', 'DayLaPassword123.', 'Test Name', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `billdetail`
--
ALTER TABLE `billdetail`
  ADD PRIMARY KEY (`BillID`,`ProductID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ID`,`ProductID`),
  ADD KEY `MaSP` (`ProductID`);

--
-- Indexes for table `menu_first`
--
ALTER TABLE `menu_first`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `menu_second`
--
ALTER TABLE `menu_second`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `menuIDFirst` (`MenuIDFirst`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `MaSP` (`ID`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`TypeID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `menu_first`
--
ALTER TABLE `menu_first`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_second`
--
ALTER TABLE `menu_second`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
