<?php

namespace TochkaApi\Models;


/**
 * Class Customer
 * @package TochkaApi\Models
 */
class Customer extends BaseModel
{

    /**
     * @var string
     */
    protected $type = "open-banking";

    /**
     * @var string
     */
    protected $instance = "customers";
}