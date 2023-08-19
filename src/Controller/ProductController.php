<?php

namespace Controller;

use Service\PropertiesService;
use Service\UniversityService;

class ProductController
{
    public function __construct(
        private readonly UniversityService $universityService,
        private readonly PropertiesService $propertiesService
    )
    {
    }

    public function index()
    {
//        $this->universityService->createElement(66,2,'qwerty');
//        $this->universityService->update('МЭИ', 66);
//        $this->universityService->deleteElem(58);
//        $this->universityService->recover();
//        $this->propertiesService->createNewPropToList('passs','qwe');
//        $b = $this->universityService->getAllActiveUniversities();
//        return $b;
//        $this->propertiesService->deleteProps(20);
//        $this->propertiesService->deletePropertyFromList(9);
//        $this->propertiesService->recoverPropertyToList(9);
//        $c = $this->propertiesService->getAllProperties(); //тут добавить перебор массива и разделить на активные и неактивные
//        return $c;
//        $this->propertiesService->updatePropToElemValue(21, 'qfsdfsdfs');
//        $this->propertiesService->deletePropertyToType(4,11);
//        $this->propertiesService->recoverPropertyToType(4,11);
//        $a = $this->propertiesService->findExistingProps(4);
//        return $a;
//        $d = $this->propertiesService->getAllowProps(55);
//        return $d;
//        $e = $this->propertiesService->properties(55);
//        return $e;
//        $f = $this->propertiesService->findMissingProps(1);
//        return $f;
//        $this->propertiesService->addPropToType(11,5);
//        $this->propertiesService->createProps(64,11,100);
        // Спросить про insert инъекции
        // Как распределить выполнение функций в контроллере
    }
}
