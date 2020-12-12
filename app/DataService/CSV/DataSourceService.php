<?php
namespace App\DataService\CSV;

use App\DataService\DataServiceInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class DataSourceService implements DataServiceInterface
{
	private $rawData;
	
	public function __construct()
	{
		$this->rawData	= explode("\n", File::get(storage_path().'/transactions.csv'));
		Arr::forget($this->rawData, 0);
	}
	
	private function getRecord($row)
	{
		return [
			'id'			=> str_replace('"', '', trim(Arr::get($row, 0))),
			'code'			=> str_replace('"', '', trim(Arr::get($row, 1))),
			'amount'		=> str_replace('"', '', trim(Arr::get($row, 2))),
			'user_id'		=> str_replace('"', '', trim(Arr::get($row, 3))),
			'created_at'	=> str_replace('"', '', trim(Arr::get($row, 4))),
			'updated_at'	=> str_replace('"', '', trim(Arr::get($row, 5)))
		];
	}
	
	/**
	 * retrieve all transactions
	 * 
	 * @return mixed 
	 */
	public function all()
	{
		$result	= [];
		foreach ($this->rawData as $row) {
			if(trim($row)!='') {
				$result[]	= $this->getRecord(explode(',', $row));
			}
		}
		return $result;
	}
	
	/**
	 * retrieve a transaction by id
	 * 
	 * @param int $transactionId
	 * @return mixed 
	 */
	public function getById(int $transactionId)
	{
		foreach ($this->rawData as $row) {
			if(trim($row)!='') {
				$row	= $this->getRecord(explode(',', $row));
				if($row['id']==$transactionId) {
					return $row;
				}
			}
		}
		throw new ModelNotFoundException();
	}
	
	/**
	 * retrieve a user`s transactions
	 * @param int $userId
	 * @return mixed 
	 */
	public function getUserTransactions(int $userId)
	{
		$result	= [];
		foreach ($this->rawData as $row) {
			if(trim($row)!='') {
				$row	= $this->getRecord(explode(',', $row));
				if($row['user_id']==$userId) {
					$result[]	= $row;
				}
			}
		}
		return $result;
	}
}