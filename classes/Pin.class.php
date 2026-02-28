<?php
class Pin
{
    // Properties
    private $id;
    private $name;
    private $lat;
    private $lon;
    private $type;
    private $count;
    private $lastSpot;

    // Constructor
    public function __construct($id, $name, $lat, $lon, $type, $count, $lastSpot)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->type = $type;
        $this->count = $count;
        $this->lastSpot = $lastSpot;
    }

    // Getter and Setter methods for each property

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getLat()
    {
        return $this->lat;
    }
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    public function getLon()
    {
        return $this->lon;
    }
    public function setLon($lon)
    {
        $this->lon = $lon;
    }

    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
    }

    public function getCount()
    {
        return $this->count;
    }
    public function setCount($count)
    {
        $this->count = $count;
    }

    public function getLastSpot()
    {
        return $this->lastSpot;
    }
    public function setLastSpot($lastSpot)
    {
        $this->lastSpot = $lastSpot;
    }

    // Method to display details of the Pin
    public function getDetails()
    {
        $dateString = $this->lastSpot->format('Y-m-d H:i:s');
        return "ID: " . $this->id . ", Name: " . $this->name . ", Latitude: " . $this->lat . ", Longitude: " . $this->lon . ", Type: " . $this->type . ", Count: " . $this->count . ", Last Spot: " . $dateString;
    }

    public function getTimePassed()
    {
        // Get the current time
        $now = new DateTime();
        // Calculate the difference
        $interval = $now->diff($this->lastSpot);
        // Output the time difference
        echo "Time passed: ";
        if ($interval->y > 0) {
            echo $interval->y . " years, ";
        }
        if ($interval->m > 0) {
            echo $interval->m . " months, ";
        }
        if ($interval->d > 0) {
            echo $interval->d . " days, ";
        }
        if ($interval->h > 0) {
            echo $interval->h . " hours, ";
        }
        if ($interval->i > 0) {
            echo $interval->i . " minutes, ";
        }
        // echo $interval->s . " seconds.";
    }
}
