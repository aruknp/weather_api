<?php

namespace App\Utils;

use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Weather class used to hold the current weather data.
 */
class Weather
{
    /**
     * The city object.
     *
     * @var Util\City
     */
    public $cityName;

    /**
     * The temperature object.
     *
     * @var Util\Temperature
     */
    public $weatherDesc;
	
	/**
     * The temperature object.
     *
     * @var Util\Temperature
     */
    public $tempCurrent;

	/**
     * The temperature object.
     *
     * @var Util\Temperature
     */
    public $tempMin;
	
	/**
     * The temperature object.
     *
     * @var Util\Temperature
     */
    public $tempMax;

    /**
     * @var Util\Wind
     */
    public $windSpeed;
	
	/**
     * @var Util\Wind
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
