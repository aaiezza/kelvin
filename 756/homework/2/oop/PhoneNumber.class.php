<?php

class PhoneNumber
{
    public $id;
    public $type;
    public $area_code;
    public $number;

    public function __construct(
        $id,
        $type,
        $area_code,
        $number )
    {
        $this->id = $id;
        $this->type = $type;
        $this->area_code = $area_code;
        $this->number = $number;
    }
}

?>
