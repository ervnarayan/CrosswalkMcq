-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2023 at 09:05 PM
-- Server version: 5.6.25
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcqs_drill`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE IF NOT EXISTS `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_email_address` varchar(150) NOT NULL,
  `admin_password` varchar(150) NOT NULL,
  `admin_verfication_code` varchar(100) NOT NULL,
  `admin_type` enum('master','sub_master') NOT NULL,
  `mcq_timing` varchar(40) NOT NULL,
  `mcq_max_question` int(11) NOT NULL,
  `mcq_per_subject_limit` int(11) NOT NULL,
  `mcq_user_limit` int(11) NOT NULL,
  `admin_created_on` datetime NOT NULL,
  `email_verified` enum('no','yes') NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_email_address`, `admin_password`, `admin_verfication_code`, `admin_type`, `mcq_timing`, `mcq_max_question`, `mcq_per_subject_limit`, `mcq_user_limit`, `admin_created_on`, `email_verified`) VALUES
(1, 'vnarayan@initialace.com', '$2y$10$YYoBwdEYcQUYkr80TJbeMunTB9Uv1.YtdCEEk3nIF2pnKDFPOmwAO', '', 'master', '2', 100, 10, 4, '2020-04-13 00:00:00', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE IF NOT EXISTS `batch` (
  `batch_id` int(11) NOT NULL,
  `batch_name` varchar(255) NOT NULL,
  `batch_code` varchar(255) NOT NULL,
  `batch_start` date NOT NULL,
  `batch_end` date NOT NULL,
  `batch_status` enum('open','closed') NOT NULL DEFAULT 'open'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `batch_name`, `batch_code`, `batch_start`, `batch_end`, `batch_status`) VALUES
(1, 'APRIL20', 'AP20', '2020-04-24', '2020-10-24', 'open'),
(2, 'AUGUST20', 'AG20', '2020-08-01', '2020-11-30', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE IF NOT EXISTS `chapter` (
  `chapter_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  `chapter_name` varchar(400) NOT NULL,
  `chapter_number` varchar(400) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`chapter_id`, `subject_id`, `module_id`, `chapter_name`, `chapter_number`) VALUES
(1, 1, 1, 'Software development', '1'),
(2, 1, 1, 'Object-oriented concepts', '2'),
(3, 1, 1, 'UML diagrams', '3'),
(4, 1, 1, 'Java', '4'),
(5, 1, 2, 'How Google works', '5'),
(6, 1, 2, 'How mobile phones work', '6'),
(7, 1, 2, 'Online banking', '7'),
(8, 1, 2, 'How the School computing services work', '8'),
(9, 1, 2, 'Wireless networking', '9'),
(10, 1, 2, 'Operating systems', '10'),
(11, 1, 3, 'Abstract Data Structures', '11'),
(12, 1, 3, 'Programming Language Fundamentals', '12'),
(13, 1, 4, 'Document Oriented Computing', '13'),
(14, 1, 4, 'Building Internet Applications', '14'),
(15, 1, 5, 'propositional calculus, notation, inference, etc', '15'),
(16, 1, 5, 'non-monotonic logic', '16'),
(17, 1, 5, 'predicate calculus, notation, truth trees', '17'),
(18, 1, 5, 'predicate calculus, completeness, decidability', '18'),
(19, 1, 5, 'first-order theories', '19'),
(20, 1, 5, 'modular arithmetic, finite fields', '20'),
(21, 1, 5, 'proof techniques', '21'),
(22, 1, 5, 'advanced topics in logic', '22'),
(23, 1, 6, 'Data models', '23'),
(24, 1, 6, 'Security & integrity', '24'),
(25, 1, 6, 'Database connection', '25'),
(26, 1, 6, 'Storage & access', '26'),
(27, 1, 6, 'Transactions, concurrency & recovery', '27'),
(28, 1, 6, 'Structured computer organisation', '28'),
(29, 1, 7, 'Process definition and implementation', '29'),
(30, 1, 7, 'Process scheduling', '30'),
(31, 1, 7, 'Synchronisation', '31'),
(32, 1, 7, 'Storage management', '32'),
(33, 1, 7, 'Protection mechanisms', '33'),
(34, 1, 7, 'File systems and secondary storage', '34'),
(35, 1, 8, 'Abstraction', '35'),
(36, 1, 8, 'Analysis', '36'),
(37, 1, 8, 'Programming', '37'),
(38, 1, 8, 'Communication', '38'),
(39, 1, 8, 'Criticism', '39'),
(41, 3, 12, 'chapter financial accounting', '93');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `module_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `module_name` varchar(400) NOT NULL,
  `module_serial_number` varchar(400) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `subject_id`, `module_name`, `module_serial_number`) VALUES
(1, 1, 'Object Oriented Programming', 'COMP1'),
(2, 1, 'Computer Science in Everyday Life', 'COMP2'),
(3, 1, 'Foundations of Computation', 'COMP3'),
(4, 1, 'Concepts and Programming', 'COMP4'),
(5, 1, 'Logic and Reasoning', 'COMP5'),
(6, 1, 'Databases', 'COMP6'),
(7, 1, 'Operating Systems', 'COMP7'),
(8, 1, 'Human Computer Interaction', 'COMP8'),
(10, 3, 'Financial Accounting', 'FA'),
(11, 3, 'Management Accounting', 'MA'),
(12, 3, 'Cost Accounting', 'CA');

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_table`
--

CREATE TABLE IF NOT EXISTS `online_exam_table` (
  `online_exam_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `online_exam_duration` varchar(30) NOT NULL,
  `total_question` int(5) NOT NULL,
  `marks_obtained` varchar(30) DEFAULT NULL,
  `user_answer` text NOT NULL,
  `marks_per_right_answer` varchar(30) NOT NULL DEFAULT '1',
  `marks_per_wrong_answer` varchar(30) NOT NULL DEFAULT '1',
  `online_exam_created_on` datetime NOT NULL,
  `mcq_mode` enum('Exam','Study') NOT NULL DEFAULT 'Exam',
  `online_exam_status` enum('Pending','Completed') NOT NULL DEFAULT 'Pending',
  `online_exam_code` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `online_exam_table`
--

INSERT INTO `online_exam_table` (`online_exam_id`, `user_id`, `subject_id`, `online_exam_duration`, `total_question`, `marks_obtained`, `user_answer`, `marks_per_right_answer`, `marks_per_wrong_answer`, `online_exam_created_on`, `mcq_mode`, `online_exam_status`, `online_exam_code`) VALUES
(33, 1, 1, '25', 5, '2', '["14-b","11-b","29-a","23-c"]', '1', '1', '2020-05-06 19:27:56', 'Exam', 'Completed', 'dd33a21f7b5d1e39ae66b67be7a6d253'),
(34, 1, 1, '25', 5, '2', '["15-d","28-b","23-a","20-d","14-b"]', '1', '1', '2020-05-06 19:49:19', 'Exam', 'Completed', 'd6ae00d77468471c0fba3a53a0273891'),
(35, 1, 1, '20', 10, '4', '["20-d","19-b","21-a","13-c","14-b","36-d","35-c","15-b","33-a","26-d"]', '1', '1', '2020-05-07 11:35:26', 'Exam', 'Completed', 'eba55fca4575e35eec8587f10ba60a43'),
(36, 1, 1, '20', 5, '1', '["31-d","19-a","16-b","11-c","22-d"]', '1', '1', '2020-05-07 14:12:35', 'Study', 'Completed', 'dbda540cbe93e1f3f57f6f132550ba79'),
(37, 1, 1, '', 10, NULL, '', '1', '1', '2020-05-11 11:06:09', 'Study', 'Pending', 'a4a1108bbcc329a70efa93d7bf060914'),
(38, 1, 1, '20', 10, NULL, '', '1', '1', '2020-05-11 13:29:20', 'Exam', 'Pending', '43e546371f8128e1e37bc52d5b200213');

-- --------------------------------------------------------

--
-- Table structure for table `option_table`
--

CREATE TABLE IF NOT EXISTS `option_table` (
  `option_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_number` int(2) NOT NULL,
  `option_title` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `option_table`
--

INSERT INTO `option_table` (`option_id`, `question_id`, `option_number`, `option_title`) VALUES
(1, 1, 1, 'I only'),
(2, 1, 2, 'II only'),
(3, 1, 3, 'Both I and II'),
(4, 1, 4, 'Neither I nor II'),
(5, 2, 1, 'Expected cash flows'),
(6, 2, 2, 'Fair value of the collateral'),
(7, 2, 3, 'Fair value of the financial asset'),
(8, 2, 4, 'Present value of the expected cash flows'),
(9, 3, 1, 'I only'),
(10, 3, 2, 'II only'),
(11, 3, 3, 'Both I and II'),
(12, 3, 4, 'Neither I nor II'),
(13, 4, 1, 'I only'),
(14, 4, 2, 'II only'),
(15, 4, 3, 'Both I and II'),
(16, 4, 4, 'Neither I nor II'),
(17, 5, 1, 'I only'),
(18, 5, 2, 'II only'),
(19, 5, 3, 'Both I and II'),
(20, 5, 4, 'Neither I nor II'),
(21, 6, 1, 'I only'),
(22, 6, 2, 'II only'),
(23, 6, 3, 'Both I and II'),
(24, 6, 4, 'Neither I nor II'),
(25, 7, 1, 'I only'),
(26, 7, 2, 'II only'),
(27, 7, 3, 'Both I and II'),
(28, 7, 4, 'Neither I nor II'),
(29, 8, 1, 'I only'),
(30, 8, 2, 'II only'),
(31, 8, 3, 'Both I and II'),
(32, 8, 4, 'Neither I nor II');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire`
--

CREATE TABLE IF NOT EXISTS `questionnaire` (
  `questionnaire_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `questionnaire_text` text NOT NULL,
  `point_1` text NOT NULL,
  `point_2` text NOT NULL,
  `point_3` text NOT NULL,
  `point_4` text NOT NULL,
  `point_5` text NOT NULL,
  `q_image` varchar(255) NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` varchar(255) NOT NULL,
  `explaination_text` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questionnaire`
--

INSERT INTO `questionnaire` (`questionnaire_id`, `subject_id`, `chapter_id`, `questionnaire_text`, `point_1`, `point_2`, `point_3`, `point_4`, `point_5`, `q_image`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explaination_text`) VALUES
(1, 1, 34, 'With reference to ASC 326, in respect of available-for-sale debt securities an entity should consider the following factors in determining whether a credit loss exists?', 'The extent to which the fair value is less than the amortized cost basis.', 'Adverse conditions specifically related to the security.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'With reference to ASC 326, in respect of available-for-sale debt securities an entity should consider the following factors in determining whether a credit loss exists. (a) The extent to which the fair value is less than the amortized cost basis. (b) Adverse conditions specifically related to the security, an industry, or geographic area, such as changes in the financial condition of the issuer of the security, or in the case of an asset-backed debt security, changes in the financial condition of the underlying loan obligors. Examples of those changes include changes in technology, the discontinuance of a segment of the business that may affect the future earnings potential of the issuer or underlying loan obligors of the security, and changes in the quality of the credit enhancement. (c) The payment structure of the debt security the likelihood of the issuer being able to make payments that increase in the future. (d) Failure of the issuer of the security to make scheduled interest or principal payments. (e) Any changes to the rating of the security by a rating agency.'),
(2, 1, 34, 'In respect of collateral-dependent financial assets, an entity should measure expected credit losses (when the foreclosure is probable) based on-', '', '', '', '', '', '', 'Expected cash flows', 'Fair value of the collateral', 'Fair value of the financial asset', 'Present value of the expected cash flows', 'b', 'An entity should measure expected credit losses based on the fair value of the collateral at the reporting date when the entity determines that foreclosure is probable. If the fair value of the collateral is less than the amortized cost basis of the financial asset, an entity should recognize an allowance for credit losses measured as the difference between (a) the fair value of the collateral, less costs to sell (if applicable), at the reporting date and (b) the amortized cost basis of the financial asset.'),
(3, 1, 34, 'With reference to ASC 326, in respect of available-for-sale debt securities an entity should consider the following factors in determining whether a credit loss exists?', 'The discontinuance of a segment of the business that may affect the future earnings potential of the issuer.', 'The payment structure of the debt security the likelihood of the issuer being able to make payments that increase in the future.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'With reference to ASC 326, in respect of available-for-sale debt securities an entity should consider the following factors in determining whether a credit loss exists. (a) The extent to which the fair value is less than the amortized cost basis. (b) Adverse conditions specifically related to the security, an industry, or geographic area, such as changes in the financial condition of the issuer of the security, or in the case of an asset-backed debt security, changes in the financial condition of the underlying loan obligors. Examples of those changes include changes in technology, the discontinuance of a segment of the business that may affect the future earnings potential of the issuer or underlying loan obligors of the security, and changes in the quality of the credit enhancement. (c) The payment structure of the debt security the likelihood of the issuer being able to make payments that increase in the future. (d) Failure of the issuer of the security to make scheduled interest or principal payments. (e) Any changes to the rating of the security by a rating agency.'),
(4, 1, 34, 'In respect of collateral-dependent financial assets (when the foreclosure is probable), in which of the following circumstances, the entity should measure expected credit losses using the fair value of the collateral?', 'When the repayment or satisfaction is expected to happen through the sale of the collateral.', 'When the repayment or satisfaction is expected to happen through the operation of the collateral.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'b', 'In respect of collateral-dependent financial assets (when the foreclosure is probable), the entity should measure expected credit losses using the fair value of the collateral when the repayment or satisfaction is expected to happen through the operation of the collateral. However, if the repayment or satisfaction is expected to happen through the sale of the collateral, use the fair value of the collateral, reduced by the cost to sell.'),
(5, 1, 34, 'With reference to ASC 326, in respect of available-for-sale debt securities if an entity intends to sell the debt security or more likely than not will be required to sell the security then-', 'Any allowance for credit losses should equal the expected credit loss.', 'The amortized cost basis should equal the present value of expected cash flows.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'd', 'In respect of available-for-sale debt securities if an entity intends to sell the debt security or more likely than not will be required to sell the security before recovery of its amortized cost basis, the amortized cost basis should be written down to the debt security?s fair value at the reporting date. Any allowance for credit losses should be written off and any incremental impairment is reported in earnings.'),
(6, 1, 34, 'In respect of purchased financial assets with credit deterioration, any discount on purchase that is noncredit is accreted to interest income using the interest method based on the effective interest rate. This is true under which circumstance(s)?', 'An entity uses a discounted cash flow method', 'An entity uses a method other than a discounted cash flow method', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'In respect of purchased financial assets with credit deterioration, any discount on purchase that is noncredit is accreted to interest income using the interest method based on the effective interest rate. This rule is applicable regardless of the method used.'),
(7, 1, 34, 'In the context of ASC 326, which of the following statements is correct?', 'An entity should always measure an allowance for credit losses for accrued interest receivables if the entity writes off the uncollectible accrued interest receivable balance in a timely manner.', 'In estimating expected credit losses for off-balance-sheet credit exposures, an entity should record a liability for credit losses on off-balance-sheet credit exposures.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'b', 'An entity may make an accounting policy election not to measure an allowance for credit losses for accrued interest receivables if the entity writes off the uncollectible accrued interest receivable balance in a timely manner. In estimating expected credit losses for off-balance-sheet credit exposures, an entity should estimate expected credit losses (over the contractual period in which the entity is exposed to credit risk) and record a liability for credit losses on off-balance-sheet credit exposures.'),
(8, 1, 34, 'With reference to ASC 326, an investment in available for sale debt securities is considered impaired when-', '', '', '', '', '', '', 'the fair value of the investment is less than its amortized cost basis', 'the expected cash flows is less than its amortized cost basis', 'the present value of the expected cash flows is less than its amortized cost basis', 'the amortized cost basis is less than the present value of the expected cash flows', 'a', 'With reference to ASC 326, an entity should record impairment on available-for-sale debt securities relating to credit losses through an allowance for credit losses.'),
(9, 1, 34, 'In respect of purchased financial assets with credit deterioration, at the date of acquisition, an entity should -', 'Not recognize the allowance for credit losses (for expected credit losses)', 'Add the allowance to the purchase price to determine the initial amortized cost basis.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'b', 'In respect of purchased financial assets with credit deterioration, at the date of acquisition, an entity should recognize the allowance for credit losses (for expected credit losses) and add the allowance to the purchase price to determine the initial amortized cost basis.'),
(10, 1, 38, 'With reference to ASC 326, in respect of available-for-sale debt securities if an entity intends to sell the debt security or more likely than not will be required to sell the security before recovery of its amortized cost basis then-', '', '', '', '', '', '', 'The amortized cost basis should be written down to the fair value.', 'The par value should be written down to the down to the amortized cost.', 'The amortized cost basis should be written down to the present value of the expected cash flows.', 'The par value should be written down to the present value of the expected cash flows.', 'a', 'In respect of available-for-sale debt securities, if an entity intends to sell the debt security or more likely than not will be required to sell the security before recovery of its amortized cost basis, the amortized cost basis should be written down to the debt security?s fair value at the reporting date.'),
(11, 1, 38, 'In respect of collateral-dependent financial assets (foreclosure is probable), when the fair value (less costs to sell, if applicable) of the collateral at the reporting date exceeds the amortized cost basis of the financial asset, an entity should adjust the allowance for credit losses to present the net amount expected to be collected on the financial asset equal to the-', '', '', '', '', '', '', 'Fair value of the financial asset', 'Fair value (less costs to sell, if applicable) of the collateral ', 'Amortized cost of the financial asset', 'Present value of the credit loss', 'b', 'When the fair value (less costs to sell, if applicable) of the collateral at the reporting date exceeds the amortized cost basis of the financial asset, an entity should adjust the allowance for credit losses to present the net amount expected to be collected on the financial asset equal to the fair value (less costs to sell, if applicable) of the collateral as long as the allowance that is added to the amortized cost basis of the financial asset(s) does not exceed amounts previously written off.'),
(12, 1, 38, 'In the context of ASC 326, which of the following statements is not correct?', '', '', '', '', '', 'https://3.bp.blogspot.com/-xorN3kZmRjI/WOVy99ChSuI/AAAAAAAAQU0/f8QGRntFaDY4jZLXdaWHg3Rm0jZCk9IEwCLcB/s640/Screen%2BShot%2B2017-04-05%2Bat%2B6.40.23%2BPM.png', 'When a discounted cash flow method is applied, the allowance for credit losses is the difference between the fair value and the present value of the expected cash flows.', 'When a loss-rate method is used, the allowance for credit losses is calculated using an estimated loss rate and multiplying it by the asset?s amortized cost at the balance sheet date.', 'When a probability-of-defaults method is applied, the loss rate is calculated by multiplying the PD (probability the asset will default within a given timeframe) by the LGD (percentage of the asset not expected to be collected due to default).', 'When aging schedule method is used, the allowance for credit losses is calculated based on how long a receivable has been outstanding.', 'a', 'When a discounted cash flow method is applied, the allowance for credit losses is the difference between the amortized cost basis and the present value of the expected cash flows.'),
(13, 1, 38, 'With reference to ASC 326, recoveries of amount (earlier written off as uncollectible) may be credited to', 'Earnings ', 'Allowance for credit losses', '', '', '', 'https://3.bp.blogspot.com/-xorN3kZmRjI/WOVy99ChSuI/AAAAAAAAQU0/f8QGRntFaDY4jZLXdaWHg3Rm0jZCk9IEwCLcB/s640/Screen%2BShot%2B2017-04-05%2Bat%2B6.40.23%2BPM.png', 'I only', 'II only', 'Either I or II', 'Neither I nor II', 'c', 'Writeoffs of financial assets should be deducted from the allowance. Recoveries of amount may be credited to earnings or to allowance for credit losses.'),
(14, 1, 38, 'In respect of purchased financial assets with credit deterioration, any discount or premium on purchase that is noncredit is accreted to interest income using the -', '', '', '', '', '', '', 'Equity method', 'Interest method', 'Allowance method', 'Valuation method', 'b', 'Any discount or premium on purchase that is noncredit is accreted to interest income using the interest method based on the effective interest rate determined after the adjustment for credit losses.'),
(15, 1, 38, 'With reference to ASC 326, which of the following statement is not correct regarding the available-for-sale debt securities?', '', '', '', '', '', '', 'An entity should determine whether a decline in fair value below the amortized cost basis has resulted from a credit loss or other factors.', 'An entity should not record impairment relating to credit losses.', 'Impairment that is recorded through an allowance for credit losses should be recorded through other comprehensive income.', 'Impairment should be assessed at the individual security level.', 'b', 'With reference to ASC 326, an entity should record impairment on available-for-sale debt securities relating to credit losses through an allowance for credit losses.'),
(16, 1, 38, 'As per ASC 326, at each reporting date, an entity should compare its current estimate of expected credit losses with -', '', '', '', '', '', '', 'the present value of expected cash flows', 'the estimate of expected credit losses previously recorded', 'the amortized cost of the financial asset', 'the amount of credit losses previously recorded', 'b', 'At each reporting date, an entity should compare its current estimate of expected credit losses with the estimate of expected credit losses previously recorded. The amount necessary to adjust the allowance for credit losses for management?s current estimate of expected credit losses on financial assets is reported a credit loss expense or a reversal of credit loss expense.'),
(17, 1, 38, 'In the context of ASC 326, which of the following statements is not correct regarding purchased financial assets with credit deterioration?', '', '', '', '', '', '', 'The discount embedded in the purchase price that is attributable to expected credit losses should be reported as a credit loss expense upon acquisition.', 'The difference between amortized cost basis and the par amount of the debt is recognized as a noncredit discount or premium.', 'Any discount or premium on purchase that is noncredit is accreted to interest income.', 'Generally, the expected credit loss can be determined by finding the difference between the contractual cash flows and the expected cash flows.', 'a', 'In respect of purchased financial assets with credit deterioration, the discount embedded in the purchase price that is attributable to expected credit losses should not be recognized as interest income and also should not be reported as a credit loss expense upon acquisition.'),
(18, 1, 38, 'With reference to ASC 326, in respect of available-for-sale debt securities which of the following factors should be considered by an entity in determining expected cash flows?', 'Remaining payment terms', 'Financial condition of the issuer', '', '', '', 'https://3.bp.blogspot.com/-xorN3kZmRjI/WOVy99ChSuI/AAAAAAAAQU0/f8QGRntFaDY4jZLXdaWHg3Rm0jZCk9IEwCLcB/s640/Screen%2BShot%2B2017-04-05%2Bat%2B6.40.23%2BPM.png', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'In respect of available-for-sale debt securities when developing the estimate of cash flows expected to be collected, an entity should consider available information about past events, current conditions, and reasonable and supportable forecasts. This includes considering information regarding remaining payment terms, prepayment speeds, financial condition of the issuer, expected defaults, and value of collateral.'),
(19, 1, 37, 'In respect of collateral-dependent financial assets (when the foreclosure is probable), which of the following statements is correct?', 'Measure expected credit losses based on the fair value of the collateral.', 'Recognize an allowance for credit losses measured as the difference between (a) the fair value of the collateral, less costs to sell (if applicable), at the reporting date and (b) the amortized cost basis of the financial asset.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'An entity should measure expected credit losses based on the fair value of the collateral at the reporting date when the entity determines that foreclosure is probable. If the fair value of the collateral is less than the amortized cost basis of the financial asset, an entity should recognize an allowance for credit losses measured as the difference between (a) the fair value of the collateral, less costs to sell (if applicable), at the reporting date and (b) the amortized cost basis of the financial asset.'),
(20, 1, 37, 'With reference to ASC 326, in respect of available-for-sale debt securities an entity should consider the following factors in determining whether a credit loss exists?', 'Changes in technology.', 'Any changes to the rating of the security by a rating agency.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'With reference to ASC 326, in respect of available-for-sale debt securities an entity should consider the following factors in determining whether a credit loss exists. (a) The extent to which the fair value is less than the amortized cost basis. (b) Adverse conditions specifically related to the security, an industry, or geographic area, such as changes in the financial condition of the issuer of the security, or in the case of an asset-backed debt security, changes in the financial condition of the underlying loan obligors. Examples of those changes include changes in technology, the discontinuance of a segment of the business that may affect the future earnings potential of the issuer or underlying loan obligors of the security, and changes in the quality of the credit enhancement. (c) The payment structure of the debt security the likelihood of the issuer being able to make payments that increase in the future. (d) Failure of the issuer of the security to make scheduled interest or principal payments. (e) Any changes to the rating of the security by a rating agency.'),
(21, 1, 37, 'An entity should record an allowance for credit losses on financial assets and should correspondingly - ', '', '', '', '', '', '', 'debit - credit loss expense', 'credit - credit loss revenue', 'debit - interest expense', 'credit - interest revenue', 'a', 'An entity should record an allowance for credit losses on financial assets and should correspondingly debit a credit loss expense for its current estimate of expected credit losses (CEECL). '),
(22, 1, 37, 'In the context of ASC 326, which of the following statements is not correct?', '', '', '', '', '', '', 'When developing an estimate of expected credit losses on financial assets, an entity should consider only quantitative factors that relate to the environment in which the entity operates and are specific to the borrowers.', 'The method used to estimate expected credit losses may vary on the basis of the type of financial asset.', 'Writeoffs of financial assets should be deducted from the allowance for credit losses.', 'When a discounted cash flow method is applied, the allowance for credit losses is the difference between the amortized cost basis and the present value of the expected cash flows.', 'a', 'When developing an estimate of expected credit losses on financial assets, an entity should consider available information relevant to assessing the collectibility of cash flows. An entity should consider relevant qualitative and quantitative factors that relate to the environment in which the entity operates and are specific to the borrowers. The method used to estimate expected credit losses may vary on the basis of the type of financial asset, the entity?s ability to predict the timing of cash flows, and the information available to the entity.'),
(23, 1, 37, 'In respect of collateral-dependent financial assets (when the foreclosure is probable), in which of the following circumstances, the entity should measure expected credit losses using the fair value of the collateral, reduced by the cost to sell?', 'When the repayment or satisfaction is expected to happen through the sale of the collateral.', 'When the repayment or satisfaction is expected to happen through the operation of the collateral.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'In respect of collateral-dependent financial assets (when the foreclosure is probable), the entity should measure expected credit losses using the fair value of the collateral when the repayment or satisfaction is expected to happen through the operation of the collateral. However, if the repayment or satisfaction is expected to happen through the sale of the collateral, use the fair value of the collateral, reduced by the cost to sell.'),
(24, 1, 37, 'In respect of purchased financial assets with credit deterioration, if an entity uses a discounted method, the entity should-', 'Discount the expected credit losses', 'Record the undiscounted value of expected credit losses as allowance for credit losses', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'In respect of purchased financial assets with credit deterioration, if an entity uses a discounted cash flow method, the entity should discount expected credit losses using the effective interest rate and record the discounted value of expected credit losses as allowance for credit losses.'),
(25, 1, 37, 'In respect of purchased financial assets with credit deterioration, any discount or premium on purchase that is noncredit is accreted to-', '', '', '', '', '', '', 'Revenue or sales income', 'Interest expense', 'Cost of goods sold', 'Interest income', 'd', 'Any discount or premium on purchase that is noncredit is accreted to interest income using the interest method based on the effective interest rate determined after the adjustment for credit losses.'),
(26, 1, 37, 'With reference to ASC 326, in respect of available-for-sale debt securities impairment should be assessed -', 'On collective or pool basis', 'On an individual basis', '', '', '', '', 'I only', 'II only', 'Either I or II', 'Neither I nor II', 'b', 'With reference to ASC 326, in respect of available-for-sale debt securities impairment should be assessed at the individual security level.'),
(27, 1, 37, 'An entity should record an allowance for credit losses on financial assets and should correspondingly record a credit loss expense for its-', '', '', '', '', '', '', 'current estimate of expected credit losses', 'future estimate of expected credit losses', 'present value of future expected losses', 'present value of expected cash flows', 'a', 'An entity should record an allowance for credit losses on financial assets and should correspondingly record a credit loss expense for its current estimate of expected credit losses (CEECL).'),
(28, 1, 37, 'In respect of purchased financial assets with credit deterioration, if an entity uses a loss rate method, the entity should-', 'Not discount the expected credit losses', 'Record the undiscounted value of expected credit losses as allowance for credit losses', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'In respect of purchased financial assets with credit deterioration, if an entity uses a method other than a discounted cash flow method, the entity should not discount the expected credit losses and record the undiscounted value of expected credit losses as allowance for credit losses.'),
(29, 1, 36, 'In the context of ASC 326, which of the following statements is not correct?', '', '', '', '', '', '', 'Writeoffs of financial assets should be deducted from the allowance.', 'The liability for credit losses for off-balance-sheet financial instruments is reduced in the period in which the off-balance-sheet financial instruments expire.', 'An entity should always measure expected credit losses of financial assets on individual basis.', 'An entity should record an allowance for credit losses on financial assets and should correspondingly record a credit loss expense for its current estimate of expected credit losses (CEECL).', 'c', 'An entity should measure expected credit losses of financial assets on a collective (pool) basis when similar risk characteristics (one or more) exist.'),
(30, 1, 36, 'As per ASC 326, at each reporting date, an entity should compare its current estimate of expected credit losses with the estimate of expected credit losses previously recorded. The amount necessary to adjust the allowance for credit losses for management?s current estimate of expected credit losses on financial assets is reported as a ', 'Credit loss expense', 'Reversal of credit loss expense -', '', '', '', '', 'I only', 'II only', 'Either I or II', 'Neither I nor II', 'c', 'At each reporting date, an entity should compare its current estimate of expected credit losses with the estimate of expected credit losses previously recorded. The amount necessary to adjust the allowance for credit losses for management?s current estimate of expected credit losses on financial assets is reported a credit loss expense or a reversal of credit loss expense.'),
(31, 1, 36, 'With reference to ASC 326, in respect of available-for-sale debt securities if the present value of cash flows expected to be collected is less than the amortized cost basis of the security then-', '', '', '', '', '', '', 'A noncredit loss exists', 'A credit loss exists', 'Gain exists', 'No gain or loss exists', 'b', 'If the present value of cash flows expected to be collected is less than the amortized cost basis of the security, a credit loss exists and an allowance for credit losses should be recorded for the credit loss, limited by the amount that the fair value is less than amortized cost basis.'),
(32, 1, 36, 'In respect of purchased financial assets with credit deterioration, if an entity uses a loss rate method, any discount on purchase that is noncredit is-', '', '', '', '', '', '', 'a credit loss expense', 'accreted to interest income using the interest method based on the effective interest rate', 'immediately recorded as interest expense', 'immediately recorded as interest income', 'b', 'In respect of purchased financial assets with credit deterioration, if an entity uses a method other than a discounted cash flow method, the entity should not discount the expected credit losses and record the undiscounted value of expected credit losses as allowance for credit losses. Any discount on purchase that is noncredit is accreted to interest income using the interest method based on the effective interest rate.'),
(33, 1, 36, 'With reference to ASC 326, in respect of available-for-sale debt securities if an entity intends to sell the debt security or more likely than not will be required to sell the security, the amortized cost basis should be written down to the debt security?s fair value at the reporting date. The write down includes-', 'Credit related impairment ', 'Noncredit related impairment', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'In respect of available-for-sale debt securities if an entity intends to sell the debt security or more likely than not will be required to sell the security, the amortized cost basis should be written down to the debt security?s fair value at the reporting date. The write down includes both credit related impairment and noncredit related impairment.'),
(34, 1, 36, 'An entity should record an allowance for credit losses on financial assets and should correspondingly record a credit loss expense for its current estimate of expected credit losses (CEECL). The allowance for credit losses that is-', '', '', '', '', '', '', 'deducted from the asset?s fair value', 'added to the asset?s amortized cost ', 'deducted from the asset?s amortized cost ', 'added to the asset?s fair value', 'c', 'An entity should record an allowance for credit losses on financial assets and should correspondingly record a credit loss expense for its current estimate of expected credit losses (CEECL). The allowance for credit losses is deducted from the asset?s amortized cost basis.'),
(35, 1, 36, 'In the context of ASC 326, which of the following statements is not correct?', '', '', '', '', '', '', 'An entity should measure expected credit losses of financial assets on a collective (pool) basis when similar risk characteristics (one or more) exist.', 'At each reporting date, an entity should compare its current estimate of expected credit losses with the estimate of expected credit losses previously recorded.', 'When a loss-rate method is used, the allowance for credit losses is calculated using an estimated loss rate and multiplying it by the asset?s amortized cost at the balance sheet date.', 'In respect of purchased financial assets with credit deterioration, the discount embedded in the purchase price that is attributable to expected credit losses should be recognized as interest income.', 'd', 'In respect of purchased financial assets with credit deterioration, the discount embedded in the purchase price that is attributable to expected credit losses should not be recognized as interest income and also should not be reported as a credit loss expense upon acquisition.'),
(36, 1, 36, 'With reference to ASC 326, which of the following is not correct in respect of available-for-sale debt securities if an entity intends to sell the debt security or more likely than not will be required to sell the security?', 'Once an individual debt security has been written down, the previous amortized cost basis less noncredit related writeoffs becomes the new amortized cost basis of the investment.', 'Any allowance for credit losses should be written off.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'In respect of available-for-sale debt securities if an entity intends to sell the debt security or more likely than not will be required to sell the security before recovery of its amortized cost basis, once an individual debt security has been written down, the previous amortized cost basis less writeoffs (both credit and noncredit) becomes the new amortized cost basis of the investment.'),
(37, 1, 34, 'Meridian Media Co. undertakes the construction of buildings on August 15, Year 7. The construction is partly financed by $350,000 borrowings at the interest rate of 9% from Short Bank. The entity has other borrowings amounting to $600,000 and the average interest rate on those borrowings is 6%. The total amount spent on construction of building at the beginning of year 8 was $100,000 and at the beginning of year 9 was $500,000. The amount of interest capitalized on the building for year 9 is-', '', '', '', '', '', '', '$30,000', '$48,000', '$28,000', '$27,000', 'd', 'Interest capitalized = $300,000 X 9% = $27,000'),
(38, 1, 34, 'Jaino Co. purchases a factory equipment at a cash price of $25,000. The company also incurred sales taxes of $300 and the cost to install the equipment $500. At what amount the equipment is recorded?', '', '', '', '', '', '', '$25,000', '$25,300', '$25,500', '$25,800', 'd', 'All the costs incurred to bring an asset to the condition and location necessary for its intended use are included in the cost. '),
(39, 1, 34, 'Meridian Media Co. undertakes the construction of buildings on August 15, Year 7. The construction is partly financed by $350,000 borrowings at the interest rate of 9% from Short Bank. The entity has other borrowings amounting to $600,000 and the average interest rate on those borrowings is 6%. The total amount spent on construction of building at the beginning of year 8 was $100,000 and at the beginning of year 9 was $500,000. The average accumulated expenditures on the building for year 9 is-', '', '', '', '', '', '', '$300,000', '$400,000', '$500,000', '$1,000,000', 'a', 'Average accumulated expenditures = ($100,000+ $500,000)/2 = $300,000'),
(40, 1, 34, 'On February 1, 20X4, L Co. purchases an asset for $64,000 with a remaining useful life of 5 years and an estimated salvage value of $4,000. Depreciation is based on the number of months an asset is used. If the company uses the straight-line method to depreciate the asset, what should be the depreciation expense for 20X4?', '', '', '', '', '', '', '$12,000', '$12,800', '$11,000', '$10,000', 'c', 'Depreciation for 12 months = $60,000/5 = $12,000; Depreciation for 11 months = $12,000 X 11/12 = $11,000'),
(41, 1, 34, 'AICPA: Sea Manufacturing Corp. is constructing a new factory building. During the current calendar year, Sea made the following payments to the construction company: (a) January 2 - $1,000,000; (b) December 31 - $1,000,000. Sea has an 8%, three-year construction loan of $3,000,000. What is the amount of interest costs that Sea may capitalize during the current year? ', '', '', '', '', '', '', '$0', '$ 80,000', '$160,000', '$240,000', 'b', 'Average accumulated expenditures = ($1,000,000 X 12/12 + $1,000,000 X 0/12) = $1,000,000; Interest capitalized = 8% X $1,000,000 = $80,000'),
(42, 1, 34, 'On January 1, 20X4, A Co. purchases an asset for $100,000 with a remaining useful life of 5 years and an estimated salvage value of $10,000. The company uses the double-declining-balance method to depreciate the asset. Depreciation is based on the number of months an asset is used. At what amount the asset (net of depreciation) should appear in the balance sheet at the end of 20X5?', '', '', '', '', '', '', '$20,000', '$60,000', '$36,000', '$40,000', 'c', 'Carrying amount at the end of 2015 = $100,000 - $40,000 - $24,000 = $36,000'),
(43, 1, 34, 'On January 1, year 1 Netco Pioneers purchases a crane for $100,000 with a remaining useful life of 5 years and an estimated salvage value of $10,000. The crane is expected to be used 1,000 hours in the first year, 1,500 hours in the second, 1,200 hours in the third year, 1,300 hours in the fourth year and 1,000 hours in the fifth year. The company depreciates the crane basis hours used. If this is the only depreciable asset owned by the company, the depreciation expense for year 1 and year 2 is-', '', '', '', '', '', '', 'Year 1: $40,000; Year 2: $24,000', 'Year 1: $30,000; Year 2: $21,000', 'Year 1: $15,000; Year 2: $22,500', 'Year 1: $30,000; Year 2: $24,000', 'c', 'Depreciation rate = $90,000/ 6,000 hours = $15 per hour; Depreciation year 1 = 1,000 X $15 = $15,000; Depreciation year 2 = 1,500 X $15 = $22,500'),
(44, 1, 34, 'Which of the following is correct regarding impairment of property, plant and equipment under U.S. GAAP?', 'An entity should measure impairment loss for all the assets individually.', 'Restoration of a previously recognized impairment loss is allowed. ', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'd', 'For purposes of recognition and measurement of an impairment loss, a long-lived asset should be grouped at an appropriate level with other assets and liabilities. Restoration or recovery of a previously recognized impairment loss is not allowed.'),
(45, 1, 34, 'Component depreciation is required under-', 'U.S. GAAP', 'IFRS', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'b', 'Under IFRS, component depreciation is required. Each component of an item of property, plant and equipment that is significant in relation to the total cost of the item should be separately depreciated. Under U.S. GAAP, component depreciation is not required but is allowed.'),
(46, 1, 36, 'Which of the following is correct regarding group/composite depreciation?', 'An entity depreciates assets collectively instead of depreciating assets individually.', 'When an asset from the group is sold, no gain or loss on sale is recognized.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'Under group/composite depreciation, an entity depreciates assets collectively instead of depreciating assets individually. And when an asset from the group is sold, no gain or loss on sale is recognized instead the difference between the cost of the asset and the proceeds from the sale is debited to the accumulated depreciation account.'),
(47, 1, 36, 'Which of the following is included in income from continuing operations before income taxes in the income statement?', 'An impairment loss for property, plant and equipment that is held and used.', 'A gain or loss recognized on the sale of property, plant and equipment that is held and used.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'The following items are included in income from continuing operations before income taxes in the income statement. (a) An impairment loss on property, plant and equipment that is held and used. (b) A gain or loss on the sale of on property, plant and equipment that is held and used.'),
(48, 1, 36, 'Which of the following approaches is acceptable, when an asset is sold or acquired in the middle of the year.', 'Full year depreciation in the year of acquisition and none in the year of sale. ', '6-months? depreciation both in the year of acquisition and in the year of sale. ', 'Depreciation based on number of months an asset was used both in the year of acquisition and in the year of sale ', '', '', '', 'I only', 'II only', 'III only', 'All three', 'd', 'If any asset is sold or acquired in the middle of the year, the following three approaches are acceptable. (a) Full year depreciation in the year of acquisition and none in the year of sale. (b) 6-months? depreciation both in the year of acquisition and in the year of sale. (c) Depreciation based on number of months an asset was used both in the year of acquisition and in the year of sale (rounded to the nearest whole month). '),
(49, 1, 36, 'Which of the following is not correct regarding the revaluation model under IFRS?', '', '', '', '', '', '', 'If an asset is accounted for using the revaluation model, all the other assets in its class should also be accounted for using the revaluation model.', 'Any gain on revaluation is generally recognized in other comprehensive income.', 'Any loss on revaluation is generally reported on the income statement. ', 'When the asset is sold, the gain or loss on sale is included in other comprehensive income.', 'd', 'If the asset is accounted for using the revaluation model, all the other assets in its class should also be accounted for using the revaluation model, except when there is no active market for those assets. Any gain on revaluation is recognized in other comprehensive income and accumulated in the revaluation surplus account. However, the gain should be reported on the income statement to the extent that it reverses a revaluation loss previously reported on the income statement. Any loss on revaluation is reported on the income statement. However, the loss should be recognized in other comprehensive income to the extent of any credit balance in the revaluation surplus. When an asset is sold, the difference between the sale value and the carrying amount is recognized as a gain or loss and reported on the income statement.'),
(50, 1, 36, 'On January 1, year 1 Netco Pioneers purchases a crane for $100,000 with a remaining useful life of 5 years and an estimated salvage value of $10,000. The company uses the sum-of-the-years?-digits method to depreciate the crane. If this is the only depreciable asset owned by the company, the depreciation expense for year 1 and year 2 is-', '', '', '', '', '', '', 'Year 1: $22,500; Year 2: $22,500', 'Year 1: $40,000; Year 2: $24,000', 'Year 1: $30,000; Year 2: $21,000', 'Year 1: $30,000; Year 2: $24,000', 'd', 'Depreciation year 1 = $90,000 X 5/15 = $30,000; Depreciation year 2 = $90,000 X 4/15 = $24,000'),
(51, 1, 37, 'Orezon International starts its operations in year 1. The company purchases computers, photocopy machines and office printers on Jan. 1, year 1. It groups all its office equipment (computers, photocopy machines and office printers) and depreciates them collectively using the composite depreciation rate and composite life. During year 2, the company sells one computer for $10,000 (original cost $14,000). Regarding the computer sold, determine the account and the amount to be debited when you are provided with the following information.', 'Computers purchased on Jan. 1, year 1: cost $800,000, salvage value $80,000 and useful life 6 years.', 'Photocopy machines purchased on Jan. 1, year 1: cost $700,000, salvage value $100,000 and useful life 12 years.', 'Printers purchased on Jan. 1, year 1: cost $400,000, salvage value $40,000 and useful life 9 years.', '', '', '', 'Cash $14,000', 'Accumulated depreciation $4,000', 'Equipment $14,000', 'Loss $4,000', 'b', 'When an asset from the group is sold, no gain or loss on sale is recognized instead the difference between the cost of the asset and the proceeds from the sale is debited to the accumulated depreciation account.'),
(52, 1, 37, 'Harley Equipment Co. purchased a machinery on January 1, 20X3, for 82,000. The machinery was depreciated on a straight-line basis over 6 years with $10,000 salvage value. On December 1, 20X5, the machinery was sold for $40,000. What is the loss on sale of machinery, when depreciation is based on the number of months the asset is used?', '', '', '', '', '', '', '$32,000', '$42,000', '$7,000', '$0', 'c', 'Loss = Carrying amount ? Sale Value = ($82,000 - $35,000) - $40,000 = $7,000'),
(53, 1, 37, 'On June 15, year 5, Simple Co. sold $50,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $10,000. The amount remaining was received on July 20, year 5. The company uses the gross method to account for the discounts. The company records the sales at-', '', '', '', '', '', '', '$50,000', '$45,000', '$10,000', '$8,000', 'a', 'Under the gross method, accounts receivable and sales are recorded at gross amount without regard to cash discounts. Any payment received within the discount period is recorded along with the cash discount. If the customer makes the payment within the discount period, the entity receives cash less than the recorded amount of the receivable and records the difference as a debit to cash discounts taken account. However, if the customer does not take the cash discount, the customer is required to pay an amount that is equal to the recorded amount of the receivable and no further adjustment is needed.'),
(54, 1, 37, 'Working capital equals-', '', '', '', '', '', '', 'Current assets plus current liabilities', 'Current assets minus current liabilities', 'Cash + accounts receivables + marketable securities', 'Current assets divided by current liabilities', 'b', 'Working capital is the excess of current assets over current liabilities. It represents the liquid portion of the capital that constitutes a buffer for meeting short-term obligations.'),
(55, 1, 37, 'Which of the following is not considered cash and cash equivalent?', '', '', '', '', '', '', 'Cash in checking account', 'A municipal bond purchased 4 years ago.', 'A 5-year treasury note purchased 3 months from maturity.', 'Petty cash ', 'b', 'Cash and cash equivalents include cash in checking account, a 5-year treasury note purchased 3 months from maturity, and petty cash. It does not include a municipal bond purchased 4 years ago even if the remaining maturity is 3 months or less.'),
(56, 1, 37, 'On June 15, year 5, Simple Co. sold $50,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $10,000. The amount remaining was received on July 20, year 5. The company uses the gross method to account for the discounts. The amount of cash received on June 20 is-', '', '', '', '', '', '', '$10,000', '$9,800', '$50,000', '$49,000', 'b', 'Under the gross method, accounts receivable and sales are recorded at gross amount without regard to cash discounts. Any payment received within the discount period is recorded along with the cash discount. If the customer makes the payment within the discount period, the entity receives cash less than the recorded amount of the receivable and records the difference as a debit to cash discounts taken account. However, if the customer does not take the cash discount, the customer is required to pay an amount that is equal to the recorded amount of the receivable and no further adjustment is needed.'),
(57, 1, 37, 'During the current year, Apex Co. made credit sales of $1,000,000. It is estimated 3% of all credit sales will be uncollectible. The balance in gross accounts receivable and allowance for doubtful debts at the end of the year were $500,000 and $25,000, respectively. What is the bad debt expense for the current year?', '', '', '', '', '', '', '$30,000', '$25,000', '$15,000', '$5,000', 'a', 'A bad debt expense is estimated as a percent of credit sales and any existing balance in the allowance account is ignored. '),
(58, 1, 14, 'On Jan. 1, year 5, Jam Co. sold a truck to Big Hop for $80,000 in exchange for a non-interest bearing note of $28,000 due in 2 years. The carrying amount of the truck in the books of Jam Co. is $90,000. The market value of the truck on Jan 1, year 5, is $75,000. The amount of discount on notes receivables recognized by is-', '', '', '', '', '', '', '$15,000', '$10,000', '$5,000', '$0', 'c', 'Since no interest is stated on the note, the $80,000 face value of the note is not the present value of the note. The $75,000 is considered the present value of the note and the difference of $5,000 ($80,000 - $75,000) is recognized as discount on note receivable.'),
(59, 1, 14, 'On June 15, year 5, Simple Co. sold $50,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $10,000. The amount remaining was received on July 20, year 5. The company uses the gross method to account for the discounts. On June 20, the company credits the accounts receivable for-', '', '', '', '', '', '', '$10,000', '$8,000', '$40,000', '$36,000', 'a', 'Under the gross method, accounts receivable and sales are recorded at gross amount without regard to cash discounts. Any payment received within the discount period is recorded along with the cash discount. If the customer makes the payment within the discount period, the entity receives cash less than the recorded amount of the receivable and records the difference as a debit to cash discounts taken account. However, if the customer does not take the cash discount, the customer is required to pay an amount that is equal to the recorded amount of the receivable and no further adjustment is needed.'),
(60, 1, 14, 'Jerry Co.?s records show a cash balance of $80,000. A review of the bank statement disclosed that a customer note for $2,000 was collected directly by the bank on April 30, and another customer check for $500 was returned because of insufficient funds. These are not recorded in the books. The company should report an adjusted cash balance of-', '', '', '', '', '', '', '$81,500', '$80,000', '$78,500', '$82,000', 'a', 'Notes collected by the bank on behalf of the entity are reported on bank statement but are not recorded by the entity on its books. These are added to the cash balance in the books. A NSF check (a check that a company has deposited but that is not paid when the bank presents it to the customer?s bank) is deducted from the balance reported on the bank statement. These charges have not been deducted by the entity from its cash balance and should be deducted now to arrive at the adjusted cash balance (true cash balance). Adjusted cash balance = Balance in the accounting records + Note collected by the bank - NSF check returned = $80,000 + $2,000 - $500 = $81,500.'),
(61, 1, 14, 'Fun Co. sold an item with a list price of $30,000. It offers a trade discount of 10% and a credit terms of 2/10, n/30. The company uses the net method to account for its discounts. The company should credit sales for-', '', '', '', '', '', '', '$30,000', '$26,460', '$29,400', '$27,000', 'b', 'Under the net method, cash discounts are recorded at the time of sales. Therefore, accounts receivable and sales are recorded net of discounts. JE: Debit Accounts Receivable $26,460; Credit Sales $26,460.');
INSERT INTO `questionnaire` (`questionnaire_id`, `subject_id`, `chapter_id`, `questionnaire_text`, `point_1`, `point_2`, `point_3`, `point_4`, `point_5`, `q_image`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explaination_text`) VALUES
(62, 1, 14, 'Fun Co. sold an item with a list price of $30,000. It offers a trade discount of 10% and a credit terms of 2/10, n/30. The company uses the net method to account for its discounts. If the buyer pays with in the 10-day discount period, the journal entry to record the collection would include a-', '', '', '', '', '', '', 'Credit to accounts receivable for $26,460', 'Debit to cash for $27,000', 'Debit to discount taken account for $600', 'Credit to discount taken account for $600', 'a', 'If the customer makes the payment within the discount period, the amount of cash received equals the amount recorded as the receivable. JE: Debit Cash $26,460; Credit Accounts Receivable $26,460.'),
(63, 1, 14, 'Hawker sold services to Timmy on January 1, year 6, and accepted a $60,000 note as payment for the services rendered. The note does not carry any interest and is payable in three equal annual installments of $20,000 each, beginning December 31, year 6.  There is no established market for the services or the note. The appropriate rate of interest is determined to be 10%.  The present value of an ordinary annuity of 1 for 3 periods at 10% is 2.48685. Hawker should record a discount on notes receivable for-', '', '', '', '', '', '', '$10,267', '$6,000', '$3,422', '$2,000', 'a', 'Present value of the note = $20,000 X 2.48685 = $49,737; Discount - $60,000 - $49,737 = $10,267'),
(64, 1, 14, 'On June 15, year 5, Total Mark Co. sold $100,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $20,000. The amount remaining was received on July 20, year 5. The company uses the net method to account for the discounts. On June 20, the company does the following.', 'Reverses the discount not taken account.', 'Records the discount taken account.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'd', 'Under the net method, cash discounts are considered at the time of sales. Therefore, accounts receivable and sales are recorded net of discounts. If the customer makes the payment within the discount period, the amount of cash received equals the amount recorded as the receivable and therefore, no adjustment is required. However, if the customer does not take the cash discount, the entity receives an amount that is more than the amount recorded as the receivable and difference is credited to the cash discount not taken account.'),
(65, 1, 14, 'Fun Co. sold an item with a list price of $30,000. It offers a trade discount of 10% and a credit terms of 2/10, n/30. The company uses the net method to account for its discounts. If the buyer does not pay within the discount period, the journal entry to record the collection would include a-', '', '', '', '', '', '', 'Credit to accounts receivable for $27,000', 'Debit to cash for $27,000', 'Debit to discount not taken account for $600', 'Credit to discount taken account for $540', 'b', 'If the customer does not take the cash discount, the entity receives an amount that is more than the amount recorded as the receivable and difference is credited to the cash discount not taken account. JE: Debit Cash $27,000; Credit Accounts Receivable $26,460; Credit Discount Not Taken $540.'),
(66, 1, 14, 'On June 15, year 5, Simple Co. sold $50,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $10,000. The amount remaining was received on July 20, year 5. The company uses the gross method to account for the discounts. On July 20, the company does the following.', 'Reverses the discount taken account.', 'Records the discount not taken account.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'd', 'Under the gross method, accounts receivable and sales are recorded at gross amount without regard to cash discounts. Any payment received within the discount period is recorded along with the cash discount. If the customer makes the payment within the discount period, the entity receives cash less than the recorded amount of the receivable and records the difference as a debit to cash discounts taken account. However, if the customer does not take the cash discount, the customer is required to pay an amount that is equal to the recorded amount of the receivable and no further adjustment is needed.'),
(67, 1, 14, 'On Dec. 10, year 7, Hanson Tech Co. sells $100,000 of accounts receivable to a bank and receives 97% of the value of the accounts. Hanson transfers the receivables to the bank but undertakes to service the financial assets. The fair value of servicing asset on the date of transfer is $4,000. Determine the amount of gain or loss on sale of receivables.', '', '', '', '', '', '', '$3,000 loss', '$1,000 loss ', '$1,000 gain', 'No gain or loss', 'c', 'A service provider should measure and recognize a servicing asset or a servicing liability at fair value when it enters into a contract to service a financial asset. However, a service provider that transfers financial assets in a transaction that is accounted for as a secured borrowing (because the transaction does not meet the requirements for sale accounting) should not recognize a servicing asset or a servicing liability. Gain on sale = $4,000 - $3,000 = $1,000.'),
(68, 1, 14, 'Which of the following method for recognizing bad debts is permitted under U.S. GAAP?', 'Allowance method', 'Direct write-off method', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'The direct write-off method is not consistent with the matching principle and is not permitted under U.S. GAAP.'),
(69, 1, 14, 'Current assets include assets that are reasonably expected to be realized in cash or consumed -', '', '', '', '', '', '', 'within one year', 'Within one year or during the normal operating cycle, whichever is longer.', 'Within one year or during the normal operating cycle, whichever is shorter.', 'During the normal operating cycle.', 'b', 'Current assets include (a) cash and (b) other assets that are reasonably expected to be realized in cash or sold or consumed within one year or during the normal operating cycle, whichever is longer. Examples of current assets include cash and cash equivalents, inventories, accounts, notes, and acceptances receivable, other short-term receivables, trading securities, other marketable securities representing the investment of cash available for current operations, and prepaid expenses.'),
(70, 1, 20, 'Getty Ventures purchases equipment at a cash price of $250,000. Calculate the amount to be capitalized when the company incurred the following related expenditures.', 'Sales taxes $24,000', 'Freight inwards $6,000', 'Insurance during shipping $2,000', 'Installation expenses $3,000', '', '', '$250,000', '$261,000', '$283,000', '$285,000', 'd', 'Cost capitalized = $250,000 + $24,000 + $6,000 + $2,000 + $3,000 = $285,000'),
(71, 1, 20, 'During the year, Husky Bank purchases a land and building for $900,000. An appraisal performed by the company indicates that the land?s market value is $600,000 and the building?s market value is $400,000. Husky bank should capitalize land for', '', '', '', '', '', '', '$600,000', '$540,000', '$400,000', '$360,000', 'b', 'Eddie Imaging should allocate $900,000 between the land and the building in the ratio of 3:2'),
(72, 1, 20, 'On January 1, year 1 Netco Pioneers purchases a crane for $100,000 with a remaining useful life of 5 years and an estimated salvage value of $10,000. The company uses the double declining balance method to depreciate the crane. If this is the only depreciable asset owned by the company, the depreciation expense for year 1 and year 2 is-', '', '', '', '', '', '', 'Year 1: $22,500; Year 2: $22,500', 'Year 1: $40,000; Year 2: $24,000', 'Year 1: $30,000; Year 2: $21,000', 'Year 1: $30,000; Year 2: $24,000', 'b', 'Depreciation year 1 = 40% X $100,000 = $40,000; Depreciation year 2 = 40% X $60,000 = $24,000'),
(73, 1, 20, 'AICPA: Restorations of carrying value for long-lived assets are permitted if an asset''s fair value increases subsequent to recording an impairment loss for which of the following? ', '', '', '', '', '', '', 'Held for use - Yes; Held for disposal ? Yes', 'Held for use - Yes; Held for disposal - No', 'Held for use - No; Held for disposal - Yes', 'Held for use - No; Held for disposal - No', 'c', 'Restoration or recovery of a previously recognized impairment loss on an asset held for use is not allowed. However, in respect of an asset held for sale, recovery of a previously recognized impairment loss is allowed.'),
(74, 1, 20, 'Which of the following interest is not likely to be capitalized?', '', '', '', '', '', '', 'Interest on funds borrowed for constructing equipment meant for own use. The construction is not yet complete.', 'Interest on funds borrowed for constructing an airplane. The airplane is constructed as discrete projects and intended for sale. The construction is not yet complete.', 'Interest on funds borrowed for constructing factory building. The building is constructed for own use but the construction is suspended due to reason beyond the control of the entity.', 'Interest on funds borrowed for constructing an asset. The construction is complete and the asset is already in use.', 'd', 'Generally, interest cost should be capitalized for all assets that require a period of time to bring them to the condition and location necessary for their intended use. Therefore, interest on assets that are already in use is not capitalized. Interest on assets constructed for own use and assets constructed as discrete projects and intended for sale are particularly identified for interest capitalization. Interest on factory building constructed for own use should continue to be capitalized because the construction is suspended due to reason beyond the control of the entity.'),
(75, 1, 20, 'Orezon International starts its operations in year 1. The company purchases computers, photocopy machines and office printers on Jan. 1, year 1. It groups all its office equipment (computers, photocopy machines and office printers) and depreciates them collectively using the composite depreciation rate and composite life. During year 2, the company sells one computer for $10,000 (original cost $14,000). Determine the amount of gain or loss recognized when you are provided with the following information.', 'Computers purchased on Jan. 1, year 1: cost $800,000, salvage value $80,000 and useful life 6 years.', 'Photocopy machines purchased on Jan. 1, year 1: cost $700,000, salvage value $100,000 and useful life 12 years.', 'Printers purchased on Jan. 1, year 1: cost $400,000, salvage value $40,000 and useful life 9 years.', '', '', '', '$14,000 loss', '$4,000 loss', '$10,000 loss', 'No gain or loss', 'd', 'When an asset from the group is sold, no gain or loss on sale is recognized instead the difference between the cost of the asset and the proceeds from the sale is debited to the accumulated depreciation account.'),
(76, 1, 20, 'Spicy Food purchases a kitchen equipment for its new restaurant. Which of the following costs associated with the equipment purchase should not be capitalized?', '', '', '', '', '', '', 'Cost of shipping the equipment to the new restaurant.', 'Insurance during shipping.', 'Cost to test the equipment.', 'Annual insurance after installation.', 'd', 'All the costs incurred to bring the equipment to the condition and location necessary for its intended use are included in the cost. Annual insurance cost after installation is not the cost that is needed to bring the equipment to the condition and location necessary for its intended use. Therefore, the annual insurance cost is not capitalized.'),
(77, 1, 20, 'AICPA: Four years ago on January 2, Randall Co. purchased a long-lived asset. The purchase price of the asset was $250,000, with no salvage value. The estimated useful life of the asset was 10 years. Randall used the straight-line method to calculate depreciation expense. An impairment loss on the asset of $30,000 was recognized on December 31 of the current year. The estimated useful life of the asset at December 31 of the current year did not change. What amount should Randall report as depreciation expense in its income statement for the next year?', '', '', '', '', '', '', '$20,000', '$22,000', '$25,000', '$30,000', 'a', 'The carrying amount of the long-lived asset after recognizing impairment loss is $120,000. The $120,000 is depreciated on a straight-line basis over the period of the asset?s useful life (6 years).'),
(78, 1, 20, 'T Co. is constructing an office building and borrowed funds from a local bank for the construction. The company should not capitalize interest during the temporary suspension of construction activities, if the suspension is-', 'Intentional.', 'Related to obtaining license and approvals.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'If the entity intentionally suspends the necessary activities related to the asset, the entity should not capitalize interest until activities are resumed. If the suspension is due to delays inherent in the asset acquisition process or is due to external forces, then interest capitalization does not stop. '),
(79, 1, 20, 'Pacific Technology commenced construction of equipment on January 1, year 3. On Dec. 31, year 3, the total amount spent on equipment (not yet complete) is $800,000.  Expenditures were made evenly throughout the year. Determine the amount interest that should be capitalized, when the following borrowings were outstanding during year 3.', '5%, $200,000 loan for construction of equipment (interest expense $10,000)', '$700,000 other debt, average interest rate 7% (interest expense $49,000)', '', '', '', '', '$40,000', '$16,000', '$24,000', '$49,000', 'c', 'Interest capitalized = $200,000 X 5% + $200,000 X 7% = $24,000'),
(80, 1, 20, 'Which of the following is correct regarding interest capitalization?', '', '', '', '', '', '', 'Interest can be capitalized for inventories routinely manufactured in large quantities.', 'Interest can be capitalized on assets already in use.', 'Interest capitalization period ends only when the asset is actually put to use.', 'Interest can be capitalized on assets produced for an entity?s own use. ', 'd', 'Interest is not capitalized on inventories routinely produced in large quantities and on an asset already in use. Interest capitalization period ends when the asset is substantially complete or ready for intended use.'),
(81, 1, 20, 'AICPA: A company acquired an aircraft for $120 million, with the cost consisting of the airframe, $60 million; the engine, $40 million; and other components, $20 million. The company applies the cost model and uses the straight-line method of depreciation. The aircraft has a total estimated useful life of 20 years and no residual value. The estimated useful lives of the components are as follows: (a) Airframe ? 20 years; (b) Engine ? 16 years; (c) Other components ? 4 years. Under IFRS, what amount should the company record as annual depreciation expense?', '', '', '', '', '', '', '$3 million.', '$6 million.', '$6.5 million.', '$10.5 million.', 'd', 'Total depreciation $10.5 million, calculated as Airframe: $60 million/20 years = $3 million; Engine : $40 million/16 years = $2.5 million; Other components : $20 million/4 years = $5 million. '),
(82, 1, 20, 'On June 15, year 5, Simple Co. sold $50,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $10,000. The amount remaining was received on July 20, year 5. The company uses the gross method to account for the discounts. The amount of cash received on July 20 is-', '', '', '', '', '', '', '$50,000', '$40,000', '$49,000', '$39,200', 'b', 'Under the gross method, accounts receivable and sales are recorded at gross amount without regard to cash discounts. Any payment received within the discount period is recorded along with the cash discount. If the customer makes the payment within the discount period, the entity receives cash less than the recorded amount of the receivable and records the difference as a debit to cash discounts taken account. However, if the customer does not take the cash discount, the customer is required to pay an amount that is equal to the recorded amount of the receivable and no further adjustment is needed.'),
(83, 1, 20, 'On March 10, year 5, Eltek Co. sold goods to Delta Tankers for $80,000 and received a 60-day, 9%, $80,000 note. On March 30, year 5, the company discounted the note. The bank charged 24% discount on the note. The discounting of the note is accounted for as a sale and number of days in a year used for calculation purposes is 360. What is the amount of cash received on discounting of note?', '', '', '', '', '', '', '$79,035', '$77,600', '$70,400', '$70,400', 'a', 'Cash received = $80,000 + Interest on note to maturity ($80,000 X 9% X 60/360) -  Discount ($81,200 X 24% X 40/360) = $79,035 '),
(84, 1, 20, 'On Dec. 10, year 7, Hanson Tech Co. sells $100,000 of accounts receivable to a bank and receives 97% of the value of the accounts. Hanson transfers the receivables to the bank but undertakes to service the financial assets. The fair value of servicing asset on the date of transfer is $4,000. The company should-', '', '', '', '', '', '', 'Record the servicing asset at $7,000', 'Record the servicing asset at $3,000', 'Record the servicing asset at $4,000', 'Not record the servicing asset', 'c', 'A service provider should measure and recognize a servicing asset or a servicing liability at fair value when it enters into a contract to service a financial asset. However, a service provider that transfers financial assets in a transaction that is accounted for as a secured borrowing (because the transaction does not meet the requirements for sale accounting) should not recognize a servicing asset or a servicing liability.'),
(85, 1, 20, 'Current liabilities are obligations that are reasonably expected to be paid-', '', '', '', '', '', '', 'Within one year', 'Within one year or during the normal operating cycle, whichever is longer.', 'Within one year or during the normal operating cycle, whichever is shorter.', 'During the normal operating cycle.', 'b', 'Current liabilities are obligations whose liquidation is reasonably expected to require the use of current assets or the creation of other current liabilities within one year or the normal operating cycle, whichever is longer. Examples of current liabilities include accounts payable, accruals for expenses, collections received in advance of the delivery of goods or performance of services, loans due on demand, and liabilities that are expected to be repaid within 12 months.'),
(86, 1, 20, 'Highly liquid investments that are readily convertible to known amounts of cash are classified as cash equivalents, when the investments-', '', '', '', '', '', '', 'Have an original maturity of 1 year.', 'Have an original maturity of 90 days or less.', 'Have a remaining maturity of 1 year.', 'Have a remaining maturity of 90 days or less.', 'b', 'Investments with original maturities of three months or less are usually considered cash equivalents. Original maturity refers to original maturity to the reporting entity holding the investment.'),
(87, 1, 20, 'On June 15, year 5, Total Mark Co. sold $100,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $20,000. The amount remaining was received on July 20, year 5. The company uses the net method to account for the discounts. The company records the sales at-', '', '', '', '', '', '', '$100,000', '$98,000', '$80,000', '$78,400', 'b', 'Under the net method, cash discounts are considered at the time of sales. Therefore, accounts receivable and sales are recorded net of discounts. If the customer makes the payment within the discount period, the amount of cash received equals the amount recorded as the receivable and therefore, no adjustment is required. However, if the customer does not take the cash discount, the entity receives an amount that is more than the amount recorded as the receivable and difference is credited to the cash discount not taken account.'),
(88, 1, 20, 'On March 5, year 7, Diamant Mining Co. sells $300,000 of accounts receivable to Jig-Jack Bank. The bank (factor) charges 2% commission based on the gross amount of accounts receivable factored and retains 8% holdback. On March 15, year 7, the goods returned on factored accounts amounted to $1,000. On April 1, year 7, the customer return privilege period expires and the remaining holdback is returned by the bank. The amount of loss on sale of receivables recorded by Diamant on March 5 is-', '', '', '', '', '', '', '$0', '$6,000', '$24,000', '$30,000', 'b', 'Loss = $6,000 '),
(89, 1, 20, 'Bob Simon, the accountant of Mark Spinning Machine Co., is preparing the company?s financial statements for the year 20X5. Which of the below mentioned 2 items, should Bob include in cash and cash equivalents?', '$45,000 Municipal bonds, purchased by the company on December 15, 20X5, maturing on 31 January 20X6.', 'A deposit of $400 by a customer directly into the bank account that is not yet entered in the books.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'Municipal bonds have an original maturity of 3 months or less and therefore, are included in cash and cash equivalents. Any amount deposited directly in the company?s bank account should be included in cash and cash equivalents.'),
(90, 1, 21, 'Total Solutions Co. sold goods to one of its customers for $100,000 and received a 6 month, 8% note. After holding the note for 2 months, the company discounted the note at 12%. What amount is reported by Total Solutions as loss on discounting of note?', '', '', '', '', '', '', '$4,160', '$160', '$4,000', '$0', 'b', 'Discount $4,160 (-) Interest on note to maturity ($100,000 X 8% X 6/12) = $160'),
(91, 1, 21, 'On June 15, year 5, Simple Co. sold $50,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $10,000. The amount remaining was received on July 20, year 5. The company uses the gross method to account for the discounts. On June 20, the company does the following.', 'Debits the discount taken account.', 'Credits the discount not taken account.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'Under the gross method, accounts receivable and sales are recorded at gross amount without regard to cash discounts. Any payment received within the discount period is recorded along with the cash discount. If the customer makes the payment within the discount period, the entity receives cash less than the recorded amount of the receivable and records the difference as a debit to cash discounts taken account. However, if the customer does not take the cash discount, the customer is required to pay an amount that is equal to the recorded amount of the receivable and no further adjustment is needed.'),
(92, 1, 21, 'Good Life Store has credit sales of $200,000 in 20X3. Based on past experience, the store manager estimates that 3% of all credit sales will be uncollectible. Gross accounts receivable and allowance for doubtful debts as on December 31, 20X3, are $120,000 and $1,000 respectively. What amount should Good Life Store report as uncollectible expense for 20X3?', '', '', '', '', '', '', '$3,600', '$6,000', '$1,000', '$5,000', 'b', 'A bad debt expense is estimated as a percent of credit sales and any existing balance in the allowance account is ignored.'),
(93, 1, 21, 'On June 15, year 5, Total Mark Co. sold $100,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $20,000. The amount remaining was received on July 20, year 5. The company uses the net method to account for the discounts. On July 20, the company does the following.', 'Credits the discount not taken account.', 'Debits the discount taken account.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'Under the net method, cash discounts are considered at the time of sales. Therefore, accounts receivable and sales are recorded net of discounts. If the customer makes the payment within the discount period, the amount of cash received equals the amount recorded as the receivable and therefore, no adjustment is required. However, if the customer does not take the cash discount, the entity receives an amount that is more than the amount recorded as the receivable and difference is credited to the cash discount not taken account.'),
(94, 1, 21, 'On Jan. 5, year 6, Elan Funding Co. transfers $100,000 of its accounts receivable to Dialog Bank. The bank pays $92,000 after deducting a commission of 8% on the gross amount of accounts receivable. The company retains the servicing activities and is responsible for all the bad debts. The bank does not have the right to sell the receivables. On April 20, year, the company collects all its receivables and pays the bank. $8,000 is reported as-', '', '', '', '', '', '', 'Borrowings', 'Interest expense', 'Loss', 'Holdback', 'b', 'Transfers of financial assets that do not meet the conditions for a sale are accounted for as secured borrowings with a pledge of collateral. The proceeds from the transfer are considered a borrowing and the transfer of financial assets is considered a pledge of collateral. The transferor should continue to report the transferred financial asset in its balance sheet. When the entity collects the receivables, the amount borrowed plus any interest charges are paid.'),
(95, 1, 21, 'Tim and Mark Store has credit sales of $500,000 in 20X4. Based on past experience, the store manager estimates its bad debts to be 3% of the outstanding gross accounts receivable balance. Gross accounts receivable and allowance for doubtful debts as on December 31, 20X4, are $400,000 and $5,000 respectively. What amount should Good Life Store report on its balance sheet as allowance for doubtful debts on December 31, 20X4?', '', '', '', '', '', '', '$7,000', '$6,000', '$1,000', '$12,000', 'd', 'The ending balance of allowance for doubtful debts is 3% of $400,000.'),
(96, 1, 21, 'Good Life Store has credit sales of $200,000 in 20X3. Based on past experience, the store manager estimates that 3% of all credit sales will be uncollectible. Gross accounts receivable and allowance for doubtful debts as on December 31, 20X3, are $120,000 and $1,000 respectively. What amount should Good Life Store report on its balance sheet as allowance for doubtful debts on December 31, 20X3?', '', '', '', '', '', '', '$7,000', '$6,000', '$1,000', '$5,000', 'a', 'The ending balance of allowance for doubtful debts include the existing balance of $1,000 and new allowance created $6,000.'),
(97, 1, 21, 'On June 15, year 5, Total Mark Co. sold $100,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $20,000. The amount remaining was received on July 20, year 5. The company uses the net method to account for the discounts. The amount of cash received on July 20 is-', '', '', '', '', '', '', '$20,000', '$19,600', '$80,000', '$78,400', 'c', 'Under the net method, cash discounts are considered at the time of sales. Therefore, accounts receivable and sales are recorded net of discounts. If the customer makes the payment within the discount period, the amount of cash received equals the amount recorded as the receivable and therefore, no adjustment is required. However, if the customer does not take the cash discount, the entity receives an amount that is more than the amount recorded as the receivable and difference is credited to the cash discount not taken account.'),
(98, 1, 21, 'On Jan. 5, year 6, Elan Funding Co. transfers $100,000 of its accounts receivable to Dialog Bank. The bank pays $92,000 after deducting a commission of 8% on the gross amount of accounts receivable. The company retains the servicing activities and is responsible for all the bad debts. The bank does not have the right to sell the receivables. On April 20, year 6, the company collects all its receivables and pays the bank. Elan should record the cash received as ?', 'Borrowings', 'Sale of accounts receivables with a pledge of collateral', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'Transfers of financial assets that do not meet the conditions for a sale are accounted for as secured borrowings with a pledge of collateral. The proceeds from the transfer are considered a borrowing and the transfer of financial assets is considered a pledge of collateral. The transferor should continue to report the transferred financial asset in its balance sheet. When the entity collects the receivables, the amount borrowed plus any interest charges are paid.'),
(99, 1, 21, 'During 20X5, Gritty Pet Foods sold goods of $900,000 on credit. The credit manager estimates its bad debts to be 4% of its credit sales. During 20X5, a customer who owed $8,000 refused to pay. This amount is considered uncollectible. Gross accounts receivable and allowance for doubtful debts as on December 31, 20X5, are $300,000 and $10,000 respectively. What amount should Gritty report as bad debt expense?', '', '', '', '', '', '', '$36,000', '$46,000', '$10,000', '$38,000', 'a', 'A bad debt expense is estimated as a percent of credit sales and any existing balance in the allowance account is ignored.'),
(100, 1, 21, 'Tim and Mark Store has credit sales of $500,000 in 20X4. Based on past experience, the store manager estimates its bad debts to be 3% of the outstanding gross accounts receivable balance. Gross accounts receivable and allowance for doubtful debts as on December 31, 20X4, are $400,000 and $5,000 respectively. What amount should Tim and Mark Store report as uncollectible expense for 20X4?', '', '', '', '', '', '', '$7,000', '$12,000', '$20,000', '$15,000', 'a', 'Uncollectible accounts at the end of the year are estimated as 3% of $400,000.  Any amount necessary to bring the existing allowance account balance of $5,000 equal to the required ending balance of $12,000 is recorded as a bad expense.'),
(101, 1, 21, 'On June 15, year 5, Total Mark Co. sold $100,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $20,000. The amount remaining was received on July 20, year 5. The company uses the net method to account for the discounts. The amount of cash received on June 20 is-', '', '', '', '', '', '', '$20,000', '$19,600', '$80,000', '$78,400', 'b', 'Under the net method, cash discounts are considered at the time of sales. Therefore, accounts receivable and sales are recorded net of discounts. If the customer makes the payment within the discount period, the amount of cash received equals the amount recorded as the receivable and therefore, no adjustment is required. However, if the customer does not take the cash discount, the entity receives an amount that is more than the amount recorded as the receivable and difference is credited to the cash discount not taken account.'),
(102, 1, 21, 'On March 5, year 7, Diamant Mining Co. sells $300,000 of accounts receivable to Jig-Jack Bank. The bank (factor) charges 2% commission based on the gross amount of accounts receivable factored and retains 8% holdback. On March 15, year 7, the goods returned on factored accounts amounted to $1,000. On April 1, year 7, the customer return privilege period expires and the remaining holdback is returned by the bank. On April 1, the company will-', '', '', '', '', '', '', 'Debit cash for $15,000.', 'Credit sales for $16,000.', 'Debit factor holdback receivable for $15,000.', 'Credit factor holdback receivable for $16,000.', 'a', 'Debit Cash $15,000; Credit Factor Holdback Receivable Cr. $15,000'),
(103, 1, 21, 'On March 10, year 5, Eltek Co. sold goods to Delta Tankers for $80,000 and received a 60-day, 9%, $80,000 note. On March 30, year 5, the company discounted the note. The bank charged 24% discount on the note. The discounting of the note is accounted for as a sale and number of days in a year used for calculation purposes is 360. What is the amount of loss on discounting of note?', '', '', '', '', '', '', '$1,600', '$1,200', '$965', '$101', 'c', 'Loss = $$80,000 - $79,035 = $965'),
(104, 1, 21, 'During 20X5, Gritty Pet Foods sold goods of $900,000 on credit. The credit manager estimates its bad debts to be 4% of its credit sales. During 20X5, a customer who owed $8,000 refused to pay. This amount is considered uncollectible. Gross accounts receivable and allowance for doubtful debts as on December 31, 20X4, are $300,000 and $10,000 respectively. What is the amount of net receivables reported by Gritty on the balance sheet?', '', '', '', '', '', '', '$1,154,000', '$1,200,000', '$1,190,000', '$1,164,000', 'a', 'Bad debt expense is debited and allowance for doubtful debts is credited for $36,000. Also, allowance for doubtful debts is debited and accounts receivable are credited for accounts written off $8,000. On December 31, the gross accounts receivable balance would be 1,192,000 and allowance for doubtful debts would be $38,000. Net accounts receivables = $1,192,000 - $38,000 = $1,154,000'),
(105, 1, 21, 'Total Solutions Co. sold goods to one of its customers for $100,000 and received a 6 month, 8% note. After holding the note for 2 months, the company discounted the note at 12%. What is the maturity value of the note?', '', '', '', '', '', '', '$100,000', '$112,000', '$108,000', '$104,000', 'd', 'Face value of note $100,000 (+) Interest on note to maturity ($100,000 X 8% X 6/12) = $104,000'),
(106, 1, 21, 'During the current year, Palli Co. made credit sales of $200,000. Management estimates its bad debts to be 8% of the outstanding gross accounts receivable balance. The balance in gross accounts receivable and allowance for doubtful debts at the end of the year were $50,000 and $1,000, respectively. What is the bad debt expense for the current year?', '', '', '', '', '', '', '$16,000', '$4,000', '$3,000', '$1,000', 'c', 'Uncollectible accounts at the end of the year are estimated as a percent of the outstanding accounts receivable balance at the end of the year.  Any amount necessary to adjust the existing allowance account balance to the required ending balance is recorded as a bad expense.'),
(107, 1, 21, 'Total Solutions Co. sold goods to one of its customers for $100,000 and received a 6 month, 8% note. After holding the note for 2 months, the company discounted the note at 12%. What amount is received by Total Solutions?', '', '', '', '', '', '', '$99,840', '$95,840', '$88,000', '$100,000', 'a', 'Maturity Value $104,000 (-)  Discount ($104,000 X 12% X 4/12) = $99,840'),
(108, 1, 21, 'In a factoring arrangement, D Co. transfers on a nonrecourse basis its $50,000 accounts receivables to E Co. for $46,000 cash. In this context, which of the following transactions are correct?', 'D Co. is liable to bear the loss of uncollectible receivables.', '$46,000 received by D Co. is accounted for as secured borrowings with a pledge of collateral.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'd', 'The transfer is without recourse. Therefore, D Co. is not liable to E Co. in the event of a loss (bad debt). The transfer of receivables may be considered as either (a) sales of assets or (b) secured borrowings with a pledge of collateral.'),
(109, 1, 21, 'A company uses the percentage of outstanding receivables method to estimate its uncollectible accounts. Under this method, the already existing balance in the allowance account is considered for the purposes of determining-', 'The bad debt expense', 'The ending balance of allowance account', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'Under this method, any already existing balance in the allowance account is ignored for determining the ending balance of the allowance account. However, any existing balance in the allowance account is considered for determining the bad debt expense.'),
(110, 1, 22, 'T Co. sold a building to X Co. for $90,000 in exchange for a non-interest bearing note of $90,000 due in 3 years. The fair value of building is $87,000 and the carrying amount of the building in the books of T Co. is $80,000. What is the amount of gain on sale of building recorded by T Co.?', '', '', '', '', '', '', '$10,000', '$3,000', '$7,000', 'Loss is recorded', 'c', 'The difference between the fair value of the building and the carrying amount of the building is recorded as gain on sale of building.'),
(111, 1, 22, 'T Co. sold a building to X Co. for $90,000 in exchange for a non-interest bearing note of $90,000 due in 3 years. The fair value of building is $87,000 and the carrying amount of the building in the books of T Co. is $80,000. What is the discount on notes receivable?', '', '', '', '', '', '', '$10,000', '$3,000', '$7,000', '$0', 'b', 'In this case, the present value of the note is $87,000 and the difference between the present value of the note and face value of the note is discount on note.'),
(112, 1, 22, 'On March 5, year 7, Diamant Mining Co. sells $300,000 of accounts receivable to Jig-Jack Bank. The bank (factor) charges 2% commission based on the gross amount of accounts receivable factored and retains 8% holdback. On March 15, year 7, the goods returned on factored accounts amounted to $1,000. On April 1, year 7, the customer return privilege period expires and the remaining holdback is returned by the bank. The amount of cash received by Diamant from sale of receivables is-', '', '', '', '', '', '', '$300,000', '$294,000', '$276,000', '$270,000', 'd', 'Cash received = $300,000 - $6,000 - $24,000 = $270,000'),
(113, 1, 22, 'A transfer may be treated as a sale of receivable when the following condition(s) are met.', 'The transferee has the right to pledge or exchange the financial assets.', 'The financial assets have been isolated from the transferor.', 'The transferor does not maintain effective control over the financial assets.', '', '', '', 'I only', 'II only', 'III only', 'All three', 'd', 'A transfer of financial assets should be accounted for as a sale if all of the following conditions are met: (a) the transferee has the right to pledge or exchange the financial assets, (b) the financial assets have been isolated from the transferor, and (c) the transferor does not maintain effective control over the financial assets.'),
(114, 1, 22, 'AICPA: Tinsel Co.''s balances in allowance for uncollectible accounts were $70,000 at the beginning of the current year and $55,000 at year end. During the year, receivables of $35,000 were written off as uncollectible. What amount should Tinsel report as uncollectible accounts expense at year end? ', '', '', '', '', '', '', '$15,000', '$20,000', '$35,000', '$50,000', 'b', 'An estimate of uncollectible receivables is recorded as a bad debt expense with a corresponding credit to the allowance account. When an account is determined to be uncollectible, it is written off against the allowance account. Ending allowance = Beginning allowance + Bad debt expense - Receivables written off. Bad debt expense = $55,000 + $35,000 - $70,000 = $20,000'),
(115, 1, 22, 'AICPA: Hilltop Co.''s monthly bank statement shows a balance of $54,200. Reconciliation of the statement with company books reveals the following information: Bank service charge $10; Insufficient funds check $650; Checks outstanding $1,500; Deposits in transit $350. Check deposited by Hilltop and cleared by the bank for $125 but improperly recorded by Hilltop as $152. What is the net cash balance after the reconciliation?', '', '', '', '', '', '', '$52,363', '$53,023', '$53,050', '$53,077', 'c', 'Adjusted cash balance = Balance on the bank statement + Deposits in transit ? Outstanding checks = $54,200 + $350 - $1,500 = $53,050.'),
(116, 1, 22, 'AICPA: Marr Co. had the following sales and accounts receivable balances, prior to any adjustments at year end: (a) credit sales $10,000,000; (b) accounts receivable $3,000,000; (c) allowance for uncollectible accounts (debit balance) $50,000. Marr uses 3% of accounts receivable to determine its allowance for uncollectible accounts at year end. By what amount should Marr adjust its allowance for uncollectible accounts at year end?', '', '', '', '', '', '', '$0', '$40,000', '$90,000', '$140,000', 'd', 'The credit balance required in allowance for doubtful debts account is $90,000 (3% of $3,000,000). Since the allowance has a debit balance of $50,000, $140,000 adjustment is required to the allowance for uncollectible accounts at year end.'),
(117, 1, 22, 'AICPA: As of December 1, year 2 a company obtained a $1,000,000 line of credit maturing in one year on which it has drawn $250,000, a $750,000 secured note due in five annual installments, and a $300,000 three-year balloon note. The company has no other liabilities. How should the company''s debt be presented in its classified balance sheet on December 31, year 2 if no debt repayments were made in December?', '', '', '', '', '', '', 'Current liabilities of $1,000,000; long-term liabilities of $1,050,000.', 'Current liabilities of $500,000; long-term liabilities of $1,550,000.', 'Current liabilities of $400,000; long-term liabilities of $900,000.', 'Current liabilities of $500,000; long-term liabilities of $800,000.', 'c', 'Current liabilities are obligations that are reasonably expected to be paid within one year or the normal operating cycle, whichever is longer. $250,000 line of credit and $150,000 secured note become due within one year from December 31, year 2, and are classified as current liabilities. The remaining liabilities of $900,000 are classified as long-term liabilities.'),
(118, 1, 22, 'AICPA: Hemple Co. maintains escrow accounts for various mortgage companies. Hemple collects the receipts and pays the bills on behalf of the customers. Hemple holds the escrow monies in interest-bearing accounts. They charge a 10% maintenance fee to the customers based on interest earned. Hemple reported the following account data: (a) escrow liability beginning of year $500,000; (b) escrow receipts during the year $1,200,000; (c) real estate taxes paid during the year $1,450,000; (d) interest earned during the year $40,000. What amount represents the escrow liability balance on Hemple''s books? ', '', '', '', '', '', '', '$290,000', '$286,000', '$214,000', '$210,000', 'b', 'The escrow liability account at the end of the year = $500,000 + $1,200,000 - $1,450,000 + $40,000 - $4,000 = $286,000.'),
(119, 1, 22, 'AICPA: At December 31, year 1, Gasp Co.''s allowance for uncollectible accounts had a credit balance of $30,000. During year 2, Gasp wrote off uncollectible accounts of $45,000. At December 31, year 2, an aging of the accounts receivable indicated that $50,000 of the December 31, year 2, receivables may be uncollectible. What amount of allowance for uncollectible accounts should Gasp report in its December 31, year 2, balance sheet?', '', '', '', '', '', '', '$20,000 ', '$25,000', '$35,000', '$50,000', 'd', 'The allowance for uncollectible accounts should appear in the December 31, year 2, balance sheet at $50,000 since the aging of the accounts receivable indicated that $50,000 of the receivables may be uncollectible. '),
(120, 1, 22, 'AICPA: On October 1, year 1, Gold Co. borrowed $900,000 to be repaid in three equal, annual installments. The note payable bears interest at 5% annually. Gold paid the first installment of $300,000 plus interest on September 30, year 2. What amount should Gold report as a current liability on December 31, year 2?', '', '', '', '', '', '', '$330,000 ', '$307,500 ', '$303,750 ', '$300,000 ', 'b', 'Current liabilities are obligations that are reasonably expected to be paid within one year or the normal operating cycle, whichever is longer. $300,000 borrowings and $7,500 interest accrued become due within one year from December 31, year, and are classified as current liabilities.'),
(121, 1, 22, 'AICPA: A company finances the purchase of equipment with a $500,000 five-year note payable. The note has an interest rate of 12% and a monthly payment of $11,122. After two payments have been made, what amount should the company report as the note payable balance in its December 31 balance sheet?', '', '', '', '', '', '', '$477,756 ', '$487,695 ', '$487,756 ', '$490,061 ', 'b', 'Note payable balance after one payment = $500,000 + $5,000 interest - $11,122 first payment = $493,878. Not payable balance after 2 payments = $493,878 + $4,939 interest - $11,122 = $487,695.'),
(122, 1, 22, 'AICPA: Clear Co.''s trial balance has the following selected accounts: (a) cash (includes $10,000 in bond-sinking fund for long-term bond payable) $50,000; (b) accounts receivable $20,000; (c) allowance for doubtful accounts $5,000; (d) deposits received from customers $3,000; (d) merchandise inventory $7,000; (e) unearned rent $1,000; (f) investment in trading securities $2,000. What amount should Clear report as total current assets in its balance sheet?', '', '', '', '', '', '', '$64,000', '$67,000', '$72,000', '$74,000', 'a', 'Current assets include (a) cash and (b) other assets that are reasonably expected to be realized in cash or sold or consumed within one year or during the normal operating cycle, whichever is longer. Total current assets = $40,000 + $15,000 + $7,000 + $2,000 = $64,000.'),
(123, 1, 22, 'AICPA: A note payable was issued in payment for services received. The services had a fair value less than the face amount of the note payable. The note payable has no stated interest rate. How should the note payable be presented in the statement of financial position?', '', '', '', '', '', '', 'At the face amount.', 'At the face amount with a separate deferred asset for the discount calculated at the imputed interest rate.', 'At the face amount with a separate deferred credit for the discount calculated at the imputed interest rate.', 'At the face amount minus a discount calculated at the imputed interest rate.', 'd', 'Since the services had a fair value less than the note?s face amount, the note payable is considered issued at a discount. The amount of discount is calculated using the imputed (appropriate) interest rate. The note should be shown in the balance sheet at the face amount minus the discount.'),
(124, 1, 22, 'AICPA: At the beginning of the year, Cann Co. started construction on a new $2 million addition to its plant. Total construction expenditures made during the year were $200,000 on January 2, $600,000 on May 1, and $300,000 on December 1. On January 2, the company borrowed $500,000 for the construction at 12%. The only other outstanding debt the company had was a 10% interest rate, long-term mortgage of $800,000, which had been outstanding the entire year. What amount of interest should Cann capitalize as part of the cost of the plant addition?', '', '', '', '', '', '', '$140,000', '$132,000', '$72,500', '$60,000', 'c', 'The average accumulated expenditures is $625,000 ($200,000 X 12/12 + $600,000 X 8/12 + $300,000 X 1/12). Because the average accumulated expenditures exceed the amounts of specific new borrowings ($500,000) associated with the asset, the entity should apply the specific new borrowing rate to the amounts of specific borrowings, and the weighted average rate to the excess of the average accumulated expenditures over the specific new borrowings. Interest to be capitalized = ($500,000 X 12%) + ($125,000 X 10%) = $72,500'),
(125, 1, 22, 'On January 1, year 4, Peru Energy purchased equipment for $90,000 with an estimated useful life of 8 years and $2,000 salvage value. The company uses the straight-line depreciation method. At the end of year 5, the company decided to abandon the equipment by the end of year 6 and estimated the new salvage as $19,000. The depreciation expense for year 5 is-', '', '', '', '', '', '', '$30,000', '$11,250', '$11,000', '$8,875', 'a', 'Depreciation year 2 = ($90,000 - $11,000 - $19,000)/2 years = $30,000'),
(126, 1, 22, 'Shawn Co. uses the revaluation model (under IFRS) to account for its equipment. In 20X3, the company recorded a revaluation gain of $6,000 on its equipment. On December 31, 20X5, the equipment?s carrying amount is $24,000 and the fair value is $16,000.  How should the company report this decrease in value?', '', '', '', '', '', '', '$6,000 loss is recognized in OCI; $2,000 loss is reported on income statement', '$2,000 loss is recognized in OCI; $6,000 loss is reported on income statement', '$8,000 loss is recognized in OCI', '$8,000 loss is reported on income statement', 'a', 'Any loss on revaluation is reported on the income statement. However, the loss should be recognized in other comprehensive income to the extent of any credit balance in the revaluation surplus. ');
INSERT INTO `questionnaire` (`questionnaire_id`, `subject_id`, `chapter_id`, `questionnaire_text`, `point_1`, `point_2`, `point_3`, `point_4`, `point_5`, `q_image`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explaination_text`) VALUES
(127, 1, 22, 'Orezon International starts its operations in year 1. The company purchases computers, photocopy machines and office printers on Jan. 1, year 1. It groups all its office equipment (computers, photocopy machines and office printers) and depreciates them collectively using the composite depreciation rate and composite life. Determine the composite life used for calculating the depreciation expense when you are provided with the following information.', 'Computers: original cost $800,000, salvage value $80,000 and useful life 6 years.', 'Photocopy machines: original cost $700,000, salvage value $100,000 and useful life 12 years.', 'Printers: original cost $400,000, salvage value $40,000 and useful life 9 years.', '', '', '', '6 years', '8 years', '9 years', '12 years', 'b', 'The composite life is the total depreciable cost (that is, total cost ? total salvage value) divided by the sum of annual depreciation expense for each asset. Composite life = $1,680,000/ $210,000 = 8 years'),
(128, 1, 22, 'AICPA: Hudson Corp. operates several factories that manufacture medical equipment. The factories have a historical cost of $200 million. Near the end of the company''s fiscal year, a change in business climate related to a competitor''s innovative products indicated to Hudson''s management that the $170 million carrying amount of the assets of one of Hudson''s factories may not be recoverable. Management identified cash flows from this factory and estimated that the undiscounted future cash flows over the remaining useful life of the factory would be $150 million. The fair value of the factory''s assets is reliably estimated to be $135 million. The change in business climate requires investigation of possible impairment. Which of the following amounts is the impairment loss?', '', '', '', '', '', '', '$15 million', '$20 million', '$35 million', '$65 million', 'c', 'The company should recognize an impairment loss because the $170,000 carrying amount is more than the $150 million undiscounted cash flows. Impairment loss  = Carrying amount ? Fair value = $170 million - $135 million = $35 million'),
(129, 1, 22, 'Pacific Technology commenced construction of equipment on January 1, year 3. On Dec. 31, year 3, the total amount spent on equipment (not yet complete) is $800,000.  Expenditures were made evenly throughout the year. What is the amount of average accumulated expenditures on construction of equipment, when the following borrowings were outstanding during year 3?', '5%, $200,000 loan for construction of equipment (interest expense $10,000)', '$700,000 other debt, average interest rate 7% (interest expense $49,000)', '', '', '', '', '$900,000', '$800,000', '$600,000', '$400,000', 'd', 'Average accumulated expenditures = ($0 + $800,000)/2 = $400,000'),
(130, 1, 22, 'The use of revaluation model is permitted under-', 'IFRS', 'U.S. GAAP', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'Under IFRS, the revaluation model is permitted. Under U.S. GAAP, the revaluation model is not permitted.'),
(131, 1, 22, 'AICPA: Under IFRS, which of the following items is considered investment property?', '', '', '', '', '', '', 'Land held for use in the production or supply of goods or services. ', 'A building held for use for administrative purpose. ', 'Land held for sale in the ordinary course of business. ', 'Part of a building held to earn rentals.', 'd', 'Under IFRS, investment property is defined as property (land or/and building) held to earn rentals or for capital appreciation or both. It does not include property held (a) for use in the production or supply of goods or services or for administrative purposes, or (b) for sale in the ordinary course of business.'),
(132, 1, 22, 'During the year, Husky Bank purchases a land and building for $900,000. An appraisal performed by the company indicates that the land?s market value is $600,000 and the building?s market value is $400,000. Husky bank should capitalize building for', '', '', '', '', '', '', '$600,000', '$540,000', '$400,000', '$360,000', 'd', 'Eddie Imaging should allocate $900,000 between the land and the building in the ratio of 3:2.'),
(133, 1, 22, 'Tom Co. purchases a building for $500,000 for constructing its factory building. The company incurred $3,000 in demolishing the old building and sold the scrap for $600. The company also conducted a feasibility study prior to acquisition and incurred $500. Other costs incurred in relation to this property include title insurance $8,000 and legal fees $2,000. What is the cost of building capitalized?', '', '', '', '', '', '', '$512,900', '$513,000', '$503,000', '$510,000', 'a', 'Amount capitalized = $500,000 + $3,000 + $500 + $8,000 + $2,000 - $600 = $512,900'),
(134, 1, 22, 'On January 1, 20X4, A Co. purchases an asset for $100,000 with a remaining useful life of 5 years and an estimated salvage value of $10,000. Depreciation is based on the number of months an asset is used. The company uses the double-declining-balance method to depreciate the asset. What is the depreciation expense for the year 20X4 and 20X5?', '', '', '', '', '', '', '20X4: $40,000; 20X5:$24,000', '20X4: $20,000; 20X5:$16,000', '20X4: $20,000; 20X5:$20,000', '20X4: $40,000; 20X5:$20,000', 'a', '2014: 40% X $100,000 = $40,000; 2015: 40% X $60,000 = $24,000'),
(135, 1, 25, 'AICPA: A company obtained a $300,000 loan with a 10% interest rate on January 1, year 1, to finance the construction of an office building for its own use. Building construction began on January 1, year 1, and the project was not completed as of December 31, year 1. The following payments were made in year 1 related to the construction project: (a) January 1 - Purchased land for $120,000; September 1 - Progress payment to contractor for $150,000. What amount of interest should be capitalized for the year ended December 31, year 1? ', '', '', '', '', '', '', '$13,500', '$15,000', '$17,000', '$30,000', 'c', 'The amount of interest cost to be capitalized is that portion of interest cost that could have been avoided, if expenditures on the asset had not been made. It is calculated by applying the capitalization rate to the weighted average accumulated expenditures for the asset during the period. Average accumulated expenditures = ($120,000 X 12/12 + $150,000 X 4/12) = $170,000; Interest capitalized = 10% X $170,000 = $17,000'),
(136, 1, 25, 'Y Co. purchases a land and building for $900,000. If the market value of the land is $600,000 and the building is $400,000. At what amount should Y Co. record the building? ', '', '', '', '', '', '', '$400,000', '$900,000', '$600,000', '$360,000', 'd', 'The total amount paid is divided between the land and the building according to their relative fair values. Therefore, $900,000 is allocated to the land and the building in the ratio of 6:4.'),
(137, 1, 25, 'During 20X4, X Co. undertakes the construction of buildings. The construction is partly financed by $300,000 borrowings at the interest rate of 4% from ABN Bank. The entity has other borrowings amounting to $700,000 and the average interest rate on those borrowings is 6%. If the average accumulated expenditure regarding buildings for 20X4 is $500,000, what is the amount of interest cost capitalized?', '', '', '', '', '', '', '$24,000', '$54,000', '$30,000', '$20,000', 'a', 'Interest capitalized = ($300,000 X 4%) + ($200,000 X 6%) = $24,000'),
(138, 1, 25, 'Orezon International starts its operations in year 1. The company purchases computers, photocopy machines and office printers on Jan. 1, year 1. It groups all its office equipment (computers, photocopy machines and office printers) and depreciates them collectively using the composite depreciation rate and composite life. During year 2, the company sells one computer for $10,000 (original cost $14,000). Regarding the computer sold, determine the account and the amount to be credited when you are provided with the following information.', 'Computers purchased on Jan. 1, year 1: cost $800,000, salvage value $80,000 and useful life 6 years.', 'Photocopy machines purchased on Jan. 1, year 1: cost $700,000, salvage value $100,000 and useful life 12 years.', 'Printers purchased on Jan. 1, year 1: cost $400,000, salvage value $40,000 and useful life 9 years.', '', '', '', 'Gain $5,000', 'Accumulated depreciation $4,000', 'Equipment $14,000', 'Loss $4,000', 'c', 'When an asset from the group is sold, the asset account is credited but no gain or loss on sale is recognized instead the difference between the cost of the asset and the proceeds from the sale is debited to the accumulated depreciation account. '),
(139, 1, 25, 'D Co. uses IFRS to prepare its financial statements. Which of the following should be reported as investment property by D Co.', 'Land held for capital appreciation', 'Building held to earn rentals', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'Under IFRS, investment property is defined as property (land or/and building) held to earn rentals or for capital appreciation or both.'),
(140, 1, 25, 'AICPA: A company recently moved to a new building. The old building is being actively marketed for sale, and the company expects to complete the sale in four months. Each of the following statements is correct regarding the old building, except:', '', '', '', '', '', '', 'It will be reclassified as an asset held for sale.', 'It will be classified as a current asset.', 'It will no longer be depreciated.', 'It will be valued at historical cost.', 'd', 'The asset classified as held for sale should be reported at its fair value less cost to sell (not at historical cost). The entity should recognize loss for any write-down of the asset?s (or disposal group?s) carrying amount to its fair value less cost to sell.'),
(141, 1, 25, 'On Jan. 1, 20X3, Top Courier Co. bought a delivery van for $105,000 with an estimated useful life of 10 years and salvage value of $15,000. The van is expected to be driven 45,000 miles over its life. The company uses the units-of-production method to depreciate its delivery trucks to depreciate its delivery vans. In 20X3, the van is driven 3,000 miles. What is the depreciation on this van for 20X3?', '', '', '', '', '', '', '$9,000', '$7,000', '$10,500', '$6,000', 'd', 'Depreciation rate = $90,000/45,000 mile = $2 per mile; Depreciation for 2013 = $2 X 3,000 miles = $6,000'),
(142, 1, 25, 'Which of the following is correct regarding impairment of property, plant and equipment?', 'Under IFRS, the computation of an impairment loss is a one-step process.', 'Under U.S. GAAP, the computation of an impairment loss is a two-step process. ', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'Under IFRS, the computation of an impairment loss is a one-step process (the fair value test). An impairment loss is the amount by which the carrying amount of the asset exceeds the higher of its value (less costs to sell) or its value in use.  (Impairment loss = Carrying amount ? Higher of (a) fair value less costs to sell or (b) value in use) Under U.S. GAAP, the computation of an impairment loss is a two-step process (the recoverability test and the fair value test). '),
(143, 1, 25, 'On January 1, year 1 Netco Pioneers purchases a crane for $100,000 with a remaining useful life of 5 years and an estimated salvage value of $10,000. The company uses the 150% declining balance method to depreciate the crane. If this is the only depreciable asset owned by the company, the depreciation expense for year 1 and year 2 is-', '', '', '', '', '', '', 'Year 1: $22,500; Year 2: $22,500', 'Year 1: $40,000; Year 2: $24,000', 'Year 1: $30,000; Year 2: $21,000', 'Year 1: $30,000; Year 2: $24,000', 'c', 'Depreciation year 1 = 30% X $100,000 = $30,000; Depreciation year 2 = 30% X $70,000 = $21,000'),
(144, 1, 25, 'On January 1, 20X1, Good Oil Co. purchased an oil well for $2 million. The well is estimated to have 4 million barrels of oil and no salvage value. What is the depletion expense for 20X1, if the company extracts and sells 17,000 barrels of oil in 20X1?', '', '', '', '', '', '', '$8,500', '$17,000', '$34,000', '$51,000', 'a', 'Depletion rate = $2,000,000/4,000,000 barrels = $0.50 per barrel; Depletion expense = $0.50 X 17,000 barrels = $8,500'),
(145, 1, 25, 'AICPA: A company has a parcel of land to be used for a future production facility. The company applies the revaluation model under IFRS to this class of assets. In year 1, the company acquired the land for $100,000. At the end of year 1, the carrying amount was reduced to $90,000, which represented the fair value at that date. At the end of year 2, the land was revalued, and the fair value increased to $105,000. How should the company account for the year 2 change in fair value?', '', '', '', '', '', '', 'By recognizing $10,000 in other comprehensive income.', 'By recognizing $15,000 in other comprehensive income.', 'By recognizing $15,000 in profit or loss.', 'By recognizing $10,000 in profit or loss and $5,000 in other comprehensive income.', 'd', 'The gain on asset should be reported on the income statement to the extent that it reverses a revaluation loss previously reported on the income statement. The remaining gain is recognized in other comprehensive income.'),
(146, 1, 25, 'AICPA: Quick Co. acquired the following assets from a liquidating competitor for a $200,000 lump-sum purchase price: (a) Inventory (Competitor?s carrying amount $70,000, Fair value $50,000); (b) Land (Competitor?s carrying amount $40,000, Fair value $50,000); (c) Building (Competitor?s carrying amount $110,000, Fair value $150,000). What amount should Quick report as the cost of the building? ', '', '', '', '', '', '', '$100,000', '$120,000', '$150,000', '$200,000', 'b', 'When an entity purchases several assets as a group and for a single price, the total amount paid is divided among the assets according to their relative fair values. Therefore, $200,000 paid is allocated to inventory, land and building in the ratio of 50,000 : 50,000 : 150,000 (or 1:1:3). Cost of building = $200,000 X 3/5 = $120,000'),
(147, 1, 25, 'Under IFRS, gains on revaluation are reported on the income statement, when the property is classified as-', 'Property, plant and equipment', 'Investment property', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'b', 'When the fair value model is adopted, investment property is carried at fair value. Any gain or loss resulting from a change in the fair value is reported on the income statement.'),
(148, 1, 25, 'AICPA: Gold Co. purchased equipment from Marshall Co. on July 1. Gold paid Marshall $10,000 cash and signed a $100,000 noninterest-bearing note payable, due in three years. Gold recorded a $24,868 discount on notes payable related to this transaction. What is the acquired cost of the equipment on July 1? ', '', '', '', '', '', '', '$75,132', '$85,132', '$100,000', '$110,000', 'b', 'The equipment is recorded at $85,132, calculated as $10,000 + $75,132 = $85,132'),
(149, 1, 25, 'X bought $2,000 goods from Y Store on terms 2/12, net 30. Y Store uses the gross method. If X paid after the 12-day discount period, Y Store should-', '', '', '', '', '', '', 'Credit - Discount not taken account for $40', 'Debit ? Discount not taken account for $40', 'Debit ? Cash $1,960', 'Credit ? Accounts receivable $2,000', 'd', 'Under the gross method, accounts receivable and sales are recorded at gross amount without regard to cash discounts. If the customer pays after the discount period (that is, does not take the cash discount), the customer is required to pay an amount (that is equal to the recorded amount of the receivable) and no further adjustment is needed. JE: Debit Cash $2,000; Credit Accounts Receivable $2,000.'),
(150, 1, 25, 'On June 15, year 5, Total Mark Co. sold $100,000 of merchandise to its customers with credit terms of 2/10, n/40. On June 20, the company received payment on goods originally billed at $20,000. The amount remaining was received on July 20, year 5. The company uses the net method to account for the discounts. On June 20, the company credits the accounts receivable for-', '', '', '', '', '', '', '$20,000', '$19,600', '$80,000', '$78,400', 'b', 'Under the net method, cash discounts are considered at the time of sales. Therefore, accounts receivable and sales are recorded net of discounts. If the customer makes the payment within the discount period, the amount of cash received equals the amount recorded as the receivable and therefore, no adjustment is required. However, if the customer does not take the cash discount, the entity receives an amount that is more than the amount recorded as the receivable and difference is credited to the cash discount not taken account.'),
(151, 1, 25, 'On Jan. 1, year 5, Jam Co. sold a truck to Big Hop for $80,000 in exchange for a non-interest bearing note of $28,000 due in 2 years. The carrying amount of the truck in the books of Jam Co. is $90,000. The market value of the truck on Jan 1, year 5, is $75,000. The loss on sale of truck recognized by Jam is-', '', '', '', '', '', '', '$15,000', '$10,000', '$5,000', '$0', 'a', 'Because, the market value of the truck is $75,000, the company should record a loss of $15,000 ($90,000 - $75,000 = $15,000).'),
(152, 1, 25, 'On March 5, year 7, Diamant Mining Co. sells $300,000 of accounts receivable to Jig-Jack Bank. The bank (factor) charges 2% commission based on the gross amount of accounts receivable factored and retains 8% holdback. On March 15, year 7, the goods returned on factored accounts amounted to $1,000. On April 1, year 7, the customer return privilege period expires and the remaining holdback is returned by the bank. On March 15, the company will-', '', '', '', '', '', '', 'Debit sales returns for $24,000', 'Credit sales returns for $1,000', 'Debit factor holdback receivable for $24,000', 'Credit factor holdback receivable for $1,000', 'd', 'Debit Sales Returns $1,000; Credit Factor Holdback Receivable $1,000'),
(153, 1, 25, 'Clark Inc. purchased land and building for a total price of $600,000. If, on the date of purchase, the fair value of land is $300,000 and building is $500,000. At what figure Clark should report the building?', '', '', '', '', '', '', '$375,000', '$300,000', '$500,000', '$225,000', 'a', 'Clark Inc. purchases land and building as a group and for a single price. In such case, the total amount paid is divided among land and building according to their relative fair values (in the ratio of 5:3). The amount allocated to building is $375,000 ($600,000 X 5/8).'),
(154, 1, 25, 'On January 1, year 1 Netco Pioneers purchases a crane for $100,000 with a remaining useful life of 5 years and an estimated salvage value of $10,000. The company uses the straight-line method to depreciate the crane. If this is the only depreciable asset owned by the company, the depreciation expense for year 1 and year 2 is-', '', '', '', '', '', '', 'Year 1: $22,500; Year 2: $22,500', 'Year 1: $40,000; Year 2: $24,000', 'Year 1: $30,000; Year 2: $21,000', 'Year 1: $30,000; Year 2: $24,000', 'a', 'Depreciation year 1 = $90,000/ 4 = $22,500; Depreciation year 2 = $90,000/ 4 = $22,500'),
(155, 1, 25, 'Orezon International groups all its office equipment (computers, photocopy machines and office printers) and depreciates them collectively using the composite depreciation rate and composite life. Determine the composite depreciation rate when you are provided with the following information.', 'Computers: original cost $800,000, salvage value $80,000 and useful life 6 years.', 'Photocopy machines: original cost $700,000, salvage value $100,000 and useful life 12 years.', 'Printers: original cost $400,000, salvage value $40,000 and useful life 9 years.', '', '', '', '11.05%', '12%', '13.33%', '14.02%', 'a', 'The composite depreciation rate is the sum of annual depreciation expense for each asset (that is, $120,000 + $50,000 + $40,000) expressed as percentage of total cost of all the assets. Composite depreciation rate = $210,000/ $1,900,000 = $11.05%'),
(156, 1, 25, 'On January 1, year 4, Peru Energy purchased equipment for $90,000 with an estimated useful life of 8 years and $2,000 salvage value. The company uses the straight-line depreciation method. At the end of year 5, the company decided to abandon the equipment by the end of year 6 and estimated the new salvage as $19,000. The depreciation expense for year 4 is-', '', '', '', '', '', '', '$30,000', '$11,250', '$11,000', '$8,875', 'c', 'Depreciation year 1 = $88,000/8 years = $11,000'),
(157, 1, 25, 'Under IFRS, investment property refers to property that is held:', 'to earn rentals', 'for capital appreciation', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'Under IFRS, investment property is defined as property held to earn rentals or for capital appreciation or both. It does not include property held (a) for use in the production or supply of goods or services or for administrative purposes, or (b) for sale in the ordinary course of business'),
(158, 1, 25, 'Orezon International starts its operations in year 1. The company purchases computers, photocopy machines and office printers on Jan. 1, year 1. It groups all its office equipment (computers, photocopy machines and office printers) and depreciates them collectively using the composite depreciation rate and composite life. Calculate the composite depreciation expense for year 1 when you are provided with the following information.', 'Computers purchased on Jan. 1, year 1: cost $800,000, salvage value $80,000 and useful life 6 years.', 'Photocopy machines purchased on Jan. 1, year 1: cost $700,000, salvage value $100,000 and useful life 12 years.', 'Printers purchased on Jan. 1, year 1: cost $400,000, salvage value $40,000 and useful life 9 years.', '', '', '', '$200,000', '$210,000', '$220,000', '$270,000', 'b', 'Composite depreciation rate = $210,000/ $1,900,000 = 11.05263%; Composite life = $1,680,000/ $210,000 = 8 years; Composite depreciation expense = 11.05263% of $1,900,000 = $210,000'),
(159, 1, 25, 'Harley Equipment Co. purchased a machinery on January 1, 20X3, for 82,000. The machinery was depreciated on a straight-line basis over 6 years with $10,000 salvage value. On December 1, 20X5, the machinery was sold for $40,000. What is the amount of accumulated depreciation on the machinery on the date of sale, when depreciation is based on the number of months the asset is used?', '', '', '', '', '', '', '$35,000', '$36,000', '$23,000', '$24,000', 'a', 'Depreciation up to the date of sale is $35,000, calculated as $12,000 for 2013, $12,000 for 2014, $11,000 for 2015 (up to Dec. 1, 2015).'),
(160, 1, 25, 'Hill Grove Co. commenced construction of its factory building on June 30, 20X3. On Dec. 31, 20X3, the total amount spent on equipment (not yet complete) is $60,000. The following borrowings were outstanding during the entire 20X3:(a) 10%, $400,000 loan, and (b) $600,000 loan, interest rate 12%.  None of the borrowings relate to the construction of factory building. What interest rate should Hill Grove use to capitalize construction period interest?', '', '', '', '', '', '', '10%', '11%', '11.20%', '12%', 'd', 'Average interest rate used = ($400,000 / $1,000,000) X 10% + ($600,000 / $1,000,000) X 12% = 11.2%'),
(161, 1, 25, 'AICPA: An entity purchased new machinery from a supplier before the entity''s year end. The entity paid freight charges for the purchased machinery. The entity took out a loan from a bank to finance the purchase. Under IFRS, what is the proper accounting treatment for the freight and interest costs related to the machinery purchase?', '', '', '', '', '', '', 'The freight and interest costs should be immediately expensed. ', 'The freight and interest costs should be capitalized as part of property, plant and equipment. ', 'The interest cost should be capitalized as part of property, plant and equipment, and the freight cost should be immediately expensed. ', 'The freight cost should be capitalized as part of property, plant and equipment, and the interest cost should be immediately expensed.', 'd', 'The freight cost should be capitalized as part of property, plant and equipment, and the interest cost should be immediately expensed.'),
(162, 1, 25, 'On January 1, 20X1, X Co. purchased an equipment for $140,000 with an estimated useful life of 12 years and $20,000 salvage value. The company uses the straight-line depreciation method. During 20X6, there was a change in technology. At the end of 20X6, the company decided to abandon the equipment by the end of 20X7 and estimated the new salvage as $2,000. Depreciation is based on the number of months an asset is used. What is the depreciation expense for 20X6?', '', '', '', '', '', '', '$40,000', '$44,000', '$10,000', '$78,000', 'b', 'The entity should revise depreciation estimates so that the depreciation expense reflects the use of the asset over its shortened (new) useful life. Annual depreciation expense for 20X1 through 20X5 was $10,000. Depreciation expense for 20X6 = ($140,000 - $10,000 X 5 - $2,000)/2 = $44,000 '),
(163, 1, 25, 'An entity should disclose which of the following with respect of interest capitalized.', 'The total amount of interest cost incurred during the period. ', 'The amount of interest cost capitalized. ', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'c', 'An entity should disclose the following with respect to interest capitalized. (a) The total amount of interest cost incurred during the period. (b) The amount of interest cost that has been capitalized. '),
(164, 1, 25, 'Which of the following is correct regarding capitalization of interest cost?', 'The amount of interest capitalized is not reduced by the income earned on unexpended portion of the borrowings.', 'The amount of interest capitalized may exceed the total amount of interest cost incurred in that period.', '', '', '', '', 'I only', 'II only', 'Both I and II', 'Neither I nor II', 'a', 'The amount of interest capitalized is not reduced by the income earned on unexpended portion of the borrowings. The amount of interest capitalized should not exceed the total amount of interest cost incurred in that period.');

-- --------------------------------------------------------

--
-- Table structure for table `question_table`
--

CREATE TABLE IF NOT EXISTS `question_table` (
  `question_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `question_title` text NOT NULL,
  `answer_option` enum('1','2','3','4') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_table`
--

INSERT INTO `question_table` (`question_id`, `online_exam_id`, `question_title`, `answer_option`) VALUES
(1, 1, 'With reference to ASC 326, in respect of available-for-sale debt securities an entity should consider the following factors in determining whether a credit loss exists?\n', '4'),
(2, 1, 'In respect of collateral-dependent financial assets, an entity should measure expected credit losses (when the foreclosure is probable) based on-\r\n', '3'),
(3, 1, 'With reference to ASC 326, in respect of available-for-sale debt securities an entity should consider the following factors in determining whether a credit loss exists?\r\n', '4'),
(4, 1, 'With reference to ASC 326, in respect of available-for-sale debt securities if an entity intends to sell the debt security or more likely than not will be required to sell the security then-\r\n', '4'),
(5, 1, 'In respect of purchased financial assets with credit deterioration, any discount on purchase that is noncredit is accreted to interest income using the interest method based on the effective interest rate. This is true under which circumstance(s)?\r\n', '2'),
(6, 1, 'With reference to ASC 326, in respect of available-for-sale debt securities if an entity intends to sell the debt security or more likely than not will be required to sell the security before recovery of its amortized cost basis then-\r\n', '1'),
(7, 1, 'In respect of collateral-dependent financial assets (foreclosure is probable), when the fair value (less costs to sell, if applicable) of the collateral at the reporting date exceeds the amortized cost basis of the financial asset, an entity should adjust the allowance for credit losses to present the net amount expected to be collected on the financial asset equal to the-\r\n', '3'),
(8, 1, 'As per ASC 326, at each reporting date, an entity should compare its current estimate of expected credit losses with -\r\n', '4'),
(9, 1, 'As per ASC 326, at each reporting date, an entity should compare its current estimate of expected credit losses with the estimate of expected credit losses previously recorded. The amount necessary to adjust the allowance for credit losses for management’s current estimate of expected credit losses on financial assets is reported as a \r\n', '3'),
(10, 1, 'With reference to ASC 326, in respect of available-for-sale debt securities if the present value of cash flows expected to be collected is less than the amortized cost basis of the security then-\r\n', '4');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject_added_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `subject_code`, `subject_added_date`) VALUES
(1, 'Computers', 'CS', '2020-04-24'),
(2, 'English', 'ENG', '2020-04-24'),
(3, 'Accounting', 'ACC', '2020-04-24'),
(4, 'Maths', 'Maths', '2020-04-24'),
(5, 'Natural Sciences', 'NS', '2020-04-24'),
(6, 'Humanities', 'HM', '2020-04-24');

-- --------------------------------------------------------

--
-- Table structure for table `subject_assignment`
--

CREATE TABLE IF NOT EXISTS `subject_assignment` (
  `assignment_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject_assignment`
--

INSERT INTO `subject_assignment` (`assignment_id`, `batch_id`, `subject_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_exam_enroll_table`
--

CREATE TABLE IF NOT EXISTS `user_exam_enroll_table` (
  `user_exam_enroll_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `attendance_status` enum('Absent','Present') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_exam_enroll_table`
--

INSERT INTO `user_exam_enroll_table` (`user_exam_enroll_id`, `user_id`, `exam_id`, `attendance_status`) VALUES
(1, 1, 1, 'Present'),
(2, 1, 1, 'Present'),
(3, 1, 1, 'Present'),
(4, 1, 3, 'Absent');

-- --------------------------------------------------------

--
-- Table structure for table `user_exam_question_answer`
--

CREATE TABLE IF NOT EXISTS `user_exam_question_answer` (
  `user_exam_question_answer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_answer_option` enum('0','1','2','3','4') NOT NULL,
  `marks` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_exam_question_answer`
--

INSERT INTO `user_exam_question_answer` (`user_exam_question_answer_id`, `user_id`, `exam_id`, `question_id`, `user_answer_option`, `marks`) VALUES
(1, 1, 1, 1, '', '-1'),
(2, 1, 1, 2, '3', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE IF NOT EXISTS `user_table` (
  `user_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `user_email_address` varchar(250) NOT NULL,
  `user_password` varchar(150) NOT NULL,
  `user_verfication_code` varchar(100) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_gender` enum('Male','Female') NOT NULL,
  `user_address` text NOT NULL,
  `user_mobile_no` varchar(30) NOT NULL,
  `user_image` varchar(150) NOT NULL,
  `user_created_on` datetime NOT NULL,
  `user_email_verified` enum('no','yes') NOT NULL DEFAULT 'yes',
  `user_dob` date NOT NULL,
  `user_national_type` text NOT NULL,
  `user_national_no` text NOT NULL,
  `batch_code` varchar(255) NOT NULL,
  `is_profile_editable` enum('1','0') NOT NULL DEFAULT '0',
  `mcq_attempt_counter` int(11) NOT NULL,
  `user_status` enum('active','deactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `batch_id`, `user_email_address`, `user_password`, `user_verfication_code`, `user_name`, `user_gender`, `user_address`, `user_mobile_no`, `user_image`, `user_created_on`, `user_email_verified`, `user_dob`, `user_national_type`, `user_national_no`, `batch_code`, `is_profile_editable`, `mcq_attempt_counter`, `user_status`) VALUES
(1, 1, 'developer@initialace.com', '$2y$10$YYoBwdEYcQUYkr80TJbeMunTB9Uv1.YtdCEEk3nIF2pnKDFPOmwAO', '9898', 'Vishal Gupta', 'Male', 'Test', '8765937483', '5ea155d75b4f0.jpg', '0000-00-00 00:00:00', 'yes', '2020-04-29', 'Aadhaar', '499118665246', 'AP20', '1', 4, 'active'),
(2, 1, 'vishal.gupta@gmail.com', '$2y$10$wx9FoTqrUKKZS6OB0sR0R.6VyFcBdopWroALA58lEZi2GJNcSJ3eG', '1', 'Vishal', 'Male', 'Test address', '888888888', '5ea1a803f14cd.jpg', '0000-00-00 00:00:00', 'yes', '0000-00-00', 'Pancard', '499118665246', 'AP20', '0', 0, 'active'),
(3, 1, 'ajay23@gmail.com', '$2y$10$wx9FoTqrUKKZS6OB0sR0R.6VyFcBdopWroALA58lEZi2GJNcSJ3eG', '98798', 'Ajay Kumar', 'Male', 'Ajay test address', '7777777779', '5ea1a82676799.jpg', '2020-04-23 15:00:00', 'yes', '0000-00-00', 'Aadhaar', '499118665246', 'AP20', '0', 0, 'deactive'),
(4, 1, 'vishwas@initialace.com', '$2y$10$nODyf.5SW3ufeBtld1CMMeg/7wAMNOfvzVSuAgMHoJlgnreRhWgZy', '', 'vishwas', 'Male', 'Banglore', '9876543298', '5eb5425b3dfbb.jpg', '2020-05-08 16:58:27', 'yes', '0000-00-00', 'voter', '42987465', 'AP20', '0', 0, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_id`),
  ADD UNIQUE KEY `batch_code` (`batch_code`),
  ADD UNIQUE KEY `batch_name` (`batch_name`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`chapter_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `online_exam_table`
--
ALTER TABLE `online_exam_table`
  ADD PRIMARY KEY (`online_exam_id`);

--
-- Indexes for table `option_table`
--
ALTER TABLE `option_table`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD PRIMARY KEY (`questionnaire_id`);

--
-- Indexes for table `question_table`
--
ALTER TABLE `question_table`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `subject_assignment`
--
ALTER TABLE `subject_assignment`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `user_exam_enroll_table`
--
ALTER TABLE `user_exam_enroll_table`
  ADD PRIMARY KEY (`user_exam_enroll_id`);

--
-- Indexes for table `user_exam_question_answer`
--
ALTER TABLE `user_exam_question_answer`
  ADD PRIMARY KEY (`user_exam_question_answer_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `chapter_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `online_exam_table`
--
ALTER TABLE `online_exam_table`
  MODIFY `online_exam_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `option_table`
--
ALTER TABLE `option_table`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `questionnaire_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=165;
--
-- AUTO_INCREMENT for table `question_table`
--
ALTER TABLE `question_table`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subject_assignment`
--
ALTER TABLE `subject_assignment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_exam_enroll_table`
--
ALTER TABLE `user_exam_enroll_table`
  MODIFY `user_exam_enroll_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_exam_question_answer`
--
ALTER TABLE `user_exam_question_answer`
  MODIFY `user_exam_question_answer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
