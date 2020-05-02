<?php
$stmt->bindParam(':course_url', $course_url);
$stmt->bindParam(':course_id', $all_course_data['scraped_course_id']);
$stmt->bindParam(':url', $all_course_data['url']);
$stmt->bindParam(':slug', $all_course_data['slug']);
$stmt->bindParam(':title', $all_course_data['scraped_title']);
$stmt->bindParam(':cat', $all_course_data['scraped_cat']);
$stmt->bindParam(':subcat', $all_course_data['scraped_subcat']);
$stmt->bindParam(':subtitle', $all_course_data['scraped_subtitle']);
$stmt->bindParam(':description', $all_course_data['scraped_description']);
$stmt->bindParam(':image_url', $all_course_data['scraped_image_url']);
$stmt->bindParam(':author', $all_course_data['scraped_author']);
$stmt->bindParam(':author_id', $all_course_data['scraped_author_id']);
$stmt->bindParam(':author_page', $all_course_data['scraped_author_page']);
$stmt->bindParam(':author_description', $all_course_data['scraped_author_description']);
$stmt->bindParam(':twitter', $all_course_data['scraped_twitter']);
$stmt->bindParam(':review_percent', $all_course_data['scraped_review_percent']);
$stmt->bindParam(':ratings', $all_course_data['scraped_ratings']);
$stmt->bindParam(':calculated_quality', $all_course_data['calculated_quality']);
$stmt->bindParam(':student_no', $all_course_data['scraped_student_no']);
$stmt->bindParam(':coupon', $all_course_data['coupon']);        
$stmt->bindParam(':full_price', $all_course_data['scraped_full_price']);
$stmt->bindParam(':reduced_price', $all_course_data['scraped_reduced_price']);
$stmt->bindParam(':notes', $updated_notes);
$stmt->bindParam(':updated', $updated);
?>