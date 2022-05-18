<?php
namespace App\Http\Controllers;

use App\Actions\FizzBuzzAction;
use App\Repositories\StatsRepository;
use App\Validators\FizzBuzzValidator;
use App\ValueObject\FizzBuzzItem;
use Exception;
use Illuminate\Http\Request;
use JsonException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Stats;

class FizzBuzzController extends Controller
{

    public function __construct()
    {
        $this->fizzBuzzAction = new FizzBuzzAction();
        $this->statsRepository = new StatsRepository();
    }

    /**
     * @OA\Get(
     *     path="/generate_fizzbuzz",
     *     operationId="/generate_fizzbuzz",
     *     @OA\Parameter(
     *         name="int1",
     *         in="query",
     *         description="",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="int2",
     *         in="query",
     *         description="",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="str1",
     *         in="query",
     *         description="",
     *         required=false,
     *         @OA\Schema(type="string", default="fizz")
     *     ),
     *      @OA\Parameter(
     *         name="str2",
     *         in="query",
     *         description="",
     *         required=false,
     *         @OA\Schema(type="string", default="bzz")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns generated fizzbuzz",
     *         @OA\JsonContent(
     *             @OA\Property(type="string")
     *         ),
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     * )
     * @throws JsonException
     */
    public function generateFizzBuzz(Request $request): string
    {
        $validator = \Validator::make($request->all(), FizzBuzzValidator::$rules);

        if ($validator->fails()) {
            abort(400, $validator->errors());
        }

        try {
            $item1 = new FizzBuzzItem();
            $item1->setMultiplier((int) $request->input('int1'))->setWord($request->input('str1', 'Fizz'));
            $item2 = new FizzBuzzItem();
            $item2->setMultiplier((int) $request->input('int2'))->setWord($request->input('str2', 'Buzz'));
            $limit = $request->input('limit');
            Stats::create([
                'request' => json_encode($request->all(), JSON_THROW_ON_ERROR),
            ]);

            return $this->fizzBuzzAction->play($item1, $item2, $limit);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw $e;
        }
    }

    /**
     * @OA\Get(
     *     path="/get_most_called_request",
     *     operationId="/get_most_called_request",
     *     @OA\Response(
     *         response="200",
     *         description="Returns the most called request",
     *         @OA\JsonContent(
     *             @OA\Property(type="string")
     *         ),
     *     ),
     * )
     * @throws JsonException
     */
    public function getMostCalledRequest(Request $request): string
    {
        try {
            $result = $this->statsRepository->getMostCalledRequest();
            if ($result === null) {
                return json_encode([], JSON_THROW_ON_ERROR);
            }

            $data = [
                'request' => $result->_id,
                'hits' => $result->count,
            ];

            return json_encode($data, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw $e;
        }
    }
}
