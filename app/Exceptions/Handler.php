<?php

namespace App\Exceptions;

use App\Services\JsonResponseService;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use ReflectionClass;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
     * @var JsonResponseService
     */
    protected $jsonResponseService;

    /**
     * Handler constructor.
     * @param Container $container
     * @param JsonResponseService $jsonResponseService
     */
    public function __construct(Container $container, JsonResponseService $jsonResponseService)
    {
        $this->jsonResponseService = $jsonResponseService;
    }


    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $exception
     * @return Response|JsonResponse
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->jsonResponseService->fail([
                'errors' => ['failed' => 'Method not allowed'],
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->jsonResponseService->fail([
                'errors' => ['failed' => 'Unauthorized'],
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->jsonResponseService->fail([
                'errors' => ['failed' => 'Not found'],
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->jsonResponseService->fail([
                'errors' => ['failed' => 'Not found'],
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof UnauthorizedException) {
            return $this->jsonResponseService->fail([
                'errors' => ['failed' => 'Forbidden'],
            ], Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof HttpResponseException || $exception instanceof ValidationException) {
            return parent::render($request, $exception);
        }

        return $this->jsonResponseService->fail([
            'message' => [
                'failed' => json_decode($exception->getMessage()) ?? $exception->getMessage(),
            ],
            'exception' => (new ReflectionClass($exception))->getShortName(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
