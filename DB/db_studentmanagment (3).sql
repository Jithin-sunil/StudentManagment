-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 01:26 PM
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
-- Database: `db_studentmanagment`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_academicyear`
--

CREATE TABLE `tbl_academicyear` (
  `academicyear_id` int(11) NOT NULL,
  `academicyear_year` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_academicyear`
--

INSERT INTO `tbl_academicyear` (`academicyear_id`, `academicyear_year`) VALUES
(1, '2024-2025'),
(2, '2025-2026');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(60) NOT NULL COMMENT '60',
  `admin_email` varchar(60) NOT NULL COMMENT '60',
  `admin_password` varchar(60) NOT NULL COMMENT '60'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assignment`
--

CREATE TABLE `tbl_assignment` (
  `assignment_id` int(11) NOT NULL,
  `assignment_status` int(60) NOT NULL DEFAULT 0,
  `assignment_questionfile` varchar(100) NOT NULL,
  `assignment_date` varchar(60) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `assignment_question` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assignmentbody`
--

CREATE TABLE `tbl_assignmentbody` (
  `assignmentbody_id` int(11) NOT NULL,
  `assignment_id` int(60) NOT NULL,
  `assignmentbody_date` varchar(60) NOT NULL,
  `assignmentbody_status` int(60) NOT NULL DEFAULT 0,
  `assignmentbody_mark` varchar(60) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assignmentbody_file` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assignsubject`
--

CREATE TABLE `tbl_assignsubject` (
  `assignsubject_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_assignsubject`
--

INSERT INTO `tbl_assignsubject` (`assignsubject_id`, `course_id`, `semester_id`, `subject_id`, `teacher_id`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 2, 2, 2),
(3, 2, 1, 3, 1),
(4, 2, 3, 4, 2),
(5, 3, 1, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `attendance_hour` int(11) NOT NULL,
  `attendance_status` enum('Present','Absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`attendance_id`, `student_id`, `teacher_id`, `semester_id`, `course_id`, `attendance_date`, `attendance_hour`, `attendance_status`) VALUES
(5, 1, 1, 1, 1, '2025-07-28', 1, 'Present'),
(6, 2, 1, 1, 1, '2025-07-28', 1, 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class`
--

CREATE TABLE `tbl_class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(60) NOT NULL,
  `course_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `academicyear_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_class`
--

INSERT INTO `tbl_class` (`class_id`, `class_name`, `course_id`, `teacher_id`, `academicyear_id`) VALUES
(1, 'CS101', 1, 1, 1),
(2, 'CS201', 2, 2, 1),
(3, 'MATH101', 3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_classsem`
--

CREATE TABLE `tbl_classsem` (
  `classsem_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_classsem`
--

INSERT INTO `tbl_classsem` (`classsem_id`, `semester_id`, `class_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 2),
(4, 3, 2),
(5, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_complaint`
--

CREATE TABLE `tbl_complaint` (
  `complaint_id` int(11) NOT NULL,
  `complaint_content` varchar(60) NOT NULL,
  `complaint_reply` varchar(60) NOT NULL,
  `complaint_status` int(60) NOT NULL DEFAULT 0,
  `complaint_date` varchar(60) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(60) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`course_id`, `course_name`, `department_id`) VALUES
(1, 'BSc Computer Science', 1),
(2, 'MSc Computer Science', 1),
(3, 'BSc Mathematics', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`department_id`, `department_name`) VALUES
(1, 'Computer Science'),
(2, 'Mathematics');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_district`
--

CREATE TABLE `tbl_district` (
  `district_id` int(11) NOT NULL,
  `district_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event`
--

CREATE TABLE `tbl_event` (
  `event_id` int(11) NOT NULL,
  `event_file` varchar(60) DEFAULT NULL,
  `event_fordate` varchar(60) NOT NULL,
  `event_content` varchar(60) NOT NULL,
  `event_date` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_eventregistration`
--

CREATE TABLE `tbl_eventregistration` (
  `eventregistration_id` int(11) NOT NULL,
  `eventregistration_date` varchar(60) NOT NULL,
  `eventregistration_status` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_internalmark`
--

CREATE TABLE `tbl_internalmark` (
  `internalmark_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `internalmark_mark` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_internalmark`
--

INSERT INTO `tbl_internalmark` (`internalmark_id`, `student_id`, `teacher_id`, `subject_id`, `semester_id`, `course_id`, `internalmark_mark`) VALUES
(1, 1, 1, 1, 1, 1, 45.00),
(2, 2, 1, 1, 1, 1, 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave`
--

CREATE TABLE `tbl_leave` (
  `leave_id` int(11) NOT NULL,
  `leave_content` varchar(60) NOT NULL,
  `leave_status` int(60) NOT NULL DEFAULT 0,
  `leave_date` varchar(60) NOT NULL,
  `leave_fordate` varchar(60) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_place`
--

CREATE TABLE `tbl_place` (
  `place_id` int(11) NOT NULL,
  `place_name` varchar(60) NOT NULL,
  `district_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_semester`
--

CREATE TABLE `tbl_semester` (
  `semester_id` int(11) NOT NULL,
  `semester_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_semester`
--

INSERT INTO `tbl_semester` (`semester_id`, `semester_name`) VALUES
(1, 'Semester 1'),
(2, 'Semester 2'),
(3, 'Semester 3'),
(4, 'Semester 4');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(60) NOT NULL,
  `student_email` varchar(60) NOT NULL,
  `student_contact` varchar(60) NOT NULL,
  `student_address` varchar(60) NOT NULL,
  `student_photo` varchar(60) NOT NULL,
  `student_gender` varchar(60) NOT NULL,
  `student_password` varchar(60) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`student_id`, `student_name`, `student_email`, `student_contact`, `student_address`, `student_photo`, `student_gender`, `student_password`, `class_id`) VALUES
(1, 'Tom Wilson', 'tom.wilson@example.com', '9123456780', '101 Pine St', 'tom.jpg', 'Male', 'pass123', 1),
(2, 'Emma Davis', 'emma.davis@example.com', '9012345678', '102 Cedar St', 'emma.jpg', 'Female', 'pass456', 1),
(3, 'Liam Johnson', 'liam.johnson@example.com', '8901234567', '103 Maple St', 'liam.jpg', 'Male', 'pass789', 2),
(4, 'Sophia Lee', 'sophia.lee@example.com', '7890123456', '104 Birch St', 'sophia.jpg', 'Female', 'pass012', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_studymaterial`
--

CREATE TABLE `tbl_studymaterial` (
  `studymaterial_id` int(11) NOT NULL,
  `studymaterial_content` varchar(11) NOT NULL,
  `studymaterial_file` varchar(60) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategory`
--

CREATE TABLE `tbl_subcategory` (
  `subcategory_id` int(11) NOT NULL,
  `subcategory_name` varchar(60) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject`
--

CREATE TABLE `tbl_subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(60) NOT NULL,
  `course_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`subject_id`, `subject_name`, `course_id`, `semester_id`) VALUES
(1, 'Programming Fundamentals', 1, 1),
(2, 'Database Systems', 1, 2),
(3, 'Advanced Algorithms', 2, 1),
(4, 'Data Science', 2, 3),
(5, 'Calculus I', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE `tbl_teacher` (
  `teacher_id` int(11) NOT NULL,
  `teacher_name` varchar(60) NOT NULL,
  `teacher_email` varchar(60) NOT NULL,
  `teacher_contact` varchar(60) NOT NULL,
  `teacher_address` varchar(60) NOT NULL,
  `teacher_gender` varchar(60) NOT NULL,
  `teacher_password` varchar(60) NOT NULL,
  `department_id` int(11) NOT NULL,
  `teacher_designation` varchar(50) NOT NULL,
  `teacher_photo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_teacher`
--

INSERT INTO `tbl_teacher` (`teacher_id`, `teacher_name`, `teacher_email`, `teacher_contact`, `teacher_address`, `teacher_gender`, `teacher_password`, `department_id`, `teacher_designation`, `teacher_photo`) VALUES
(1, 'Dr. John Smith', 'john.smith@example.com', '9876543210', '123 Main St', 'Male', 'password123', 1, 'Professor', 'john.jpg'),
(2, 'Prof. Jane Doe', 'jane.doe@example.com', '8765432109', '456 Elm St', 'Female', 'password456', 1, 'Associate Professor', 'jane.jpg'),
(3, 'Dr. Alice Brown', 'alice.brown@example.com', '7654321098', '789 Oak St', 'Female', 'password789', 2, 'Professor', 'alice.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_timetable`
--

CREATE TABLE `tbl_timetable` (
  `timetable_id` int(11) NOT NULL,
  `timetable_day` varchar(100) NOT NULL,
  `timetable_hour` varchar(100) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_timetable`
--

INSERT INTO `tbl_timetable` (`timetable_id`, `timetable_day`, `timetable_hour`, `subject_id`, `semester_id`) VALUES
(1, 'Monday', '1', 1, 1),
(2, 'Monday', '2', 2, 2),
(3, 'Tuesday', '3', 3, 1),
(4, 'Wednesday', '4', 4, 3),
(5, 'Thursday', '1', 5, 1),
(6, 'Friday', '2', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_contact` varchar(60) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_dob` varchar(60) NOT NULL,
  `user_gender` varchar(60) NOT NULL,
  `user_photo` varchar(200) NOT NULL,
  `user_password` varchar(60) NOT NULL,
  `place_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_academicyear`
--
ALTER TABLE `tbl_academicyear`
  ADD PRIMARY KEY (`academicyear_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_assignment`
--
ALTER TABLE `tbl_assignment`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `tbl_assignmentbody`
--
ALTER TABLE `tbl_assignmentbody`
  ADD PRIMARY KEY (`assignmentbody_id`);

--
-- Indexes for table `tbl_assignsubject`
--
ALTER TABLE `tbl_assignsubject`
  ADD PRIMARY KEY (`assignsubject_id`);

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_class`
--
ALTER TABLE `tbl_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `tbl_classsem`
--
ALTER TABLE `tbl_classsem`
  ADD PRIMARY KEY (`classsem_id`);

--
-- Indexes for table `tbl_complaint`
--
ALTER TABLE `tbl_complaint`
  ADD PRIMARY KEY (`complaint_id`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `tbl_district`
--
ALTER TABLE `tbl_district`
  ADD PRIMARY KEY (`district_id`);

--
-- Indexes for table `tbl_event`
--
ALTER TABLE `tbl_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tbl_eventregistration`
--
ALTER TABLE `tbl_eventregistration`
  ADD PRIMARY KEY (`eventregistration_id`);

--
-- Indexes for table `tbl_internalmark`
--
ALTER TABLE `tbl_internalmark`
  ADD PRIMARY KEY (`internalmark_id`);

--
-- Indexes for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `tbl_place`
--
ALTER TABLE `tbl_place`
  ADD PRIMARY KEY (`place_id`);

--
-- Indexes for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tbl_studymaterial`
--
ALTER TABLE `tbl_studymaterial`
  ADD PRIMARY KEY (`studymaterial_id`);

--
-- Indexes for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  ADD PRIMARY KEY (`subcategory_id`);

--
-- Indexes for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `tbl_timetable`
--
ALTER TABLE `tbl_timetable`
  ADD PRIMARY KEY (`timetable_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_academicyear`
--
ALTER TABLE `tbl_academicyear`
  MODIFY `academicyear_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_assignment`
--
ALTER TABLE `tbl_assignment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_assignmentbody`
--
ALTER TABLE `tbl_assignmentbody`
  MODIFY `assignmentbody_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_assignsubject`
--
ALTER TABLE `tbl_assignsubject`
  MODIFY `assignsubject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_class`
--
ALTER TABLE `tbl_class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_classsem`
--
ALTER TABLE `tbl_classsem`
  MODIFY `classsem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_complaint`
--
ALTER TABLE `tbl_complaint`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_district`
--
ALTER TABLE `tbl_district`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_event`
--
ALTER TABLE `tbl_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_eventregistration`
--
ALTER TABLE `tbl_eventregistration`
  MODIFY `eventregistration_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_internalmark`
--
ALTER TABLE `tbl_internalmark`
  MODIFY `internalmark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_place`
--
ALTER TABLE `tbl_place`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_studymaterial`
--
ALTER TABLE `tbl_studymaterial`
  MODIFY `studymaterial_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_timetable`
--
ALTER TABLE `tbl_timetable`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
