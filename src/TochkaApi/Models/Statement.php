<?php

namespace TochkaApi\Models;


/**
 * Class Statement
 * @package TochkaApi\Models
 */
class Statement extends BaseModel
{

    /**
     * @var string
     */
    protected $type = "open-banking";

    /**
     * @var string
     */
    protected $instance = "statements";
}