<?php

namespace Scytale\DatabaseConfigurationBundle\DependencyInjection;

/**
 * This class provides the methods to manipulate parameters
 */
class ParameterService
{
    /**
     * @var Scytale\DatabaseConfigurationBundle\Manager\ParameterManager
     */
    private $manager;

    /**
     * @var ParameterRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * Constructor
     *
     * @param Scytale\DatabaseConfigurationBundle\Manager\ParameterManager
     */
    public function __construct($manager)
    {
        $this->manager = $manager;
        $this->repository = $manager->getRepository();
        $this->objectManager = $manager->getObjectManager();
    }

    /**
     * Fetches the value of a parameter from database identified by $parameter
     *
     * @param string $parameter
     *
     * @return null|string
     */
    public function get($parameter)
    {
        $parameter = $this->repository->findOneBy(array(
            'name' => $parameter,
        ));

        if (!$parameter) {

            return null;
        }

        $this->objectManager->refresh($parameter);

        return $parameter->getValue();
    }

    /**
     * Sets the $value of the $parameter.
     *
     * @param string $parameter
     * @param string $value
     *
     * @return boolean TRUE on success, FALSE otherwise
     */
    public function set($parameter, $value)
    {
        $parameterObj = $this->repository->findOneBy(array(
            'name' => $parameter
        ));

        if (!$parameterObj) {
            $parameterObj = $this->manager->create();
        }

        $parameterObj->setName($parameter);
        $parameterObj->setValue($value);

        $parameterObj = $this->manager->save($parameterObj);

        if ($parameterObj !== false) {

            return true;
        }

        return false;
    }

    /**
     * Deletes the $parameter
     *
     * @param string $parameter
     *
     * @return boolean TRUE on success, FALSE otherwise
     */
    public function delete($parameter)
    {
        $parameterObj = $this->repository->findOneBy(array(
            'name' => $parameter
        ));

        if (!$parameterObj) {

            return false;
        }

        $this->manager->delete($parameterObj);

        return true;
    }
}