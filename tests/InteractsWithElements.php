<?php

namespace Iinasg\FortuneAdInserter\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Testing\Assert as PHPUnit;
use Illuminate\Testing\TestView;
use Symfony\Component\DomCrawler\Crawler;

trait InteractsWithElements
{
    use InteractsWithViews;

    protected function addMacros(): void
    {
        TestView::macro('assertElementText', function ($selector, $expected) {
            PHPUnit::assertSame($expected, (new Crawler($this->rendered))->filter($selector)->text());
        });
        TestView::macro('assertElementCount', function ($selector, $number) {
            PHPUnit::assertSame($number, (new Crawler($this->rendered))->filter($selector)->count());
        });
        TestView::macro('assertHasElement', function ($selector) {
            PHPUnit::assertTrue((new Crawler($this->rendered))->filter($selector)->count() >= 1);
        });
        TestView::macro('assertNotHasElement', function ($selector) {
            PHPUnit::assertFalse((new Crawler($this->rendered))->filter($selector)->count() >= 1);
        });
    }
}
