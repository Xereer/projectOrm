<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Entity\Properties;

class PropertiesRepository extends EntityRepository
{
    public function findPropertiesByUniversityId($id)
    {
        return $this->createQueryBuilder('properties')
            ->select('proptoelem.value', 'properties.alias', 'proptoelem.id')
            ->from('Proptoelem', 'proptoelem')
            ->leftJoin('proptoelem.properties', 'properties')
            ->where('proptoelem.idUniv = :id')
            ->andWhere('proptoelem.isArchive = 0')
            ->andWhere('properties.isArchive = 0')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function addNewPropToList($alias, $name)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder
            ->select('1')
            ->from(Properties::class, 'p')
            ->where('p.alias = :alias')
            ->setParameter('alias', $alias);

        $subQueryBuilder = $this->createQueryBuilder();
        $subQueryBuilder
            ->select('1')
            ->from(Properties::class, 'p')
            ->where('p.alias = :alias');

        $queryBuilder
            ->insert(Properties::class, 'p')
            ->setValue('p.alias', ':alias')
            ->setValue('p.name', ':name')
            ->setParameter('alias', $alias)
            ->setParameter('name', $name)
            ->andWhere($queryBuilder->expr()->not($queryBuilder->expr()->exists($subQueryBuilder->getDQL())));

        $query = $queryBuilder->getQuery();
        $query->execute();
        return $query;
    }

    public function deletePropsFromList($id)
    {
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.isArchive', 1)
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function recoverPropsToList($id)
    {
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.isArchive', 0)
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function getAllProps()
    {
        return $this->createQueryBuilder('p')
            ->select('p.id','p.alias', 'p.isArchive')
            ->getQuery()
            ->getResult();
    }
}