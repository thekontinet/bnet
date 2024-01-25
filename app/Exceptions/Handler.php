<?php

namespace App\Exceptions;

use App\Enums\ErrorCode;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use MannikJ\Laravel\Wallet\Exceptions\UnacceptedTransactionException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Exception $e) {
            logger()->error($e->getMessage());

            if(ErrorCode::exist($e->getCode())) return redirect()->back()
                ->with('error', ErrorCode::getMessage($e->getCode()) ?? $e->getMessage());

            return null;
        });

        $this->renderable(function (UnacceptedTransactionException $e) {
            return redirect('/dashboard')->with('error', $e->getMessage());
        });
    }
}
