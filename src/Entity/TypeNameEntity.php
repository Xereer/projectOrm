<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
#[ORM\Table(name: 'typename')]
class TypeNameEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'id')]
    private $id;
    #[ORM\Column(name: 'name')]
    private $name;


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
        return $this;
    }
}