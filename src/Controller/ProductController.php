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
    public function createElem($childType,$childName,$parentId)
    {
        $this->universityService->createElement($parentId,$childType,$childName);
    }
    public function updateElem($updateId,$newName)
    {
        $this->universityService->update($newName, $updateId);
    }
    public function deleteElem($deleteId)
    {
        $this->universityService->deleteElem($deleteId);
    }
    public function recoverElems()
    {
        $this->universityService->recover();
    }
    public function getProperties ($id)
    {
        $propsValues = $this->propertiesService->propertiesToElement($id);
        $properties = array();

        foreach ($propsValues as $value) {
            $properties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['properties'] = $properties;
    }
    public function deleteProperty ($delPropId)
    {
        $this->propertiesService->deleteProps($delPropId);
    }
    public function updateProperty ($updatePropId,$newVal)
    {
        $this->propertiesService->updatePropToElemValue($updatePropId, $newVal);
    }
    public function getAllowProperties($id)
    {
        $propsValues = $this->propertiesService->getAllowProps($id);

        $allowProperties = array();

        foreach ($propsValues as $value) {
            $allowProperties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['allowProperties'] = $allowProperties;
    }
    public function createProperty($id, $createPropId,$value)
    {
        $this->propertiesService->createProps($id,$createPropId,$value);
    }
    public function deletePropFromList($id)
    {
        $this->propertiesService->deletePropertyFromList($id);
        $this->refresh();
    }
    public function recoverPropToList($recoverProps)
    {
        $this->propertiesService->recoverPropertyToList($recoverProps);
        $this->refresh();
    }
    public function refresh ()
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
    public function addNewPropertyToList($alias,$name)
    {
        $this->propertiesService->createNewPropToList($alias,$name);
    }
    public function findMissingProperties($propMissId)
    {
        $propsValues = $this->propertiesService->findMissingProps($propMissId);

        $properties = array();

        foreach ($propsValues as $value) {
            $properties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['missingProperties'] = $properties;
    }
    public function addPropertyToType($type,$property)
    {
        $this->propertiesService->addPropToType($property,$type);
    }
    public function findExistingProperties($propId)
    {
        $propsValues = $this->propertiesService->findExistingProps($propId);

        $properties = array();

        foreach ($propsValues as $value) {
            $properties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['existingProperties'] = $properties;
    }
    public function deletePropertyToType($type,$property)
    {
        $this->propertiesService->deletePropertyToType($type,$property);
    }
    public function index()
    {
        $b = $this->universityService->getAllActiveUniversities(0);
        return json_encode($b);
    }
}
