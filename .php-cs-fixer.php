<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude([
        'node_modules',
        'vendor',
        'public',
        'storage',
        'tests',
        '.git',
        '.idea',
        '.vscode',
    ])
    ->name('*.php');

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => ['=>' => null],
        ],
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => ['return'],
        ],
        'single_space_around_construct' => true,
        'control_structure_braces' => true,
        'curly_braces_position' => true,
        'control_structure_continuation_position' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'phpdoc_align' => true,
        'phpdoc_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_summary' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => true,
        'no_trailing_whitespace' => true,
        'no_whitespace_in_blank_line' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder);
