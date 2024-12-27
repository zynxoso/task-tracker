<?php
/**
 * Task Model for Task Tracker Application
 * 
 * @author Jan Harry Madrona
 * @contact xtremejeel@gmail.com
 * @github https://github.com/janharrymadrona
 */
require_once __DIR__ . '/../config/database.php';

class Task {
    private $conn;
    private $table_name = 'tasks';

    public $id;
    public $title;
    public $description;
    public $priority;
    public $due_date;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create Task
    public function create() {
        $query = "INSERT INTO {$this->table_name} 
                  SET title=:title, description=:description, 
                      priority=:priority, due_date=:due_date, 
                      status=:status, created_at=NOW()";
        
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->priority = htmlspecialchars(strip_tags($this->priority));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":priority", $this->priority);
        $stmt->bindParam(":due_date", $this->due_date);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read Tasks
    public function read($filter = null) {
        $query = "SELECT * FROM {$this->table_name}";
        
        if ($filter) {
            $query .= " WHERE status = :status";
        }

        $stmt = $this->conn->prepare($query);

        if ($filter) {
            $stmt->bindParam(":status", $filter);
        }

        $stmt->execute();
        return $stmt;
    }

    // Update Task
    public function update() {
        $query = "UPDATE {$this->table_name} 
                  SET title=:title, description=:description, 
                      priority=:priority, due_date=:due_date, 
                      status=:status 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->priority = htmlspecialchars(strip_tags($this->priority));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":priority", $this->priority);
        $stmt->bindParam(":due_date", $this->due_date);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete Task
    public function delete() {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
