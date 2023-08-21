<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Repository\TypesAllowRepository;

#[Entity(repositoryClass: TypesAllowRepository::class)]
#[ORM\Table(name: 'typesallow')]
class TypesAllowEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;
    #[ORM\Column(name: 'id_prop')]
    private $id_prop;
    #[ORM\Column(name: 'typeId')]
    private $typeId;
    #[ORM\Column(name: 'isArchive')]
    private int $isArchive = 0;

    public function getId()
    {
        return $this->id;
    }

    public function getIdProp()
    {
        return $this->id_prop;
    }

    public function getTypeID()
    {
        return $this->typeId;
    }

    public function getIsArchive()
    {
        return $this->isArchive;
    }
    public function setIdProp($id_prop)
    {
        $this->id_prop = $id_prop;
        return $this;
    }

    public function setTypeID($typeId)
    {
        $this->typeId = $typeId;
        return $this;
    }

    public function setIsArchive($isArchive)
    {
        $this->isArchive = $isArchive;
        return $this;
    }
}