<?php

namespace TochkaApi\Models;


/**
 * Class Balance
 * @package TochkaApi\Models
 */
class Balance extends BaseModel
{

    /**
     * @var string
     */
    protected $type = "open-banking";

    /**
     * @var string
     */
    protected $instance = "balances";

    /**
     * @return array
     * @throws \TochkaApi\Exceptions\BaseApiException
     */
    public function get()
    {
        $this->validateIdRequired();

        return (new Account($this->getApi(), $this->getId()))->balances();
    }
}