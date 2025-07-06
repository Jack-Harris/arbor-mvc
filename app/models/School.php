<?php 

class School extends Model {
    public int $school_id;
    public ?int $multi_academy_trust_id;
    public string $school_name;
    public string $webhook;

}