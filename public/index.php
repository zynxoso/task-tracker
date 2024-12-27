<?php
/**
 * Task Tracker Main Endpoint
 * 
 * @author Jan Harry Madrona
 * @contact xtremejeel@gmail.com
 * @github https://github.com/janharrymadrona
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $filter = isset($_GET['status']) ? $_GET['status'] : null;
        $stmt = $task->read($filter);
        $num = $stmt->rowCount();

        $tasks_arr = [];
        $tasks_arr["records"] = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $task_item = [
                "id" => $id,
                "title" => $title,
                "description" => $description,
                "priority" => $priority,
                "due_date" => $due_date,
                "status" => $status,
                "created_at" => $created_at
            ];
            array_push($tasks_arr["records"], $task_item);
        }

        http_response_code(200);
        echo json_encode($tasks_arr);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->title)) {
            $task->title = $data->title;
            $task->description = $data->description ?? '';
            $task->priority = $data->priority ?? 'medium';
            $task->due_date = $data->due_date ?? null;
            $task->status = $data->status ?? 'pending';

            if ($task->create()) {
                http_response_code(201);
                echo json_encode(["message" => "Task created successfully."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Unable to create task."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete task data."]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->id)) {
            $task->id = $data->id;
            $task->title = $data->title;
            $task->description = $data->description ?? '';
            $task->priority = $data->priority ?? 'medium';
            $task->due_date = $data->due_date ?? null;
            $task->status = $data->status ?? 'pending';

            if ($task->update()) {
                http_response_code(200);
                echo json_encode(["message" => "Task updated successfully."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Unable to update task."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete task data."]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->id)) {
            $task->id = $data->id;

            if ($task->delete()) {
                http_response_code(200);
                echo json_encode(["message" => "Task deleted successfully."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Unable to delete task."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Task ID not provided."]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
}
?>
