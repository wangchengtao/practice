<?php

namespace App\Http\Controllers;

use App\Data\APIResultData;
use App\Data\PaginationResultData;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function paginate(mixed $list, int $count = 0, int $page = 1, int $size = 15): JsonResponse
    {
        if ($list instanceof ResourceCollection) {
            $count = $list->count();
            $page = $list->resource->currentPage();
            $size = $list->resource->perPage();
        }

        return $this->success(new PaginationResultData($page, $size, $count, $list));
    }

    protected function success(mixed $data = null, $message = '请求成功'): JsonResponse
    {
        $data = new APIResultData(SUCCESS, $message, $data);

        return response()->json($data)->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // return response()->json([
        //     'code' => SUCCESS,
        //     'message' => $message,
        //     'data' => $data,
        // ])->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function error($message = '请求失败', $code = FAILED, $data = [])
    {
        $result = compact('message', 'code', 'data');

        return response()->json($result)->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
