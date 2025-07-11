<?php

class Model {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::get();
    }

    /**
     * By default, the table name in the database is expected to be the snake case version
     * of the class name. 
     * Eg. ExampleModelName -> example_model_name.
     */
    public function tableName() {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', get_class($this)));
        // return StringUtils::camelToSnakeCase(get_class($this)); 
    }

    /**
     * Get the primary key for this model. It is assumed to be the name of the model in snake 
     * case with _id appended to the end. For example teacher_id.
     */
    public function primaryKey(): string
    {
        $className = (new \ReflectionClass($this))->getShortName();

        $classNameSnakeCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
        // $classNameSnakeCase = StringUtils::camelToSnakeCase($className);
        return $classNameSnakeCase . '_id';
    }

    /**
     * Return all of the model attributes.
     * @return array
     */
    public function getAttributes() {
        $attributes = get_object_vars($this);
        unset($attributes['pdo']);
        return $attributes;
    }

    /**
     * Execute raw prepared SQL statement.
     */
    public function executeRaw(string $sql, array $params = []): array {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find a list of models which meet the criteria given in $attributes.
     * 
     * @todo split into findByAttributes and findAllByAttributes
     */
    public function findByAttributes(array $attributes, ?int $limit = null): mixed {
        $where = [];
        $params = [];

        foreach ($attributes as $column => $value) {
            $where[] = "`$column` = :$column";
            $params[":$column"] = $value;
        }

          $sql = "SELECT * FROM " . $this->tableName() .
           " WHERE " . implode(" AND ", $where);

        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        if ($limit === 1) {
            $results = [$statement->fetch(PDO::FETCH_ASSOC)];
        } else {
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        $models = [];
        foreach ($results ?? [] as $result) {
            if (empty($result)) {
                continue;
            }

            $newModel = new static();
            foreach ($result as $key => $value) {
                if (property_exists($this, $key)) {
                    $newModel->$key = $value;
                }
            }

            $models[] = $newModel;
        }

        if ($limit === 1) {
            return (!empty($models[0])) ? $models[0] : null;
        } else {
            return $models;
        }
    }

    /**
     * Insert a new row with the attributes stored in this object. Automatically 
     * retrieve any AUTO_INCREMENT IDs.
     */
    public function save() {
        $columns = array_keys($this->getAttributes());
        $queryPlaceholders = array_map(fn($column) => ":$column", $columns);

        $sql = "INSERT INTO " . $this->tableName() .
            " (`" . implode('`, `', $columns) . "`)" .
            " VALUES (" . implode(', ', $queryPlaceholders) . ")";

        $statement = $this->pdo->prepare($sql);
        $success =  $statement->execute($this->getAttributes());

        if ($success) {
            $id = $this->pdo->lastInsertId();
            $primaryKey = $this->primaryKey();
          
            if (!empty($id) && is_numeric($id) && property_exists($this, $primaryKey)) {
                $this->$primaryKey = $id;
            }
        }

        return $this;
    }

}