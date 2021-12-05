<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@sendVerificationCode')->name('login.sendCode');
Route::put('login', 'Auth\LoginController@verify')->name('login.verify');
Route::any('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('index');
Route::get('/search', 'HomeController@search')->name('search');
Route::post('/contact', 'HomeController@sendContact')->name('contact.send');
Route::get('/refereshcapcha', 'HomeController@refereshCapcha')->name('captcha.refresh');
Route::get('/c/{slug}', 'CategoryController@show')->name('category.show');
Route::get('/page/{slug}', 'PageController@show')->name('pages.show');
Route::get('cart', 'CartController@show')->name('cart.show');
Route::post('cart/submit_order_integration', 'CartController@order_integration')->name('cart.SubmitOrderIntegration');
Route::get('/cart/add/{product}', 'CartController@add')->name('cart.add');
Route::get('/cart/remove/{rowId}', 'CartController@remove')->name('cart.remove');
Route::get('/cart/increase/{rowId}', 'CartController@increase')->name('cart.increase');
Route::get('/cart/decrease/{rowId}', 'CartController@decrease')->name('cart.decrease');
Route::get('/tags/{tag}', 'HomeController@tags')->name('tags');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart/shipping', 'CartController@shipping')->name('cart.shipping');
    Route::post('/cart/shipping', 'CartController@submitShipping')->name('cart.submitShipping');
});

Route::post('/p/price', 'ProductController@price')->name('products.price');
Route::get('/p/{product}', 'ProductController@show')->name('products.show.short');
Route::prefix('products')->group(function () {
    Route::name('products.')->group(function () {
        Route::get('/', 'ProductController@all')->name('all');
        Route::get('/p/{slug}', 'ProductController@show')->name('show');
        Route::post('/p/{slug}/rate', 'ProductController@rate')->name('rate');
        Route::post('/p/{slug}/submitComment', 'ProductController@submitComment')->name('submitComment');
    });
});




Route::get('/sitemap', 'SitemapController@index')->name('sitemap');
Route::get('/sitemap/products', 'SitemapController@products')->name('sitemap.products');
Route::get('/sitemap/images', 'SitemapController@images')->name('sitemap.images');
Route::get('/sitemap/categories', 'SitemapController@categories')->name('sitemap.categories');
Route::get('/sitemap/pages', 'SitemapController@pages')->name('sitemap.pages');
Route::get('/sitemap/tags', 'SitemapController@tags')->name('sitemap.tags');
Route::get('/sitemap/brands', 'SitemapController@brands')->name('sitemap.brands');
Route::get('/sitemap/articleCategories', 'SitemapController@articleCategories')->name('sitemap.articleCategories');
Route::get('/sitemap/articles', 'SitemapController@articles')->name('sitemap.articles');

Route::get('/orders', 'OrderController@index')->name('orders.index');
Route::get('/orders/{code}', 'OrderController@show')->name('orders.show');

Route::post('/orders/{code}', 'OrderController@SubmitCoupon')->name('orders.submitCoupon');

Route::post('/orders/{code}/pay', 'OrderController@pay')
    ->name('orders.pay');
Route::any('/orders/{uuid}/verify', 'OrderController@verify')
    ->name('orders.verify');


Route::get('/provinces', 'HomeController@provinces')->name('provinces');
Route::get('/cities', 'HomeController@cities')->name('cities');
Route::get('/shippings', 'HomeController@shippings')->name('shippings');


Route::prefix('mag')->group(function () {
    Route::namespace('Mag')->group(function () {
        Route::name('mag.')->group(function () {

            Route::get('/', 'PublicController@index')->name('index');
            Route::get('/c/{slug}', 'CategoryController@show')->name('categories.show');
            Route::get('/p/{slug}', 'ArticleController@show')->name('articles.show');
            Route::post('/p/{slug}/rate', 'ArticleController@rate')->name('articles.rate');
            Route::post('/p/{slug}/submitComment', 'ArticleController@submitComment')->name('articles.submitComment');
        });
    });
});



