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
        $this->universityService->createElement($request->get('parentID'),$request->get('childType'),$request->get('childName'));
    }
    public function updateElem()
    {
        $updateId = $_POST['updateId'];
        $newName = $_POST['newName'];
        $this->universityService->update($newName, $updateId);
    }
    public function deleteElem()
    {
        $deleteId = $_POST['deleteId'];
        $this->universityService->deleteElem($deleteId);
    }
    public function recoverElems()
    {
        $this->universityService->recover();
    }
    public function getProperties()
    {
        $id = $_POST['elemId'];
        $propsValues = $this->propertiesService->propertiesToElement($id);
        $properties = array();

        foreach ($propsValues as $value) {
            $properties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['properties'] = $properties;
    }
    public function deleteProperty()
    {
        $delPropId = $_POST['delPropId'];
        $this->propertiesService->deleteProps($delPropId);
    }
    public function updateProperty()
    {
        $updatePropId = $_POST['UpdatePropId'];
        $newVal = $_POST['newVal'];
        $this->propertiesService->updatePropToElemValue($updatePropId, $newVal);
    }
    public function getAllowProperties()
    {
        $id = $_POST['elemId'];
        $propsValues = $this->propertiesService->getAllowProps($id);

        $allowProperties = array();

        foreach ($propsValues as $value) {
            $allowProperties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['allowProperties'] = $allowProperties;
    }
    public function createProperty()
    {
        $createPropId = $_POST['createPropId'];
        $value = $_POST['value'];
        $id = $_POST['id'];
        $this->propertiesService->createProps($id,$createPropId,$value);
    }
    public function deletePropFromList()
    {
        $id = $_POST['deleteProps'];
        $this->propertiesService->deletePropertyFromList($id);
        $this->refresh();
    }
    public function recoverPropToList()
    {
        $recoverProps = $_POST['recoverProps'];
        $this->propertiesService->recoverPropertyToList($recoverProps);
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
    public function addNewPropertyToList()
    {
        $alias = $_POST['alias'];
        $name = $_POST['name'];
        $this->propertiesService->createNewPropToList($alias,$name);
    }
    public function findMissingProperties()
    {
        $propMissId = $_POST['propMissId'];
        $propsValues = $this->propertiesService->findMissingProps($propMissId);

        $properties = array();

        foreach ($propsValues as $value) {
            $properties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['missingProperties'] = $properties;
    }
    public function addPropertyToType()
    {
        $type = $_POST['type'];
        $property = $_POST['property'];
        $this->propertiesService->addPropToType($property,$type);
    }
    public function findExistingProperties()
    {
        $propId = $_POST['propId'];
        $propsValues = $this->propertiesService->findExistingProps($propId);

        $properties = array();

        foreach ($propsValues as $value) {
            $properties[$value['id']] = $value['alias'];
        }
        session_start();
        $_SESSION['existingProperties'] = $properties;
    }
    public function deletePropertyToType()
    {
        $type = $_POST['type'];
        $property = $_POST['property'];
        $this->propertiesService->deletePropertyToType($type,$property);
    }
    public function index()
    {
        $b = $this->universityService->getAllActiveUniversities(0);
        return json_encode($b);
    }
}
