<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath('vendor')
    ->notPath('node_modules')
    ->notPath('bootstrap/cache')
    ->notPath('resources/nuxt')
    ->notPath('public')
    ->notPath('storage')
    ->notPath('.vagrant')
    ->notName('_ide_helper.php')
    ->notName('_ide_helper_models.php')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

return PhpCsFixer\Config::create()
    ->registerCustomFixers(new PedroTroller\CS\Fixer\Fixers())
    ->setRules([
        '@Symfony'               => true,
        'cast_spaces'            => [
            'space' => 'none',
        ],
        'binary_operator_spaces' => [
            'default'   => 'single_space',
            'operators' => ['=>' => 'align_single_space'],
        ],
        'ordered_imports' => [
            'imports_order'  => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],
        'array_syntax'                => ['syntax' => 'short'],
        'array_indentation'           => true,
        'linebreak_after_opening_tag' => true,
        'phpdoc_order'                => true,
        // Custom fixer config
        'PedroTroller/ordered_with_getter_and_setter_first' => true,
        'PedroTroller/line_break_between_statements'        => true,
        'PedroTroller/comment_line_to_phpdoc_block'         => true,
        'PedroTroller/forbidden_functions'                  => ['comment' => '@TODO: remove'],
        'PedroTroller/line_break_between_method_arguments'  => [
            'max-args'                 => 4,
            'max-length'               => 120,
            'automatic-argument-merge' => true,
        ],
    ])
    ->setFinder($finder)
;
