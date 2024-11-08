<?php

declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use App\Helpers\HttpResponse;
use App\Helpers\Validation;

trait ProductTrait
{
    public function save(): void
    {
        $data = $this->getData();
        $dbTable = $this->type;
        $validationSchema = new Validation($dbTable);
        $isValid = $validationSchema->validate($data);

        if (gettype($isValid) === 'string') {
            HttpResponse::invalidData($isValid);
            return;
        }

        $dbConn = Database::getConnection();

        $sqlValueString = join(', ', array_map(fn($item) => ":" . $item, array_keys($data)));
        $sql = "INSERT INTO $dbTable VALUES ($sqlValueString)";
        $stmt = $dbConn->prepare($sql);
        try {
            $stmt->execute($data);
            HttpResponse::added();
        } catch (\Exception $e) {
            HttpResponse::dbError($e->getMessage());
        }
    }

    public static function findAll(string $table): array
    {
        $dbConn = Database::getConnection();
        $sql = "SELECT * FROM $table";
        $result = $dbConn->query($sql);
        if (!$result) {
            throw new \Exception("Database query failed: " . $dbConn->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function throwDbError(\Exception $e)
    {
        HttpResponse::dbError($e->getMessage());
    }
}
