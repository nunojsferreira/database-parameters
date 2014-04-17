<?php

namespace Scytale\DatabaseConfigurationBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Parameter Manager Class
 */
class ParameterManager
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var Symfony\Component\Validator\Validator
     */
    protected $validator;

    /**
     * Constructor
     *
     * @param ObjectManager                         $objectManager
     * @param string                                $class
     * @param Symfony\Component\Validator\Validator $validator
     */
    public function __construct(ObjectManager $objectManager, $class, $validator)
    {
        $this->objectManager = $objectManager;
        $this->class = $class;
        $this->validator = $validator;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * Create
     *
     * @return Object
     */
    public function create()
    {
        $object = new $this->class();

        return $object;
    }

    /**
     * Save
     *
     * @param Object $object
     *
     * @return false|Object
     */
    public function save($object)
    {
        $errors = $this->validator->validate($object);

        if (count($errors) > 0) {

            return false;
        }

        if (!$object->getId()) {
            $this->objectManager->persist($object);
        }

        $this->objectManager->flush($object);

        return $object;
    }

    /**
     * Get repository
     *
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->objectManager->getRepository($this->class);
    }

    /**
     * Delete
     *
     * @param Object $object object
     */
    public function delete($object)
    {
        $this->objectManager->remove($object);
        $this->objectManager->flush();
    }
}
