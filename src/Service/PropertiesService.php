<?php

namespace Service;

use Entity\Properties;
use Entity\PropToElem;
use Entity\University;
use Doctrine\ORM\EntityManager;


class PropertiesService
{
    public function __construct(
        private EntityManager $entityManager
    )
    {
        $propertiesRepository = $this->entityManager->getRepository(Properties::class);
        $this->propertiesRepository = $propertiesRepository;
        $propToElemRepository = $this->entityManager->getRepository(PropToElem::class);
        $this->propToElemRepository = $propToElemRepository;
    }
    public function createNewPropToList ($alias, $name) {
        $this->propertiesRepository->addNewPropToList($alias, $name);
        $this->entityManager->flush();
    }
    public function deleteProps ($id)
    {
        $this->propToElemRepository->deletePropById($id);
    }
    public function deletePropertyFromList ($id)
    {
        $this->propertiesRepository->deletePropsFromList($id);
    }
    public function recoverPropertyToList ($id)
    {
        $this->propertiesRepository->recoverPropsToList($id);
    }

    public function getAllProperties ()
    {
        return $this->propertiesRepository->getAllProps();
    }
    public function updatePropToElemValue($id,$value)
    {
        return $this->propToElemRepository->updatePropById($id, $value);
    }
}