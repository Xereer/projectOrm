<?php

namespace Controller;

use Service\PropertiesService;
use Service\UniversityService;
use Request;

class ProductController
{
    public function __construct(
        private readonly UniversityService $universityService,
        private readonly PropertiesService $propertiesService
    )
    {
    }
    public function createElem(Request $request)
    {
        $this->universityService->createElement($request->getParams('parentID'),
            $request->getParams('childType'),
            $request->getParams('childName'));
    }
    public function updateElem(Request $request)
    {
        $this->universityService->update($request->getParams('newName'),
            $request->getParams('updateId'));
    }
    public function deleteElem(Request $request)
    {
        $this->universityService->deleteElem($request->getParams('deleteId'));
    }
    public function recoverElems()
    {
        $this->universityService->recover();
    }
    public function getProperties(Request $request)
    {
        $propsValues = $this->propertiesService->propertiesToElement($request->getParams('elemId'));
        $properties = array();

        foreach ($propsValues as $value) {
            $properties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['properties'] = $properties;
    }
    public function deleteProperty(Request $request)
    {
        $this->propertiesService->deleteProps($request->getParams('delPropId'));
    }
    public function updateProperty(Request $request)
    {
        $this->propertiesService->updatePropToElemValue($request->getParams('UpdatePropId'),
            $request->getParams('newVal'));
    }
    public function getAllowProperties(Request $request)
    {
        $propsValues = $this->propertiesService->getAllowProps($request->getParams('elemId'));

        $allowProperties = array();

        foreach ($propsValues as $value) {
            $allowProperties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['allowProperties'] = $allowProperties;
    }
    public function createProperty(Request $request)
    {
        $this->propertiesService->createProps(
            $request->getParams('id'),
            $request->getParams('createPropId'),
            $request->getParams('value')
        );
    }
    public function deletePropFromList(Request $request)
    {
        $this->propertiesService->deletePropertyFromList(
            $request->getParams('deleteProps'));
        $this->refresh();
    }
    public function recoverPropToList(Request $request)
    {
        $this->propertiesService->recoverPropertyToList(
            $request->getParams('recoverProps'));
        $this->refresh();
    }
    public function refresh()
    {
        $elem = $this->propertiesService->getAllProperties();
        $currentProps = array();
        $deletedProps = array();

        foreach ($elem as $value) {
            if ($value->getArchive() == 0) {
                $currentProps[$value->getId()] = $value->getAlias();
            } else {
                $deletedProps[$value->getId()] = $value->getAlias();
            }
        }
        session_start();
        $_SESSION['currentProps'] = $currentProps;
        $_SESSION['deletedProps'] = $deletedProps;
    }
    public function addNewPropertyToList(Request $request)
    {
        $this->propertiesService->createNewPropToList(
        $request->getParams('alias'),
        $request->getParams('name'));
    }
    public function findMissingProperties(Request $request)
    {
        $propsValues = $this->propertiesService->findMissingProps($request->getParams('propMissId'));

        $properties = array();

        foreach ($propsValues as $value) {
            $properties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['missingProperties'] = $properties;
    }
    public function addPropertyToType(Request $request)
    {
        $this->propertiesService->addPropToType(
            $request->getParams('property'),
            $request->getParams('type'));
    }
    public function findExistingProperties(Request $request)
    {
        $propsValues = $this->propertiesService->findExistingProps($request->getParams('propId'));

        $properties = array();

        foreach ($propsValues as $value) {
            $properties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['existingProperties'] = $properties;
    }
    public function deletePropertyToType(Request $request)
    {
        $this->propertiesService->deletePropertyToType(
            $request->getParams('type'),
            $request->getParams('property')
        );
    }
    public function index()
    {
        $b = $this->universityService->getAllActiveUniversities(0);
        return json_encode($b);
    }
}
