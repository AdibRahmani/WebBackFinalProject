<?php

namespace CRUD\Helper;

use CRUD\Model\Task;

class TaskHelper
{
    public function insertTask(Task $task)
    {
        /** @var DBConnector $dbHelper */
        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $sql = "INSERT INTO task (id, title, description, status) VALUES (null, '" . $task->getTitle() . "', '" . $task->getDescription() . "', '" . $task->getStatus() . "')";
        if ($dbHelper->execQuery($sql)) {
            echo "Record added successfully";
        } else {
            echo "An Error Occurred";
        }
    }

    public function fetchTask(int $id)
    {
        $task = new Task();
        /** @var DBConnector $dbHelper */
        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $result = $dbHelper->execQuery("SELECT * FROM task WHERE id =" . $id);
        $row = $result->fetch_all(MYSQLI_ASSOC);
        $task->setId($row[0]['id']);
        $task->setTitle($row[0]['title']);
        $task->setDescription($row[0]['description']);
        $task->setStatus($row[0]['status']);

        return $task;
    }

    public function fetchAll()
    {
        $task = [];
        /** @var DBConnector $dbHelper */
        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $result = $dbHelper->execQuery("SELECT * FROM task ORDER BY id");
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $task = new Task();
            $task->setId($row['id']);
            $task->setTitle($row['title']);
            $task->setDescription($row['description']);
            $task->setStatus($row['status']);
            $tasks[] = $task;
        }
        return $tasks;
    }

    public function updateTask(Task $task)
    {
        /** @var DBConnector $dbHelper */
        echo $task->getTitle();

        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $sql = "UPDATE task SET title = '" . $task->getTitle() . "', description = '" . $task->getDescription() . "', status = '" . $task->getStatus() . "' WHERE id = '" . $task->getId() . "'";
        if ($dbHelper->execQuery($sql)) {
            echo "Record updated successfully";
        } else {
            echo "An Error Occurred";
        }
    }

    public function delete($id)
    {
        /** @var DBConnector $dbHelper */
        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $sql = "DELETE FROM task WHERE id = '" . $id . "'";
        if ($dbHelper->execQuery($sql)) {
            echo "Record deleted successfully";
        } else {
            echo "An Error Occurred";
        }
    }
}
