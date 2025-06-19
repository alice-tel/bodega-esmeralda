<?php

namespace App\Http\Controllers;

use App\Models\HumidityMeasurements;
use App\Models\TemperaturesMeasurements;
use \DOMDocument;
use \DOMElement;
use Illuminate\Support\Facades\Log;

class ExportDataController extends Controller
{
    private const ROOT_NAME = 'measurements';
    private const MEASUREMENT_ELEMENT_NAME = 'measurement';
    public function exportData(){
        $temperatures = TemperaturesMeasurements::all();
        $humidities = HumidityMeasurements::all();

        $xml = new DOMDocument();
        $root = $this->addRoot($xml, self::ROOT_NAME);

        if (!$temperatures->isEmpty())
            $root->appendChild($this->createElementFromModels($xml, TemperaturesMeasurements::TABLE_NAME, $temperatures));
        if (!$humidities->isEmpty())
            $root->appendChild($this->createElementFromModels($xml, HumidityMeasurements::TABLE_NAME, $humidities));

        $xml->formatOutput = true;

        $resultXML = $xml->saveXML();
        return response()->streamDownload(function () use ($resultXML) {
            echo $resultXML;
        }, 'measurements.xml');
    }

    private function addRoot(DOMDocument $xml, string $name): DOMElement{
        $root = $xml->createElement($name);
        return $xml->appendChild($root);
    }

    private function createElementFromModels(DOMDocument $xml, $modelName, $modelEntries): DOMElement {
        $modelMainElement = $xml->createElement($modelName);
        foreach($modelEntries as $modelEntry){
            $modelEntryElement = $xml->createElement(self::MEASUREMENT_ELEMENT_NAME);
            $modelEntryElement = $modelMainElement->appendChild($modelEntryElement);

            foreach ($modelEntry->toArray() as $key => $value){
                $modelEntryValueElement = $xml->createElement($key, $value);
                $modelEntryElement->appendChild($modelEntryValueElement);
            }
        }
        return $modelMainElement;
    }
}
