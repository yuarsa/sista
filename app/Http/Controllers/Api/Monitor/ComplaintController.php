<?php

namespace App\Http\Controllers\Api\Monitor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Monitors\Complaint;
use App\Traits\UploadFileTrait;
use App\Transformers\Monitor\ComplaintTransformer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ComplaintController extends Controller
{
    use UploadFileTrait;

    protected $complaintTransformer;

    public function __construct(ComplaintTransformer $complaintTransformer)
    {
        parent::__construct();

        $this->complaintTransformer = $complaintTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Complaint::paginate();

            return $this->withCollectionResponse($data, $this->complaintTransformer);
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
                'complain_failure' => 'required|string',
                'complain_name' => 'required|string',
                'complain_address' => 'required|string',
            ]);

            if($validation->fails()) {
                return $this->withCustomErrorResponse(422, $validation->errors());
            }

            if($request->hasFile('complain_image')) {
                $picture = $this->upload($request->file('complain_image'), 'complain');

                $request['complain_image'] = $picture;
            } else {
                $request['complain_image'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('complain_image1')) {
                $picture = $this->upload($request->file('complain_image1'), 'complain');

                $request['complain_image1'] = $picture;
            } else {
                $request['complain_image1'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('complain_image2')) {
                $picture = $this->upload($request->file('complain_image2'), 'complain');

                $request['complain_image2'] = $picture;
            } else {
                $request['complain_image2'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('complain_image3')) {
                $picture = $this->upload($request->file('complain_image3'), 'complain');

                $request['complain_image3'] = $picture;
            } else {
                $request['complain_image3'] = 'img/no_image_available.jpg';
            }

            $request['complain_code'] = $this->_generateCode();

            Complaint::create($request->input());

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
            $data = Complaint::findOrFail($id);

            return $this->withItemResponse($data, $this->complaintTransformer);
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
            $data = Complaint::find($id);

            // $validation = Validator::make($request->all(), [
            //     'complain_failure' => 'required|string',
            //     'complain_name' => 'required|string',
            //     'complain_address' => 'required|string',
            // ]);

            // if($validation->fails()) {
            //     return $this->withCustomErrorResponse(422, $validation->errors());
            // }

            if($request->hasFile('complain_image')) {
                $picture = $this->upload($request->file('complain_image'), 'complain');

                $request['complain_image'] = $picture;
            } else {
                $request['complain_image'] = $data->complain_image;
            }

            if($request->hasFile('complain_image1')) {
                $picture = $this->upload($request->file('complain_image1'), 'complain');

                $request['complain_image1'] = $picture;
            } else {
                $request['complain_image1'] = $data->complain_image1;
            }

            if($request->hasFile('complain_image2')) {
                $picture = $this->upload($request->file('complain_image2'), 'complain');

                $request['complain_image2'] = $picture;
            } else {
                $request['complain_image2'] = $data->complain_image2;
            }

            if($request->hasFile('complain_image3')) {
                $picture = $this->upload($request->file('complain_image3'), 'complain');

                $request['complain_image3'] = $picture;
            } else {
                $request['complain_image3'] = $data->complain_image3;
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

    public function followUp(Request $request, $id)
    {
        try {
            $data = Complaint::find($id);

            if($request->hasFile('complain_follow_up_image')) {
                $picture = $this->upload($request->file('complain_follow_up_image'), 'complain');

                $request['complain_follow_up_image'] = $picture;
            } else {
                $request['complain_follow_up_image'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('complain_follow_up_image1')) {
                $picture = $this->upload($request->file('complain_follow_up_image1'), 'complain');

                $request['complain_follow_up_image1'] = $picture;
            } else {
                $request['complain_follow_up_image1'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('complain_follow_up_image2')) {
                $picture = $this->upload($request->file('complain_follow_up_image2'), 'complain');

                $request['complain_follow_up_image2'] = $picture;
            } else {
                $request['complain_follow_up_image2'] = 'img/no_image_available.jpg';
            }

            if($request->hasFile('complain_follow_up_image3')) {
                $picture = $this->upload($request->file('complain_follow_up_image3'), 'complain');

                $request['complain_follow_up_image3'] = $picture;
            } else {
                $request['complain_follow_up_image3'] = 'img/no_image_available.jpg';
            }

            $request['complain_status'] = 2;

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
}
