<?php
namespace App\DataService\DB;

use App\DataService\DataServiceInterface;
use App\Models\Transaction\Transaction;

class DataSourceService implements DataServiceInterface
{
	/**
	 * retrieve all transactions
	 * 
	 * @return mixed 
	 */
	public function all()
	{
		return Transaction::all();
	}
	
	/**
	 * retrieve a transaction by id
	 * 
	 * @param int $transactionId
	 * @return mixed 
	 */
	public function getById(int $transactionId)
	{
		return Transaction::where('id', $transactionId)->firstOrFail();
	}
	
	/**
	 * retrieve a user`s transactions
	 * @param int $userId
	 * @return mixed 
	 */
	public function getUserTransactions(int $userId)
	{
		return Transaction::where('user_id', $userId)->get();
	}
}