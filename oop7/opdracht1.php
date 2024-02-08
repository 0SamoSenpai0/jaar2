<html><?php
class house{
    public $floor;
    public $rooms;
    public $volume;

    function __construct($floor,$rooms,$width,$height,$depth)
    {
        $this->floor = $floor;
        $this->rooms = $rooms;
        //$this->width = $width;
        //$this->height = $height;
        //$this->depth = $depth;
        $this->volume = $width*$height*$depth;
    }   
    function setVolume($width,$height,$depth){
        $volume = $width*$height*$depth;
    }
    function getHouse(){
        return "dit huis heeft {$this->floor} verdieping(en), {$this->rooms} kamers en heeft een volume van {$this->volume} m3"; echo "br";
    }
     function getPrice(){    
        $priseperm3 = 1500;
        $price = $this->volume * $priseperm3;
        return "De pris van het huis is: $price";
     }
}
$house1 = new house(1,2,10.0,10.0,1.0);
echo $house1->getHouse() , "<br>";
echo $house1->getPrice();
echo "<br>";
$house2 = new house(3,8,15,10,1);
echo $house2->getHouse() , "<br>";
echo $house2->getPrice();
echo "<br>";
$house3 = new house(2,5,7.5,10,1);
echo $house3->getHouse() , "<br>";
echo $house3->getPrice();




?>
</html>
