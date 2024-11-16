<?php

namespace Iinasg\FortuneAdInserter\Facades ;

use Illuminate\Support\Facades\Facade;
use Iinasg\FortuneAdInserter\FortuneAdInserter;

/**
 * @see \Iinasg\FortuneAdInserter\FortuneAdInserter
 */
class FortuneAdInserterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FortuneAdInserter::class;
    }
}
