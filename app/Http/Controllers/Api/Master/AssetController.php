<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Asset;
use App\Transformers\Asset\AssetTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class AssetController extends Controller
{
    protected $assetTransformer;

    public function __construct(AssetTransformer $assetTransformer)
    {
        parent::__construct();

        $this->assetTransformer = $assetTransformer;
    }

    public function getByGroupAll($group_id)
    {
        try {
            $data = Asset::where('asset_asset_group_id', $group_id)->get();

            return $this->withCollectionWithoutPaginationResponse($data, $this->assetTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }
}
