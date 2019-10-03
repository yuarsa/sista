<?php

namespace App\Traits;

use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Symfony\Component\HttpFoundation\Response;

Trait JsonResponseTrait
{
    protected $code = 200;

    protected $fractal;

    public function setFractal(Manager $fractal)
    {
        $this->fractal = $fractal;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function withCustomResponse($code, $message, $data = '')
    {
        return response()->json(['code' => $code, 'message' => $message, 'result' => $data], $code);
    }

    public function withArrayResponse(array $data, array $header = [])
    {
        return response()->json(['code' => $this->code, 'message' => null, 'result' => $data], $this->code, $header);
    }

    public function withCustomErrorResponse($code, $message)
    {
        return response()->json(['error' => ['code' => $code, 'message' => $message]], $code);
    }

    public function withItemResponse($item, $callback)
    {
        $items = new Item($item, $callback);

        $create = $this->fractal->createData($items);

        return $this->withArrayResponse($create->toArray());
    }

    public function withCollectionResponse($collection, $transformer)
    {
        $data = new Collection($collection, $transformer);

        if(empty($collection)) {
            $collection = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);

            $data = new Collection($collection, $transformer);
        }

        $data->setPaginator(new IlluminatePaginatorAdapter($collection));

        $response = $this->fractal->createData($data);

        return $this->withArrayResponse($response->toArray());
    }

    public function withCollectionWithoutPaginationResponse($collection, $transformer)
    {
        $data = new Collection($collection, $transformer);

        $response = $this->fractal->createData($data);

        return $this->withArrayResponse($response->toArray());
    }

    public function forbiddenResponse($message = 'Forbidden response')
    {
        return response()->json(['code' => Response::HTTP_FORBIDDEN, 'message' => $message], Response::HTTP_FORBIDDEN);
    }

    public function emptyResponse()
    {
        $result = new \stdClass();

        return response()->json(['code' => Response::HTTP_NO_CONTENT, 'message' => 'No Content', 'data' => $result]);
    }

    public function notFoundResponse($message = '')
    {
        if($message == '') {
            $message = 'Response was not found';
        }

        return response()->json(['code' => Response::HTTP_NOT_FOUND, 'message' => $message], Response::HTTP_NOT_FOUND);
    }

    public function errorFieldResponse($type, $error)
    {
        if($type == 'unknown') {
            return response()->json(['code' => 400, 'unknown' => $error], 400);
        }

        if($type == 'invalid') {
            return response()->json(['code' => 400, 'invalid' => $error], 400);
        }

        if($type == 'invalid_filter') {
            return response()->json(['code' => 400, 'invalid_filter' => $error], 400);
        }
    }
}