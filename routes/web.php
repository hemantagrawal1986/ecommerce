<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified','cart'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get("/user/view",[UserController::class,'view'])->name("user.view");
});





Route::prefix("order")->middleware(["auth","verified"])->group(function()
{
   // Route::get('/view', function () {
   //     return view('order.view');
   // })->name('order.view');

   // Route::get('/view_exp', function () {
   //     return view('order.view_exp');
   // })->name('order.view_exp');


   // Route::get("/view",[\App\Http\Controllers\OrderController::class,''])
    Route::post('/store',[\App\Http\Controllers\OrderController::class,"store"])->name('order.store');

    Route::match(["get",'post'],'/products',[\App\Http\Controllers\OrderController::class,"products"])->name('order.products');
});

Route::match(["get",'post'],"/order/products",[\App\Http\Controllers\OrderController::class,"products"])->name('order.products'); //public 
Route::match(["get","post"],"/order/cart/{item}",[\App\Http\Controllers\OrderController::class,"cart"])->name("order.cart"); //public
Route::match(["get","post"],"/order/itemsearch",[\App\Http\Controllers\OrderController::class,"itemsearch"])->name("order.itemsearch"); //public
Route::get("/item/info/{product}",[\App\Http\Controllers\ItemController::class,"info"])->name("item.info"); //public
Route::get("/cart/view",[\App\Http\Controllers\CartController::class,"view"])->name("cart.view"); //public
Route::post("/cart/action",[\App\Http\Controllers\CartController::class,"action"])->name("cart.action"); //public
Route::match(["get","post"],"/cart/checkout",[\App\Http\Controllers\CartController::class,"checkout"])->name("cart.checkout"); //public


Route::prefix("wallet")->middleware(["auth","verified"])->group(function()
{
    Route::get('/view',[\App\Http\Controllers\WalletController::class,"view"])->name('wallet.view');
    Route::get('/create',[\App\Http\Controllers\WalletController::class,"create"])->name('wallet.create');
    Route::post('/store',[\App\Http\Controllers\WalletController::class,"store"])->name('wallet.store');
    Route::get('/transact/{desiredwallet?}',[\App\Http\Controllers\WalletController::class,"transact"])->name('wallet.transact');
    Route::post('/use',[\App\Http\Controllers\WalletController::class,"use"])->name('wallet.use');
    Route::get('/history/{wallet}',[\App\Http\Controllers\WalletController::class,"history"])->name('wallet.history');
});

Route::prefix("item")->middleware(["auth","verified"])->group(function()
{
    Route::match(['get','post'],'/view',[\App\Http\Controllers\ItemController::class,"view"])->name('item.view');
    Route::get('/create',[\App\Http\Controllers\ItemController::class,"create"])->name('item.create');
    Route::post('/store',[\App\Http\Controllers\ItemController::class,"store"])->name('item.store');
    Route::get('/edit/{item}',[\App\Http\Controllers\ItemController::class,"edit"])->name('item.edit')->withTrashed();
    Route::put('/update/{item}',[\App\Http\Controllers\ItemController::class,"update"])->name('item.update')->withTrashed();
    Route::delete('/delete/{item}',[\App\Http\Controllers\ItemController::class,"delete"])->name('item.delete');
    Route::put('/restore/{item}',[\App\Http\Controllers\ItemController::class,"restore"])->name('item.restore')->withTrashed();
    Route::get('/search/{searchstr?}',[\App\Http\Controllers\ItemController::class,"search"])->name('item.search');
    Route::delete('/deletephoto/{item?}',[\App\Http\Controllers\ItemController::class,"deletephoto"])->name('item.deletephoto');
});

Route::prefix("invoice_tracking")->middleware(["auth"])->group(function()
{
    Route::get("/view",[\App\Http\Controllers\InvoiceTrackingController::class,"view"])->name("invoice_tracking.view");
    Route::get("/update/{invoice_tracking?}/{newstatus?}",[\App\Http\Controllers\InvoiceTrackingController::class,"update"])->name("invoice_tracking.update");
});

