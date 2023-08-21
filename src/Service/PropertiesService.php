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


class PropertiesService
{
    private readonly PropertiesRepository $propertiesRepository;

    private readonly PropToElemRepository $propToElemRepository;

    private readonly  TypesAllowRepository $typesAllowRepository;

    public function __construct(
        private readonly EntityManager $entityManager
    )
    {
        /** @var PropertiesRepository $propertiesRepository */
        $propertiesRepository = $this->entityManager->getRepository(PropertiesEntity::class);
        $this->propertiesRepository = $propertiesRepository;
        /** @var PropToElemRepository $propToElemRepository */
        $propToElemRepository = $this->entityManager->getRepository(PropToElemEntity::class);
        $this->propToElemRepository = $propToElemRepository;
        /** @var TypesAllowRepository $typesAllowRepository */
        $typesAllowRepository = $this->entityManager->getRepository(TypesAllowEntity::class);
        $this->typesAllowRepository = $typesAllowRepository;
    }
    public function createNewPropToList($alias, $name)
    {
        $existingEntity = $this->entityManager->getRepository(PropertiesEntity::class)->findOneBy(['alias' => $alias]);

        if (!$existingEntity) {
            $this->entityManager->beginTransaction();
            $newEntity = (new PropertiesEntity())
                ->setAlias($alias)
                ->setName($name);

            $this->entityManager->persist($newEntity);
            $this->entityManager->flush();
            $this->entityManager->commit();
        }
    }
    public function deleteProps($id)
    {
        $property = $this->propToElemRepository->findOneBy([
            'id' => $id,
            'isArchive' => 0
        ]);
        $this->entityManager->beginTransaction();
        $property->setArchive(1);
        $this->entityManager->persist($property);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function deletePropertyFromList($id)
    {
        $property = $this->propertiesRepository->findOneBy([
            'id' => $id,
            'isArchive' => 0
        ]);
        $this->entityManager->beginTransaction();
        $property->setArchive(1);
        $this->entityManager->persist($property);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function recoverPropertyToList($id)
    {
        $property = $this->propertiesRepository->findOneBy([
            'id' => $id,
            'isArchive' => 1
        ]);
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
    public function updatePropToElemValue($id, $value)
    {
        $property = $this->propToElemRepository->findOneBy([
            'id' => $id,
            'isArchive' => 0
        ]);
        $this->entityManager->beginTransaction();
        $property->setValue($value);
        $this->entityManager->persist($property);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function deletePropertyToType($type, $property)
    {
        $this->typesAllowRepository->deletePropFromTypesAllow($type,$property);
        $this->propToElemRepository->deletePropFromPropToElem($type);
    }
    public function recoverPropertyToType($type, $property)
    {
        $this->typesAllowRepository->recoverPropFromTypesAllow($type,$property);
        $this->propToElemRepository->recoverPropFromPropToElem($type);
    }
    public function findExistingProps($id): array
    {
        return $this->typesAllowRepository->getExistingProps($id);
    }
    public function getAllowProps($id): array
    {
        return $this->propertiesRepository->getAllowPropsByElemId ($id);
    }
    public function propertiesToElement($id): array
    {
        return $this->propToElemRepository->getPropertiesById($id);
    }
    public function findMissingProps($id): array
    {
        return $this->propertiesRepository->getMissingProps($id);
    }
    public function addPropToType ($id_prop,$typeId)
    {
        $this->entityManager->beginTransaction();
        $prop = new TypesAllowEntity();
        $prop->setIdProp($id_prop)->setTypeID($typeId);
        $this->entityManager->persist($prop);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function createProps($id_univ, $propId, $value)
    {
        $typeId  = $this->entityManager->getRepository(UniversityEntity::class)->findOneBy([
        'id' => $id_univ,
        'isArchive' => 0
        ])->getType();
        $this->entityManager->beginTransaction();
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
