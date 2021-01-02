<?php
namespace App\DataService\CSV;

use App\DataService\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class DataSourceService implements DataServiceInterface
{
	private $data;

	public function __construct()
	{
	    $filePath   = storage_path().'/transactions.csv';
	    if(file_exists($filePath)) {
            $file       = fopen($filePath, 'r');
            fgetcsv($file);
            while(!feof($file)) {
                $row    =   fgetcsv($file);
                $this->data[$row[0]] = [
                    'id'            => (int)$row[0],
                    'code'          => $row[1],
                    'amount'        => (double)$row[2],
                    'user_id'       => (int)$row[3],
                    'created_at'    => $row[4],
                    'updated_at'    => $row[5]
                ];
            }
        }
	}

	/**
	 * retrieve all transactions
	 *
	 * @return mixed
	 */
	public function all()
	{
	    [, $values] = Arr::divide($this->data);
        return $values;
	}

	/**
	 * retrieve a transaction by id
	 *
	 * @param int $transactionId
	 * @return mixed
	 */
	public function getById(int $transactionId)
	{
	    $row    = Arr::get($this->data, $transactionId, false);
	    if(!$row) {
            throw new ModelNotFoundException();
        }
	    return $row;
	}

	/**
	 * retrieve a user`s transactions
	 * @param int $userId
	 * @return mixed
	 */
	public function getUserTransactions(int $userId)
	{
	    return $this->filterByKey('user_id', $userId);
	}

    /**
     * Filter data array by given key
     * @param $key key
     * @param $value search value
     * @param false $keepRowKeys keep the key of rows
     * @return array|mixed
     */
	private function filterByKey($key, $value, $keepRowKeys=false)
    {
        $result = Arr::where($this->data, function ($row) use($key, $value) {
            if(Arr::get($row, $key)==$value) {
                return $row;
            }
        });

        if(!$keepRowKeys) {
            [, $result] = Arr::divide($result);
        }

        return $result;
    }
}
