ScytaleDatabaseParametersBundle
===============================

This Symfony bundle allows to store parameters in database. This is particularly usefull if you want to enable parameter management (e.g. web admin email address, VAT taxes, ...)

Instalation
-----------

You can install this bundle using composer

`````
composer "scytale/database-parameters": "1.0.*"
````

Add to AppKernel

``````
new Scytale\DatabaseConfigurationBundle\ScytaleDatabaseConfigurationBundle(),
``````

Don't forget to update schema.
And you are done!

Usage
-----

This bundles creates a service `scy_parameters`

1. Set a parameter

  ``````
  $container->get('scy_parameters')->set('parameter_key', 'parameter_value');
  ``````
  
2. Fetch a parameter
  
  ``````
  $parameterValue = $container->get('scy_parameters')->get('parameter_key');
  ``````

3. Delete a parameter

  ``````
  $container->get('scy_parameters')->delete('parameter_key');
  ``````

License
-------

This bundle is released under the MIT license.





