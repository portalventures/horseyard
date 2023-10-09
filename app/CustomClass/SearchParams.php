<?php

namespace App\CustomClass;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class SearchParams
{
  public $top_category;
  public $sortBy = "a_z";
  public $perPage = 20;
  public $minPrice = 0;
  public $maxPrice = 0;
  public $selectedDiscipline = [];
  public $selectedBreed = [];
  public $selectedColor = [];
  public $selectedGender = [];
  public $selectedLocation = [];
  public $selectedMinHeight = '';
  public $selectedMaxHeight = '';
  public $selectedMinAge = '';
  public $selectedMaxAge = '';
  public $selectedRiderLevel = [];
  public $selectedTransportType = [];
  public $selectedHorseNumber = [];
  public $selectedRampLocation = [];
  public $selectedPropertyType = [];
  public $selectedPropertyCategory = [];
  public $selectedBedrooms = [];
  public $selectedBathrooms = [];
  public $selectedSaddleryType = [];
  public $selectedSaddleryCategory = [];
  public $selectedSaddleryCondition = [];
  public $keywordTxt = "";
  public $TitleTxt = "";

  public function resetSearchTerms() {
    $this->sortBy = "a_z";
    $this->quick_search_type = "";
    $this->perPage = 20;
    $this->minPrice = 0;
    $this->maxPrice = 0;
    $this->top_category = [];
    $this->keywordTxt = "";
    $this->TitleTxt = "";
    
    /*horses*/
    $this->selectedMinHeight = '';
    $this->selectedMaxHeight = '';
    $this->selectedMinAge = '';
    $this->selectedMaxAge = '';

    $this->selectedBreed = [];
    $this->selectedColor = [];
    $this->selectedDiscipline = [];
    $this->selectedGender = [];
    $this->selectedLocation = [];
    $this->selectedRiderLevel = [];

    /*transport*/
    $this->selectedTransportType = [];
    $this->selectedHorseNumber = [];
    $this->selectedRampLocation = [];

    /*saddlery*/
    $this->selectedSaddleryType = [];
    $this->selectedSaddleryCategory = [];
    $this->selectedSaddleryCondition = [];
    
    /*property*/
    $this->selectedPropertyType = [];
    $this->selectedBedrooms = [];
    $this->selectedBathrooms = [];
    $this->selectedPropertyCategory = [];
  }
}
