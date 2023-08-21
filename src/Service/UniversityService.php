<?php

namespace Service;

use Entity\Properties;
use Entity\UniversityEntity;
use Doctrine\ORM\EntityManager;
use Repository\PropertiesRepository;
use Repository\UniversityRepository;

class UniversityService
{

    private readonly UniversityRepository $universityRepository;

    private readonly PropertiesRepository $propertiesRepository;

    public function __construct(
        private EntityManager $entityManager
    )
    {
        $universityRepository = $this->entityManager->getRepository(UniversityEntity::class);
        $this->universityRepository = $universityRepository;
        $propertiesRepository = $this->entityManager->getRepository(Properties::class);
        $this->propertiesRepository = $propertiesRepository;
    }

    public function getAllActiveUniversities($parentId)
    {
        $univ = $this->universityRepository->findActiveUniversities();
        $universities = $this->read($univ, $parentId);
        return $universities;
    }
    public function createElement($parentID,$childType,$childName)
    {
        //проверка на архивность
        //на обычный find
        $type = $this->universityRepository->getIdAndType($parentID)[0];
        if (isset($parentID) && $type['typeID'] + 1 != $childType) {
            throw new Exception('ошибка заполнения');
        }
        //setter chain
        $university = new UniversityEntity();
        $university->setParentID($parentID);
        $university->setType($childType);
        $university->setName($childName)
            ->setArchive(0);
        $this->entityManager->persist($university);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
    public function update($newName, $id)
    {
        $university = $this->universityRepository->findBy([
            'id' => $id,
            'isArchive' => 0
        ]);
        $this->entityManager->beginTransaction();
        $university->setName($newName);
        $this->entityManager->pesrsit();
        $this->entityManager->flush();
        $this->entityManager->commit();
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
    public function read($elem, $parentId)
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
