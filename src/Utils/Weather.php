<?php

namespace App\Utils;

/**
 * Weather class used to hold the current weather data.
 */
class Weather
{
    /**
     * City name
     */
    public $cityName;

    /**
     * Weather description
     */
    public $weatherDesc;
	
	/**
     * Current temperature in K
     */
    public $tempCurrent;

	/**
     * Min temperature in K
     */
    public $tempMin;
	
	/**
     * max temperature in K
     */
    public $tempMax;

    /**
     * wind speed
     */
    public $windSpeed;
	
	/**
     * Direction of wind in degrees
     */
    public $windDir;

    /**
     * Create a new weather object.
     *
     * @param mixed  $data
     * @internal
     */
    public function __construct($json_data)
    {
		$data = json_decode( $json_data, true );

		$this->cityName = $data['name'] ?? '--';
		$this->weatherDesc = $data['weather'][0]['description'] ?? '--';
		$this->tempCurrent = $data['main']['temp'] ?? '--';
		$this->tempMin = $data['main']['temp_min'] ?? '--';
		$this->tempMax = $data['main']['temp_max'] ?? '--';
		$this->windSpeed = $data['wind']['speed'] ?? '--';
		$this->windDir = $data['wind']['deg'] ?? '--';
    }

}
