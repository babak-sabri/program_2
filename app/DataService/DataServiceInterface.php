<?php
namespace App\DataService;

interface DataServiceInterface
{
	/**
	 * retrieve all transactions
	 * 
	 * @return mixed 
	 */
	public function all();
	
	/**
	 * retrieve a transaction by id
	 * 
	 * @param int $transactionId
	 * @return mixed 
	 */
	public function getById(int $transactionId);
	
	/**
	 * retrieve a user`s transactions
	 * @param int $userId
	 * @return mixed 
	 */
	public function getUserTransactions(int $userId);
}