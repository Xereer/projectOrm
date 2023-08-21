<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Entity\Properties;
use Entity\TypesAllow;

class TypesAllowRepository extends EntityRepository
{
    public function deletePropFromTypesAllow ($type,$property)
    {
        return $this->createQueryBuilder('typesallow')
            ->update(TypesAllow::class, 'ta')
            ->set('ta.isArchive', 1)
            ->where('ta.id_prop = :id_prop')
            ->andWhere('ta.typeId = :typeId')
            ->setParameter('id_prop', $property)
            ->setParameter('typeId', $type)
            ->getQuery()
            ->getResult();
    }
    public function recoverPropFromTypesAllow ($type,$property)
    {
        return $this->createQueryBuilder('typesallow')
            ->update(TypesAllow::class, 'ta')
            ->set('ta.isArchive', 0)
            ->where('ta.id_prop = :id_prop')
            ->andWhere('ta.typeId = :typeId')
            ->setParameter('id_prop', $property)
            ->setParameter('typeId', $type)
            ->getQuery()
            ->getResult();
    }
    public function getExistingProps ($id)
    {
        return $this->createQueryBuilder('t')
            ->select('p.id', 'p.alias')
            ->innerJoin(Properties::class,'p','WITH','t.id_prop = p.id')
            ->where('t.typeId = :id')
            ->andWhere('t.isArchive = 0')
            ->andWhere('p.isArchive = 0')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
