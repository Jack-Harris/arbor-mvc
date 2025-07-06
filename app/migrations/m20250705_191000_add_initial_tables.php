<?php


class M20250705_191000_add_initial_tables extends Migration {

    public function up() {
        $this->createTable('message_status', [
            '`message_status_id` INT AUTO_INCREMENT PRIMARY KEY',
            '`message_status_name` VARCHAR(20) NOT NULL',
        ]);

        $this->createTable("provider", [
            '`provider_id` INT AUTO_INCREMENT PRIMARY KEY',
            '`provider_name` VARCHAR(512)'
        ]);

        $this->createTable("multi_academy_trust", [
            '`multi_academy_trust_id` INT AUTO_INCREMENT PRIMARY KEY',
            '`multi_academy_trust_name` VARCHAR(512)',
        ]);

        $this->createTable("school", [
            '`school_id` INT AUTO_INCREMENT PRIMARY KEY',
            '`multi_academy_trust_id` INT',
            '`school_name` VARCHAR(512)',
            '`webhook` VARCHAR(512)',
        ], 'FOREIGN KEY (`multi_academy_trust_id`) REFERENCES `multi_academy_trust`(`multi_academy_trust_id`) ON DELETE SET NULL ON UPDATE CASCADE');

        $this->createTable("teacher", [
            '`teacher_id` INT AUTO_INCREMENT PRIMARY KEY',
            '`school_id` INT',
            '`forename` VARCHAR(512)',
            '`surname` VARCHAR(512)',
        ], 'FOREIGN KEY (`school_id`) REFERENCES `school`(`school_id`) ON DELETE SET NULL ON UPDATE CASCADE');


        $this->createTable("guardian", [
            '`guardian_id` INT AUTO_INCREMENT PRIMARY KEY',
            '`forename` VARCHAR(512)',
            '`surname` VARCHAR(512)',
            '`phone_number` VARCHAR(20) NOT NULL',
        ]);

        $this->createTable("student", [
            '`student_id` VARCHAR(256) UNIQUE',
            '`guardian_id` INT',
            '`school_id` INT',
            '`forename` VARCHAR(512)',
            '`surname` VARCHAR(512)',
        ],
         '
            FOREIGN KEY (`guardian_id`) REFERENCES `guardian`(`guardian_id`) ON DELETE SET NULL ON UPDATE CASCADE,
            FOREIGN KEY (`school_id`) REFERENCES `school`(`school_id`) ON DELETE SET NULL ON UPDATE CASCADE
         ');

        $this->createTable(
            'message',
            [
                '`message_id` VARCHAR(128) PRIMARY KEY',
                '`sender_id` INT NOT NULL',
                '`recipient_id` INT NOT NULL',
                '`provider_id` INT NOT NULL',
                '`subject` TEXT NOT NULL',
                '`message` TEXT NOT NULL',
                '`message_status_id` INT',
                '`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
            ],
            '
                FOREIGN KEY (`sender_id`) REFERENCES `teacher`(`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (`recipient_id`) REFERENCES `guardian`(`guardian_id`) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (`provider_id`) REFERENCES `provider`(`provider_id`) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (`message_status_id`) REFERENCES `message_status`(`message_status_id`) ON DELETE SET NULL ON UPDATE CASCADE
            '
        );
    }

    public function down() {    

    }

}