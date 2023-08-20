<?php


use Doctrine\ORM\EntityManager;

require_once 'vendor/autoload.php';
require_once 'config/bootstrap.php';

try {
    $controller = $container->get(\Controller\ProductController::class);
    echo $controller->index();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action'])) {
        $action = $_GET['action'];

        switch ($action) {
            case 'create':
                $childType = $_POST['childType'];
                $childName = $_POST['childName'];
                $parentID = $_POST['parentID'];
                $controller->createElem($childType, $childName, $parentID);
                break;
            case 'update':
                $updateId = $_POST['updateId'];
                $newName = $_POST['newName'];
                $controller->updateElem($updateId, $newName);
                break;
            case 'delete':
                $deleteId = $_POST['deleteId'];
                $controller->deleteElem($deleteId);
                break;
            case 'recover':
                $controller->recoverElems();
                break;
            case 'properties':
                $id = $_POST['elemId'];
                $controller->getProperties($id);
                break;
            case 'deleteProps':
                $delPropId = $_POST['delPropId'];
                $controller->deleteProperty($delPropId);
                break;
            case 'updateProps':
                $updatePropId = $_POST['UpdatePropId'];
                $newVal = $_POST['newVal'];
                $controller->updateProperty($updatePropId, $newVal);
                break;
            case 'getAllowProps':
                $id = $_POST['elemId'];
                $controller->getAllowProperties($id);
                break;
            case 'createProperty':
                $createPropId = $_POST['createPropId'];
                $value = $_POST['value'];
                $id = $_POST['id'];
                $controller->createProperty($id, $createPropId, $value);
                break;
            case 'deletePropsFromList':
                $deleteProps = $_POST['deleteProps'];
                $controller->deletePropFromList($deleteProps);
                break;
            case 'recoverPropsToList':
                $recoverProps = $_POST['recoverProps'];
                $controller->recoverPropToList($recoverProps);
                break;
            case 'refresh':
                $controller->refresh();
                break;
            case 'addNewPropToList':
                $alias = $_POST['alias'];
                $name = $_POST['name'];
                $controller->addNewPropertyToList($alias, $name);
                break;
            case 'findMissingProps':
                $propMissId = $_POST['propMissId'];
                $controller->findMissingProperties($propMissId);
                break;
            case 'addPropToType':
                $type = $_POST['type'];
                $property = $_POST['property'];
                $controller->addPropertyToType($type,$property);
                break;
            case 'findExistingProps':
                $propId = $_POST['propId'];
                $controller->findExistingProperties($propId);
                break;
            case 'deletePropToType':
                $type = $_POST['type'];
                $property = $_POST['property'];
                $controller->deletePropertyToType($type,$property);
                break;
        }
        header('Location: index.php');
    }
} catch (Throwable $exception) {
    print_r(  $exception->getMessage());
}