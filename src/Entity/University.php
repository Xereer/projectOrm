<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Repository\UniversityRepository;

#[Entity(repositoryClass: UniversityRepository::class)]
#[ORM\Table(name: 'university')]
class University
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;
    #[ORM\Column(name: 'parentID')]
    private $parentID;
    #[ORM\Column(name: 'typeID')]
    private $typeID;
    #[ORM\Column(name: 'name')]
    private $name;
    #[ORM\Column(name: 'isArchive', type: 'integer', options: ['default' => 0])]
    private $isArchive;

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getType()
    {
        return $this->typeID;
    }
    public function setType($type)
    {
        $this->typeID = $type;
    }
    public function getParentId()
    {
        return $this->parentID;
    }
    public function setParentId($parentId)
    {
        $this->parentID = $parentId;
    }
    public function getArhcive()
    {
        return $this->isArchive;
    }
    public function setArchive($isArchive)
    {
        $this->isArchive = $isArchive;
    }
}