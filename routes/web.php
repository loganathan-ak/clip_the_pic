<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\BrandsProfileController;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\EnquiryController;
use App\Http\Middleware\IsSubscriber;
use App\Http\Middleware\IsSuperadmin;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsQualitychecker;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnotationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\CreditsUsageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualityChecker;
use App\Http\Controllers\ProjectzipController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ReportsControllers;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\SubOrderController;
use App\Http\Controllers\DesignersProjectZipController;



Route::get('/register', [RouteController::class, 'register'])->name('register');
Route::get('/login', [RouteController::class, 'login'])->name('login');
Route::post('/login', [Authentication::class, 'userLogin']);
Route::post('/register', [Authentication::class, 'userRegister']);
Route::post('/logout', [Authentication::class, 'userLogout'])->name('logout');
Route::get('/forgot-password', [Authentication::class, 'forgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [Authentication::class, 'sendNewPassword'])->name('password.update');

Route::post('/save-preview', [PreviewController::class, 'store']);
Route::get('/all-previews', [PreviewController::class, 'fetch']);


Route::get('/php-info', function () {
    phpinfo();
});

Route::post('/paypal/create', [PaymentController::class, 'createPayment'])->name('paypal.create');
Route::get('/paypal/success', [PaymentController::class, 'paymentSuccess'])->name('paypal.success');
Route::get('/paypal/cancel', [PaymentController::class, 'paymentCancel'])->name('paypal.cancel');
Route::post('/credits-usage-store', [CreditsUsageController::class, 'store'])->name('credits-usage.store');
Route::put('/credits-usage/{order}/update', [CreditsUsageController::class, 'update'])->name('credits-usage.update');
Route::post('/credits-usage/{order}/approve', [CreditsUsageController::class, 'approve'])->name('credits-usage.approve');
Route::delete('/credits-usage/{usage}', [CreditsUsageController::class, 'destroy'])->name('credits-usage.destroy');
Route::post('/sub-orders/create/{order}', [SubOrderController::class, 'store'])->name('sub-orders.create');




Route::get('/projectzips/download/{id}', [ProjectZipController::class, 'download'])->name('projectzips.download');

Route::post('/designers-zipupload', [DesignersProjectZipController::class, 'upload'])->name('designers.zipupload');
Route::get('/designers-zip/download/{id}', [DesignersProjectZipController::class, 'download'])->name('designers.zipdownload');



Route::middleware([IsSubscriber::class])->group(function () {

    Route::get('/', [RouteController::class, 'home'])->name('subscribers.dashboard');

    Route::get('/billing', [RouteController::class, 'billing'])->name('billing');

    Route::get('/plans', [PlansController::class, 'index'])->name('plans');

    //Brandprofile Routes
    Route::get('/brandprofile', [RouteController::class, 'brandProfile'])->name('brandprofile');

    Route::get('/add-brand', [RouteController::class, 'brandForm'])->name('addbrand');

    Route::post('/add-brand', [BrandsProfileController::class, 'store']);

    Route::get('/view-brand/{id}', [RouteController::class, 'viewBrand']);

    Route::get('/edit-brand/{id}', [RouteController::class, 'editBrand'])->name('brand.edit');

    Route::put('/update-brand/{id}', [BrandsProfileController::class, 'updateBrand'])->name('update.brand');

    Route::delete('/delete-brand/{id}', [BrandsProfileController::class, 'deleteBrand'])->name('delete.brand');

    Route::get('/search-brand', [BrandsProfileController::class, 'searchBrand']);

    Route::get('/search-job', [OrdersController::class, 'searchJob']);

    Route::get('/profile', [RouteController::class, 'profile'])->name('profile');

    Route::get('/designbrief', [RouteController::class, 'designBrief'])->name('designbrief');

    Route::get('/revisiontool', [RouteController::class, 'revisionTool'])->name('revisiontool');

    Route::get('/helpcenter', [RouteController::class, 'helpCenter'])->name('helpcenter');

    Route::get('/requests', [RouteController::class, 'requests'])->name('requests');

    Route::get('/add-order', [RouteController::class, 'addOrder'])->name('create.order');

    Route::post('/add-order', [OrdersController::class, 'store'])->name('create.order');

    Route::put('/subs-update-order/{id}', [SubscribersController::class, 'updateStatus'])->name('update.orderstatus');

    Route::get('/usage', [RouteController::class, 'usage'])->name('usage');

    Route::get('/users', [RouteController::class, 'users'])->name('users');

    Route::post('/submit-enquiry', [EnquiryController::class, 'store'])->name('submit.enquiry');

    Route::get('/credits-usage/requote/{order}', [CreditsUsageController::class, 'requote'])->name('credits-usage.requote');


});

Route::post('/save-annotation', [AnnotationController::class, 'store'])->name('save.annotation');
Route::get('/view-order/{id}', [RouteController::class, 'viewOrder'])->name('view.order');
Route::put('/update-order/{id}', [SuperadminController::class, 'updateOrder'])->name('update.order');

Route::middleware([IsSuperadmin::class])->group(function (){

    Route::get('/superadmin-dashboard', [RouteController::class, 'superadminDashboard'])->name('superadmin.dashboard');

    Route::get('/superadmin-dashboard/{status}', [SuperadminController::class, 'superadminDashboardLink'])->name('superadmin.dashboardLink');

    Route::get('/superadmin-orders', [RouteController::class, 'superadminOrders'])->name('superadmin.orders');

    Route::get('/superadmin-subscribers', [RouteController::class, 'superadminSubscribers'])->name('superadmin.subscribers');
     
    Route::get('/admins-list', [RouteController::class, 'adminsList'])->name('superadmin.admins'); 

    Route::get('/add-admin', [RouteController::class, 'addAdminForm'])->name('superadmin.addadmins');

    Route::post('/add-admin', [SuperadminController::class, 'createAdmin']);

    Route::get('/edit-admin/{id}', [SuperadminController::class, 'updateAdminform'])->name('superadmin.editadmin');

    Route::put('/edit-admin/{id}', [SuperadminController::class, 'updateAdmin'])->name('superadmin.editadmin');

    Route::delete('/delete-admin/{id}', [SuperadminController::class, 'deleteAdmin'])->name('delete.admin');

    Route::get('/superadmin-enquires', [RouteController::class, 'superadminEnquires'])->name('superadmin.enquires');

    Route::get('/edit-order/{id}', [RouteController::class, 'editOrder'])->name('edit.order');

    Route::get('/reports', [SuperadminController::class, 'reportsPage'])->name('superadmin.reports');

    Route::get('/search-enquiry', [SuperadminController::class, 'searchEnquiry'])->name('superadmin.searchenquiry');

    Route::get('/sub-orders', [SuperadminController::class, 'subOrders'])->name('superadmin.suborders');

    Route::get('/view-sub-orders/{id}', [SuperadminController::class, 'viewsubOrdres'])->name('superadmin.viewsuborders');

    Route::get('/transaction-report', [ReportsControllers::class, 'index'])->name('superadmin.transactionreport');

    Route::get('/jobs-report', [ReportsControllers::class, 'jobsReport'])->name('superadmin.jobsreport');

    Route::get('/credits-usage-report', [ReportsControllers::class, 'usageReport'])->name('creditsusage.report');

    Route::get('/superadmin-search-job', [SuperadminController::class, 'searchJob']);

    Route::get('/superadmin-search-subjob', [SuperadminController::class, 'searchsubJob']);

    Route::get('/plans-list', [SuperadminController::class, 'Plans'])->name('plans.list');
    Route::get('/plans/create', [PlansController::class, 'create'])->name('plans.create');
    Route::post('/plans/create', [PlansController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit', [PlansController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}/edit', [PlansController::class, 'update']);
    Route::delete('/plans/{plan}', [PlansController::class, 'destroy'])->name('plans.destroy');

  
});



Route::middleware([IsAdmin::class])->group(function (){

    Route::get('/admin-dashboard', [RouteController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::get('/admin-orders', [RouteController::class, 'adminOrders'])->name('admin.orders');

    Route::get('/admin-orders/{status}', [AdminController::class, 'dashiboardOrdersLink'])->name('admin.dashiboardorders');

    Route::get('/admin-suborders', [RouteController::class, 'adminsubOrders'])->name('admin.suborders');

    Route::get('/admin-vieworders/{id}', [AdminController::class, 'adminViewOrders'])->name('admin.vieworders');

    Route::get('/admin-editorders/{id}', [AdminController::class, 'adminEditOrders'])->name('admin.editorders');

    Route::put('/admin-editorders/{id}', [AdminController::class, 'updateOrder'])->name('admin.updateorders');

    Route::get('/designer-job-search', [AdminController::class, 'jobSearch']);

});


Route::middleware(['auth'])->group(function () {
    // Show profile page
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Update name/email
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Update password
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});



Route::middleware([IsQualitychecker::class])->group(function () {

    Route::get('/qc-dashboard', [QualityChecker::class, 'dashboard'])->name('qc.dashboard');

    Route::get('/qc-dashboard/{status}', [QualityChecker::class, 'dashboardStatusJobs'])->name('qc.dashboardstatus');

    Route::get('/qc-main-orders', [QualityChecker::class, 'mainOrders'])->name('qc.mainorders');

    Route::get('/qc-orders', [QualityChecker::class, 'orders'])->name('qc.orders');

    Route::get('/qc-order/edit/{id}', [QualityChecker::class, 'ordersEdit'])->name('qc.ordersedit');

    Route::put('/qc-editorders/{id}', [QualityChecker::class, 'updateOrder'])->name('qc.updateorders');

    Route::get('/qc-vieworders/{id}', [QualityChecker::class, 'viewOrder'])->name('qc.vieworders');

    Route::post('/project-zip-upload', [ProjectzipController::class, 'projectZip'])->name('projects.upload');

    Route::get('/qc-list', [QualityChecker::class, 'qclist'])->name('qc.lists');

    Route::get('/qc-view-order/{id}', [QualityChecker::class, 'viewQcorders'])->name('qc.view');

    Route::get('/view-main-job/{id}', [QualityChecker::class, 'viewMainJob'])->name('qc.viewmainjob');

    Route::get('/search_qc_list', [QualityChecker::class, 'ajaxSearchQcList']);

    Route::get('/search_qc_mainjob', [QualityChecker::class, 'ajaxSearchQcMainJob']);

    Route::get('/search_qc_job', [QualityChecker::class, 'ajaxSearchQcJob']);

    Route::get('/qc_edit_main_job/{id}', [QualityChecker::class, 'qcEditMainJob'])->name('qc.editmainjob');

    Route::put('/qc_update_main_job/{id}', [QualityChecker::class, 'updateMainOrder'])->name('qc.updatemainorders');

});


