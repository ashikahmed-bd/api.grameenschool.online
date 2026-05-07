<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\BkashController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\MeetController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/navigation', [CategoryController::class, 'getNavigation']);
Route::get('/sliders', [SliderController::class, 'getSliders']);
Route::get('/collections', [CollectionController::class, 'getCollections']);
Route::get('/collections/{collection:slug}/courses', [CollectionController::class, 'getCollectionCourses']);
Route::get('/benefits', [BenefitController::class, 'getBenefits']);
Route::get('/courses/featured', [CourseController::class, 'getFeaturedCourses']);
Route::get('/categories', [CategoryController::class, 'getCategories']);
Route::get('/courses/latest', [CourseController::class, 'getLatestCourses']);
Route::get('/testimonials', [TestimonialController::class, 'getTestimonials']);
Route::get('/cta', [AppController::class, 'cta']);

Route::get('/grades', [GradeController::class, 'getGrades']);


Route::get('/courses', [CourseController::class, 'courses']);
Route::get('/courses/{course}/instructors', [CourseController::class, 'instructors']);
Route::get('/courses/{course}/curriculum', [CourseController::class, 'curriculum']);
Route::get('/courses/{course}/reviews', [CourseController::class, 'reviews']);
Route::get('/courses/search', [CourseController::class, 'search']);
Route::get('/courses/{slug}/{course}', [CourseController::class, 'details']);

Route::get('/categories/{category:slug}/courses', [CategoryController::class, 'getCourses']);

Route::get('/settings', [SettingsController::class, 'index']);
Route::get('/pages', [PageController::class, 'getPages']);
Route::get('/pages/{slug}', [PageController::class, 'pageDetails']);
Route::get('/reviews', [ReviewController::class, 'getReviews']);


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot', [AuthController::class, 'forgot']);

    Route::get('auth/google', [GoogleController::class, 'redirect']);
    Route::get('auth/google/callback', [GoogleController::class, 'callback']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [ProfileController::class, 'index']);
        Route::put('user', [ProfileController::class, 'update']);
        Route::put('password', [ProfileController::class, 'changePassword']);
        Route::post('logout', [ProfileController::class, 'logout']);
    });
});


Route::prefix('cart')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('items/{course}', [CartController::class, 'add']);
    Route::delete('items/{course}', [CartController::class, 'remove']);
    Route::post('coupon', [CartController::class, 'applyCoupon']);
    Route::delete('/', [CartController::class, 'clear']);

    Route::get('items/{course}/exists', [CartController::class, 'hasCourse']);
    Route::get('empty', [CartController::class, 'isEmpty']);

    Route::post('checkout', [CheckoutController::class, 'store']);
});

// Payments
Route::prefix('payment')->group(function () {
    Route::post('process', [PaymentController::class, 'process']);
    Route::post('success', [PaymentController::class, 'success']);
    Route::post('failed', [PaymentController::class, 'failed']);
    Route::post('cancel', [PaymentController::class, 'cancel']);
    Route::get('approved', [PaymentController::class, 'approved']);

    Route::get('bkash/callback', [BkashController::class, 'callback']);

    Route::get('invoice', [PaymentController::class, 'getInvoice']);
});

