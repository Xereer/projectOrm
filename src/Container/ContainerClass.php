<?php

namespace Container;

class ContainerClass
{

    private array $objects = [];

    private array $constructedObjects = [];

    public function has(string $id): bool
    {
        return isset($this->objects[$id]) || class_exists($id) || isset($this->constructedObjects[$id]);
    }

    public function get(string $id): mixed
    {
        $classObject = null;
        if (isset($this->constructedObjects[$id])) {
            $classObject = $this->constructedObjects[$id];
        } elseif (isset($this->objects[$id])) {
            $classObject =  $this->objects[$id]();
        } else {
            $classObject = $this->prepareObject($id);
        }
        return $classObject;
    }

    public function set(string $id, mixed $classObject) {
        $this->constructedObjects[$id] = $classObject;
    }

    private function prepareObject(string $class): object
    {
        $classReflector = new \ReflectionClass($class);

        // Получаем рефлектор конструктора класса, проверяем - есть ли конструктор
        // Если конструктора нет - сразу возвращаем экземпляр класса
        $constructReflector = $classReflector->getConstructor();
        if (empty($constructReflector)) {
            return new $class;
        }

        // Получаем рефлекторы аргументов конструктора
        // Если аргументов нет - сразу возвращаем экземпляр класса
        $constructArguments = $constructReflector->getParameters();
        if (empty($constructArguments)) {
            return new $class;
        }

        // Перебираем все аргументы конструктора, собираем их значения
        $args = [];
        foreach ($constructArguments as $argument) {
            // Получаем тип аргумента
            $argumentType = $argument->getType()->getName();
            // Получаем сам аргумент по его типу из контейнера
            $args[$argument->getName()] = $this->get($argumentType);
        }

        // И возвращаем экземпляр класса со всеми зависимостями
        return new $class(...$args);
    }

}