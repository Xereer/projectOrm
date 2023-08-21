<?php

namespace Service;

use Entity\PropertiesEntity;
use Entity\UniversityEntity;
use Doctrine\ORM\EntityManager;
use Repository\PropertiesRepository;
use Repository\UniversityRepository;

class UniversityService
{

    private readonly UniversityRepository $universityRepository;

//    private readonly PropertiesRepository $propertiesRepository;

    public function __construct(
        private EntityManager $entityManager
    )
    {
        $universityRepository = $this->entityManager->getRepository(UniversityEntity::class);
        $this->universityRepository = $universityRepository;
    }

    public function getAllActiveUniversities($parentId)
    {
        $univ = $this->universityRepository->findActiveUniversities();
        $universities = $this->getElements($univ, $parentId);
        return $universities;
    }
    public function createElement($parentID,$childType,$childName)
    {
        $type = $this->universityRepository->findBy([
            'id' => $parentID,
            'isArchive' => 0
            ])[0]->getType();
        if (isset($parentID) && $type + 1 != $childType) {
            throw new Exception('ошибка заполнения');
        }
        //setter chain
        $university = new UniversityEntity();
        $university->setParentID($parentID)
            ->setType($childType)
            ->setName($childName);
        $this->entityManager->persist($university);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function update($newName, $id)
    {
        $university = $this->universityRepository->findBy([
            'id' => $id,
            'isArchive' => 0
        ])[0];
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
        } catch (Execution $e) {
            $this->entityManager->rollback();
        }

    }
    public function delete($parentId)
    {
        $child = $this->universityRepository->getIdByParentId($parentId);
        foreach ($child as $value) {
            $this -> delete($value['id']);
        }
        $this->universityRepository->deleteElement($parentId);
    }
    public function recover()
    {
        $this->universityRepository->recoverElements();
    }
    public function getElements($elem, $parentId)
    {
        $arr = array();
        foreach ($elem as $value) {
            if ($value->getParentId() == $parentId) {
                $child = $this->getElements($elem, $value->getId());

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
    public function getProperties($id)
    {
        $propertiesRepository = $this->entityManager->getRepository(PropertiesEntity::class);
        $this->propertiesRepository = $propertiesRepository;
        $properties = array();
        $propsValues = $this->propertiesRepository->findPropertiesByUniversityId($id);
        foreach ($propsValues as $value) {
            $properties[$value['alias']] = $value['value'];
        }
        return $properties;
    }
}
