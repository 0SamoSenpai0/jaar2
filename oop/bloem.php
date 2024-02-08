<html>
<?php
class flower{
    public $color; 
    public $name; 

    function __construct($color,$name)
    {
        $this->color = $color;
        $this->name = $name;
    }

}

$flower1 = new flower("geel","zonnebloem");
$flower2 = new flower("roze","paardenbloem");
var_dump($flower1);
echo "<br>";
var_dump($flower2);


?>
</html>