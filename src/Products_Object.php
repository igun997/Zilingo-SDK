<?php
namespace igun997\Objects;
/**
 * Product_Object
 */
class Products_Object
{
  public $approvedProducts;
  public $delistedProducts;
  function __construct($data)
  {

    $this->approvedProducts = (isset($data["approvedProducts"])) ?$data["approvedProducts"]:null;
    $this->delistedProducts = (isset($data["delistedProducts"])) ?$data["delistedProducts"]:null;
  }
  public function getApproved()
  {
    $res = [];
    if ($this->approvedProducts != null) {
      foreach ($this->approvedProducts as $key => $value) {
        $res[] = new Product_Object($value);
      }
    }

    return $res;
  }
  public function getDelisted()
  {
    $res = [];
    if ($this->delistedProducts != null) {
      foreach ($this->delistedProducts as $key => $value) {
        $res[] = new Product_Object($value);
      }
    }
    return $res;
  }
}
