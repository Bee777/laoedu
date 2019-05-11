<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/******************** @GuestUserSection ****************** */
Route::group(['prefix' => '/guest', 'middleware' => ['cors']], function () {
    Route::post('/login', 'Auth\LoginController@login')->name('api.post.login');
    Route::post('/aGlkZGVuLXJlZ2lzdGVyLXBhZ2UtQGphb2w-post', 'Auth\RegisterController@register')->name('api.post.register');
    //Users Email Forgot Password
    Route::post('/forgot-password/email/{token}', 'Auth\ForgotPasswordController@getEmailFromToken')->name('api.post.getEmailFromToken');
    //Users Password Reset
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('api.post.resetPassword');
});
/******************** @GuestUserSection ****************** */

/******************** @HomeSection ****************** */
Route::group(['prefix' => '/home', 'middleware' => ['cors', 'parseToken:guest-bearer'] ], function () {
    Route::get('/index', 'HomeController@index')->name('api.get.home.index');
    /*********@Posts */
    Route::get('/posts/{type}', 'HomeController@responsePosts')->name('get.home.posts');
    Route::get('/posts/{type}/single/{id}', 'HomeController@responsePostsSingle')->name('get.home.posts.single');
    /********* @Posts */
    /****@ContactInfo */
    Route::post('/contact-info', 'HomeController@responsePostContactInfo')->name('api.post.contactInfo');
    /****@ContactInfo */
    /***@MembersChartRange */
    Route::get('/chart-ranges/{id}', 'HomeController@getChartRangeMembers');
    /***@MembersChartRange */
});
/******************** @HomeSection ****************** */

