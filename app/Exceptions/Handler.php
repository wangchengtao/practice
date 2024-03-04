<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        CustomException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable               $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof CustomException) {
            return $this->response(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->response(['code' => NOT_EXISTS, 'message' => '404T_T']);
        }

        if ($e instanceof AuthenticationException) {
            return $this->response(['code' => EXPIRED, 'message' => '未登录']);
        }

        if ($e instanceof AuthorizationException) {
            return $this->response(['code' => NOT_ALLOWED, 'message' => '无权访问']);
        }

        return parent::render($request, $e);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return $this->response(['code' => PARAM_ERROR, 'message' => $exception->validator->errors()->first()]);
    }

    public function response($params)
    {
        return response()->json($params)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
