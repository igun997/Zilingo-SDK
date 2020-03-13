<?php
namespace igun997\Objects;
/**
 * Order_Object
 */
class Order_Object
{
   // rejected
   // cancelled
   // successfullyProcessed
   // awaitingConfirmation
   // awaitingPickupRequest
   // awaitingPickupSchedule
   // pickupScheduled
   // inTransit

  public $totalCount;
  public $results;


  function __construct($data)
  {

    $this->totalCount = $data["totalCount"];
    $this->results = $data["results"];

  }

  public function getInvoice(Zilingo $instance)
  {
    $res = [];
    foreach ($this->results as $key => $value) {
      $req = $instance::request("/api/v4/orders/invoice/".$value["shippableUnitId"]);
      $res[] = new Invoice_Object($req);
    }
    return $res;
  }

}
