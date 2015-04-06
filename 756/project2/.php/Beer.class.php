<?php
class Beer
{
    private $name;
    private $price;

    public function __construct( $name, $price )
    {
        $this->name  = $name;
        $this->price = $price;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function toArray()
    {
        return array( $this->name, $this->price );
    }
}
?>
