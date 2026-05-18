<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('pointInPolygon')) {
    function pointInPolygon($lng, $lat, $polygon)
    {
        $inside = false;
        $j = count($polygon) - 1;

        for ($i = 0; $i < count($polygon); $i++) {

            $xi = $polygon[$i][0]; // lng
            $yi = $polygon[$i][1]; // lat
            $xj = $polygon[$j][0];
            $yj = $polygon[$j][1];

            $intersect = (($yi > $lat) != ($yj > $lat)) &&
                ($lng < ($xj - $xi) * ($lat - $yi) / ($yj - $yi) + $xi);

            if ($intersect) {
                $inside = !$inside;
            }

            $j = $i;
        }

        return $inside;
    }
}
