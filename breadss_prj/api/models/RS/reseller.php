<?php
class Reseller {
    private $conn;
    private $table = "reseller";

    public $reseller_id;
    public $f_name;
    public $m_name;
    public $l_name;
    public $phone_number;
    public $address;

    public function __construct($db) {
        $this->conn = $db; // FIXED: assign to $this->conn
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table; // added space after FROM

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE reseller_id = ? LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->reseller_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->f_name = $row['f_name'];
            $this->m_name = $row['m_name'];
            $this->l_name = $row['l_name'];
            $this->phone_number = $row['phone_number'];
            $this->address = $row['address'];
        }
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET
            reseller_id = :reseller_id,
            f_name = :f_name,
            m_name = :m_name,
            l_name = :l_name,
            phone_number = :phone_number,
            address = :address';

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->reseller_id = htmlspecialchars(strip_tags($this->reseller_id));
        $this->f_name = htmlspecialchars(strip_tags($this->f_name));
        $this->m_name = htmlspecialchars(strip_tags($this->m_name));
        $this->l_name = htmlspecialchars(strip_tags($this->l_name));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->address = htmlspecialchars(strip_tags($this->address));

        // Bind params — notice the colon prefix
        $stmt->bindParam(':reseller_id', $this->reseller_id);
        $stmt->bindParam(':f_name', $this->f_name);
        $stmt->bindParam(':m_name', $this->m_name);
        $stmt->bindParam(':l_name', $this->l_name);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':address', $this->address);

        // Execute statement
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET
            f_name = :f_name,
            m_name = :m_name,
            l_name = :l_name,
            phone_number = :phone_number,
            address = :address
            WHERE reseller_id = :reseller_id";

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->reseller_id = htmlspecialchars(strip_tags($this->reseller_id));
        $this->f_name = htmlspecialchars(strip_tags($this->f_name));
        $this->m_name = htmlspecialchars(strip_tags($this->m_name));
        $this->l_name = htmlspecialchars(strip_tags($this->l_name));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->address = htmlspecialchars(strip_tags($this->address));

        // Bind params
        $stmt->bindParam(':reseller_id', $this->reseller_id);
        $stmt->bindParam(':f_name', $this->f_name);
        $stmt->bindParam(':m_name', $this->m_name);
        $stmt->bindParam(':l_name', $this->l_name);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':address', $this->address);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE reseller_id = :reseller_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':reseller_id', $this->reseller_id);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }
}
?>
