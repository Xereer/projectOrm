<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<pre id="json-output"></pre>

<script>
    fetch('api.php')
        .then(response => response.json())
        .then(data => {
            const jsonOutputDiv = document.getElementById('json-output');
            jsonOutputDiv.textContent = JSON.stringify(data, null, 4);
        })
        .catch(error => {
            console.error('Error:', error);
        });
</script>
<hr>
<form method="post" action="api.php?action=properties">
    <label for="inputId">id элемента:</label>
    <input type="text" name="elemId">
    <input type="submit" value="Поиск">
</form>
<br>

<form method="post" action="api.php?action=deleteProps">
    <select id="propertySelect" name="delPropId">
        <?php
        session_start();
        if (isset($_SESSION['properties']) && !empty($_SESSION['properties'])) {
            foreach ($_SESSION['properties'] as $key => $value) {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
        } else {
            echo '<option value="-1">Нет доступных свойств</option>';
        }
        ?>
    </select>
    <button type="sumbit">Удалить свойство</button>
</form>
<br>
<form method="post" action="api.php?action=updateProps">
    <select id="propertySelect" name="UpdatePropId">
        <?php
        session_start();
        if (isset($_SESSION['properties']) && !empty($_SESSION['properties'])) {
            foreach ($_SESSION['properties'] as $key => $value) {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
        } else {
            echo '<option value="-1">Нет доступных свойств</option>';
        }
        ?>
    </select>
    <input type="text" name="newVal">
    <button type="sumbit">Изменить свойство</button>
</form>
<br>
<form method="post" action="api.php?action=getAllowProps">
    <label for="inputId">id элемента:</label>
    <input type="text" name="elemId">
    <input type="submit" value="Поиск">
</form>
<br>
<form method="post" action="api.php?action=createProperty">
    <select id="propertySelect" name="createPropId">
        <?php
        session_start();
        if (isset($_SESSION['allowProperties']) && !empty($_SESSION['allowProperties'])) {
            foreach ($_SESSION['allowProperties'] as $key => $value) {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
        } else {
            echo '<option value="-1">Нет доступных свойств</option>';
        }
        ?>
    </select>
    <label for="inputId">id элемента:</label>
    <input type="text" name="id">
    <label for="inputId">Значение</label>
    <input type="text" name="value">
    <button type="sumbit">Добавить свойство</button>
</form>
<br>
<hr>
<form method="post" action="api.php?action=deletePropsFromList">
    <select id="propertySelect" name="deleteProps">
        <?php
        session_start();
        if (isset($_SESSION['currentProps']) && !empty($_SESSION['currentProps'])) {
            foreach ($_SESSION['currentProps'] as $key => $value) {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
        } else {
            echo '<option value="-1">Нет доступных свойств</option>';
        }
        ?>
    </select>
    <button type="sumbit">Удалить свойство из справочника</button>
</form>
<form method="post" action="api.php?action=recoverPropsToList">
    <select id="propertySelect" name="recoverProps">
        <?php
        session_start();
        if (isset($_SESSION['deletedProps']) && !empty($_SESSION['deletedProps'])) {
            foreach ($_SESSION['deletedProps'] as $key => $value) {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
        } else {
            echo '<option value="-1">Нет доступных свойств</option>';
        }
        ?>
    </select>
    <button type="sumbit">Восстановить свойства</button>
</form>
<form action="api.php?action=refresh" method="post">
    <button type="sumbit">Обновить</button>
</form>
<br>
<form method="post" action="api.php?action=addNewPropToList">
    <label for="inputId">Псевдоним</label>
    <input type="text" name="alias">
    <label for="inputId">Название</label>
    <input type="text" name="name">
    <button type="sumbit">Добавить</button>
</form>
<br>
<form method="post" action="api.php?action=findMissingProps">
    <label for="inputId">Тип:</label>
    <select id="propertySelect" name="propMissId">
        <option value="1">Университет</option>
        <option value="2">Факультет</option>
        <option value="3">Кафедра</option>
        <option value="4">Группа</option>
        <option value="5">Студент</option>
    </select>
    <input type="submit" value="Поиск">
</form>
<form method="post" action="api.php?action=addPropToType">
    <label for="inputId">Тип</label>
    <select id="propertySelect" name="type">
        <option value="1">Университет</option>
        <option value="2">Факультет</option>
        <option value="3">Кафедра</option>
        <option value="4">Группа</option>
        <option value="5">Студент</option>
    </select>
    <label for="inputId">Свойство</label>
    <select id="propertySelect" name="property">
        <?php
            session_start();
            if (isset($_SESSION['missingProperties']) && !empty($_SESSION['missingProperties'])) {
                foreach ($_SESSION['missingProperties'] as $key => $value) {
        echo '<option value="' . $key . '">' . $value . '</option>';
        }
        } else {
        echo '<option value="-1">Нет доступных свойств</option>';
        }
        ?>
    </select>
    <button type="sumbit">Добавить свойство для типа</button>
</form>
<form method="post" action="api.php?action=findExistingProps">
    <label for="inputId">Тип:</label>
    <select id="propertySelect" name="propId">
        <option value="1">Университет</option>
        <option value="2">Факультет</option>
        <option value="3">Кафедра</option>
        <option value="4">Группа</option>
        <option value="5">Студент</option>
    </select>
    <input type="submit" value="Поиск">
</form>
<form method="post" action="api.php?action=deletePropToType">
    <label for="inputId">Тип</label>
    <select id="propertySelect" name="type">
        <option value="1">Университет</option>
        <option value="2">Факультет</option>
        <option value="3">Кафедра</option>
        <option value="4">Группа</option>
        <option value="5">Студент</option>
    </select>
    <label for="inputId">Свойство</label>
    <select id="propertySelect" name="property">
        <?php
            session_start();
            if (isset($_SESSION['existingProperties']) && !empty($_SESSION['existingProperties'])) {
                foreach ($_SESSION['existingProperties'] as $key => $value) {
        echo '<option value="' . $key . '">' . $value . '</option>';
        }
        } else {
        echo '<option value="-1">Нет доступных свойств</option>';
        }
        ?>
    </select>
    <button type="sumbit">Убрать свойство у типа</button>
</form>

<hr>

<form action="api.php?action=create" method="post">
    <p>id родителя</p>
    <input type="text" name="parentID">
    <p>Новый элемент</p>
    <input type="text" name="childName"><br>
    <p>Тип элемента</p>
    <select id="propertySelect" name="childType">
        <option value="1">Университет</option>
        <option value="2">Факультет</option>
        <option value="3">Кафедра</option>
        <option value="4">Группа</option>
        <option value="5">Студент</option>
    </select>
    <p><button type="sumbit">Добавить</button></p>
</form>

<hr>

<form action="api.php?action=update" method="post">
    <p>id названия</p>
    <input type="text" name="updateId">
    <p>Новое название</p>
    <input type="text" name="newName"><br>
    <p><button type="sumbit">Изменить</button></p>
</form>

<hr>

<form action="api.php?action=delete" method="post">
    <p>id</p>
    <input type="text" name="deleteId">
    <p><button type="sumbit">Удалить</button></p>
</form>

<form action="api.php?action=recover" method="post">
    <p><button type="sumbit">Восстановить</button></p>
</form>

</body>

</html>