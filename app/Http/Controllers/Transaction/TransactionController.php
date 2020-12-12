<?php
namespace App\Http\Controllers\Transaction;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\FetchTransactionsRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionController extends Controller
{
	private $dataService;
	
	//Select data source
	public function __construct()
	{
		try {
			$this->dataService	= resolve(request()->source.'-data-source');
		} catch (Exception $ex) {
			// DO SOMETHING
		}
	}
	
	/**
	 * Get all Transactions
	 * 
	 * @return type
	 */
	public function index(FetchTransactionsRequest $request)
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
	 * @return type
	 */
	public function show(FetchTransactionsRequest $request, int $transactionId)
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
	 * @return type
	 */
	public function user(FetchTransactionsRequest $request, int $userId)
	{
		try {
			return response($this->dataService->getUserTransactions($userId), Response::HTTP_OK);
		} catch (Exception $ex) {
			return response('', Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}
}