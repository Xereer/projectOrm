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
//        $this->propertiesService->createNewPropToList('qwerty','qwe');
//        $b = $this->universityService->getAllActiveUniversities();
//        return $b;
//        $this->propertiesService->deleteProps(20);
//        $this->propertiesService->deletePropertyFromList(9);
//        $this->propertiesService->recoverPropertyToList(9);
//        $c = $this->propertiesService->getAllProperties(); //тут добавить перебор массива и разделить на активные и неактивные
//        return $c;
//        $this->propertiesService->updatePropToElemValue(21, 'qfsdfsdfs');

    }
}
