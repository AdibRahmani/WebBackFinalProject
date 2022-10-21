<?php

namespace CRUD\Controller;

use CRUD\Helper\TaskHelper;
use CRUD\Model\Actions;
use CRUD\Model\Task;

class Controller
{
    public function switcher($uri, $request)
    {
        switch ($uri) {
            case Actions::CREATE:
                $this->createTaskAction($request);
                break;
            case Actions::UPDATE:
                $this->updateTaskAction($request);
                break;
            case Actions::READ:
                $this->readTaskAction($request);
                break;
            case Actions::READ_ALL:
                $this->readAllTasksAction($request);
                break;
            case Actions::DELETE:
                $this->deleteTaskAction($request);
                break;
            default:
                break;
        }
    }

    public function createTaskAction($request)
    {
        $task = new task();
        // $task->setId($_POST['id']);
        echo $_POST['title'];
        echo '<pre>'; print_r($_POST); echo '</pre>';
        $task->setTitle($_POST['title']);
        $task->setDescription($_POST['description']);
        $task->setStatus($_POST['status']);
        $taskHelper = new TaskHelper();
        $taskHelper->insertTask($task);
    }

    public function updateTaskAction($request)
    {
        // $task->setId($_POST['id']);
        $taskHelper = new TaskHelper();
        $task = $taskHelper->fetchTask($_POST['task_id']);

        $task->setTitle($_POST['task_title']);
        $task->setDescription($_POST['task_description']);
        $task->setStatus($_POST['task_status']);
        echo $_POST['task_title'];
        $taskHelper->updateTask($task);
    }

    public function readTaskAction($request)
    {
        $taskHelper = new TaskHelper();
        /** @var Task $task */
        $task = $taskHelper->fetchTask($request['id']);
        return $task;
    }

    public function readAllTasksAction($request)
    {
        $taskHelper = new TaskHelper();
        $tasks = $taskHelper->fetchAll();
        if (isset($tasks)) {
            $task_arr = array();
            $task_arr['data'] = array();

            foreach ($tasks as $task) {
                $task_item = array(
                    'id' => $task->getId(),
                    'title' => $task->getTitle(),
                    'description' => $task->getDescription(),
                    'status' => $task->getStatus(),
                );
                array_push($task_arr['data'], $task_item);
            }
            $toJSON = json_encode($task_arr);
            echo json_encode($task_arr);
        } else {
            $toJSON = json_encode(array('message' => 'No task found'));
            echo json_encode(array('message' => 'No task found'));
        }
        return $toJSON;
    }

    public function deleteTaskAction($request)
    {
        $taskHelper = new TaskHelper();
        $taskHelper->delete($request['id']);
    }

}