Route::prefix('panel')->group(function () {
    Route::namespace('Panel')->group(function () {
        Route::name('panel.')->group(function () {
            Route::get('/clear-cache', function () {
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
            });
            Route::middleware(['auth', 'role:superadmin|admin'])->group(function () {
                Route::get('/', 'DashboardController@index')->name('dashboard');

                Route::resource('users', 'UserController');
                Route::prefix('user/{user}')->group(function () {
                    Route::name('users.')->group(function () {
                        Route::get('changeActive', 'UserController@changeActive')->name('changeActive');
                        Route::get('deleteImage', 'UserController@deleteImage')->name('deleteImage');
                        Route::post('addRole', 'UserController@addRole')->name('addRole');
                        Route::get('removeRole/{role}', 'UserController@removeRole')->name('removeRole');
                        Route::post('addPermission', 'UserController@addPermission')->name('addPermission');
                        Route::get('revokePermission/{permission}', 'UserController@revokePermission')->name('revokePermission');
                    });
                });

                Route::resource('roles', 'RoleController')->except('show');
                Route::resource('permissions', 'PermissionController')->except('show');
                Route::resource('permissionGroups', 'PermissionGroupController')->except('show');

                Route::resource('pages', 'PageController');
                Route::get('pages/{page}/deleteImage', 'PageController@deleteImage')->name('pages.deleteImage');
                Route::get('pages/{page}/changePublished', 'PageController@changePublished')->name('pages.changePublished');

                Route::resource('brands', 'BrandController');
                Route::get('brands/{brand}/deleteImage', 'BrandController@deleteImage')->name('brands.deleteImage');
                Route::get('brands/{brand}/deleteLogo', 'BrandController@deleteLogo')->name('brands.deleteLogo');


                Route::namespace('Attribute')->group(function () {
                    Route::resource('attributeGroups', 'AttributeGroupController');
                    Route::get('attributeForm', 'AttributeController@getForm')->name('attributes.getForm');
                    Route::post('attributeForm', 'AttributeController@addNewValue')->name('attributes.addNewValue');
                    Route::post('variationForm', 'AttributeController@getVariationForm')->name('attributes.getVariationForm');
                    Route::post('singleVariation', 'AttributeController@addSingleVariation')->name('attributes.addSingleVariation');
                    Route::prefix('attributeGroups/{group}')->group(function () {
                        Route::resource('attributes', 'AttributeController');
                        Route::prefix('attributes/{attribute}')->group(function () {
                            Route::resource('attributeItems', 'AttributeItemController');
                        });
                    });
                });

                Route::resource('tags', 'TagController')->except(['show']);
                Route::get('tags/search', 'TagController@search')->name('tags.search');

                Route::resource('menus', 'MenuController');
                Route::prefix('menus/{menu}')->group(function () {
                    Route::resource('menuItems', 'MenuItemController');
                });

                Route::resource('slides', 'SlideController');

                Route::resource('productCategories', 'ProductCategoryController');
                Route::get('productCategories/{category}/deleteIcon', 'ProductCategoryController@deleteIcon')->name('productCategories.deleteIcon');
                Route::get('productCategories/{category}/deleteImage', 'ProductCategoryController@deleteImage')->name('productCategories.deleteImage');

                Route::namespace('Product')->group(function () {
                    Route::resource('products', 'ProductController');
                    Route::prefix('products/{product}')->group(function () {
                        Route::get('/deleteImage', 'ProductController@deleteImage')->name('products.deleteImage');
                        Route::get('/gallery/{image}/delete', 'ProductController@deleteGalleryImage')->name('products.gallery.delete');
                        Route::get('/changePublished', 'ProductController@changePublished')->name('products.changePublished');
                        Route::get('/changeFeatured', 'ProductController@changeFeatured')->name('products.changeFeatured');

                        Route::get('/attributes', 'AttributeController@index')->name('products.attributes');
                        Route::post('/attributes', 'AttributeController@store')->name('products.attributes.store');
                        Route::put('/attributes', 'AttributeController@update')->name('products.attributes.update');
                        Route::delete('/attributes', 'AttributeController@destroy')->name('products.attributes.destroy');

                        Route::get('/variations', 'VariationController@index')->name('products.variations');
                        Route::post('/variations', 'VariationController@store')->name('products.variations.store');
                        Route::put('/variations', 'VariationController@update')->name('products.variations.update');
                        Route::delete('/variations', 'VariationController@destroy')->name('products.variations.destroy');
                        Route::get('/variations/createAll', 'VariationController@createAll')->name('products.variations.createAll');
                        Route::get('/variations/deleteInvalids', 'VariationController@deleteInvalids')->name('products.variations.deleteInvalids');

                        Route::get('/logs', 'LogController@index')->name('products.logs');

                    });
                });


                Route::resource('contacts', 'ContactController')->only(['index', 'show', 'destroy']);


                Route::prefix('posts/')->group(function () {
                    Route::name('posts.')->group(function () {
                        Route::resource('articles', 'ArticleController');
                        Route::get('articles/{article}/deleteImage', 'ArticleController@deleteImage')->name('articles.deleteImage');
                        Route::get('articles/{article}/rates', 'ArticleController@rates')->name('articles.rates');
                        Route::get('articles/{article}/comments', 'ArticleController@comments')->name('articles.comments.index');

                        Route::resource('categories', 'ArticleCategoriesController');
                        Route::get('categories/{category}/deleteIcon', 'ArticleCategoriesController@deleteIcon')->name('categories.deleteIcon');
                        Route::get('categories/{category}/deleteImage', 'ArticleCategoriesController@deleteImage')->name('categories.deleteImage');
                    });
                });


                Route::resource('comments', 'CommentController')->only(['index', 'destroy']);
                Route::get('comments/{comment}/approve', 'CommentController@toggleApprove')->name('comments.approve');
                Route::post('comments/{comment}', 'CommentController@reply')->name('comments.reply');

                Route::resource('/coupons', 'CouponController');
                Route::get('/couponLimit/{coupon}', 'CouponController@viewLimit')->name('coupons.limit');
                Route::post('/coupons/limit/{coupon}', 'CouponController@limitStore')->name('coupons.limitStore');
                Route::delete('/coupons/limit/{limit}', 'CouponController@limitDestroy')->name('coupons.limitDestroy');
                Route::post('/products/viewProducts', 'CouponController@viewProduct')->name('viewProduct');

                Route::resource('rates', 'RateController')->only('index', 'destroy');


                Route::post('/orders/action', 'OrderController@action')->name('orders.action');
                Route::resource('orders', 'OrderController')->except(['create', 'store']);

                Route::get('/reports', 'ReportController@index')->name('reports.index');
                Route::post('/chart', 'ReportController@chart')->name('reports.chart');

                Route::get('options', 'OptionController@index')->name('options.index');
                Route::prefix('options')->group(function () {
                    Route::resource('widgets', 'WidgetController')->except(['create', 'edit', 'show']);
                    Route::name('options.')->group(function () {
                        Route::post('site-information/updateLogo', 'OptionController@updateLogo')->name('siteInformation.updateLogo');
                        Route::post('site-information/updateFooterLogo', 'OptionController@updateFooterLogo')->name('siteInformation.updateFooterLogo');
                        Route::post('site-information/updateFavicon', 'OptionController@updateFavicon')->name('siteInformation.updateFavicon');
                        Route::get('site-information/deleteLogo', 'OptionController@deleteLogo')->name('siteInformation.deleteLogo');
                        Route::get('site-information/deleteFooterLogo', 'OptionController@deleteFooterLogo')->name('siteInformation.deleteFooterLogo');
                        Route::get('site-information/deleteFavicon', 'OptionController@deleteFavicon')->name('siteInformation.deleteFavicon');
                        Route::post('site-information', 'OptionController@siteInformation')->name('siteInformation');
                        Route::post('updateShipping', 'OptionController@updateShipping')->name('updateShipping');
                    });
                });
            });
        });
    });
});

