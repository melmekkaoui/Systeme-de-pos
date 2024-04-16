<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaf78e7d261c6268b16162e86ea07292d
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\Models\\' => 11,
            'App\\Helpers\\' => 12,
            'App\\Controllers\\' => 16,
            'App\\Connections\\' => 16,
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/models',
        ),
        'App\\Helpers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/helpers',
        ),
        'App\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
        'App\\Connections\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/connections',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'App\\Connections\\Config' => __DIR__ . '/../..' . '/app/connections/Config.php',
        'App\\Connections\\SQLConnection' => __DIR__ . '/../..' . '/app/connections/SQLConnection.php',
        'App\\Controllers\\CarteController' => __DIR__ . '/../..' . '/app/controllers/CarteController.php',
        'App\\Controllers\\CategorieController' => __DIR__ . '/../..' . '/app/controllers/CategorieController.php',
        'App\\Controllers\\ClientController' => __DIR__ . '/../..' . '/app/controllers/ClientController.php',
        'App\\Controllers\\FornisseurController' => __DIR__ . '/../..' . '/app/controllers/FornisseurController.php',
        'App\\Controllers\\LoanController' => __DIR__ . '/../..' . '/app/controllers/LoanController.php',
        'App\\Controllers\\OrderController' => __DIR__ . '/../..' . '/app/controllers/OrderController.php',
        'App\\Controllers\\OrderItemController' => __DIR__ . '/../..' . '/app/controllers/OrderItemController.php',
        'App\\Controllers\\ProduitController' => __DIR__ . '/../..' . '/app/controllers/ProduitController.php',
        'App\\Controllers\\UniteController' => __DIR__ . '/../..' . '/app/controllers/UniteController.php',
        'App\\Helpers\\Alert' => __DIR__ . '/../..' . '/app/helpers/Alert.php',
        'App\\Helpers\\DateH' => __DIR__ . '/../..' . '/app/helpers/DateH.php',
        'App\\Helpers\\Hash' => __DIR__ . '/../..' . '/app/helpers/Hash.php',
        'App\\Helpers\\Validator' => __DIR__ . '/../..' . '/app/helpers/Validator.php',
        'App\\Models\\Carte' => __DIR__ . '/../..' . '/app/models/Carte.php',
        'App\\Models\\Categorie' => __DIR__ . '/../..' . '/app/models/Categorie.php',
        'App\\Models\\Client' => __DIR__ . '/../..' . '/app/models/Client.php',
        'App\\Models\\Fornisseur' => __DIR__ . '/../..' . '/app/models/Fornisseur.php',
        'App\\Models\\Loan' => __DIR__ . '/../..' . '/app/models/Loan.php',
        'App\\Models\\Model' => __DIR__ . '/../..' . '/app/models/Model.php',
        'App\\Models\\Order' => __DIR__ . '/../..' . '/app/models/Order.php',
        'App\\Models\\OrderItem' => __DIR__ . '/../..' . '/app/models/OrderItem.php',
        'App\\Models\\Produit' => __DIR__ . '/../..' . '/app/models/Produit.php',
        'App\\Models\\Unite' => __DIR__ . '/../..' . '/app/models/Unite.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaf78e7d261c6268b16162e86ea07292d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaf78e7d261c6268b16162e86ea07292d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaf78e7d261c6268b16162e86ea07292d::$classMap;

        }, null, ClassLoader::class);
    }
}
