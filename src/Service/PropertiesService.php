<?php

namespace Service;

use Doctrine\Tests\ORM\Functional\Type;
use Entity\Properties;
use Entity\PropToElem;
use Entity\TypesAllow;
use Entity\UniversityEntity;
use Doctrine\ORM\EntityManager;
use Repository\PropertiesRepository;
use Repository\PropToElemRepository;
use Repository\TypesAllowRepository;
use Repository\UniversityRepository;


class PropertiesService
{

    private readonly PropertiesRepository $propertiesRepository;

    private readonly PropToElemRepository $propToElemRepository;

    private readonly  TypesAllowRepository $typesAllowRepository;

    private readonly UniversityRepository $university;

    public function __construct(
        private EntityManager $entityManager
    )
    {
        $propertiesRepository = $this->entityManager->getRepository(Properties::class);
        $this->propertiesRepository = $propertiesRepository;
        $propToElemRepository = $this->entityManager->getRepository(PropToElem::class);
        $this->propToElemRepository = $propToElemRepository;
        $typesAllowRepository = $this->entityManager->getRepository(TypesAllow::class);
        $this->typesAllowRepository = $typesAllowRepository;
        $university = $this->entityManager->getRepository(UniversityEntity::class);
        $this->university = $university;
    }
    public function createNewPropToList($alias, $name) {
        $existingEntity = $this->entityManager->getRepository(Properties::class)->findOneBy(['alias' => $alias]);

        if (!$existingEntity) {
            $newEntity = new Properties();
            $newEntity->setAlias($alias);
            $newEntity->setName($name);

            $this->entityManager->persist($newEntity);
            $this->entityManager->flush();
            $this->entityManager->commit();
        }
    }
    public function deleteProps($id)
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
        $this->propToElemRepository->updatePropById($id, $value);
    }
    public function deletePropertyToType($type,$property)
    {
        $this->typesAllowRepository->deletePropFromTypesAllow($type,$property);
        $this->propToElemRepository->deletePropFromPropToElem($type);
    }
    public function recoverPropertyToType($type,$property)
    {
        $this->typesAllowRepository->recoverPropFromTypesAllow($type,$property);
        $this->propToElemRepository->recoverPropFromPropToElem($type);
    }
    public function findExistingProps($id)
    {
        return $this->typesAllowRepository->getExistingProps($id);
    }
    public function getAllowProps ($id)
    {
        return $this->propertiesRepository->getAllowPropsByElemId ($id);
    }
    public function properties ($id)
    {
        return $this->propToElemRepository->getPropertiesById($id);
    }
    public function findMissingProps ($id)
    {
        return $this->propertiesRepository->getMissingProps($id);
    }
    public function addPropToType ($id_prop,$typeId)
    {
        $prop = new TypesAllow();
        $prop->setIdProp($id_prop);
        $prop->setTypeID($typeId);
        $prop->setIsArchive(0);
        $this->entityManager->persist($prop);
        $this->entityManager->flush();
    }
    public function createProps($id_univ,$propId,$value)
    {
        $typeId = $this->university->getIdAndType($id_univ)[0]['typeID'];
        $propToElem = new PropToElem();
        $propToElem->setPropId($propId);
        $propToElem->setIdUniv($id_univ);
        $propToElem->setValue($value);
        $propToElem->setType($typeId);
        $propToElem->setArchive(0);
        $this->entityManager->persist($propToElem);
        $this->entityManager->flush();
    }
}
