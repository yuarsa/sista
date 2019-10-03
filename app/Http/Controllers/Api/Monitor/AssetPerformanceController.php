<?php

namespace App\Http\Controllers\Api\Monitor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Asset;
use App\Models\Monitors\AssetPerformance;
use App\Transformers\Asset\AssetTransformer;
use App\Transformers\Monitor\AssetPerformanceTransformer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class AssetPerformanceController extends Controller
{
    protected $assetPerformanceTransformer;

    protected $assetTransformer;

    public function __construct(AssetPerformanceTransformer $assetPerformanceTransformer, AssetTransformer $assetTransformer)
    {
        parent::__construct();

        $this->assetPerformanceTransformer = $assetPerformanceTransformer;

        $this->assetTransformer = $assetTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $shift_id = \Auth::user()->shift;

			$date_now = Carbon::today()->toDateString();

            $data = AssetPerformance::where('assetperf_shift', $shift_id)->whereDate('created_at', '=', $date_now)->paginate();

            return $this->withCollectionResponse($data, $this->assetPerformanceTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'assetperf_asset_group_id' => 'required|integer',
                'assetperf_asset_id' => 'required|integer',
                'assetperf_is_work' => 'required|integer',
            ]);

            if($validation->fails()) {
                return $this->withCustomErrorResponse(422, $validation->errors());
            }

            $shif_id = \Auth::user()->shift;

            $request['assetperf_code'] = $this->_generateCode();

            $request['assetperf_shift'] = $shif_id;

            AssetPerformance::create($request->all());

            return $this->withCustomResponse(201, 'Created data successfully');
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
            $data = AssetPerformance::find($id);

            if(!$data) {
                return $this->notFoundResponse("Performa Aset dengan id {$id} tidak ditemukan");
            }

            return $this->withItemResponse($data, $this->assetPerformanceTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = AssetPerformance::find($id);

            $validation = Validator::make($request->all(), [
                'assetperf_asset_group_id' => 'required|integer',
                'assetperf_asset_id' => 'required|integer',
                'assetperf_is_work' => 'required|integer',
            ]);

            if($validation->fails()) {
                return $this->withCustomErrorResponse(422, $validation->errors());
            }

            $data->update($request->all());

            return $this->withCustomResponse(200, 'Updated data successfully');
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    public function getAssetNotPost()
    {
        try {
            $shift = \Auth::user()->shift;

            $date_now = Carbon::today()->toDateString();

            $performancesPerShift = AssetPerformance::where('assetperf_shift', $shift)
                ->whereDate('created_at', '=', $date_now)->get();

            if(!$performancesPerShift->isEmpty()) {
                foreach ($performancesPerShift as $key => $value) {
                    $asset_id[] = $value->assetperf_asset_id;
                }

                $assets = Asset::whereNotIn('asset_id', $asset_id)->orderBy('asset_id', 'ASC')->get();
            } else {
                $assets = Asset::orderBy('asset_id', 'ASC')->get();
            }

            return $this->withCollectionWithoutPaginationResponse($assets, $this->assetTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    private function _generateCode($length = 7)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
