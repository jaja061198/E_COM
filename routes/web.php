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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/about-us', 'AboutUsController@index')->name('about.us');

Route::get('/terms-&-conditions', 'TermsController@index')->name('terms.index');

// Route::get('/', 'LandingPageController@index')->name('landing-page');
Route::get('/services', 'ShopController@serviceIndex')->name('services.index');

Route::get('/services/filter/{filter}', 'ShopController@filterIndex')->name('filter.services.index');

Route::get('/shop', 'ShopController@index')->name('shop.index');

Route::get('/shop/{product}', 'ShopController@show')->name('shop.show');
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart/store/item', 'CartController@store')->name('cart.store');
Route::post('/cart/store/shipping', 'CartController@shipping')->name('cart.ship');
Route::post('/cart/update/quantity', 'CartController@update')->name('cart.update');
Route::get('/cart/delete/{product}', 'CartController@destroy')->name('cart.destroy');
// Route::post('/cart/switchToSaveForLater/{product}', 'CartController@switchToSaveForLater')->name('cart.switchToSaveForLater');
// Route::delete('/saveForLater/{product}', 'SaveForLaterController@destroy')->name('saveForLater.destroy');
// Route::post('/saveForLater/switchToCart/{product}', 'SaveForLaterController@switchToCart')->name('saveForLater.switchToCart');
// Route::post('/coupon', 'CouponsController@store')->name('coupon.store');
// Route::delete('/coupon', 'CouponsController@destroy')->name('coupon.destroy');
Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
// Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');
// Route::post('/paypal-checkout', 'CheckoutController@paypalCheckout')->name('checkout.paypal');
// Route::get('/guestCheckout', 'CheckoutController@index')->name('guestCheckout.index');
// Route::get('/thankyou', 'ConfirmationController@index')->name('confirmation.index');
// Route::group(['prefix' => 'admin'], function () {
//     Voyager::routes();
// });
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/search', 'ShopController@search')->name('search');
// Route::get('/search-algolia', 'ShopController@searchAlgolia')->name('search-algolia');
Route::middleware('auth')->group(function () {
    Route::get('/my-profile', 'UsersController@edit')->name('users.edit');
    Route::post('/my-profile', 'UsersController@update')->name('users.update');
    
    Route::get('/my-orders', 'OrdersController@index')->name('orders.index');
    Route::get('/my-orders/{order}', 'OrdersController@show')->name('orders.show');

    Route::get('/my-orders-shipping', 'OrdersController@shipping')->name('orders.shipping');

    Route::get('/my-orders-shipping-received', 'OrdersController@received')->name('orders.received');

    Route::get('/my-orders-shipping-pickup', 'OrdersController@pickup')->name('orders.pickup');

    Route::get('/my-orders-completed', 'OrdersController@complete')->name('orders.complete');

    Route::get('/my-orders-cancelled', 'OrdersController@cancel')->name('orders.cancel');

    Route::get('/my-orders-change-status/{id}/{action}', 'OrdersController@changeStatus')->name('orders.change.status');

    Route::get('/my-orders-payment', 'PaymentsController@index')->name('payment.index');
    Route::post('/my-orders-payment', 'PaymentsController@store')->name('payment.post');
    Route::get('/my-orders-payment/{order}', 'PaymentsController@show')->name('payment.show');

	Route::get('/payment-guide', 'PaymentGuideController@index')->name('payment.guide.index');

});

// 0 = New
// 1 = Cancelled
// 2 = For Payment
// 3 = Reveiwing of Payment
// 4 = To Pickup if ( Store pickup )
// 5 = To receive 
// 6 = To Ship
// 7 = Completed
// 8 = for invoice