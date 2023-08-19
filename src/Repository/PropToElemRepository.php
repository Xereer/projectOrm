<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Entity\Properties;
use Entity\PropToElem;

class PropToElemRepository extends EntityRepository

{
    public function deletePropById ($id)
    {
        return $this->createQueryBuilder('pt')
            ->update()
            ->set('pt.isArchive', 1)
            ->where('pt.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function updatePropById ($id,$value)
    {
        return $this->createQueryBuilder('pt')
            ->update()
            ->set('pt.value', ':value')
            ->where('pt.id = :id')
            ->setParameter('value', $value)
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function deletePropFromPropToElem($type)
    {
        return $this->createQueryBuilder('proptoelem')
            ->update(PropToElem::class, 'pte')
            ->set('pte.isArchive', 1)
            ->where('pte.typeId = :typeId')
            ->setParameter('typeId', $type)
            ->getQuery()
            ->getResult();
    }
    public function recoverPropFromPropToElem($type)
    {
        return $this->createQueryBuilder('proptoelem')
            ->update(PropToElem::class, 'pte')
            ->set('pte.isArchive', 0)
            ->where('pte.typeId = :typeId')
            ->setParameter('typeId', $type)
            ->getQuery()
            ->getResult();
    }
    public function getPropertiesById ($id)
    {
        return $this->createQueryBuilder('pt')
            ->select('pt.value','p.alias','pt.id')
            ->leftJoin(Properties::class, 'p','WITH','pt.propId = p.id')
            ->where('pt.id_univ = :id')
            ->andWhere('pt.isArchive = 0')
            ->andWhere('p.isArchive = 0')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}