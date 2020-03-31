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

  public function recent(Array $old,Array $range)
  {
    $recent = [];

    $count = 0;

    foreach ($this->results as $key => $value) {

      if (!in_array($value["shippableUnitId"],$old)) {

        $createdAt = strtotime($value["createdAt"]);

        if ($createdAt >= $range[0] && $createdAt <= $range[1]) {
          $recent[] = $value;
          $count++;
        }

      }

    }

    $this->totalCount = $count;
    $this->results = $recent;
  }

}
