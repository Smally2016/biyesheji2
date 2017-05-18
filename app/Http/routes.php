<?php
Route::get('/test', 'TestController@test');

Route::get('/home', function () {
    return view('web.web');
});
Route::get('/login', 'UserController@login');
Route::post('/login', 'UserController@doLogin');
Route::get('/check/{id}', 'EmployeeController@cardDetail');
Route::any('/wechat', 'WechatController@serve');

Route::group(['middleware' => ['auth', 'wechat_login']], function () {
    Route::get('/', 'DashboardController@getInout');
    Route::get('/logout', 'UserController@logout');

    Route::group(['prefix' => 'm'], function () {

        Route::get('/', function () {
            return view('user.welcome.welcome');
        });
        Route::get('/dashboard', 'MobileController@index');
        Route::post('/dashboard', 'MobileController@checkIn');
        Route::get('/rosters', 'MobileController@getRosterList');
        Route::get('/reports', 'MobileController@getReport');
        Route::post('/reports', 'MobileController@getReport');
        Route::get('/attendances', 'MobileController@getAttendance');
        Route::get('/profile', 'MobileController@getProfile');
    });

    Route::group(array('prefix' => 'user'), function () {
        Route::get('/', 'UserController@getList');
        Route::get('/new', 'UserController@createNew');
    });

    Route::group(array('prefix' => 'dashboard'), function () {
        Route::get('/inout', 'DashboardController@getInout');
        Route::get('/inout/api', 'DashboardController@inoutAPI');
        Route::get('/map', 'DashboardController@map');
        Route::get('/updateGeo', 'DashboardController@updateGeo');

    });

    Route::group(array('prefix' => 'attendance'), function () {
        Route::get('/weekly', 'AttendanceController@getWeekly');
        Route::post('/weekly', 'AttendanceController@getWeekly');
        Route::post('/weekly/getSiteAPI', 'AttendanceController@getSiteAPI');
    });

    Route::group(array('prefix' => 'employee'), function () {
        Route::get('/list/', 'EmployeeController@getList');
        Route::get('/list/{id}', 'EmployeeController@getList');
        Route::get('/new', 'EmployeeController@createNew');
        Route::post('/new', 'EmployeeController@saveNew');
        Route::get('/edit/{id}', 'EmployeeController@edit');
        Route::post('/edit/{id}', 'EmployeeController@saveEdit');
        Route::post('/edit/{id}/pdf', 'EmployeeController@saveEditPDF');
        Route::get('/delete/{id}', 'EmployeeController@delete');
        Route::get('/detail/{id}', 'EmployeeController@detail');
        Route::get('/card', 'EmployeeController@card');

        Route::post('/add_secret', 'EmployeeController@addSecret');
    });

    Route::group(array('prefix' => 'record'), function () {
        Route::get('/', 'RecordController@getRecord');

        Route::get('/manual', 'RecordController@getManual');
        Route::post('/manual/new', 'RecordController@getManual');
        Route::get('/manual/delete/{id}', 'RecordController@deleteManual');
        Route::post('/manual/get_site_with_employee', 'RecordController@getSiteWithEmployeeAPI');
        Route::post('/manual/get_shift_with_employee', 'RecordController@getShiftWithEmployeeAPI');
        Route::post('/manual/get_site', 'RecordController@getSiteAPI');
        Route::post('/manual/get_shift', 'RecordController@getShiftAPI');

        Route::get('/edit', 'RecordController@edit');
        Route::post('/edit', 'RecordController@edit');
        Route::post('/edit/duty_date', 'RecordController@changeDutyDate');
        Route::post('/edit/shift', 'RecordController@changeShift');
        Route::post('/edit/mode', 'RecordController@changeMode');
        Route::post('/edit/delete', 'RecordController@deleteEdit');
        Route::get('/report', 'RecordController@getReport');
        Route::post('/report', 'RecordController@getReport');
    });

    Route::get('/roster/roster', 'RosterController@getRoster');
    Route::post('/roster/roster', 'RosterController@getRoster');
    Route::post('/roster/roster/add', 'RosterController@addEmployee');
    Route::post('/roster/roster/delete/work', 'RosterController@deleteWork');
    Route::post('/roster/roster/delete/leave', 'RosterController@deleteLeave');
    Route::post('/roster/roster/add/workOrLeave', 'RosterController@addWorkOrLeave');

    Route::get('/shift/list', 'ShiftController@getList');
    Route::get('/shift/new', 'ShiftController@createNew');
    Route::post('/shift/new', 'ShiftController@saveNew');
    Route::get('/shift/edit/{id}', 'ShiftController@editShift');
    Route::post('/shift/edit/{id}', 'ShiftController@editShift');

    Route::group(array('prefix' => 'admin'), function () {
        Route::get('department/new', 'AdminDepartmentController@newDepartment');
        Route::post('department/new', 'AdminDepartmentController@newDepartment');
        Route::get('department/list', 'AdminDepartmentController@getDepartment');
        Route::get('department/edit/{id}', 'AdminDepartmentController@editDepartment');
        Route::post('department/edit/{id}', 'AdminDepartmentController@editDepartment');
        Route::get('department/delete/{id}', 'AdminDepartmentController@deleteDepartment');
        Route::get('department/manage_site/{id}', 'AdminDepartmentController@manageDepartment');
        Route::post('department/manage_site/{id}', 'AdminDepartmentController@newDepartmentSite');
        Route::get('department/{department_id}/site/{site_id}/delete', 'AdminDepartmentController@deleteDepartmentSite');
        Route::get('department/manage_user/{id}', 'AdminDepartmentController@manageUser');
        Route::post('department/manage_user/{id}', 'AdminDepartmentController@newDepartmentUser');
        Route::get('department/{department_id}/user/{user_id}/delete', 'AdminDepartmentController@deleteDepartmentUser');
    });

    Route::get('admin/user/list', 'AdminUserController@getList');
    Route::get('admin/user/new', 'AdminUserController@createNew');
    Route::any('admin/user/edit/{id}', 'AdminUserController@edit');
    Route::post('admin/user/new', 'AdminUserController@saveNew');

    Route::get('admin/site/list', 'AdminSiteController@getList');
    Route::get('admin/site/new', 'AdminSiteController@newSite');
    Route::post('admin/site/new', 'AdminSiteController@newSite');
    Route::get('admin/site/edit/{id}', 'AdminSiteController@editSite');
    Route::post('admin/site/edit/{id}', 'AdminSiteController@editSite');
    Route::get('admin/site/delete/{id}', 'AdminSiteController@deleteSite');

    Route::get('admin/reader/list', 'AdminReaderController@getList');
    Route::get('admin/reader/new', 'AdminReaderController@createNew');
    Route::post('admin/reader/new', 'AdminReaderController@saveNew');
    Route::get('admin/reader/edit/{id}', 'AdminReaderController@editReader');
    Route::post('admin/reader/edit/{id}', 'AdminReaderController@editReader');
    Route::get('admin/reader/delete/{id}', 'AdminReaderController@deleteReader');

    Route::get('admin/employee/title/list', 'AdminEmployeeController@getTitle');
    Route::get('admin/employee/title/new', 'AdminEmployeeController@newEmployeeTitle');
    Route::post('admin/employee/title/new', 'AdminEmployeeController@newEmployeeTitle');
    Route::get('admin/employee/title/edit/{id}', 'AdminEmployeeController@editEmployeeTitle');
    Route::post('admin/employee/title/edit/{id}', 'AdminEmployeeController@editEmployeeTitle');
    Route::get('admin/employee/title/delete/{id}', 'AdminEmployeeController@deleteEmployeeTitle');

    Route::get('admin/leave/type/new', 'AdminLeaveController@newLeaveType');
    Route::post('admin/leave/type/new', 'AdminLeaveController@newLeaveType');
    Route::get('admin/leave/type/list', 'AdminLeaveController@getLeaveType');
    Route::get('admin/leave/type/edit/{id}', 'AdminLeaveController@editLeaveType');
    Route::post('admin/leave/type/edit/{id}', 'AdminLeaveController@editLeaveType');
    Route::get('admin/leave/type/delete/{id}', 'AdminLeaveController@deleteLeaveType');

});
//api
Route::post('api/py/last_date', 'APIController@getLastDate');
Route::post('api/py/push', 'APIController@push');
Route::get('ta', 'APIController@insertTimeAttendance');

//web api
Route::post('api/web/get_weeks', 'WebAPIController@getWeeks');