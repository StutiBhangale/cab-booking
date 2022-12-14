<?php
// returns distance in km
function distance($lat1, $lon1, $lat2, $lon2)
{
  if (($lat1 == $lat2) && ($lon1 == $lon2))
  {
    return rand(100,300);
  }
  else
  {
    $theta = $lon1 - $lon2;
    $dist =sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;

    $km=$miles * 1.609344;
    return $km;
  }
}

?>