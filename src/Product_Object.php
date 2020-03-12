<?php
namespace igun997\Objects;
/**
 * Product_Object
 */
class Product_Object
{

  public $productId;
  public $productClientId;
  public $name;
  public $description;
  public $SKUs;
  public $subCategory;
  public $attributeChoiceIds;
  private $isSubFetch;
  private $subCategory_detail;

  function __construct($data)
  {

    $this->isSubFetch = false;
    $this->productId = $data["productId"];
    $this->productClientId = $data["productClientId"];
    $this->name = $data["name"];
    $this->description = $data["description"];
    $this->SKUs = $data["SKUs"];
    $this->subCategory = $data["subCategory"];
    $this->attributeChoiceIds = $data["attributeChoiceIds"];
    $this->subCategory_detail = [];

  }
  public function getSubCategories(Zilingo $zilinggo,String $colorId = null,String $sizeId = null)
  {
    if ($this->isSubFetch == false) {

      $req = $zilinggo::request("/api/v1/subCategories/byId/".$this->subCategory["id"],null);

      $this->isSubFetch = true;
      $this->subCategory_detail = $req;
      $obj = $this->subCategory_detail;

    }else {

      $obj = $this->subCategory_detail;
    }
    if ($colorId == null && $sizeId == null) {

      return $obj;

    }else {

      $new = [];

      $new["colorName"] = null;
      $new["sizeName"] = null;

      foreach ($obj["colors"] as $key => $value) {
        if ($value["id"] == $colorId) {
          $new["colorName"] = $value["name"];
          break;
        }
      }

      foreach ($obj["sizes"] as $key => $value) {

        if ($value["id"] == $sizeId) {

          $new["sizeName"] = $value["name"];

          break;

        }
      }

      return $new;

    }

  }
  public function getSkus()
  {

    $newBuild = [];

    if ($this->SKUs !== null) {

      if (count($this->SKUs) > 0) {

        foreach ($this->SKUs as $key => $value) {

          $value["productId"] = $this->productId;
          $value["name"] = $this->name;
          $value["description"] = $this->description;
          $newBuild[] = $value;

        }

        return $newBuild;

      }else {

        return false;

      }
    }else {

      return false;

    }
  }
}
