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
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(name: 'id_univ')]
    private $id_univ;

    #[ORM\Column(name: 'propId')]
    private $propId;

    #[ORM\Column(name: 'value')]
    private $value;

    #[ORM\Column(name: 'typeId')]
    private $typeId;

    #[ORM\Column(name: 'isArchive')]
    private $isArchive;

//    #[OneToOne(targetEntity: Properties::class,inversedBy: 'proptoelem')]
//    #[JoinColumn(name: 'propId', referencedColumnName: 'id')]
//    private Properties|null $properties = null;

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
        $this->id_univ = $idUniv;
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