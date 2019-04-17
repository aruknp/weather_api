<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use \App\Utils\Weather;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="landing_index")
     */
    public function indexAction()
    {
		return $this->render('index/index.html.twig');
    }
	

	/** 
	 * @Route("/index/ajax", name="weather_ajax", methods={"POST"}) 
	 */ 
	public function ajaxAction(Request $request) {
		if ($request->isXmlHttpRequest() ) {
			
			$error = false;
			$status = 'success';
			$message = '';
			$weather = false;
			$html_content = '';

			$api = $request->request->get('api_code');
			$city = $request->request->get('api_city');
			
			if ( !$api || !$city ) {
				$error = true;
				$status = 'error';
				$message = 'Missing Data';
			}
			
			if ( !$error ) {
				$weather_url = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api";
				//for testing success result
				//$weather_url = "https://samples.openweathermap.org/data/2.5/weather?q=$city&appid=$api";

				try {
					$json_response = file_get_contents( $weather_url );
				} catch (\Exception $e) {
					$error = true;
					$status = 'error';
					$message = 'General exception: '.$e->getMessage().' (Code '.$e->getCode().').';
				}
			}

			if ( !$error ) {
				$weather = new Weather($json_response);
				$html_content = self::getWeatherReponsemHtml($weather);
			}

			$jsonData = array(
				'tab_label' => ($weather? $weather->cityName: '--'),
				'tab_content' => $html_content,
				'status' => $status,
				'message' => $message,
			);

			return new JsonResponse($jsonData);
		}
	}
	
	/**
	 * Form html result string with main data from weather object
	 * @param type $weather object
	 * @return string
	 */
	private static function getWeatherReponsemHtml( $weather ) {
		
		$result = '';
		
		if ( !$weather ) {
			return $result;
		}

		$result = "<table>";
			$result .= "<tr><td>Timestamp:</td><td>". date('Y-m-d H:i:s') ."</td></tr>";
			$result .= "<tr><td>Weather:</td><td>$weather->weatherDesc</td></tr>";
			$result .= "<tr><td>Current Temparature:</td><td> $weather->tempCurrent K</td></tr>";
			$result .= "<tr><td>Min Temparature:</td><td> $weather->tempMin K</td></tr>";
			$result .= "<tr><td>Max Temparature:</td><td> $weather->tempMax K</td></tr>";
			$result .= "<tr><td>Wind Speed:</td><td> $weather->windSpeed m/s</td></tr>";
			$result .= "<tr><td>Wind Direction:</td><td> $weather->windDir</td></tr>";
			$result .= "<tr><td>City:</td><td>$weather->cityName</td></tr>";
		$result .= "</table>";
		
		return $result;
	}
}