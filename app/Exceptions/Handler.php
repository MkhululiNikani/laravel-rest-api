<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson()) {   //add Accept: application/json in request
            return $this->handleApiException($request, $exception);
        }

        //TODO: Add support for other data types... for now, give em json
        return $this->handleApiException($request, $exception);
    }

    // TO LOOK AT (copy and paste)
    private function handleApiException($request, Exception $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        $response = [];

        switch ($statusCode) {
            case 200:
                $response['type'] = 'OK';
                break;
            case 400:
                $response['type'] = 'Bad Request';
                break; 
            case 401:
                $response['type'] = 'Unauthorized';
                break;
            case 403:
                $response['type'] = 'Forbidden';
                break;
            case 404:
                $response['type'] = 'Not Found';
                break;
            default:
                $statusCode = 500;
                $response['type'] = 'Internal Server Error';
                break;
        }

        if (config('app.debug')) {
            $response['trace'] = $exception->getTrace();
            $response['code'] = $exception->getCode();
        }

        $type = $response['type'];
        $message =  $exception->getMessage();
        
        if($statusCode == 500 && !config('app.debug')){
            $message = 'Something went wrong on the server';
        }

        $jsonResponse = ['error' => ['status' => $statusCode,'type' =>  $type, 'message' => $message]];

        return response()->json($jsonResponse, $statusCode);
    }
}
