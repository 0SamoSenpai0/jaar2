<?php
// van Yermaih Waterfort
class Room {
    private $length;
    private $width;
    private $height;

    public function __construct($length, $width, $height) {
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
    }

    public function getLength() {
        return $this->length;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getVolume() {
        return $this->length * $this->width * $this->height;
    }
}

class House {
    private $volume;
    private $rooms;
    private $price;

    public function __construct() {
        $this->volume = 0;
        $this->rooms = [];
        $this->price = 0;
    }

    public function addRoom(Room $room) {
        $this->rooms[] = $room;
        $this->volume += $room->getVolume();
    }

    public function getRooms() {
        return $this->rooms;
    }

    public function getTotalVolume() {
        return $this->volume;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }
}

// Voorbeeldgebruik:
$house = new House();

// Kamers toevoegen
$house->addRoom(new Room(5.2, 5.1, 5.5));
$house->addRoom(new Room(4.8, 4.6, 4.9));
$house->addRoom(new Room(5.9, 2.5, 3.1));

// Totale volume berekenen
$totalVolume = $house->getTotalVolume();

// Prijs instellen
$house->setPrice(894000);

// Uitvoer genereren
echo "Inhoud Kamers:", "<br>";
foreach ($house->getRooms() as $room) {
    echo "• Lengte: " . $room->getLength() .
    "m Breedte: " . $room->getWidth() .
    "m Hoogte: " . $room->getHeight() . "m<br>";
}
echo "Volume Totaal = " . $totalVolume . "m3<br>";
echo "Prijs van het huis is= " . $house->getPrice() . "Euro";
?>
