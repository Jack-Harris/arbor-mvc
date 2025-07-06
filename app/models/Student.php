<?php 

class Student extends Model {
    public string $student_id;
    public int $guardian_id;
    public int $school_id;
    public ?string $forename;
    public ?string $surname; 
}