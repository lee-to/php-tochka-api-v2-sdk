<?php

namespace TochkaApi\Models;


/**
 * Class Payment
 * @package TochkaApi\Models
 */
class Payment extends BaseModel
{

    /**
     * @var string
     */
    protected $type = "payment";

    /**
     * @param $data
     * @param bool $forSign
     * @return array
     */
    public function create($data, $forSign = true)
    {
        return $this->getApi()->call(
            "POST",
            $this->getType(),
            $forSign ? "for-sign" : "order",
            $data
        );
    }

    /**
     * @return array
     * @throws \TochkaApi\Exceptions\BaseApiException
     */
    public function get()
    {
        $this->validateIdRequired();

        return $this->getApi()->call(
            "GET",
            $this->getType(),
            "status",
            [],
            $this->getId()
        );
    }
}