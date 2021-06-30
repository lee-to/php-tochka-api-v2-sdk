<?php

namespace TochkaApi\Models;

use TochkaApi\Api;
use TochkaApi\Exceptions\BaseApiException;

/**
 * Class BaseModel
 * @package TochkaApi\Models
 */
class BaseModel
{

    /**
     * @var
     */
    private $api;

    /**
     * @var
     */
    protected $type;

    /**
     * @var
     */
    protected $instance;

    /**
     * @var null
     */
    protected $id = null;

    /**
     * @var null
     */
    protected $customerCode = null;

    /**
     * BaseModel constructor.
     * @param Api $api
     * @param null $id
     * @param null $customerCode
     */
    public function __construct(Api $api, $id = null, $customerCode = null)
    {
        $this->setApi($api);
        $this->setId($id);
        $this->setCustomerCode($customerCode);
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param Api $api
     */
    public function setApi($api)
    {
        $this->api = $api;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @param mixed $instance
     */
    public function setInstance($instance)
    {
        $this->instance = $instance;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getCustomerCode()
    {
        return $this->customerCode;
    }

    /**
     * @param null $customerCode
     */
    public function setCustomerCode($customerCode)
    {
        $this->customerCode = $customerCode;
    }

    /**
     * @throws BaseApiException
     */
    protected function validateIdRequired()
    {
        if(is_null($this->getId())) {
            throw new BaseApiException("ID is required");
        }
    }

    protected function addCustomerCodeHeader()
    {
        if($this->getCustomerCode()) {
            $this->getApi()->setHeaders([
                "customer-code" => $this->getCustomerCode()
            ]);
        }
    }

    /**
     * @return array
     * @throws BaseApiException
     */
    public function get()
    {
        $this->validateIdRequired();
        $this->addCustomerCodeHeader();

        return $this->getApi()->call(
            "GET",
            $this->getType(),
            $this->getInstance(),
            [],
            $this->getId()
        );
    }

    /**
     * @param array $query
     * @return array
     */
    public function all($query = [])
    {
        $this->addCustomerCodeHeader();

        return $this->getApi()->call("GET", $this->getType(), $this->getInstance(), $query);
    }

    /**
     * @param $data
     * @return array
     */
    public function create($data)
    {
        $this->addCustomerCodeHeader();

        return $this->getApi()->call("POST", $this->getType(), $this->getInstance(), $data);
    }

    /**
     * @param $data
     * @return array
     * @throws BaseApiException
     */
    public function update($data)
    {
        $this->validateIdRequired();
        $this->addCustomerCodeHeader();

        return $this->getApi()->call("POST", $this->getType(), $this->getInstance(), $data, $this->getId());
    }

    /**
     * @return array
     * @throws BaseApiException
     */
    public function delete()
    {
        $this->validateIdRequired();
        $this->addCustomerCodeHeader();

        return $this->getApi()->call("DELETE", $this->getType(), $this->getInstance(), [], $this->getId());
    }
}