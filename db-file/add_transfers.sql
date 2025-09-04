CREATE TABLE `student_transfer` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `from_class_id` int(11) NOT NULL,
  `from_section_id` int(11) NOT NULL,
  `to_class_id` int(11) NOT NULL,
  `to_section_id` int(11) NOT NULL,
  `reason` VARCHAR(255) NULL,
  `transfer_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  
  -- Indexes (optional, because FK creates them automatically)
  INDEX `idx_student_id` (`student_id`),
  INDEX `idx_from_class_id` (`from_class_id`),
  INDEX `idx_from_section_id` (`from_section_id`),
  INDEX `idx_to_class_id` (`to_class_id`),
  INDEX `idx_to_section_id` (`to_section_id`),
  
  -- Foreign key constraints
  CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `student`(`student_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_from_class` FOREIGN KEY (`from_class_id`) REFERENCES `class`(`class_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_from_section` FOREIGN KEY (`from_section_id`) REFERENCES `section`(`section_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_to_class` FOREIGN KEY (`to_class_id`) REFERENCES `class`(`class_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_to_section` FOREIGN KEY (`to_section_id`) REFERENCES `section`(`section_id`) ON DELETE CASCADE
);