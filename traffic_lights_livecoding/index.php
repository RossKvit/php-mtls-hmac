<?php
require 'TrafficLightsController.php';
//require 'TrafficLights.php';

$trafficLightsController = new TrafficLightsController();
$trafficLightsController->printTwoTrafficLightsValues('00:01:46');