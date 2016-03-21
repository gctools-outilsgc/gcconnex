<?php
/**
 * Exif Processing Library
 *
 * @package TidypicsExif
 */

/**
 * Pull EXIF data from image file
 *
 * @param TidypicsImage $image
 */
function td_get_exif($image) {

	// catch for those who don't have exif module loaded
	if (!is_callable('exif_read_data')) {
		return;
	}

	$mime = $image->mimetype;
	if ($mime != 'image/jpeg' && $mime != 'image/pjpeg') {
		return;
	}

	$filename = $image->getFilenameOnFilestore();
	$exif = exif_read_data($filename, 'IFD0,EXIF', true);
	if (is_array($exif)) {
		$data = array_merge($exif['IFD0'], $exif['EXIF']);
		foreach ($data as $key => $value) {
			if (is_string($value)) {
				// there are sometimes unicode characters that cause problems with serialize
				$data[$key] = preg_replace( '/[^[:print:]]/', '', $value);
			}
		}
		$image->tp_exif = serialize($data);
	}
	
	$filename = $image->getFilenameOnFilestore();
	$exif = exif_read_data($filename, "ANY_TAG", true);
	if (is_array($exif)) {
		// GPS data
		$gps_exif = array_intersect_key($exif['GPS'], array_flip(array('GPSLatitudeRef', 'GPSLatitude', 'GPSLongitudeRef', 'GPSLongitude')));

		$data = array_merge($exif['IFD0'], $exif['EXIF']);
		foreach ($data as $key => $value) {
			if (is_string($value)) {
				// there are sometimes unicode characters that cause problems with serialize
				$data[$key] = preg_replace( '/[^[:print:]]/', '', $value);
			}
		}

		if (count($gps_exif) == 4) {
			if (
				is_array($gps_exif['GPSLatitude']) && in_array($gps_exif['GPSLatitudeRef'], array('S', 'N')) &&
				is_array($gps_exif['GPSLongitude']) && in_array($gps_exif['GPSLongitudeRef'], array('W', 'E'))
			) {
				$data['latitude'] = parse_exif_gps_data($gps_exif['GPSLatitude'], $gps_exif['GPSLatitudeRef']);
				$data['longitude'] = parse_exif_gps_data($gps_exif['GPSLongitude'], $gps_exif['GPSLongitudeRef']);
			}

		}
		$image->tp_exif = serialize($data);
	}
}

/**
 * Grab array of EXIF data for display
 *
 * @param TidypicsImage $image
 * @return array|false
 */
function tp_exif_formatted($image) {

	$exif = $image->tp_exif;
	if (!$exif) {
		return false;
	}

	$exif = unserialize($exif);

	$model = $exif['Model'];
	if (!$model) {
		$model = "N/A";
	}
	$exif_data['Model'] = $model;

	$exposure = $exif['ExposureTime'];
	if (!$exposure) {
		$exposure = "N/A";
	}
	$exif_data['Shutter'] = $exposure;

	//got the code snippet below from http://www.zenphoto.org/support/topic.php?id=17
	//convert the raw values to understandible values
	$Fnumber = explode("/", $exif['FNumber']);
	if ($Fnumber[1] != 0) {
		$Fnumber = $Fnumber[0] / $Fnumber[1];
	} else {
		$Fnumber = 0;
	}
	if (!$Fnumber) {
		$Fnumber = "N/A";
	} else {
		$Fnumber = "f/$Fnumber";
	}
	$exif_data['Aperture'] = $Fnumber;

	$iso = $exif['ISOSpeedRatings'];
	if (!$iso) {
		$iso = "N/A";
	}
	$exif_data['ISO Speed'] = $iso;

	$Focal = explode("/", $exif['FocalLength']);
	if ($Focal[1] != 0) {
		$Focal = $Focal[0] / $Focal[1];
	} else {
		$Focal = 0;
	}
	if (!$Focal || round($Focal) == "0") {
		$Focal = 0;
	}
	if (round($Focal) == 0) {
		$Focal = "N/A";
	} else {
		$Focal = round($Focal) . "mm";
	}
	$exif_data['Focal Length'] = $Focal;

	$captured = $exif['DateTime'];
	if (!$captured) {
		$captured = "N/A";
	}
	$exif_data['Captured'] = $captured;

	// uncomment the following lines if you want to get the GPS position displayed - used only for testing now
// 	if ($exif['latitude'] && $exif['longitude']) {
// 		$exif_data['latitude'] = $exif['latitude'];
// 		$exif_data['longitude'] = $exif['longitude'];
// 	}

	return $exif_data;
}

/**
 * Converts EXIF GPS format to a float value.
 *
 * @param string[] $raw eg:
 *    - 41/1
 *    - 54/1
 *    - 9843/500
 * @param string $ref 'S', 'N', 'E', 'W'. eg: 'N'
 * @return float eg: 41.905468
 */
function parse_exif_gps_data($raw, $ref) {
	foreach ($raw as &$i) {
		$i = explode('/', $i);
		$i = $i[1] == 0 ? 0 : $i[0] / $i[1];
	}
	unset($i);

	$v = $raw[0] + $raw[1] / 60 + $raw[2] / 3600;

	$ref = strtoupper($ref);
	if ($ref == 'S' || $ref == 'W') {
		$v= -$v;
	}

	return $v;
}
