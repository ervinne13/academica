SELECT 
	sg.student_id, 
--    SUM(sg.grade) AS total_grade, 
	sg.grade,
    grading_period_id, 
    c.subject_id, 
    gi.name AS graded_item_name,
    percentage_value
FROM student_grades AS sg
LEFT JOIN graded_items AS gi ON sg.graded_item_id = gi.id
LEFT JOIN student_classes AS sc ON sg.student_id = sc.student_id
LEFT JOIN classes AS c ON c.id = sc.class_id
LEFT JOIN grading_years AS gy ON gy.id = c.grading_year_id
RIGHT JOIN class_graded_items AS cgi ON cgi.class_id = c.id
LEFT JOIN graded_item_types AS git ON git.id = gi.type_id
WHERE sg.student_id = 44 AND gy.is_open = 1 AND cgi.is_active = 1
-- GROUP BY git.id