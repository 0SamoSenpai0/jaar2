<html>
<?php
// van yermaih Waterfort

class circle{
    private $length;   
    
    public function __construct($color,$length)
    {
        $this->color = $color;
        $this->length = $length;
    }
    public function draw($circle,$color){
        echo "<svg> width='400' height='200'
        <circle r='45' cx='50' cy='50' fill='$color'/>     
        </svg>";
    }
}

class rectangle{
    private $height;
    private $width;

    public function __construct($color,$height,$width)
    {
        $this->color = $color;
        $this->height = $height;
        $this->width = $width;
    }
    public function draw($rectangle,$color){
        echo "<svg> width='400' height='200'
        <rect <svg width='400' height='200'>
        <rect width='200' height='100' x='100' y='50' rx='20' ry='20' fill='$color' />
      </svg>";
    }
}

class square{
    private $length;

    public function __construct($color,$length)
    {
        $this->color = $color;
        $this->length = $length;
    }
}

class Triangle{
    private $height;
    private $width;

    public function __construct($color,$height,$width)
    {
        $this->color = $color;
        $this->height = $height;
        $this->width = $width;
    }
}   

class figure{
    private $color;

    public function __construct($color)
    {
        $this->color = $color;
    }
    
}

$circle = new circle($circle,$color);
$color = "blue";
$circle->draw("",$color);

$rectangle = new rectangle($color, $height,$weight);
$color = "red";
$rectangle->draw("",$color);