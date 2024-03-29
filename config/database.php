<?php

function getDatabaseConfig(): array {
    return [
        "database" => [
            "test" => [
                "url" => "mysql:host=localhost:3306;dbname=absensikaryawan_test",
                "username" => "root",
                "password" => ""
            ],
            "production" => [
                "url" => "mysql:host=localhost:3306;dbname=absensikaryawan",
                "username" => "root",
                "password" => ""
            ]
        ]
    ];
}