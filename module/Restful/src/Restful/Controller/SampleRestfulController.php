<?php
/**
 * Created by PhpStorm.
 * User: phoenix
 * Date: 7/05/17
 * Time: 08:08 PM
 */

namespace Restful\Controller;


use Zend\Mvc\Controller\AbstractRestfulController;

class SampleRestfulController extends AbstractRestfulController
{
    /**
     * @inheritDoc
     */
    public function getResponseWithHeader()
    {
        $response = $this->getResponse();
        $response->getHeaders()
            // make can accessed by *
            ->addHeaderLine('Access-Control-Allow-Origin', '*')
            // set allow methods
            ->addHeaderLine('Access-Control-Allow-Methods', 'GET DELETE POST PUT');
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function create($data)
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__.' create new item of data : <b>'.$data['name'].'</b>');
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__.' delete current data with id = '.$id);
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__.' get current data with id = '.$id);
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function getList()
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__.' get the list of data');
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function update($id, $data)
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__.' update current data with id = '.$id.' with data of name is '.$data['name']);
        return $response;
    }

}