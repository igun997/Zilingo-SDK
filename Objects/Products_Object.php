<?php
namespace Objects;
/**
 * Product_Object
 */
class Products_Object
{
  public $approvedProducts;
  public $delistedProducts;
  function __construct($data)
  {
    $this->approvedProducts = $data["approvedProducts"];
    $this->delistedProducts = $data["delistedProducts"];
  }
  public function getApproved()
  {
    $res = [];
    foreach ($this->approvedProducts as $key => $value) {
      $res[] = new Product_Object($value);
    }
    return $res;
  }
  public function getDelisted()
  {
    $res = [];
    foreach ($this->delistedProducts as $key => $value) {
      $res[] = new Product_Object($value);
    }
    return $res;
  }
}
