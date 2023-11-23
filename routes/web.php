<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\ContactGroupsController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SettingsController;

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
Route::get('/', function () { return view('home'); });


Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () { 
	return view('pages.forgot-password'); 
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);

	// dashboard route  
	// Route::get('/dashboard', function () { 
	// 	return view('dashboard'); 
	// })->name('dashboard');

	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
	Route::get('/users', [UserController::class,'index']);
	Route::get('/user/get-list', [UserController::class,'getUserList']);
		Route::get('/user/create', [UserController::class,'create']);
		Route::post('/user/create', [UserController::class,'store'])->name('create-user');
		Route::get('/user/{id}', [UserController::class,'edit']);
		Route::post('/user/update', [UserController::class,'update']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);

	// Basic demo routes
	include('modules/demo.php');
	// Inventory routes
	include('modules/inventory.php');
	// Accounting routes
	include('modules/accounting.php');
});


Route::middleware(['auth'])->group(function () {
    // List Products
    Route::get('products', [ProductsController::class, 'index'])->name('products.index');

    // Add Products
    Route::get('product/create', [ProductsController::class, 'create'])->name('products.create');
	Route::post('products', [ProductsController::class, 'store'])->name('products.store');
	
	// Edit Products
	Route::get('/products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
	Route::put('/products/{product}', [ProductsController::class, 'update'])->name('products.update');


	// Delete Products
	Route::delete('/products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');

    // Product Categories
    Route::get('/categories', [CategoriesController::class, 'index'])->name('products.categories');
	Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
	Route::put('/categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');



    // Print Labels
    Route::get('products/labels', [ProductsController::class, 'labels'])->name('products.labels');

    // Import Products
    Route::get('products/import', [ProductsController::class, 'import'])->name('products.import');

	Route::get('/subcategories', [CategoriesController::class, 'subIndex'])->name('subcategories.index');



	Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('sale/sale', [SalesController::class, 'show'])->name('sales.show');
    // Route::get('sale/create', [SalesController::class, 'create'])->name('sales.create');
	Route::post('sales', [SalesController::class, 'store'])->name('sales.store');
	Route::get('/sale/{sale}/edit', [SalesController::class, 'edit'])->name('sales.edit');
	Route::put('/sale/{sale}', [SalesController::class, 'update'])->name('sales.update');
	Route::delete('/sale/{sale}', [SalesController::class, 'destroy'])->name('sales.destroy');


	Route::get('/pos', [PosController::class, 'index'])->name('sales.pos');


	Route::get('contacts', [ContactsController::class, 'index'])->name('contacts.index');
    Route::get('contact/contact', [ContactsController::class, 'show'])->name('contacts.show');
    // Route::get('sale/create', [ContactsController::class, 'create'])->name('contacts.create');
	Route::post('contacts', [ContactsController::class, 'store'])->name('contacts.store');
	Route::get('/contact/{contact}/edit', [ContactsController::class, 'edit'])->name('contacts.edit');
	Route::put('/contact/{contact}', [ContactsController::class, 'update'])->name('contacts.update');
	Route::delete('/contact/{contact}', [ContactsController::class, 'destroy'])->name('contacts.destroy');
    Route::get('contact/contact', [ContactsController::class, 'show'])->name('contacts.show');
    
	Route::get('contactsGroups', [ContactGroupsController::class, 'index'])->name('contacts.groups');
	Route::post('contactsGroups', [ContactGroupsController::class, 'store'])->name('contactGroup.store');
	Route::put('/contactsGroup/{contactsGroup}', [ContactGroupsController::class, 'update'])->name('contactGroup.update');
	Route::delete('/contactsGroup/{contactsGroup}', [ContactGroupsController::class, 'destroy'])->name('contactGroup.destroy');

	
	
	Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

});







Route::get('/register', function () { return view('pages.register'); });
Route::get('/login-1', function () { return view('pages.login'); });
