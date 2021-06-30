<?php

namespace TochkaApi\Models;


class Custom extends BaseModel
{
    /**
     * @param $method
     * @param $url
     * @param array $data
     * @return array
     */
    public function request($method, $url, $data = [])
    {
        $this->addCustomerCodeHeader();

        return $this->getApi()->apiRequest($method, $url, $data);
    }
}