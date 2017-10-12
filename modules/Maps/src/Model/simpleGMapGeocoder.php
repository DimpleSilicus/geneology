<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class simpleGMapGeocoder extends Model
{
		/**
		* @function     getGeoCoords
		* @param        $address : string
		* @returns      -
		* @description  Gets GeoCoords by calling the Google Maps geoencoding API
		*/
		function getGeoCoords($address)
		{
			$coords = array();   
			$address = utf8_encode($address);
			// call geoencoding api with param json for output
			$geoCodeURL = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";
			$result = json_decode(file_get_contents($geoCodeURL), true);
			$coords['status'] = $result["status"];
			$coords['lat'] = $result["results"][0]["geometry"]["location"]["lat"];
			$coords['lng'] = $result["results"][0]["geometry"]["location"]["lng"];
		
			return $coords;
		}

		/**
		* WORK IN PROGRESS...
		*
		* @function     reverseGeoCode
		* @param        $lat : string
		* @param        $lng : string
		* @returns      -
		* @description  Gets Address for the given LatLng by calling the Google Maps geoencoding API
		*/
		function reverseGeoCode($lat,$lng)
		{
			$address = array();
			// call geoencoding api with param json for output
			$geoCodeURL = "http://maps.google.com/maps/api/geocode/json?address=$lat,$lng&sensor=false";
			$result = json_decode(file_get_contents($geoCodeURL), true);        
			$address['status'] = $result["status"];    
			echo $geoCodeURL."<br />";
			print_r($result);    
			return $address;
		}

		/**
		* @function     getOSMGeoCoords
		* @param        $address : string
		* @returns      -
		* @description  Gets GeoCoords by calling the OpenStreetMap geoencoding API
		*/
		function getOSMGeoCoords($address)
		{
			$coords = array();        
			$address = utf8_encode($address);    
			// call OSM geoencoding api
			// limit to one result (limit=1) without address details (addressdetails=0)
			// output in JSON
			$geoCodeURL = "http://nominatim.openstreetmap.org/search?format=json&limit=1&addressdetails=0&q=".urlencode($address);    
			$result = json_decode(file_get_contents($geoCodeURL), true);    
			$coords['lat'] = $result[0]["lat"];
			$coords['lng'] = $result[0]["lon"];
			return $coords;
		}
} // end of class
