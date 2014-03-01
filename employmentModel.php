<?php

class EmploymentModel
{

	private $IndustryID; 
	private $Year; 
	private $RegionID; 
	private $Value; 
	
	public function __construct($IndustryID, $Year, $RegionID, $Value){
		$this->IndustryID = $IndustryID; 
		$this->Year = $Year; 
		$this->RegionID = $RegionID; 
		$this->Value = $Value; 
	}

	public function setIndustryID($IndustryID){
		$this->IndustryID = $IndustryID; 
	}

	public function getIndustryID(){
		return $this->IndustryID; 
	}

	public function setYear($Year){
		$this->Year = $Year; 
	}

	public function getYear(){
		return $this->Year; 
	}

	public function setRegionID($RegionID){
		$this->RegionID = $RegionID; 
	}

	public function getRegionID(){
		return $this->RegionID; 
	}	

	public function setValue($Value){
		$this->Value= $Value; 
	}

	public function getValue(){
		return $this->Value; 
	}

}

?>