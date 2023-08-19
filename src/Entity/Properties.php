<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Repository\PropertiesRepository;

#[Entity(repositoryClass: PropertiesRepository::class)]
#[ORM\Table(name: 'properties')]
class Properties
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(name: 'alias')]
    private $alias;

    #[ORM\Column(name: 'name')]
    private $name;

    #[ORM\Column(name: 'isArchive')]
    private $isArchive;

//    #[ORM\OneToOne(targetEntity: PropToElem::class, mappedBy: 'properties')]
//    private PropToElem|null $propToElem = null;

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getAlias()
    {
        return $this->alias;
    }
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }
    public function getArchive()
    {
        return $this->isArchive;
    }
    public function setArchive($isArchive)
    {
        $this->isArchive = $isArchive;
    }
}