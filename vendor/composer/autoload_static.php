<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitec23a36ee169c48276ffa7c9bacfbbe2
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Loan_Calculator\\' => 16,
        ),
        'C' => 
        array (
            'Carbon_Fields\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Loan_Calculator\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
        'Carbon_Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-fields/core',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitec23a36ee169c48276ffa7c9bacfbbe2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitec23a36ee169c48276ffa7c9bacfbbe2::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
