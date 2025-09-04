INSERT INTO `permissions` (`permission_id`, `permission_name`, `description`) VALUES
-- Dashboard
(1, 'view_dashboard', 'Access the dashboard'),

-- Students
(2, 'view_students', 'View student list'),
(3, 'create_student', 'Add new student'),
(4, 'edit_student', 'Edit existing student'),
(5, 'delete_student', 'Delete student'),
(6, 'transfer_student', 'Transfer student between classes/sections'),

-- Teachers
(7, 'view_teachers', 'View teacher list'),
(8, 'create_teacher', 'Add new teacher'),
(9, 'edit_teacher', 'Edit existing teacher'),
(10, 'delete_teacher', 'Delete teacher'),

-- Classes
(11, 'view_classes', 'View classes'),
(12, 'create_class', 'Create new class'),
(13, 'edit_class', 'Edit existing class'),
(14, 'delete_class', 'Delete class'),

-- Sections
(15, 'view_sections', 'View sections'),
(16, 'create_section', 'Create new section'),
(17, 'edit_section', 'Edit existing section'),
(18, 'delete_section', 'Delete section'),

-- Attendance
(19, 'view_attendance', 'View attendance records'),
(20, 'mark_attendance', 'Mark attendance'),
(21, 'edit_attendance', 'Edit attendance'),
(22, 'delete_attendance', 'Delete attendance'),

-- Subjects
(23, 'view_subjects', 'View subjects'),
(24, 'create_subject', 'Add new subject'),
(25, 'edit_subject', 'Edit subject'),
(26, 'delete_subject', 'Delete subject'),

-- Payments
(27, 'view_payments', 'View payments'),
(28, 'create_payment', 'Record payment'),
(29, 'edit_payment', 'Edit payment'),
(30, 'delete_payment', 'Delete payment'),

-- Expenses
(31, 'view_expenses', 'View expenses'),
(32, 'create_expense', 'Add new expense'),
(33, 'edit_expense', 'Edit expense'),
(34, 'delete_expense', 'Delete expense'),

-- Marksheets
(35, 'view_marksheets', 'View marksheets'),
(36, 'create_marksheet', 'Create new marksheet'),
(37, 'edit_marksheet', 'Edit marksheet'),
(38, 'delete_marksheet', 'Delete marksheet'),

-- Users
(39, 'view_users', 'View user accounts'),
(40, 'create_user', 'Create new user'),
(41, 'edit_user', 'Edit user'),
(42, 'delete_user', 'Delete user'),
(43, 'assign_roles', 'Assign roles and permissions to users');


-- --------------------------------------------------------------------------------------

INSERT INTO `roles` (`role_id`, `role_name`) VALUES (1, 'admin'), (2, 'teacher');

-- --------------------------------------------------------------------------------------

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(2, 11), -- view_classes
(2, 12), -- create_class
(2, 13), -- edit_class
(2, 14); -- delete_class