<?php

namespace Scytale\DatabaseConfigurationBundle\Tests\DependencyInjection;

use Scytale\DatabaseConfigurationBundle\Tests\BaseTestCase;

/**
 * This class test the parameter handling
 */
class ParameterServiceTest extends BaseTestCase
{
    /**
     * @var ParameterService
     */
    private $parameterService;

    public function setup()
    {
        parent::setup();
        $this->parameterService = $this->container->get('scy_db_parameters');

    }

    public function testParameterFlow()
    {
        $result = $this->parameterService->set('param_name', 'param_value');
        $this->assertTrue($result);

        $result = $this->parameterService->get('param_name');
        $this->assertEquals($result, 'param_value');

        // Tries to set a blank name
        $result = $this->parameterService->set('', 'param_value');
        $this->assertFalse($result);

        // The value should not have changed
        $result = $this->parameterService->get('param_name');
        $this->assertEquals($result, 'param_value');

        // Tries to set a blank value
        $result = $this->parameterService->set('param_name', '');
        $this->assertFalse($result);

        // The value should not have changed
        $value = $this->parameterService->get('param_name');
        $this->assertEquals($value, 'param_value');

        $result = $this->parameterService->delete('param_name');
        $this->assertTrue($result);

        $result = $this->parameterService->delete('non_existing');
        $this->assertFalse($result);

        $result = $this->parameterService->get('param_name');
        $this->assertNull($result);
    }


}
