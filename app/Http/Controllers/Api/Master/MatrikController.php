<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Matrik;
use App\Transformers\Master\MatrikTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class MatrikController extends Controller
{
    protected $matrikTransformer;

    public function __construct(MatrikTransformer $matrikTransformer)
    {
        parent::__construct();

        $this->matrikTransformer = $matrikTransformer;
    }

    public function getByGroupAll($group_id)
    {
        try {
            $data = Matrik::where('matrik_group_id', $group_id)->get();

            return $this->withCollectionWithoutPaginationResponse($data, $this->matrikTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }
}
