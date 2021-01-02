<?php
namespace App\Http\Controllers\Transaction;

use App\DataService\DataServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionController extends Controller
{
	private $dataService;

	//Select data source
	public function __construct(DataServiceInterface $dataService)
	{
        $this->dataService	= $dataService;
	}

	/**
	 * Get all Transactions
	 *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			return response($this->dataService->all(), Response::HTTP_OK);
		} catch (Exception $ex) {
			return response('', Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

	/**
	 * Get a transaction by id
     *
	 * @param int $transactionId transaction id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
	 */
	public function show(int $transactionId)
	{
		try {
			return response($this->dataService->getById($transactionId), Response::HTTP_OK);
		} catch (ModelNotFoundException $ex) {
			return response('', Response::HTTP_NOT_FOUND);
		} catch (Exception $ex) {
			return response('', Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

    /**
     * Get a user transactions
     *
     * @param int $userId user id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
	public function user(int $userId)
	{
		try {
			return response($this->dataService->getUserTransactions($userId), Response::HTTP_OK);
		} catch (Exception $ex) {
			return response('', Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}
}
