<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
;

return Retailcrm\PhpCsFixer\Defaults::rules([
    'declare_strict_types' => true,
])
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/.php_cs.cache/results')
    ;