Route::middleware(['auth'])->group(function () {
    Route::name('user.')->group(function () {
        Route::namespace('User')->group(function () {
            Route::prefix('user')->group(function () {
                Route::get('/', 'UserController@dashboard')->name('dashboard');

                Route::get('/profile', 'ProfileController@index')->name('profile.index');
                Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
                Route::post('/profile', 'ProfileController@update')->name('profile.update');
                Route::post('/profile/changePassword', 'ProfileController@changePassword')->name('profile.changePassword');

                //                Route::resource('addresses', 'AddressController');
                //                Route::get('addresses/{address}/setAsDefault','AddressController@setAsDefault')->name('addresses.setAsDefault');

                Route::get('/notifications', 'NotificationController@all')->name('notifications');
                Route::get('/notifications/readAll', 'NotificationController@readAll')->name('notifications.readAll');
                Route::get('/notifications/deleteRead', 'NotificationController@deleteRead')->name('notifications.deleteRead');
                Route::get('/notification/{id}/delete', 'NotificationController@delete')->name('notifications.delete');
                Route::get('/notification/{id}/read', 'NotificationController@markAsRead')->name('notifications.read');
                Route::get('/notification/{id}/show', 'NotificationController@show')->name('notifications.show');

                Route::get('/orders', 'OrderController@index')->name('orders.index');
                Route::get('/orders/{code}', 'OrderController@show')->name('orders.show');
                Route::get('/orders/{code}/reserve', 'OrderController@reserve')->name('orders.reserve');
                Route::get('/orders/{code}/done', 'OrderController@done')->name('orders.done');

                Route::get('/comments', 'CommentsController@index')->name('comments.index');
                Route::get('/comments/{comment}', 'CommentsController@show')->name('comments.show');
                Route::get('/comments/{comment}/edit', 'CommentsController@edit')->name('comments.edit');
                Route::post('/comments/{comment}', 'CommentsController@update')->name('comments.update');
                Route::delete('/comments/{comment}', 'CommentsController@destory')->name('comments.destroy');
            });
        });
    });
});
