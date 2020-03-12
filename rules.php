<?php

// Available placeholders: :uc:vendor, :uc:package, :lc:vendor, :lc:package
return [
   
    'config/mypackage.php' => 'config/:lc:package.php',
    'src/Facades/MyPackage.php' => 'src/Facades/:uc:package.php',
    'src/MyPackageServiceProvider.php' => 'src/:uc:packageServiceProvider.php',
    'src/Controllers/MyPackageController.php' => 'src/:uc:packageController.php',
];