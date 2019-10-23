<?php

namespace App\Http\Controllers\Api\Monitor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Monitors\Inspection;
use App\Traits\UploadFileTrait;
use App\Transformers\Monitor\InspectionTransformer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class InspectionController extends Controller
{
    use UploadFileTrait;

    protected $inspectionTransformer;

    public function __construct(InspectionTransformer $inspectionTransformer)
    {
        parent::__construct();

        $this->inspectionTransformer = $inspectionTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Inspection::paginate();

            return $this->withCollectionResponse($data, $this->inspectionTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'insp_area_id' => 'required|integer',
                'insp_asset_group_id' => 'required|integer',
                'insp_asset_id' => 'required|integer',
                'insp_volume' => 'required',
                'insp_matrik_id' => 'required|integer',
            ]);

            if($validation->fails()) {
                return $this->withCustomErrorResponse(422, $validation->errors());
            }

            if($request->hasFile('insp_image')) {
                $picture = $this->upload($request->file('insp_image'), 'inspection');

                $request['insp_image'] = $picture;
            } else {
                $request['insp_image'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('insp_image1')) {
                $picture = $this->upload($request->file('insp_image1'), 'inspection');

                $request['insp_image1'] = $picture;
            } else {
                $request['insp_image1'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('insp_image2')) {
                $picture = $this->upload($request->file('insp_image2'), 'inspection');

                $request['insp_image2'] = $picture;
            } else {
                $request['insp_image2'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('insp_image3')) {
                $picture = $this->upload($request->file('insp_image3'), 'inspection');

                $request['insp_image3'] = $picture;
            } else {
                $request['insp_image3'] = 'img/no_image_available.jpg';
            }

            $request['insp_code'] = $this->_generateCode();

            $request['insp_user_id'] = \Auth::user()->id;
            $request['insp_shift_id'] = \Auth::user()->shift;

            Inspection::create($request->input());

            return $this->withCustomResponse(201, 'Created data successfully');
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    private function _generateCode($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
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
            $data = Inspection::findOrFail($id);

            return $this->withItemResponse($data, $this->inspectionTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $data = Inspection::find($id);

            // $validation = Validator::make($request->all(), [
            //     'insp_area_id' => 'required|integer',
            //     'insp_asset_group_id' => 'required|integer',
            //     'insp_asset_id' => 'required|integer',
            //     'insp_volume' => 'required',
            //     'insp_matrik_id' => 'required|integer'
            // ]);

            // if($validation->fails()) {
            //     return $this->withCustomErrorResponse(422, $validation->errors());
            // }

            if($request->hasFile('insp_image')) {
                $picture = $this->upload($request->file('insp_image'), 'inspection');

                $request['insp_image'] = $picture;
            } else {
                $request['insp_image'] = $data->insp_image;
            }

            if($request->hasFile('insp_image1')) {
                $picture = $this->upload($request->file('insp_image1'), 'inspection');

                $request['insp_image1'] = $picture;
            } else {
                $request['insp_image1'] = $data->insp_image1;
            }

            if($request->hasFile('insp_image2')) {
                $picture = $this->upload($request->file('insp_image2'), 'inspection');

                $request['insp_image2'] = $picture;
            } else {
                $request['insp_image2'] = $data->insp_image2;
            }

            if($request->hasFile('insp_image3')) {
                $picture = $this->upload($request->file('insp_image3'), 'inspection');

                $request['insp_image3'] = $picture;
            } else {
                $request['insp_image3'] = $data->insp_image3;
            }

            $data->update($request->input());

            return $this->withCustomResponse(200, 'Updated data successfully');
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAllInspectionOpen()
    {
        try {
            $data = Inspection::open()->get();

            return $this->withCollectionWithoutPaginationResponse($data, $this->inspectionTransformer);
        } catch (QueryException $qe) {
            return $this->withCustomErrorResponse(422, $qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return $this->withCustomErrorResponse(422, $mnfe->getMessage());
        } catch (\Exception $e) {
            return $this->withCustomErrorResponse(500, $e->getMessage());
        }
    }

    public function followUp(Request $request, $id)
    {
        try {
            $data = Inspection::find($id);

            if($request->hasFile('insp_follow_up_image')) {
                $picture = $this->upload($request->file('insp_follow_up_image'), 'inspection');

                $request['insp_follow_up_image'] = $picture;
            } else {
                $request['insp_follow_up_image'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('insp_follow_up_image1')) {
                $picture = $this->upload($request->file('insp_follow_up_image1'), 'inspection');

                $request['insp_follow_up_image1'] = $picture;
            } else {
                $request['insp_follow_up_image1'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('insp_follow_up_image2')) {
                $picture = $this->upload($request->file('insp_follow_up_image2'), 'inspection');

                $request['insp_follow_up_image2'] = $picture;
            } else {
                $request['insp_follow_up_image2'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('insp_follow_up_image3')) {
                $picture = $this->upload($request->file('insp_follow_up_image3'), 'inspection');

                $request['insp_follow_up_image3'] = $picture;
            } else {
                $request['insp_follow_up_image3'] = 'img/no_image_available.jpg';
            }

            $request['insp_status'] = 2;

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
}
