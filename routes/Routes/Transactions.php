<?php
use App\Http\Controllers\Transaction\TransactionController;
/*
|--------------------------------------------------------------------------
| User routes
|--------------------------------------------------------------------------
|
|
*/
Route::prefix('transaction')->group(function () {
	//Get all transactions
	Route::get('/', [TransactionController::class, 'index'])
		->name('transaction.list')
		;

	//Get a transaction
	Route::get('/{transactionId}', [TransactionController::class, 'show'])
		->where('transactionId', '[0-9]+')
		->name('transaction.show')
		;

	//Get a user transactions
	Route::get('/user/{userId}', [TransactionController::class, 'user'])
		->where('userId', '[0-9]+')
		->name('transaction.user.list')
		;
});
