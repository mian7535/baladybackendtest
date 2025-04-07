<?php


$router->get('/', function () use ($router) {
    return 'Work in progress';
});

$router->get('fetch-image', 'GalleryController@index');

$router->get('call-back', 'AuthController@call_back');
    $router->get('api/student/generate-certificate', 'CertificateController@pdf');
$router->post('api/student/push-info', 'TestController@push_info');
$router->group(["middleware" => ["auth"], "prefix" => "api"], function () use ($router) {
$router->post('auth/login', 'AuthController@login');
    $router->post('auth/register', 'AuthController@register');
    $router->get('student/courses', 'CourseController@index');
$router->post('student/type/update', 'AuthController@updateType');
    $router->get('student/exams', 'QuizController@index');
    $router->get('student/exams/questions', 'QuizController@questions');
    $router->get('student/get-course', 'CourseController@courseGet');
$router->get('student/check-progress', 'CourseController@checkProgress');
    $router->post('student/check-result', 'QuizController@check_result');
    $router->get('student/certificate', 'CertificateController@get_certificate');
    $router->post('student/course-completed', 'CourseController@CourseComplete');
    $router->post('student/lesson-completed', 'LessonController@LessonComplete');
    $router->get('student/get-enquiry', 'TestController@get_Enquiry');
    $router->get('student/dashbaord', 'DashbaordController@index');
    $router->get('student/my-profile', 'AuthController@my_profile');
    $router->post('logout', 'AuthController@logout');
});
