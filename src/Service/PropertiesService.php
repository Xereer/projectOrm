<?php

namespace Service;

use Entity\PropertiesEntity;
use Entity\PropToElemEntity;
use Entity\TypesAllowEntity;
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
        $propertiesRepository = $this->entityManager->getRepository(PropertiesEntity::class);
        $this->propertiesRepository = $propertiesRepository;
        $propToElemRepository = $this->entityManager->getRepository(PropToElemEntity::class);
        $this->propToElemRepository = $propToElemRepository;
        $typesAllowRepository = $this->entityManager->getRepository(TypesAllowEntity::class);
        $this->typesAllowRepository = $typesAllowRepository;
    }
    public function createNewPropToList($alias, $name)
    {
        $existingEntity = $this->entityManager->getRepository(PropertiesEntity::class)->findOneBy(['alias' => $alias]);

        if (!$existingEntity) {
            $newEntity = new PropertiesEntity();
            $newEntity->setAlias($alias)->setName($name);

            $this->entityManager->persist($newEntity);
            $this->entityManager->flush();
            $this->entityManager->commit();
        }
    }
    public function deleteProps($id)
    {
        $property = $this->propToElemRepository->findBy([
            'id' => $id,
            'isArchive' => 0
        ])[0];
        $this->entityManager->beginTransaction();
        $property->setArchive(1);
        $this->entityManager->persist($property);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function deletePropertyFromList($id)
    {
        $property = $this->propertiesRepository->findBy([
            'id' => $id,
            'isArchive' => 0
        ])[0];
        $this->entityManager->beginTransaction();
        $property->setArchive(1);
        $this->entityManager->persist($property);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function recoverPropertyToList($id)
    {
        $property = $this->propertiesRepository->findBy([
            'id' => $id,
            'isArchive' => 1
        ])[0];
        $this->entityManager->beginTransaction();
        $property->setArchive(0);
        $this->entityManager->persist($property);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }

    public function getAllProperties()
    {
        $properties = $this->propertiesRepository->findAll();
        return $properties;
    }
    public function updatePropToElemValue($id,$value)
    {
        $property = $this->propToElemRepository->findBy([
            'id' => $id,
            'isArchive' => 0
        ])[0];
        $this->entityManager->beginTransaction();
        $property->setValue($value);
        $this->entityManager->persist($property);
        $this->entityManager->flush();
        $this->entityManager->commit();
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
    public function getAllowProps($id)
    {
        return $this->propertiesRepository->getAllowPropsByElemId ($id);
    }
    public function properties($id)
    {
        return $this->propToElemRepository->getPropertiesById($id);
    }
    public function findMissingProps($id)
    {
        return $this->propertiesRepository->getMissingProps($id);
    }
    public function addPropToType ($id_prop,$typeId)
    {
        $prop = new TypesAllowEntity();
        $prop->setIdProp($id_prop)->setTypeID($typeId);
        $this->entityManager->persist($prop);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function createProps($id_univ,$propId,$value)
    {
        $university = $this->entityManager->getRepository(UniversityEntity::class);
        $this->university = $university;
        $typeId = $this->university->findBy([
            'id' => $id_univ,
            'isArchive' => 0
        ])[0]->getType();

        $propToElem = new PropToElemEntity();
        $propToElem->setPropId($propId)
            ->setIdUniv($id_univ)
            ->setValue($value)
            ->setType($typeId);
        $this->entityManager->persist($propToElem);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
}
