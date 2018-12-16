<?php

namespace App\Traits;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

trait ExceptionLoggerTrait
{
    /** @var LoggerInterface */
    private $exceptionLogger;

    /**
     * @return LoggerInterface
     */
    public function getExceptionLogger()
    {
        return $this->exceptionLogger;
    }

    /**
     * @required
     *
     * @param LoggerInterface $exceptionLogger
     */
    public function setExceptionLogger(LoggerInterface $exceptionLogger)
    {
        $this->exceptionLogger = $exceptionLogger;
    }

    /**
     * Log a given exception.
     *
     * @param \Exception $ex
     */
    public function logException(\Exception $ex)
    {
        $message = sprintf('[%s] $%s on %s#%s ', $ex->getCode(), $ex->getMessage(), $ex->getFile(), $ex->getLine());
        if (($ex instanceof HttpExceptionInterface) || (500 <= $ex->getStatusCode())) {
            $this->getExceptionLogger()->critical($message, ['exception' => $ex]);

            return;
        }

        $this->getExceptionLogger()->error($message, ['exception' => $ex]);
    }
}
