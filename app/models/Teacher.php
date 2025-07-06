<?php

class Teacher extends Model {
    
    public int $teacher_id;
    public int $school_id;
    public ?string $forename;
    public ?string $surname;

}