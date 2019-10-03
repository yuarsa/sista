<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Area;
use App\Transformers\Master\AreaTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class AreaController extends Controller
{
    protected $areaTransformer;

    public function __construct(AreaTransformer $areaTransformer)
    {
        parent::__construct();

        $this->areaTransformer = $areaTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Area::paginate();

            return $this->withCollectionResponse($data, $this->areaTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Area::findOrFail($id);

            return $this->withItemResponse($data, $this->areaTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    public function getByUserId()
    {
        try {
            $area_id = \Auth::user()->area_id;

            if(is_null($area_id)) {
                return $this->withCustomErrorResponse(500, 'Error get data is null');
            }

            $data = Area::findOrFail($area_id);

            if(!$data) {
                return $this->withCustomErrorResponse(422, 'Data not found');
            }

            return $this->withItemResponse($data, $this->areaTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }
}
