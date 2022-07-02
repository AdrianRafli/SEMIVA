<?php

function getDatabaseConfig(): array {
    return [
        "database" => [
            "test" => [
                "url" => "mysql:host=localhost:3306;dbname=sekolah_test",
                "username" => "root",
                "password" => "",
            ],
            "prod" => [
                "url" => "mysql:host=localhost:3306;dbname=sekolah",
                "username" => "root",
                "password" => "",
            ]
        ]
    ];
}