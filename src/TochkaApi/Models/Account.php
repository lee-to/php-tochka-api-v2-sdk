<?php

namespace TochkaApi\Models;


/**
 * Class Account
 * @package TochkaApi\Models
 */
class Account extends BaseModel
{

    /**
     * @var string
     */
    protected $type = "open-banking";

    /**
     * @var string
     */
    protected $instance = "accounts";


    /**
     * @param array $query
     * @return array
     */
    public function balances($query = [])
    {
        return $this->getApi()->call("GET", $this->getType(), $this->getInstance(), $query, $this->getId(), "balances");
    }

    /**
     * @param $id
     * @return array
     */
    public function statement($id)
    {
        return $this->getApi()->call("GET", $this->getType(), $this->getInstance(), [], $this->getId(), "statements", $id);
    }
}