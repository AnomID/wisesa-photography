<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    BookingController,
    DashboardController,
    PaymentController,
};

use App\Http\Controllers\admin\{
    ArtikelController,
    KategoriGambarController,
    KategoriProdukController,
    LayananController,
    SubLayananController,
    ProdukController,
    ProfilController,
    TentangController,
    TestimoniController,
    TimController,
    DashboardSuperAdminController,
    GaleriController,
    KategoriArtikelController,
    KomentarArtikelController,
    KontakController,
    BerandaController,
    BookingProgressController,
    ProfilAdminController,
};
// use App\Http\Controllers\user\{

// };
use App\Http\Controllers\auth\{
    LoginController,
    RegisterController,
    GoogleController,
    ForgotPasswordController,
};
use App\Http\Controllers\web\{
    LandingController,
    AboutController,
    ServiceController,
    GalleryController,
    ContactController,
    ProfilWebController,
};

Route::get('/run-superadmin', function () {
    Artisan::call('db:seed', [
        '--class' => 'SuperAdminSeeder'
    ]);

    return "SuperAdminSeeder has been create successfully!";
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout.post');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/auth/google/complete', [GoogleController::class, 'showCompleteForm'])->name('google.complete');
Route::post('/auth/google/complete-register', [GoogleController::class, 'completeRegister'])->name('google.complete.register');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showRequestOtpForm'])->name('forgot-password');
Route::get('/forgot-password/verify', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('forgot-password.verify');
Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('forgot-password.reset');

Route::post('/forgot-password/request-otp', [ForgotPasswordController::class, 'requestOtp'])->name('forgot-password.request-otp');
Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('forgot-password.verify-otp');
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('forgot-password.reset-password');


Route::group(['middleware' => ['role.superadmin']], function () {
    Route::get('/profil-admin', [ProfilAdminController::class, 'index'])->name('profil-admin');
    Route::put('/profil-admin/update', [ProfilAdminController::class, 'update'])->name('profil-admin.update');
    Route::get('/dashboard-superadmin', [DashboardSuperAdminController::class, 'index'])->name('dashboard-superadmin');
    Route::get('/dashboard/get-bookings-by-date', [DashboardSuperAdminController::class, 'getBookingsByDate'])->name('dashboard.get-bookings-by-date');
    Route::get('/dashboard/get-calendar-data', [DashboardSuperAdminController::class, 'getCalendarData'])->name('dashboard.get-calendar-data');
    Route::resource('beranda', BerandaController::class);
    Route::resource('artikel', ArtikelController::class);
    Route::resource('galeri', GaleriController::class);
    Route::resource('kontak', KontakController::class);
    Route::resource('layanan', LayananController::class);
    Route::resource('sub-layanan', SubLayananController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('tentang', TentangController::class);
    Route::resource('testimoni', TestimoniController::class);
    Route::resource('tim', TimController::class);
    Route::resource('kategoriArtikel', KategoriArtikelController::class);
    Route::resource('komentarArtikel', KomentarArtikelController::class);
    Route::resource('kategoriProduk', KategoriProdukController::class);
    Route::resource('kategoriGambar', KategoriGambarController::class);

    Route::get('/super-admin/booking', [BookingController::class, 'adminIndex'])->name('admin.booking.index');
    Route::get('/super-admin/booking/{id}', [BookingController::class, 'adminShow'])->name('admin.booking.show');
    Route::get('/super-admin/booking/{id}/edit', [BookingController::class, 'edit'])->name('admin.booking.edit');
    Route::put('/super-admin/booking/{id}', [BookingController::class, 'update'])->name('admin.booking.update');
    Route::put('/super-admin/booking/{id}/update-status', [BookingController::class, 'updateStatus'])->name('admin.booking.update-status');
    Route::delete('/super-admin/booking/{id}', [BookingController::class, 'destroy'])->name('admin.booking.destroy');
    Route::get('/super-admin/booking-export/excel', [BookingController::class, 'export'])->name('admin.booking.export');

    Route::get('/super-admin/payment/{id}', [PaymentController::class, 'show'])->name('admin.payment.show');
    Route::get('/super-admin/payment/{id}/json', [PaymentController::class, 'showJson'])->name('admin.payment.show.json');
    Route::post('/super-admin/payment/{id}/verifikasi', [PaymentController::class, 'verifikasi'])->name('admin.payment.verifikasi');
    Route::get('/super-admin/payment-image/{filename}', [PaymentController::class, 'serveImage'])->name('admin.payment.image');
    Route::delete('/super-admin/payment/{bookingId}', [PaymentController::class, 'destroy'])->name('admin.payment.destroy');

    Route::get('/super-admin/booking/{id}/progress', [BookingProgressController::class, 'edit'])->name('admin.booking.progress');
    Route::put('/super-admin/booking/{id}/progress', [BookingProgressController::class, 'update'])->name('admin.booking.progress.update');
    Route::post('/super-admin/booking/{id}/progress/quick', [BookingProgressController::class, 'quickUpdate'])->name('admin.booking.progress.quick');
    Route::put('/super-admin/booking/{id}/progress-update', [BookingController::class, 'updateProgress'])->name('admin.booking.progress.update.new');
});

Route::group(['middleware' => ['role.user']], function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');

    Route::get('/booking/{id}/payment', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{id}/payment', [BookingController::class, 'storePayment'])->name('booking.payment.store');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::post('/booking/{id}/selected-photos', [BookingController::class, 'storeSelectedPhotos'])->name('booking.selected-photos.store');
});

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'detail'])->name('services-detail');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{slug}', [GalleryController::class, 'detail'])->name('gallery.detail');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/profil-user', [ProfilWebController::class, 'index'])->name('profil-user');
Route::put('/profil-user/update', [ProfilWebController::class, 'update'])->name('profil-user.update');

Route::get('/api/sub-layanan/{layananId}', [BookingController::class, 'getSubLayanan'])->name('api.sub-layanan');
