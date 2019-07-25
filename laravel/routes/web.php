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

Route::get('/', function() {
	return redirect('login');
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function() {
	Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'HomeController@profile')->name('profile');
    Route::post('/change-password', 'HomeController@changePassword')->name('change-password');
    Route::post('/update-profile', 'HomeController@updateProfile')->name('update-profile');
    // Plan
    Route::group(['prefix' => 'plan', 'middleware' => 'permission:view_plan'], function() {
    	Route::get('/', 'PlanController@index')->name('plan.index');
    	Route::get('/create', 'PlanController@create')->middleware('permission:create_plan')->name('plan.create');
    	Route::post('/', 'PlanController@store')->middleware('permission:create_plan')->name('plan.store');
    	Route::get('/{id}', 'PlanController@show')->where(['id' => '[0-9]+'])->name('plan.show');
        Route::post('/update', 'PlanController@update')->middleware('permission:edit_plan')->name('plan.update');
        // Actual
        Route::group(['prefix' => 'actual', 'middleware' => 'permission:view_actual'], function() {
            Route::get('/{id}/create', 'ActualController@form')->middleware('permission:create_actual')->where(['id' => '[0-9]+'])->name('actual.create');
            Route::post('/{id}/store', 'ActualController@store')->middleware('permission:create_actual')->where(['id' => '[0-9]+'])->name('actual.store');
            Route::get('/{id}/edit/{act}', 'ActualController@show')->where(['id' => '[0-9]+', 'act' => '[0-9]+'])->name('actual.show');
            Route::post('/{id}/update/{act}', 'ActualController@update')->middleware('permission:edit_actual')->where(['id' => '[0-9]+', 'act' => '[0-9]+'])->name('actual.update');
            Route::delete('/delete', 'ActualController@delete')->middleware('permission:delete_actual')->name('actual.delete');
        });
    });

    Route::group(['prefix' => 'user-management', 'middleware' => 'permission:user_management'], function(){
    	Route::get('/', 'UserManagementController@index')->name('user-management.index');
    	Route::get('/user/{id}', 'UserManagementController@edit')->where(['id' => '[0-9]+'])->name('user-management.edit');
        Route::get('/create', 'UserManagementController@create')->name('user-management.create');
        Route::post('/insert', 'UserManagementController@insert')->name('user-management.insert');
    	Route::post('/update', 'UserManagementController@update')->name('user-management.update');
        Route::post('/set-status', 'UserManagementController@setStatus')->name('user-management.set-status');
        Route::delete('delete', 'UserManagementController@delete')->name('user-management.delete');
        Route::get('/import', 'UserManagementController@import')->name('user-management.import');
        Route::post('/import-process', 'UserManagementController@process')->name('user-management.process');
        Route::get('/download-example', 'UserManagementController@downloadExample')->name('user-management.download');
        Route::group(['prefix' => 'role'], function() {
            Route::get('/', 'RoleManagementController@index')->name('role-management.index');
            Route::get('/{id}', 'RoleManagementController@show')->where(['id' => '[0-9]+'])->name('role-management.show');
            Route::post('/update', 'RoleManagementController@update')->name('role-management.update');
            Route::get('/create', 'RoleManagementController@create')->name('role-management.create');
            Route::post('/insert', 'RoleManagementController@insert')->name('role-management.insert');
            Route::delete('/delete', 'RoleManagementController@delete')->name('role-management.delete');
        });
        Route::group(['prefix' => 'permission'], function() {
            Route::get('/', 'PermissionManagementController@index')->name('permission-management.index');
            Route::get('/{id}', 'PermissionManagementController@show')->where(['id' => '[0-9]+'])->name('permission-management.show');
            Route::post('/update', 'PermissionManagementController@update')->name('permission-management.update');
            Route::get('/create', 'PermissionManagementController@create')->name('permission-management.create');
            Route::post('/insert', 'PermissionManagementController@insert')->name('permission-management.insert');
            Route::delete('/delete', 'PermissionManagementController@delete')->name('permission-management.delete');
        });
    });

    Route::group(['prefix' => 'plan-category', 'middleware' => 'permission:view_master_data'], function() {
        // Plan Category
        Route::get('/', 'PlanCategoryController@index')->name('plan-category.index');
        Route::get('/create', 'PlanCategoryController@create')->middleware('permission:create_master_data')->name('plan-category.create');
        Route::post('/', 'PlanCategoryController@store')->middleware('permission:create_master_data')->name('plan-category.store');
        Route::get('/{id}', 'PlanCategoryController@show')->where(['id' => '[0-9]+'])->name('plan-category.show');
        Route::post('/update', 'PlanCategoryController@update')->middleware('permission:edit_master_data')->name('plan-category.update');
        Route::delete('/delete', 'PlanCategoryController@delete')->middleware('permission:delete_master_data')->name('plan-category.delete');
        Route::group(['prefix' => 'sub'], function() {
            Route::get('/', 'PlanSubCategoryController@index')->name('plan-sub-category.index');
            Route::get('/create', 'PlanSubCategoryController@create')->name('plan-sub-category.create');
            Route::post('/', 'PlanSubCategoryController@store')->name('plan-sub-category.store');
            Route::get('/{id}', 'PlanSubCategoryController@show')->where(['id' => '[0-9]+'])->name('plan-sub-category.show');
            Route::post('/update', 'PlanSubCategoryController@update')->name('plan-sub-category.update');
            Route::delete('/delete', 'PlanSubCategoryController@delete')->name('plan-sub-category.delete');
        });
    });

    Route::group(['prefix' => 'setting', 'middleware' => 'permission:view_master_data'], function() {
        Route::get('/', 'SettingController@index')->name('setting.index');
        Route::post('/update', 'SettingController@update')->middleware('permission:edit_master_data')->name('setting.update');
        Route::group(['prefix' => 'holiday'], function() {
            Route::get('/', 'SettingController@holiday')->name('setting.holiday.index');
            Route::get('/{id}', 'SettingController@show')->where(['id' => '[0-9]+'])->name('setting.holiday.show');
            Route::post('/update', 'SettingController@updateHoliday')->middleware('permission:edit_master_data')->name('setting.holiday.update');
            Route::get('/create', 'SettingController@create')->middleware('permission:create_master_data')->name('setting.holiday.create');
            Route::post('/insert', 'SettingController@insert')->middleware('permission:create_master_date')->name('setting.holiday.insert');
            Route::delete('/delete', 'SettingController@delete')->middleware('permission:delete_master_data')->name('setting.holiday.delete');
        });
    });

    Route::group(['prefix' => 'actual-category', 'middleware' => 'permission:view_master_data'], function() {
        // Actual Category
        Route::get('/', 'ActualCategoryController@index')->name('actual-category.index');
        Route::get('/create', 'ActualCategoryController@create')->middleware('permission:create_master_data')->name('actual-category.create');
        Route::post('/', 'ActualCategoryController@store')->middleware('permission:create_master_data')->name('actual-category.store');
        Route::get('/{id}', 'ActualCategoryController@show')->where(['id' => '[0-9]+'])->name('actual-category.show');
        Route::post('/update', 'ActualCategoryController@update')->middleware('permission:edit_master_data')->name('actual-category.update');
        Route::delete('/delete', 'ActualCategoryController@delete')->middleware('permission:delete_master_data')->name('actual-category.delete');
    });

    // Actual
    // Route::get('/plan/{plan_id}/actual/create', 'ActualController@create')->name('actual.create');
    // Route::post('/plan/{plan_id}/actual', 'ActualController@store')->name('actual.store');

    // Departmen
    Route::group(['prefix' => 'department', 'middleware' => 'permission:view_department'], function() {
	    Route::get('/', 'DepartmentController@index')->name('department.index');
	    Route::get('/create', 'DepartmentController@create')->middleware('permission:create_department')->name('department.create');
	    Route::post('/', 'DepartmentController@store')->middleware('permission:create_department')->name('department.store');
	    Route::get('/{id}', 'DepartmentController@show')->where(['id' => '[0-9]+'])->name('department.show');
        Route::post('/update', 'DepartmentController@update')->middleware('permission:edit_department')->name('department.update');
        Route::delete('/delete', 'DepartmentController@delete')->middleware('permission:delete_department')->name('department.delete');
        Route::group(['prefix' => 'team'], function() {
            Route::get('/', 'TeamController@index')->name('team.index');
            Route::get('/create', 'TeamController@create')->middleware('permission:create_department')->name('team.create');
            Route::get('/{id}', 'TeamController@show')->where(['id' => '[0-9]+'])->name('team.show');
            Route::post('/', 'TeamController@store')->middleware('permission:edit_department')->name('team.store');
            Route::post('/update', 'TeamController@update')->middleware('permission:edit_department')->name('team.update');
            Route::delete('/delete', 'TeamController@delete')->middleware('permission:delete_department')->name('team.delete');
        });
	});

    Route::group(['prefix' => 'project', 'middleware' => 'permission:view_project'], function() {
        Route::get('/', 'ProjectController@index')->name('project.index');
        Route::get('/create', 'ProjectController@create')->middleware('permission:create_project')->name('project.create');
        Route::get('/{id}', 'ProjectController@show')->where(['id' => '[0-9]+'])->name('project.show');
        Route::post('/', 'ProjectController@store')->middleware('permission:create_project')->name('project.store');
        Route::post('/update', 'ProjectController@update')->middleware('permission:edit_project')->name('project.update');
        Route::delete('/delete', 'ProjectController@delete')->middleware('permission:delete_project')->name('project.delete');
    });

    Route::group(['prefix' => 'config', 'middleware' => 'permission:view_config'], function() {
        Route::get('/', 'ConfigController@index')->name('config.index');
        Route::get('/create', 'ConfigController@create')->middleware('permission:create_config')->name('config.create');
        Route::get('/{id}', 'ConfigController@show')->name('config.show');
        Route::post('/', 'ConfigController@store')->middleware('permission:create_config')->name('config.store');
        Route::post('/update', 'ConfigController@update')->middleware('permission:edit_config')->name('config.update');
        Route::delete('/delete', 'ConfigController@delete')->middleware('permission:delete_config')->name('config.delete');
    });

    Route::group(['prefix' => 'overtime'], function() {
        Route::get('/', 'OvertimeController@index')->name('overtime.index');
        Route::get('/claim', 'OvertimeController@claim')->middleware('permission:create_claim_overtime')->name('overtime.claim');
        Route::post('/claim', 'OvertimeController@createClaim')->middleware('permission:create_claim_overtime')->name('overtime.create');
        Route::get('/claim/{id}', 'OvertimeController@showClaim')->where(['id' => '[0-9]+'])->name('overtime.show');
        Route::group(['prefix' => 'unclaimed'], function() {
            Route::get('/', 'OvertimeController@unclaimedIndex')->name('overtime.unclaimed.index');
        });
    });

    Route::group(['prefix' => 'ajax'], function() {
        Route::get('/plan-resource', 'PlanController@resource')->name('ajax.plan-resource');
        Route::get('/plan-event', 'PlanController@event')->name('ajax.plan-event');
        Route::get('/sub-category/{id}', 'PlanController@subCategory')->where(['id' => '[0-9]+'])->name('ajax.sub-category');
    });
});

// Git
Route::post('/git-pull/{key}/{branch?}', 'PullController@pull')->name('pull');

Route::get('health.php', function () {
    try {
        \DB::connection()->getPdo();
        return 'OK';
    } catch (\Exception $e) {
        abort(500, "Connection failed: " . $e->getMessage());
    }
});
