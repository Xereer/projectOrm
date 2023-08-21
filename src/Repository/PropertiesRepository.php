<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Entity\PropertiesEntity;
use Entity\PropToElemEntity;
use Entity\TypesAllowEntity;
use Entity\UniversityEntity;

class PropertiesRepository extends EntityRepository
{
    public function findPropertiesByUniversityId($id)
    {
        return $this->createQueryBuilder('p')
            ->select('pt.value', 'p.alias', 'pt.id')
            ->leftJoin(PropToElemEntity::class, 'pt','WITH', 'pt.propId = p.id')
            ->where('pt.propId = p.id')
            ->andWhere('pt.id_univ = :id')
            ->andWhere('pt.isArchive = 0')
            ->andWhere('p.isArchive = 0')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function getAllowPropsByElemId ($id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p.alias', 'p.id')
            ->leftJoin(TypesAllowEntity::class, 't', 'WITH', 'p.id = t.id_prop and t.isArchive = 0')
            ->leftJoin(UniversityEntity::class, 'u', 'WITH', 't.typeId = u.typeID and u.isArchive = 0')
            ->leftJoin(PropToElemEntity::class, 'pt', 'WITH', 'pt.propId = p.id AND pt.id_univ = u.id')
            ->where('p.isArchive = 0')
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

        $sub = $this->createQueryBuilder('sub')
        ->select('t.id')
            ->from(TypesAllowEntity::class, 't')
            ->where('t.id_prop = p.id')
            ->andWhere('t.typeId = :id')
            ->andWhere('t.isArchive = 0')
            ->andWhere('p.isArchive = 0');

        $qb->andWhere($qb->expr()->not($qb->expr()->exists($sub->getDQL())));

        $qb->setParameter('id', $id);

        return $qb->getQuery()->getResult();

    }
}
