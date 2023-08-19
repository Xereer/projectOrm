<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Entity\Properties;
use Entity\PropToElem;
use Entity\TypesAllow;
use Entity\University;

class PropertiesRepository extends EntityRepository
{
    public function findPropertiesByUniversityId($id)
    {
        return $this->createQueryBuilder('p')
            ->select('pt.value', 'p.alias', 'pt.id')
            ->leftJoin(PropToElem::class, 'pt','WITH', 'pt.propId = p.id')
            ->where('pt.propId = p.id')
            ->andWhere('pt.id_univ = :id')
            ->andWhere('pt.isArchive = 0')
            ->andWhere('p.isArchive = 0')
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

        $subQueryBuilder = $this->createQueryBuilder('p');
        $subQueryBuilder
            ->select('1')
            ->from(Properties::class, 'p')
            ->where('p.alias = :alias');

        $queryBuilder
            ->add('')
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

    public function getAllowPropsByElemId ($id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p.alias', 'p.id')
            ->leftJoin(TypesAllow::class, 't', 'WITH', 'p.id = t.id_prop')
            ->leftJoin(University::class, 'u', 'WITH', 't.typeId = u.typeID')
            ->leftJoin(PropToElem::class, 'pt', 'WITH', 'pt.propId = p.id AND pt.id_univ = u.id')
            ->where('p.isArchive = 0')
            ->andWhere('t.isArchive = 0')
            ->andWhere('u.isArchive = 0')
            ->andWhere('u.id = :id')
            ->andWhere($qb->expr()->orX(
                'pt.propId IS NULL',
                'pt.isArchive = 1'
            ))
            ->setParameter('id', $id);
        return $qb->getQuery()->getResult();
    }
    public function getMissingProps($id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p.id', 'p.alias');

        $sub = $this->createQueryBuilder('sub') // Указываем псевдоним для подзапроса
        ->select('t.id')
            ->from(TypesAllow::class, 't')
            ->where('t.id_prop = p.id')
            ->andWhere('t.typeId = :id')
            ->andWhere('t.isArchive = 0')
            ->andWhere('p.isArchive = 0');

        $qb->andWhere($qb->expr()->not($qb->expr()->exists($sub->getDQL())));

        $qb->setParameter('id', $id);

        return $qb->getQuery()->getResult();

    }
}