<?php

namespace Service;

use Doctrine\DBAL\Exception;
use Entity\PropertiesEntity;
use Entity\UniversityEntity;
use Doctrine\ORM\EntityManager;
use Repository\PropertiesRepository;
use Repository\UniversityRepository;

class UniversityService
{

    private readonly UniversityRepository $universityRepository;

    public function __construct(
        private readonly EntityManager $entityManager
    )
    {
        /** @var UniversityRepository $universityRepository */
        $universityRepository = $this->entityManager->getRepository(UniversityEntity::class);
        $this->universityRepository = $universityRepository;
    }

    public function getAllActiveUniversities($parentId): array
    {
        $univ = $this->universityRepository->findBy(['isArchive' => 0]);
        return $this->mapElements($univ, $parentId);
    }
    public function createElement($parentID, $childType, $childName)
    {
        if (empty($parentID)) {
            $parentID = 0;
        }
        if (empty($childName)) {
            throw new Exception('ошибка заполнения');
        }
        $type = $this->universityRepository->findOneBy([
            'id' => $parentID,
            'isArchive' => 0
            ])->getType();

        if ($type + 1 != $childType){
            throw new Exception('ошибка заполнения');
        }
        $this->entityManager->beginTransaction();
        $university = (new UniversityEntity())
            ->setParentID($parentID)
            ->setType($childType)
            ->setName($childName);
        $this->entityManager->persist($university);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function update($newName, $id)
    {
        $university = $this->universityRepository->findOneBy([
            'id' => $id,
            'isArchive' => 0
        ]);
        $this->entityManager->beginTransaction();
        $university->setName($newName);
        $this->entityManager->persist($university);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function deleteElem($deleteId)
    {
        try {
            $this->entityManager->beginTransaction();
            $this->delete($deleteId);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
        }

    }
    public function delete($parentId)
    {
        $child = $this->universityRepository->getIdByParentId($parentId);
        foreach ($child as $value) {
            $this->delete($value['id']);
        }
        $this->universityRepository->deleteElement($parentId);
    }
    public function recover()
    {
        $this->universityRepository->recoverElements();
    }
    public function mapElements($elem, $parentId): array
    {
        $arr = array();
        foreach ($elem as $value) {
            if ($value->getParentId() == $parentId) {
                $child = $this->mapElements($elem, $value->getId());

                if (!empty($child)) {
                    $value->child = $child;
                }
                $arr[] = array(
                    'id' => $value->getId(),
                    'name' => $value->getName(),
                    ...$this->getProperties($value->getId()),
                    'child' => $child
                );
            }
        }
        return $arr;
    }
    public function getProperties($id): array
    {
        /** @var PropertiesRepository $propertiesRepository */
        $propertiesRepository = $this->entityManager->getRepository(PropertiesEntity::class);
        $properties = array();
        $propsValues = $propertiesRepository->findPropertiesByUniversityId($id);
        foreach ($propsValues as $value) {
            $properties[$value['alias']] = $value['value'];
        }
        return $properties;
    }
}
