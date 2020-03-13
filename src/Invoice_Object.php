<?php
namespace igun997\Objects;
/**
 * Invoice Object
 */
class Invoice_Object
{

  public $subOrderId;
  public $shippableUnitId;
  public $orderId;
  public $sellerId;
  public $userAddress;
  public $orderedAt;
  public $orderItems;
  public $subOrderAmount;
  public $appliedCoupon;
  public $paymentMode;
  public $deliveryAddress;


  function __construct($data)
  {

    $this->subOrderId = $data["subOrderId"];
    $this->shippableUnitId = $data["shippableUnitId"];
    $this->orderId = $data["orderId"];
    $this->sellerId = $data["sellerId"];
    $this->userAddress = $data["userAddress"];
    $this->orderedAt = $data["orderedAt"];
    $this->orderItems = $data["orderItems"];
    $this->subOrderAmount = (isset($data["subOrderAmount"]))?$data["subOrderAmount"]:null;
    $this->appliedCoupon = (isset($data["appliedCoupon"]))?$data["appliedCoupon"]:null;
    $this->paymentMode = $data["paymentMode"];
    $this->deliveryAddress = $data["deliveryAddress"];

  }



}
