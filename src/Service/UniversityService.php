<?php

namespace Service;

use Entity\Properties;
use Entity\University;
use Doctrine\ORM\EntityManager;

class UniversityService
{
    public function __construct(
        private EntityManager $entityManager
    )
    {
        $universityRepository = $this->entityManager->getRepository(University::class);
        $this->universityRepository = $universityRepository;
        $propertiesRepository = $this->entityManager->getRepository(Properties::class);
        $this->propertiesRepository = $propertiesRepository;
    }

    public function getAllActiveUniversities()
    {
        $univ = $this->universityRepository->findActiveUniversities();
        $universities = $this->read($univ, 0);
        return $universities;
    }
    public function createElement($parentID,$childType,$childName)
    {
        $type = $this->universityRepository->getIdAndType($parentID)[0];
        if (isset($parentID) && $type['typeID'] + 1 != $childType) {
            throw new Exception('ошибка заполнения');
        }
        $university = new University();
        $university->setParentID($parentID);
        $university->setType($childType);
        $university->setName($childName);
        $university->setArchive(0);
        $this->entityManager->persist($university);
        $this->entityManager->flush();
    }
    public function update ($newName, $id)
    {
        $this->universityRepository->updateElement($newName, $id);
    }
    public function deleteElem ($deleteId)
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
    public function delete ($parentId)
    {
        $child = $this->universityRepository->getIdByParentId($parentId);
        foreach ($child as $value) {
            $this -> delete($value['id']);
        }
        $this->universityRepository->deleteElement($parentId);
    }
    public function recover ()
    {
        $this->universityRepository->recoverElements();
    }
    public function read ($elem, $parentId)
    {
        $arr = array();
        foreach ($elem as $value) {
            if ($value->getParentId() == $parentId) {
                $child = $this->read($elem, $value->getId());

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
        $properties = array();
        $propsValues = $this->propertiesRepository->findPropertiesByUniversityId($id);
        foreach ($propsValues as $value) {
            $properties[$value['alias']] = $value['value'];
        }
        return $properties;
    }
}