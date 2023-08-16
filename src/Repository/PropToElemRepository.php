<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;

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
}