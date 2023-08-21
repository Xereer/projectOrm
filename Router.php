<?php

class Router {
    private $controller;
    private $actions = [
        'create' => 'handleCreateAction',
        'update' => 'handleUpdateAction',
        'delete' => 'handleDeleteAction',
        'recover' => 'handleRecoverAction',
        'properties' => 'handlePropertiesAction',
        'deleteProps' => 'handleDeletePropsAction',
        'updateProps' => 'handleUpdatePropsAction',
        'getAllowProps' => 'handleGetAllowPropsAction',
        'createProperty' => 'handleCreatePropertyAction',
        'deletePropsFromList' => 'handleDeletePropsFromListAction',
        'recoverPropsToList' => 'handleRecoverPropsToListAction',
        'refresh' => 'handleRefreshAction',
        'addNewPropToList' => 'handleAddNewPropToListAction',
        'findMissingProps' => 'handleFindMissingPropsAction',
        'addPropToType' => 'handleAddPropToTypeAction',
        'findExistingProps' => 'handleFindExistingPropsAction',
        'deletePropToType' => 'handleDeletePropToTypeAction'
    ];

    public function __construct($controller) {
        $this->controller = $controller;
        echo $this->controller->index();
    }
    private function redirectToIndex()
    {
        header('Location: index.html');
    }

    public function handleRequest() {

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action'])) {
            $action = $_GET['action'];

            if (array_key_exists($action, $this->actions)) {
                $methodName = $this->actions[$action];
                $this->$methodName();
            }
        }
    }

    private function handleCreateAction() {
        $childType = $_POST['childType'];
        $childName = $_POST['childName'];
        $parentID = $_POST['parentID'];
        $this->controller->createElem($childType, $childName, $parentID);
        $this->redirectToIndex();
    }

    private function handleUpdateAction() {
        $updateId = $_POST['updateId'];
        $newName = $_POST['newName'];
        $this->controller->updateElem($updateId, $newName);
        $this->redirectToIndex();
    }
    private function handleDeleteAction() {
        $deleteId = $_POST['deleteId'];
        $this->controller->deleteElem($deleteId);
        $this->redirectToIndex();
    }

    private function handleRecoverAction() {
        $this->controller->recoverElems();
        $this->redirectToIndex();
    }

    private function handlePropertiesAction() {
        $id = $_POST['elemId'];
        $this->controller->getProperties($id);
        $this->redirectToIndex();
    }

    private function handleDeletePropsAction() {
        $delPropId = $_POST['delPropId'];
        $this->controller->deleteProperty($delPropId);
        $this->redirectToIndex();
    }

    private function handleUpdatePropsAction() {
        $updatePropId = $_POST['UpdatePropId'];
        $newVal = $_POST['newVal'];
        $this->controller->updateProperty($updatePropId, $newVal);
        $this->redirectToIndex();
    }

    private function handleGetAllowPropsAction() {
        $id = $_POST['elemId'];
        $this->controller->getAllowProperties($id);
        $this->redirectToIndex();
    }
    private function handleCreatePropertyAction() {
        $createPropId = $_POST['createPropId'];
        $value = $_POST['value'];
        $id = $_POST['id'];
        $this->controller->createProperty($id, $createPropId, $value);
        $this->redirectToIndex();
    }

    private function handleDeletePropsFromListAction() {
        $deleteProps = $_POST['deleteProps'];
        $this->controller->deletePropFromList($deleteProps);
        $this->redirectToIndex();
    }

    private function handleRecoverPropsToListAction() {
        $recoverProps = $_POST['recoverProps'];
        $this->controller->recoverPropToList($recoverProps);
        $this->redirectToIndex();
    }

    private function handleRefreshAction() {
        $this->controller->refresh();
        $this->redirectToIndex();
    }
    private function handleAddNewPropToListAction() {
        $alias = $_POST['alias'];
        $name = $_POST['name'];
        $this->controller->addNewPropertyToList($alias, $name);
        $this->redirectToIndex();
    }

    private function handleFindMissingPropsAction() {
        $propMissId = $_POST['propMissId'];
        $this->controller->findMissingProperties($propMissId);
        $this->redirectToIndex();
    }

    private function handleAddPropToTypeAction() {
        $type = $_POST['type'];
        $property = $_POST['property'];
        $this->controller->addPropertyToType($type, $property);
        $this->redirectToIndex();
    }

    private function handleFindExistingPropsAction() {
        $propId = $_POST['propId'];
        $this->controller->findExistingProperties($propId);
        $this->redirectToIndex();
    }

    private function handleDeletePropToTypeAction() {
        $type = $_POST['type'];
        $property = $_POST['property'];
        $this->controller->deletePropertyToType($type, $property);
        $this->redirectToIndex();
    }
}