/*
|--------------------------------------------------------------------------
| Protected Routes - Sanctum
|--------------------------------------------------------------------------
*/
Route::scopeBindings()->group(function () {
    Route::prefix('profile')->middleware(['auth:sanctum'])->group(function () {

        Route::put('/academic', [ProfileController::class, 'academic']);
        Route::get('/courses', [ProfileController::class, 'courses']);
        Route::get('/courses/{course:slug}/lectures/{lecture}', [CourseController::class, 'learn']);

        Route::post('/courses/{course:slug}/reviews', [ReviewController::class, 'store']);
        Route::post('/courses/{course}/lectures/{lecture}/homeworks/{homework}/submit', [HomeworkController::class, 'submit']);

        Route::get('/meets', [ProfileController::class, 'getMeets']);
        Route::get('/orders', [ProfileController::class, 'getOrders']);

        Route::get('/notifications', [NoticeController::class, 'notifications']);
        Route::put('/notifications/{notification}/read', [NoticeController::class, 'markAsRead']);
    });


    Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index']);

        // Categories
        Route::get('categories/search', [CategoryController::class, 'search']);
        Route::get('categories', [CategoryController::class, 'index']);
        Route::post('categories', [CategoryController::class, 'store']);
        Route::get('categories/{category}', [CategoryController::class, 'show']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
        Route::get('categories/{category}/courses', [CategoryController::class, 'getCourses']);

        // Courses
        Route::get('courses/search', [CourseController::class, 'search']);
        Route::get('courses', [CourseController::class, 'index']);
        Route::post('courses', [CourseController::class, 'store']);
        Route::get('courses/{course}', [CourseController::class, 'show']);
        Route::delete('courses/{course}', [CourseController::class, 'destroy']);

        Route::get('courses/{course}/basic', [CourseController::class, 'getBasic']);
        Route::put('courses/{course}/basic', [CourseController::class, 'updateBasic']);
        Route::post('courses/{course}/cover', [CourseController::class, 'uploadCover']);
        Route::get('courses/{course}/curriculum', [CourseController::class, 'curriculum']);

        // Sections
        Route::prefix('courses/{course}')->group(function () {
            Route::prefix('sections')->group(function () {
                Route::get('/', [SectionController::class, 'index']);
                Route::post('/', [SectionController::class, 'store']);
                Route::get('{section}', [SectionController::class, 'show']);
                Route::put('{section}', [SectionController::class, 'update']);
                Route::delete('{section}', [SectionController::class, 'destroy']);

                Route::post('{section}/lectures', [LectureController::class, 'store']);
            });

            Route::prefix('lectures')->group(function () {
                Route::put('{lecture}', [LectureController::class, 'update']);
                Route::delete('{lecture}', [LectureController::class, 'destroy']);

                Route::put('{lecture}/article', [LectureController::class, 'article']);
                Route::post('{lecture}/video', [LectureController::class, 'video']);
            });
        });

        //Questions
        Route::get('/lectures/{lecture}/questions', [QuestionController::class, 'index']);
        Route::post('/lectures/{lecture}/questions', [QuestionController::class, 'store']);
        Route::get('/lectures/{lecture}/questions/{question}', [QuestionController::class, 'show']);
        Route::put('/lectures/{lecture}/questions/{question}', [QuestionController::class, 'update']);
        Route::delete('/lectures/{lecture}/questions/{question}', [QuestionController::class, 'destroy']);

        // homeworks
        Route::get('/courses/{course}/lectures/{lecture}/homeworks', [HomeworkController::class, 'index']);
        Route::post('/courses/{course}/lectures/{lecture}/homeworks', [HomeworkController::class, 'store']);
        Route::put('/courses/{course}/lectures/{lecture}/homeworks/{homework}', [HomeworkController::class, 'update']);
        Route::delete('/courses/{course}/lectures/{lecture}/homeworks/{homework}', [HomeworkController::class, 'destroy']);

        Route::get('/courses/{course}/lectures/{lecture}/homeworks/{homework}/submissions', [HomeworkController::class, 'submissions']);
        Route::put('/courses/{course}/lectures/{lecture}/submissions/{submission}/grade', [HomeworkController::class, 'grade']);

        // Orders
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);

        Route::post('/payments/{order}/verify', [PaymentController::class, 'verify']);

        // Collections
        Route::get('collections', [CollectionController::class, 'index']);
        Route::post('collections', [CollectionController::class, 'store']);
        Route::get('collections/{collection}', [CollectionController::class, 'show']);
        Route::put('collections/{collection}', [CollectionController::class, 'update']);
        Route::delete('collections/{collection}', [CollectionController::class, 'destroy']);

        // Reviews
        Route::get('reviews', [ReviewController::class, 'index']);
        Route::post('reviews', [ReviewController::class, 'store']);
        Route::get('reviews/{review:id}', [ReviewController::class, 'show']);
        Route::put('reviews/{review:id}', [ReviewController::class, 'update']);
        Route::delete('reviews/{review:id}', [ReviewController::class, 'destroy']);

        // Notice
        Route::get('notices', [NoticeController::class, 'index']);
        Route::post('notices', [NoticeController::class, 'store']);
        Route::get('notices/{notice}', [NoticeController::class, 'show']);
        Route::put('notices/{notice}', [NoticeController::class, 'update']);
        Route::delete('notices/{notice}', [NoticeController::class, 'destroy']);

        // Meet
        Route::get('meets', [MeetController::class, 'index']);
        Route::post('meets', [MeetController::class, 'store']);
        Route::get('meets/{meet}', [MeetController::class, 'show']);
        Route::put('meets/{meet}', [MeetController::class, 'update']);
        Route::delete('meets/{meet}', [MeetController::class, 'destroy']);
        Route::put('meets/{meet}/join', [MeetController::class, 'join']);

        // Users
        Route::get('users/search', [UserController::class, 'search']);
        Route::get('users', [UserController::class, 'index']);
        Route::post('users', [UserController::class, 'store']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::put('users/{user}', [UserController::class, 'update']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);

        // benefits
        Route::get('benefits', [BenefitController::class, 'index']);
        Route::post('benefit', [BenefitController::class, 'store']);
        Route::get('benefit/{benefit}', [BenefitController::class, 'show']);
        Route::put('benefit/{benefit}', [BenefitController::class, 'update']);
        Route::delete('benefit/{benefit}', [BenefitController::class, 'destroy']);

        // contact
        Route::get('contacts', [ContactController::class, 'index']);
        Route::post('contact', [ContactController::class, 'store']);
        Route::get('contact/{contact}', [ContactController::class, 'show']);
        Route::put('contact/{contact}', [ContactController::class, 'update']);
        Route::delete('contact/{contact}', [ContactController::class, 'destroy']);

        // Settings
        Route::prefix('settings')->group(function () {
            Route::post('logo', [SettingsController::class, 'logo']);

            Route::get('general', [SettingsController::class, 'getGeneral']);
            Route::put('general', [SettingsController::class, 'general']);
            Route::get('contact', [SettingsController::class, 'getContact']);
            Route::put('contact', [SettingsController::class, 'contact']);
            Route::get('seo', [SettingsController::class, 'getSeo']);
            Route::put('seo', [SettingsController::class, 'seo']);
            Route::get('sms', [SettingsController::class, 'getSms']);
            Route::put('sms', [SettingsController::class, 'sms']);

            Route::get('payment-gateways', [PaymentController::class, 'index']);
            Route::put('payment-gateways/{gateway}', [PaymentController::class, 'update']);

            Route::post('hero-banner', [SettingsController::class, 'uploadHeroBanner']);
            Route::post('preview-app', [SettingsController::class, 'uploadPreviewApp']);
            Route::get('homepage', [SettingsController::class, 'getHomepage']);
            Route::put('homepage', [SettingsController::class, 'updateHomepage']);
        });

        Route::get('backup/all', [BackupController::class, 'index']);
        Route::post('backup/create', [BackupController::class, 'create']);
        Route::get('backup/download/{file}', [BackupController::class, 'download']);

        Route::delete('tokens/flush', [SettingsController::class, 'flushTokens']);

        Route::get('storage-link', [SettingsController::class, 'storageLink']);
        Route::get('reboot', [SettingsController::class, 'reboot']);
    });
});
