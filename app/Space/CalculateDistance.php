<?php

namespace App\Space;

class CalculateDistance {
    private $lat1;
    private $lon1;
    private $lat2;
    private $lon2;
    private $unit;
    public function __construct($lat1, $lon1, $lat2, $lon2, $unit) {
        $this->lat1 = $lat1;
        $this->lat2 = $lat2;
        $this->lon1 = $lon1;
        $this->lon2 = $lon2;
        $this->unit = $unit;

        // dd($this);
    }

    public function distance() {

      $theta = $this->lon1 - $this->lon2;
      $dist = sin(deg2rad($this->lat1)) * sin(deg2rad($this->lat2)) +  cos(deg2rad($this->lat1)) * cos(deg2rad($this->lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $this->unit = strtoupper($this->unit);

      if ($this->unit == "K") {
          return ($miles * 1.609344);
      } else if ($this->unit == "N") {
          return ($miles * 0.8684);
      } else {
          return $miles;
      }
    }
}