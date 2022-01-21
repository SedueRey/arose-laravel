<?php

namespace App\Models;

class StudentRaw
{
    public $name;
    public $surname;
    public $age;
    public $level;
    public $class;
    public $group;
    public $status;

    function __construct($surname, $name, $age, $level, $class, $group, $status) {
        $this->name = $name;
        $this->surname = $surname;
        $this->age = $age;
        $this->level = $level;
        $this->class = $class;
        $this->group = $group;
        $this->status = $status;
    }
}
