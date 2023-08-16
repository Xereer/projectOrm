<?php

namespace Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Repository\PropToElemRepository;


#[Entity(repositoryClass: PropToElemRepository::class)]
#[ORM\Table(name: 'proptoelem')]
class PropToElem
{
    #[ORM\Id]
    #[ORM\Column(name: 'id')]
    private $id;

    #[ORM\Column(name: 'id_univ')]
    private $idUniv;

    #[ORM\Column(name: 'propId')]
    private $propId;

    #[ORM\Column(name: 'value')]
    private $value;

    #[ORM\Column(name: 'typeId')]
    private $typeId;

    #[ORM\Column(name: 'isArchive')]
    private $isArchive;

    #[ManyToOne(targetEntity: Properties::class)]
    #[JoinColumn(name: 'propId', referencedColumnName: 'id')]
    private $property;

    public function getId()
    {
        return $this->id;
    }
    public function getIdUniv()
    {
        return $this->idUniv;
    }
    public function setIdUniv($idUniv)
    {
        $this->idUniv = $idUniv;
    }
    public function getPropId()
    {
        return $this->propId;
    }
    public function setPropId($propId)
    {
        $this->propId = $propId;
    }
    public function getType()
    {
        return $this->typeId;
    }
    public function setType($typeId)
    {
        $this->typeId = $typeId;
    }
    public function getArchive()
    {
        return $this->isArchive;
    }
    public function setArchive($isArchive)
    {
        $this->isArchive = $isArchive;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
}