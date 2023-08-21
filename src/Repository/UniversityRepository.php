<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Entity\UniversityEntity;

class UniversityRepository extends EntityRepository
{
    public function findActiveUniversities()
    {
        return $this->createQueryBuilder('u')
            ->where('u.isArchive = 0')
            ->getQuery()
            ->getResult();
    }
    public function getIdAndType($id)
    {
        return $this->createQueryBuilder('u')
            ->select('u.id','u.typeID')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function addNewElement($parentID,$childType,$childName)
    {
        $university = new UniversityEntity();
        $university->setParentID($parentID);
        $university->setType($childType);
        $university->setName($childName);
        $university->setArchive(0);
    }
    public function getIdByParentId($parentId)
    {
        return $this->createQueryBuilder('u')
            ->select('u.id')
            ->where('u.parentID = :parentID')
            ->setParameter('parentID', $parentId)
            ->getQuery()
            ->getResult();
    }
    public function deleteElement ($id)
    {
        return $this->createQueryBuilder('u')
            ->update()
            ->set('u.isArchive', 1)
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function recoverElements ()
    {
        return $this->createQueryBuilder('u')
            ->update()
            ->set('u.isArchive', 0)
            ->getQuery()
            ->getResult();
    }
}
