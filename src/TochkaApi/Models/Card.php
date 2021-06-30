<?php

namespace TochkaApi\Models;


/**
 * Class Card
 * @package TochkaApi\Models
 */
class Card extends BaseModel
{

    /**
     * @var string
     */
    protected $type = "card";

    /**
     * @var string
     */
    protected $instance = "card";

    /**
     * @param array $query
     * @return array
     * @throws \TochkaApi\Exceptions\BaseApiException
     */
    public function limits($query = [])
    {
        $this->validateIdRequired();

        return $this->getApi()->call(
            "GET",
            $this->getType(),
            $this->getInstance(),
            $query,
            $this->getId(),
            "limits"
        );
    }

    /**
     * @param $data
     * @return array
     * @throws \TochkaApi\Exceptions\BaseApiException
     */
    public function state($data)
    {
        $this->validateIdRequired();

        return $this->getApi()->call(
            "POST",
            $this->getType(),
            $this->getInstance(),
            $data,
            $this->getId(),
            "state"
        );
    }
}