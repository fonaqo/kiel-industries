<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CmsCategoryController;
use App\Http\Controllers\Admin\CmsDashboardController;
use App\Http\Controllers\Admin\CmsMediaController;
use App\Http\Controllers\Admin\CmsExpertiseController;
use App\Http\Controllers\Admin\CmsPostController;
use App\Http\Controllers\Admin\AdminExportController;
use App\Http\Controllers\Admin\CmsProductController;
use App\Http\Controllers\Admin\CmsCompanyDocumentController;
use App\Http\Controllers\Admin\CmsSettingsController;
use App\Http\Controllers\Admin\CmsTipVideoController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LlmsTxtController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', RobotsController::class)->name('robots');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/media/avatars/{filename}', [UserAvatarController::class, 'show'])->name('media.avatars');
Route::get('/llms.txt', LlmsTxtController::class)->name('llms');
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/boutique', [ShopController::class, 'index'])->name('boutique');
Route::get('/boutique/{product:slug}', [ShopController::class, 'show'])->name('boutique.show');
Route::post('/boutique/{product:slug}/avis', [ProductReviewController::class, 'store'])->middleware('auth')->name('boutique.reviews.store');
Route::get('/nos-astuces', [PageController::class, 'nosAstuces'])->name('nos-astuces');
Route::get('/nos-documents', [PageController::class, 'nosDocuments'])->name('nos-documents');
Route::get('/expertises', [PageController::class, 'expertises'])->name('expertises');
Route::get('/expertises/{slug}', [PageController::class, 'expertiseShow'])->name('expertises.show');
Route::get('/a-propos', [PageController::class, 'aPropos'])->name('a-propos');
Route::get('/partenaire', [PageController::class, 'partenaire'])->name('partenaire');
Route::get('/actualites', [PageController::class, 'actualites'])->name('actualites');
Route::get('/actualites/{post:slug}', [PageController::class, 'actualiteShow'])->name('actualites.show');
Route::get('/mentions-legales', [PageController::class, 'mentionsLegales'])->name('mentions-legales');
Route::get('/politique-de-confidentialite', [PageController::class, 'politiqueConfidentialite'])->name('politique-confidentialite');
Route::get('/conditions-generales', [PageController::class, 'conditionsGenerales'])->name('conditions-generales');
Route::get('/conditions-utilisation', [PageController::class, 'conditionsUtilisation'])->name('conditions-utilisation');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:6,1')->name('contact.store');
Route::get('/panier', [PageController::class, 'panier'])->name('panier');
Route::get('/commande', [CheckoutController::class, 'show'])->name('commande');
Route::post('/commande', [CheckoutController::class, 'store'])->name('commande.store');
Route::get('/commande/merci/{order:access_token}', [CheckoutController::class, 'success'])->name('commande.success');

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/sync', [CartController::class, 'sync'])->name('cart.sync');
Route::patch('/cart/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{productId}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware('auth')->group(function () {
    Route::get('/wishlist/items', [WishlistController::class, 'index'])->name('wishlist.items');
    Route::post('/wishlist/sync', [WishlistController::class, 'sync'])->name('wishlist.sync');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->middleware('guest')->name('auth.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::middleware('guest')->group(function () {
    Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/connexion', [AuthController::class, 'login'])->name('login.store');
    Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/inscription', [AuthController::class, 'register'])->name('register.store');
    Route::get('/mot-de-passe-oublie', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/mot-de-passe-oublie', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reinitialiser-mot-de-passe/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reinitialiser-mot-de-passe', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/deconnexion', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/cms')->name('dashboard');

    Route::get('/commandes/export/{format}', [AdminExportController::class, 'orders'])->name('orders.export')->where('format', 'pdf|excel');
    Route::get('/commandes', [AdminDashboardController::class, 'orders'])->name('orders');
    Route::get('/commandes/historique', [AdminDashboardController::class, 'ordersHistory'])->name('orders.history');
    Route::get('/commandes/{order}', [AdminDashboardController::class, 'orderShow'])->name('orders.show');
    Route::patch('/commandes/{order}/statut', [AdminDashboardController::class, 'updateOrderStatus'])->name('orders.status');
    Route::get('/utilisateurs', [AdminDashboardController::class, 'users'])->name('users');
    Route::get('/favoris', [AdminDashboardController::class, 'wishlist'])->name('wishlist');

    Route::prefix('cms')->name('cms.')->group(function () {
        Route::get('/', [CmsDashboardController::class, 'index'])->name('dashboard');
        Route::post('/media', [CmsMediaController::class, 'store'])->name('media.store');
        Route::get('/parametres', [CmsSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/parametres', [CmsSettingsController::class, 'update'])->name('settings.update');

        Route::get('/categories', [CmsCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/nouveau', [CmsCategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CmsCategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CmsCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CmsCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CmsCategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/expertises', [CmsExpertiseController::class, 'index'])->name('expertises.index');
        Route::get('/expertises/nouveau', [CmsExpertiseController::class, 'create'])->name('expertises.create');
        Route::post('/expertises', [CmsExpertiseController::class, 'store'])->name('expertises.store');
        Route::get('/expertises/{expertise}/edit', [CmsExpertiseController::class, 'edit'])->name('expertises.edit');
        Route::put('/expertises/{expertise}', [CmsExpertiseController::class, 'update'])->name('expertises.update');
        Route::delete('/expertises/{expertise}', [CmsExpertiseController::class, 'destroy'])->name('expertises.destroy');

        Route::get('/astuces', [CmsTipVideoController::class, 'index'])->name('tips.index');
        Route::get('/astuces/nouveau', [CmsTipVideoController::class, 'create'])->name('tips.create');
        Route::post('/astuces', [CmsTipVideoController::class, 'store'])->name('tips.store');
        Route::get('/astuces/{tip}/edit', [CmsTipVideoController::class, 'edit'])->name('tips.edit');
        Route::put('/astuces/{tip}', [CmsTipVideoController::class, 'update'])->name('tips.update');
        Route::delete('/astuces/{tip}', [CmsTipVideoController::class, 'destroy'])->name('tips.destroy');

        Route::get('/documents', [CmsCompanyDocumentController::class, 'index'])->name('documents.index');
        Route::get('/documents/nouveau', [CmsCompanyDocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [CmsCompanyDocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents/{document}/edit', [CmsCompanyDocumentController::class, 'edit'])->name('documents.edit');
        Route::put('/documents/{document}', [CmsCompanyDocumentController::class, 'update'])->name('documents.update');
        Route::delete('/documents/{document}', [CmsCompanyDocumentController::class, 'destroy'])->name('documents.destroy');

        Route::get('/actualites', [CmsPostController::class, 'index'])->name('posts.index');
        Route::get('/actualites/nouveau', [CmsPostController::class, 'create'])->name('posts.create');
        Route::post('/actualites', [CmsPostController::class, 'store'])->name('posts.store');
        Route::get('/actualites/{post}/edit', [CmsPostController::class, 'edit'])->name('posts.edit');
        Route::put('/actualites/{post}', [CmsPostController::class, 'update'])->name('posts.update');
        Route::delete('/actualites/{post}', [CmsPostController::class, 'destroy'])->name('posts.destroy');

        Route::get('/produits/export/{format}', [AdminExportController::class, 'products'])->name('products.export')->where('format', 'pdf|excel');
        Route::get('/produits', [CmsProductController::class, 'index'])->name('products.index');
        Route::post('/produits/{product}/stock', [CmsProductController::class, 'adjustStock'])->name('products.stock');
        Route::get('/produits/nouveau', [CmsProductController::class, 'create'])->name('products.create');
        Route::post('/produits', [CmsProductController::class, 'store'])->name('products.store');
        Route::get('/produits/{product}/edit', [CmsProductController::class, 'edit'])->name('products.edit');
        Route::put('/produits/{product}', [CmsProductController::class, 'update'])->name('products.update');
        Route::delete('/produits/{product}', [CmsProductController::class, 'destroy'])->name('products.destroy');
    });
});

Route::middleware('auth')->prefix('mon-compte')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
    Route::get('/commandes', [AccountController::class, 'orders'])->name('orders');
    Route::get('/commandes/{order}', [AccountController::class, 'orderShow'])->name('orders.show');
    Route::get('/profil', [AccountController::class, 'profile'])->name('profile');
    Route::put('/profil', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::get('/favoris', [AccountController::class, 'wishlist'])->name('wishlist');
});
