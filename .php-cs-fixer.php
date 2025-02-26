<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setRules([
        '@PSR12' => true, // Segue o PSR-12
        'array_syntax' => ['syntax' => 'short'], // Usa colchetes em arrays []
        'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'cast_spaces' => ['space' => 'single'],
        'class_attributes_separation' => [
            'elements' => ['method' => 'one']
        ],
        'concat_space' => ['spacing' => 'one'], // Espaço ao concatenar strings
        'no_unused_imports' => true, // Remove imports não utilizados
        'ordered_imports' => ['sort_algorithm' => 'alpha'], // Ordena imports alfabeticamente
        'phpdoc_align' => true, // Alinha PHPDocs corretamente
    ])
    ->setFinder($finder);
