<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::any('index',['uses'=> 'IndexController@index']);//首页
Route::get('notice/detail/{nid}',['uses'=> 'IndexController@notice'])->where(['nid' =>'[0-9]+']);//公告
Route::any('login',['uses'=> 'LoginController@login']);//登陆
Route::any('logout',['uses'=> 'LoginController@logout']);//退出
Route::any('action/login',['uses'=> 'LoginController@loginAction']);//登陆行为的处理

//个人中心
Route::any('personal/info',['uses'=> 'PersonalController@info']);//我的资料
Route::any('personal/passedit',['uses'=> 'PersonalController@edit']);//密码修改
Route::any('personal/message',['uses'=> 'PersonalController@message']);//我的消息
Route::any('personal/edit',['uses'=> 'PersonalController@infoEdit']);//信息修改处理
Route::any('personal/editpass',['uses'=> 'PersonalController@infoPass']);//信息修改处理
Route::any('personal/newsnum',['uses'=> 'PersonalController@getMessageCount']);//获取消息的条目
Route::any('personal/newsstatus',['uses'=> 'PersonalController@dealMessageStatus']);//获取消息的状态

//课程管理（非管理员）
Route::any('course/list', ['uses' => 'CourseController@courseList']);//课程列表
Route::any('course/edit/{id?}/{name?}', ['uses' => 'CourseController@courseEdit']);//课程修改
Route::any('course/add', ['uses' => 'CourseController@courseAdd']);//课程增加
Route::any('course/edit-action', ['uses' => 'CourseController@courseEditAction']);//课程修改操作
Route::any('course/del-action', ['uses' => 'CourseController@courseDelAction']);//课程删除操作
Route::any('course/add-action', ['uses' => 'CourseController@courseAddAction']);//课程增加操作
Route::any('course/add-checking', ['uses' => 'CourseController@courseAddCheck']);//课程增加操作验证



//学生管理（非管理员）
Route::any('student/courselist', ['uses' => 'StudentController@studentCourseList']);//学生管理下的课程列表
Route::any('student/list/{teachs_code}', ['uses' => 'StudentController@studentList']);//学生管理下单个课程下的学生列表
Route::any('student/add', ['uses' => 'StudentController@studentAdd']);//学生管理下单个课程下的学生增加
Route::any('student/add-checking', ['uses' => 'StudentController@studentAddCheck']);//学生管理下单个课程下的学生增加
Route::any('student/add-action', ['uses' => 'StudentController@studentAddAction']);//学生管理下单个课程下的学生增加
Route::any('student/del-action', ['uses' => 'StudentController@studentDelAction']);//学生管理下单个课程下的学生删除


//签到管理
Route::any('signmanager/publish', ['uses' => 'SignController@signPublish']); //签到管理的发布新的签到
Route::any('signmanager/getstudent', ['uses' => 'SignController@signGetStudent']); //签到管理 拉取学生列表
Route::any('signmanager/getcode', ['uses' => 'SignController@signGetCode']); //签到管理 获取二维码
Route::any('signmanager/deal', ['uses' => 'SignController@signDeal']); //签到管理 处理学生签到状态
Route::any('signmanager/showcode', ['uses' => 'SignController@ShowCode']); //签到管理 二维码放大展示
Route::any('signmanager/showcode/{teachs_code?}', ['uses' => 'SignController@signShowCode']); //签到管理的发布新的签到,展示签到二维码


Route::any('signmanager/courselist/{action?}', ['uses' => 'SignController@signCourseList']); //签到管理下的课程列表
Route::any('signmanager/published/{teachs_code?}', ['uses' => 'SignController@signPublished']); //签到管理下的该课程的签到列表
Route::any('signmanager/list-detail', ['uses' => 'SignController@signListDetail']); //签到管理下的该课程的签到列表中的签到详情
Route::any('signmanager/detail-update', ['uses' => 'SignController@signListDetailUpdate']); //签到管理下的该课程的签到列表中的签到详情修改
Route::any('signmanager/update-action', ['uses' => 'SignController@signListDetailUpdateAction']); //签到管理下的该课程的签到列表中的签到详情修改请求


//管理员模块
Route::any('admin/teachers',    ['uses'=> 'AdminController@teacher']);//教师列表
Route::any('admin/teacher/edit-action',    ['uses'=> 'AdminController@teacherEdit']);//教师列表编辑行为
Route::any('admin/teacher/add',    ['uses'=> 'AdminController@teacherAdd']);//教师列表添加
Route::any('admin/teacher/add-action',    ['uses'=> 'AdminController@teacherAddAction']);//教师列表添加行为
Route::any('admin/teacher/del-action',    ['uses'=> 'AdminController@teacherDel']);//教师列表删除行为

Route::any('admin/teacher/admin-action', ['uses' => 'AdminController@adminSet']);//教师列表置为管理员
Route::any('admin/teacher/passReset-action', ['uses' => 'AdminController@passReset']);//教师列表密码重置

Route::any('admin/teacher/admin-action',    ['uses'=> 'AdminController@adminSet']);//教师列表置为管理员
Route::any('admin/teacher/passReset-action',    ['uses'=> 'AdminController@passReset']);//教师列表密码重置


Route::any('admin/students',    ['uses'=> 'AdminController@student']);//学生列表
Route::any('admin/students/edit-action',    ['uses'=> 'AdminController@studentEdit']);//学生列表编辑行为
Route::any('admin/students/add',    ['uses'=> 'AdminController@studentAdd']);//学生添加
Route::any('admin/students/add-action',    ['uses'=> 'AdminController@studentAddAction']);//学生添加行为
Route::any('admin/students/del-action',    ['uses'=> 'AdminController@studentDel']);//学生列表删除
Route::any('admin/classRooms',    ['uses'=> 'AdminController@classRoom']);//教室列表
Route::any('admin/classRoom/edit-action',    ['uses'=> 'AdminController@classRoomEdit']);//教室列表编辑行为
Route::any('admin/classRoom/del-action',    ['uses'=> 'AdminController@classRoomDel']);//教室列表删除行为


Route::any('admin/courses',['uses'=> 'AdminController@course']);//课程列表
Route::any('admin/course/del-action',['uses'=> 'AdminController@courseDel']);//课程删除
Route::any('admin/course/edit-action',['uses'=> 'AdminController@courseEdit']);//课程修改
Route::any('admin/course/add',['uses'=> 'AdminController@courseAdd']);//课程新增
Route::any('admin/course/add-action',['uses'=> 'AdminController@courseAddAction']);//课程新增行为


Route::any('admin/messages',    ['uses'=> 'AdminController@message']);//消息列表
Route::any('admin/messages-push',    ['uses'=> 'AdminController@messagePush']);//消息发送
Route::any('admin/messages-to',    ['uses'=> 'AdminController@messageTo']);//消息接收送人检查
Route::any('admin/notices',    ['uses'=> 'AdminController@notice']);//公告列表
Route::any('admin/notices-push',    ['uses'=> 'AdminController@noticePush']);//公告发布


//uploading

Route::any('image-upload',    ['uses'=> 'UploadingController@imageUpload']);//图片上传
Route::any('image-uploading',['uses'=> 'UploadingController@uploadImgAction']);//图片上传操作


//export
Route::any('detailExport/{qrcode_code?}',['uses'=> 'ExportController@detailExport']);//签到详情导出
Route::any('sumExport/{teachs_code?}',['uses'=> 'ExportController@courseExport']);//单门课程的签到统计