//product catalog -- grouping
Route::prefix("category_group")->middleware(["auth","verified"])->group(function()
{
    Route::get('/view',[\App\Http\Controllers\CategoryGroupController::class,"view"])->name('category_group.view');
    Route::get('/create',[\App\Http\Controllers\CategoryGroupController::class,"create"])->name('category_group.create');
    Route::post('/store',[\App\Http\Controllers\CategoryGroupController::class,"store"])->name('category_group.store');
    Route::get('/edit/{categoryGroup}',[\App\Http\Controllers\CategoryGroupController::class,"edit"])->name('category_group.edit');
    Route::put('/update/{categoryGroup}',[\App\Http\Controllers\CategoryGroupController::class,"update"])->name('category_group.update');
    //Route::get('/create',[\App\Http\Controllers\ItemController::class,"create"])->name('item.create');
    //Route::post('/store',[\App\Http\Controllers\ItemController::class,"store"])->name('item.store');
    //Route::get('/edit/{item}',[\App\Http\Controllers\ItemController::class,"edit"])->name('item.edit')->withTrashed();
    //Route::put('/update/{item}',[\App\Http\Controllers\ItemController::class,"update"])->name('item.update')->withTrashed();
    //Route::delete('/delete/{item}',[\App\Http\Controllers\ItemController::class,"delete"])->name('item.delete');
    //Route::put('/restore/{item}',[\App\Http\Controllers\ItemController::class,"restore"])->name('item.restore')->withTrashed();
    //Route::get('/search/{searchstr?}',[\App\Http\Controllers\ItemController::class,"search"])->name('item.search');
});

Route::prefix("category")->middleware(["auth","verified"])->group(function()
{
    Route::get("/view/{categoryGroup?}",[\App\Http\Controllers\CategoryController::class,"view"])->name("category.view");
    Route::get("/create/{categoryGroup?}",[\App\Http\Controllers\CategoryController::class,"create"])->name("category.create");
    Route::post("/store",[\App\Http\Controllers\CategoryController::class,"store"])->name("category.store");
    Route::get("/edit/{category}",[\App\Http\Controllers\CategoryController::class,"edit"])->name("category.edit");
    Route::put("/update/{category}",[\App\Http\Controllers\CategoryController::class,"update"])->name("category.update");
});

//recommendations
Route::get("/order/recommend/{item}",[\App\Http\Controllers\OrderController::class,"recommend"])->name("order.recommend");

//Route::get("test",function()
//{
  //  echo "<br> test ".\App\Models\AppSequence::count();
//});

Route::middleware(["auth","verified"])->get("/settings",function() {
    return view("settings.view");
})->name("settings.view");

Route::get("/order/confirm",function() {
    return view("order.confirm");
});

Route::middleware(["auth","verified"])->prefix("invoice")->group(function()
{
    Route::get("/view/{invoice}",[\App\Http\Controllers\InvoiceController::class,"view"])->name("invoice.view");
});


Route::get("/mailinvoice/{invoice}",function (App\Models\Invoice $invoice) {
    if(!request()->hasValidSignature())
    {
        abort(401);
    }

    return view("invoice.view",["invoice"=>$invoice]);
})->name("mailinvoice");

//Route::get('/order', function () {
  //  return view('order.view');
//})->middleware(['auth', 'verified'])->name('order');

//--------------------------------------------------------

Route::get('/tokens/create', function (\Illuminate\Http\Request $request) {
    $token = $request->user()->createToken("api");
 
    return ['token' => $token->plainTextToken];
});

Route::get("/learning/view",function(\App\Action\OrderAction $orderaction) {
   // $orderaction=new \App\Action\OrderAction();
    $orderaction->execute();
});

Route::get("/learning/chain",function(\App\Action\OrderAction $orderaction) {
    // $orderaction=new \App\Action\OrderAction();
   //  $orderaction->execute();

    return $orderaction->foo()->bar()->done();
 });

 Route::get("/learning/set",function(\App\Action\OrderAction $orderaction) {
    // $orderaction=new \App\Action\OrderAction();
   //  $orderaction->execute();

   //$orderaction->invoice_number="te2st";

  // echo $orderaction->invoice_number;
 });

 Route::get("/urlcheck",function()
 {
    return URL::temporarySignedRoute(
        'unsubscribe', now()->addMinutes(30), ['user' => 1]
    );
 });

 

 Route::get("/unsubscribe",function(\Illuminate\Http\Request $request)
 {
    if (! $request->hasValidSignature()) {
        abort(401);
    }
    //return "<b>unscribed</b>";
 })->name("unsubscribe"); 

require __DIR__.'/auth.php';