Route::group(['prefix' => '/', 'middleware' => ['cors', 'parseToken', 'auth:api']], function () {

    /**
     ***************** @AdminSection routes ************************
     */
    Route::group(['prefix' => '/admin', 'middleware' => []], function () {
        /*** @Searches ** */
        Route::get('/searches/{type}', 'AdminController@responseSearches')->name('api.admin.get.searches');
        /*** @Searches ** */

        /*** @Users actions ** */
        Route::post('/users-register', 'AdminController@responseActionAddUser')->name('api.admin.post.users.addUser');
        Route::post('/users-change-status/{id}', 'AdminController@responseActionChangeUserStatus')->name('api.admin.post.users.changeStatus');
        Route::post('/users-delete/{id}', 'AdminController@responseActionDeleteUser')->name('api.admin.post.users.deleteUser');
        /*** @Users actions ** */

        /*** @Organize ** */
        Route::post('/organize/create', 'AdminController@responseActionCreateOrganize')->name('api.admin.post.organize.create');
        Route::post('/organize/update/{id}', 'AdminController@responseActionUpdateOrganize')->name('api.admin.post.organize.update');
        Route::delete('/organize/delete/{id}', 'AdminController@responseActionDeleteOrganize')->name('api.admin.delete.organize.delete');
        /*** @Organize ** */

        /*** @Department ** */
        Route::post('/department/create', 'AdminController@responseActionCreateDepartment')->name('api.admin.post.department.create');
        Route::post('/department/update/{id}', 'AdminController@responseActionUpdateDepartment')->name('api.admin.post.department.update');
        Route::delete('/department/delete/{id}', 'AdminController@responseActionDeleteDepartment')->name('api.admin.delete.department.delete');
        /*** @Department ** */
        // Phoud
        /*** @SiteInfo ** */
        Route::post('site-info/manage', 'AdminController@responseActionManageSiteInfo')->name('api.admin.post.site-info.manage');
        Route::get('site-info', 'AdminController@getSiteInfo')->name('api.admin.get.site-info');
        /*** @SiteInfo ** */

        //End Phoud

        /*** @News ** */
        Route::post('/news/create', 'AdminController@insertNews');
        Route::post('/news/update/{id}', 'AdminController@updateNews');
        Route::delete('/news/delete/{id}', 'AdminController@DeleteNews');
        /***@News ** */
        /*** @Activity ** */
        Route::post('/activity/create', 'AdminController@insertActivity');
        Route::post('/activity/update/{id}', 'AdminController@updateActivity');
        Route::delete('/activity/delete/{id}', 'AdminController@DeleteActivity');
        /***@Activity ** */
        /*** @Event ** */
        Route::post('/event/create', 'AdminController@insertEvent');
        Route::post('/event/update/{id}', 'AdminController@updateEvent');
        Route::delete('/event/delete/{id}', 'AdminController@DeleteEvent');
        /***@Event ** */
        /*** @Scholarship ** */
        Route::post('/scholarship/create', 'AdminController@insertScholarship');
        Route::post('/scholarship/update/{id}', 'AdminController@updateScholarship');
        Route::delete('/scholarship/delete/{id}', 'AdminController@DeleteScholarship');
        /***@Scholarship ** */

        /***@ContactInfo ** */
        Route::get('/contactinfo', 'AdminController@getContactInfo');
        Route::post('/contactinfo/manage', 'AdminController@manageContactInfo');
        /** @ContactInfo ** */
        /***@AboutInfo ** */
        Route::get('/aboutinfo', 'AdminController@getAboutInfo');
        Route::post('/aboutinfo/manage', 'AdminController@manageAboutInfo');
        /** @AboutInfo ** */
        /***@OrganizeInfo ** */
        Route::get('/organizeinfo', 'AdminController@getOrganizeInfo');
        Route::post('/organizeinfo/manage', 'AdminController@manageOrganizeInfo');
        /** @OrganizeCharRange ** */
        Route::get('/chart-ranges', 'AdminController@getChartRangeOptions');
        Route::get('/chart-ranges/{id}', 'AdminController@getChartRangeMembers');
        Route::post('/chart-ranges/create', 'AdminController@insertCharRange');
        Route::post('/chart-ranges/update/{id}', 'AdminController@updateChartRange');
        Route::delete('/chart-ranges/delete/{id}', 'AdminController@deleteChartRange');
        /***@OrganizeCharRange ** */
        /** @ChartRangeMembers */
        Route::post('/chart-range-members/create', 'AdminController@createChartRangeMember');
        Route::post('/chart-range-members/update/{id}', 'AdminController@updateChartRangeMember');
        Route::delete('/chart-range-members/delete/{id}', 'AdminController@deleteChartRangeMember');
        /** @ChartRangeMembers */
        /***@Banner ** */
        Route::post('/banner/create', 'AdminController@insertBanner');
        Route::post('/banner/update/{id}', 'AdminController@updateBanner');
        Route::delete('/banner/delete/{id}', 'AdminController@deleteBanner');
        /***@Banner ** */
        /***@File ** */
        Route::post('/file/create', 'AdminController@insertFile');
        Route::post('/file/update/{id}', 'AdminController@updateFile');
        Route::delete('/file/delete/{id}', 'AdminController@deleteFile');
        /***@File ** */
        /***@Sponsor ** */
        Route::post('/sponsor/create', 'AdminController@insertSponsor');
        Route::post('/sponsor/update/{id}', 'AdminController@updateSponsor');
        Route::delete('/sponsor/delete/{id}', 'AdminController@deleteSponsor');
        /***@Sponsor ** */

        /*** @UploadPostsImage * */
        Route::post('posts/upload-images', 'AdminController@responseActionUploadImages')->name('api.admin.post.posts.uploadImages');
        Route::get('/posts/get-images', 'AdminController@responseActionGetImages')->name('api.admin.post.posts.getImages');
        Route::post('posts/delete-images/', 'AdminController@responseActionDeleteImages')->name('api.admin.delete.posts.delete');
        /*** @UploadPostsImage * */
        /*** @SendUserResetPasswordLink * */
        Route::post('/users-send-reset-password-link/{id}', 'AdminController@responseActionSendUserResetPasswordLink')->name('api.admin.post.users.sendResetPasswordLink');
        /*** @SendUserResetPasswordLink * */
        /*** @postManagePostsStatus * */
        Route::post('posts-status/manage', 'AdminController@responseActionManagePostsStatus')->name('api.admin.post.posts.ManagePostsStatus');
        /*** @postManagePostsStatus * */
    });
    /**
     ***************** @AdminSection routes ************************
     */
    /******************** @UserSection ****************** */
    Route::group(['prefix' => '/users', 'middleware' => []], function () {
        Route::post('me', 'UserController@me')->name('api.user.post.me');
        /*** @Searches ** */
        Route::get('/searches/{type}', 'UserController@responseSearches')->name('api.user.get.searches');
        /*** @Searches ** */
        /*** @UserProfileSettings ** */
        Route::get('/profile-options', 'UserController@responseProfileOptions')->name('api.user.get.profileOptions');
        Route::post('/profile-manage', 'UserController@responseProfileManage')->name('api.user.get.responseProfileManage');
        /*** @UserProfileSettings ** */
        Route::post('/profile-manage', 'UserController@responseProfileManage')->name('api.user.get.profileManage');
        Route::post('/credentials-manage', 'UserController@responseCredentialsManage')->name('api.user.get.credentialsManage');
        /*** @UserProfileSettings ** */
        /*** @UserMembersProfileSearch** */
        Route::post('/search-members', 'UserController@responseSearchMembersProfile')->name('api.user.post.searchMembersProfile');
        /*** @UserMembersProfileSearch** */
        /*** @UserMemberProfileSingle** */
        Route::get('/profile-single/{user_id}', 'UserController@responseUserProfileSingle')->name('api.user.get.userProfileSingle');
        /*** @UserMemberProfileSingle** */
        /*** @DashboardData Make it can accessible for admin and user * */
        Route::get('/dashboard-data', 'UserController@responseDashboardData')->name('api.user.get.dashboardData');
        /*** @DashboardData Make it can accessible for admin and user * */
        /*** @News ** */
        Route::post('/news/create', 'UserController@insertNews');
        Route::post('/news/update/{id}', 'UserController@updateNews');
        Route::delete('/news/delete/{id}', 'UserController@DeleteNews');
        /***@News ** */
        /*** @Activity ** */
        Route::post('/activity/create', 'UserController@insertActivity');
        Route::post('/activity/update/{id}', 'UserController@updateActivity');
        Route::delete('/activity/delete/{id}', 'UserController@DeleteActivity');
        /***@Activity ** */
        /*** @Event ** */
        Route::post('/event/create', 'UserController@insertEvent');
        Route::post('/event/update/{id}', 'UserController@updateEvent');
        Route::delete('/event/delete/{id}', 'UserController@DeleteEvent');
        /***@Event ** */
        /*** @Scholarship ** */
        Route::post('/scholarship/create', 'UserController@insertScholarship');
        Route::post('/scholarship/update/{id}', 'UserController@updateScholarship');
        Route::delete('/scholarship/delete/{id}', 'UserController@DeleteScholarship');
        /***@Scholarship ** */
        /*** @postManagePostsStatus * */
        Route::post('posts-status/manage', 'UserController@responseActionManagePostsStatus')->name('api.users.post.posts.ManagePostsStatus');
        /*** @postManagePostsStatus * */
        /*** @postMemberEducationsProfile */
        Route::post('member-educations/manage', 'UserController@responseActionManageMemberEducations')->name('api.users.post.ManageMemberEducations');
         /*** @postMemberEducationsProfile */
        /*** @postMemberEducationsProfile */
        Route::post('member-careers/manage', 'UserController@responseActionManageMemberCareers')->name('api.users.post.ManageMemberCareers');
        /*** @postMemberEducationsProfile */
    });
    /******************** @UserSection ****************** */
    /** @Logout */
    Route::post('/logout', 'Auth\LoginController@logout')->name('api.get.logout');
    /** @Logout */
});
