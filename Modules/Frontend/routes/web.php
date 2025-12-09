<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controllers\FrontendController;
use Modules\Frontend\Http\Controllers\PaymentController;
use Modules\Frontend\Http\Controllers\MailSubscribeController;
use Modules\Frontend\Http\Controllers\PagesController;

use Modules\Frontend\Http\Controllers\Auth\GoogleController;
use Modules\Frontend\Http\Controllers\Auth\AuthenticatedSessionController;
use Modules\Frontend\Http\Controllers\Auth\PasswordResetLinkController;

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

// Signin Route

Route::get('/signin', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('frontend.signin');

Route::post('/signin', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::get('/forget-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('frontend.password.request');

Route::post('/forget-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('frontend.password.email');

Route::group(['middleware' => [ 'auth', 'useractive' ]], function () {

     // Website Section Route

     Route::get('website-section/{type}', [ FrontendController::class, 'websiteSettingForm' ] )->name('frontend.website.form');
     Route::post('update-website-information/{type}', [ FrontendController::class, 'websiteSettingUpdate' ] )->name('frontend.website.information.update');
 
     Route::post('store-frontend-data', [ FrontendController::class, 'storeFrontendData' ] )->name('store.frontend.data');
     Route::get('frontend-data-list',[ FrontendController::class, 'getFrontendDatatList'])->name('get.frontend.data');
     Route::post('frontend-data-delete',[ FrontendController::class, 'frontendDataDestroy' ])->name('delete.frontend.data');

    Route::group(['middleware' => [ 'frontendcheckrole' ]], function () {
        Route::get('user-dashboard',[ FrontendController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('favourite/{subtype}',[ FrontendController::class, 'favourite'])->name('favourite.index');
        Route::get('favourite-list',[ FrontendController::class, 'favouriteList'])->name('favourite.list');
        Route::get('user-profile',[ FrontendController::class, 'userProfile'])->name('profile');
        Route::post('profile-update',[ FrontendController::class, 'profileUpdate'])->name('profile.update');
        Route::get('daily-reminder',[ FrontendController::class, 'dailyReminder'])->name('daily.reminder');
        Route::get('my-subscription',[ FrontendController::class, 'mySubscription'])->name('my.subscription');
        Route::post('cancelsubscription',[ FrontendController::class, 'cancelSubscription'])->name('cancel.subscription');
        Route::get('metrics-setting',[ FrontendController::class, 'metricsSetting'])->name('metrics.setting');
        Route::get('configurepassword',[ FrontendController::class, 'configurePassword'])->name('user.changepassword');
        Route::post('update-password',[ FrontendController::class, 'updatePassword'])->name('update.password');
        Route::get('user-logout',[ FrontendController::class, 'logout'])->name('user.logout');
    });

    Route::get('payment', [PaymentController::class, 'payment'])->name('payment')->middleware('paymentcheck');

});

// Frontend Route
Route::get('/', [FrontendController::class,'index']);
Route::get('browse', [FrontendController::class, 'index'])->name('browse');
Route::post('user-store', [FrontendController::class, 'frontendUserStore'])->name('user.store');
Route::get('signup', [FrontendController::class, 'signup'])->name('signup');
Route::get('otp-login', [FrontendController::class, 'otpLogin'])->name('otp-login');

Route::get('diets', [FrontendController::class, 'diet'])->name('diet');
Route::get('diet-categories', [FrontendController::class, 'dietCategories'])->name('diet.categories');
Route::get('diet-categories-list/{slug}', [FrontendController::class, 'dietCategoriesList'])->name('diet.categories.list');
Route::get('diet-list', [FrontendController::class, 'dietList'])->name('diet.list');
Route::get('diet-detail/{slug}', [FrontendController::class, 'dietDetails'])->name('diet.details');

Route::get('workouts', [FrontendController::class, 'workouts'])->name('workouts');
Route::get('workout-exercises', [FrontendController::class, 'bodypartExercises'])->name('bodypart.exercises');
Route::get('workout-exercises-list/{slug}', [FrontendController::class, 'bodypartExercisesList'])->name('bodypart.exercises.list');
Route::get('workout-equipment-exercises-list/{slug}', [FrontendController::class, 'equipmentExercisesList'])->name('equipment.exercises.list');
Route::get('workout-exercises-detail/{slug}', [FrontendController::class, 'bodypartExercisesDetail'])->name('bodypart.exercises.detail');
Route::get('workout-level', [FrontendController::class, 'getLevels'])->name('get.levels');
Route::get('workout-levels/{slug}', [FrontendController::class, 'workoutLevel'])->name('workout.level');
Route::get('workout-equipment-based-exercise', [FrontendController::class, 'equipmentBasedExercise'])->name('equipment.based.exercise');
Route::get('workout-all', [FrontendController::class, 'workoutAll'])->name('all.workout');
Route::get('workouts-detail/{slug}', [FrontendController::class, 'workoutDetail'])->name('workout.detail');
Route::get('workout-day-exercise-list',[ FrontendController::class, 'getWorkoutDayExercise'])->name('get.workout.day.exercise');

Route::get('products', [FrontendController::class, 'product'])->name('products');
Route::get('product-categories', [FrontendController::class, 'productCategories'])->name('product.categories');
Route::get('product-categories-list/{slug}', [FrontendController::class, 'productCategoriesList'])->name('product.categories.list');
Route::get('product-list', [FrontendController::class, 'productList'])->name('product.list');
Route::get('product-detail/{slug}', [FrontendController::class, 'productDetails'])->name('product.details');

Route::get('blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('blog-recent', [FrontendController::class, 'recentBlog'])->name('recent.blog');
Route::get('blog-trending', [FrontendController::class, 'trendingBlog'])->name('trending.blog.list');
Route::get('blog-detail/{slug}', [FrontendController::class, 'BlogDetails'])->name('blog.details');

Route::get('pricing', [FrontendController::class, 'price'])->name('pricing-plan')->middleware('paymentcheck');

Route::post('toggle-favorite', [FrontendController::class, 'toggleFavorite'])->name('toggle.favorite');
Route::get('get-all-workouts-list',[ FrontendController::class, 'workoutAllList'])->name('get.all.workouts.list');

Route::get('change-setting-status', [ FrontendController::class, 'changeSettingStatus'])->name('change.setting.status');

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/search', [FrontendController::class, 'search'])->name('search');
Route::get('/search/suggestions', [FrontendController::class, 'getSuggestions'])->name('search.suggestions');

Route::get('page/{slug}', [FrontendController::class, 'page'])->name('pages');

Route::post('otp-registration', [FrontendController::class, 'otpUserRegister'])->name('otp.register');
Route::post('Registration', [FrontendController::class, 'completeRegistration'])->name('save.new.user');

Route::post('razorpay', [PaymentController::class, 'razorpay'])->name('razorpay');
Route::post('razorpay-payment-callback', [PaymentController::class, 'razorpayPaymentCallback'])->name('razorpay.payment.callback');

Route::post('stripe-payment', [PaymentController::class, 'stripe'])->name('stripe.payment');

route::get('payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

Route::post('/paystack', [PaymentController::class, 'paystack'])->name('paystack');
Route::get('paystack-payment-callback', [PaymentController::class, 'handleGatewayCallback'])->name('paystack.payment.callback');

Route::post('paypal-payment', [PaymentController::class, 'paypalPayment'])->name('paypal.payment');
Route::get('paypal-callback', [PaymentController::class, 'paypalCallback'])->name('paypal.callback');

Route::get('get-user-theme', [FrontendController::class, 'getUserTheme'])->name('getTheme');
Route::post('save-user-theme', [FrontendController::class, 'saveUserTheme'])->name('setTheme');

Route::post('subscribe', [MailSubscribeController::class, 'subscribe'])->name('subscribe');
Route::get('unsubscribe/success', [MailSubscribeController::class, 'unsubscribeSuccess'])->name('unsubscribe.success');
Route::get('/unsubscribe/{email}', [MailSubscribeController::class, 'showUnsubscribeForm'])->name('unsubscribe');
Route::post('/unsubscribe', [MailSubscribeController::class, 'unsubscribe'])->name('unsubscribe.submit');
Route::get('resubscribe', [MailSubscribeController::class, 'resubscribe'])->name('resubscribe');

Route::group([], function () {
    Route::resource('frontend', FrontendController::class)->names('frontend');
});

Route::get('language-setting', [FrontendController::class, 'languageSetting'])->name('language.setting');
Route::resource('pages', PagesController::class);