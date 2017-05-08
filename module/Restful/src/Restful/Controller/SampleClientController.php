<?php
/**
 * Created by PhpStorm.
 * User: phoenix
 * Date: 7/05/17
 * Time: 08:50 PM
 */

namespace Restful\Controller;


use Zend\Http\Client as HttpClient;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Parameters;
use Zend\Uri\Uri as UriUri;

class SampleClientController extends AbstractActionController
{
    const ROOT_URL = 'http://api24.tst:80';

    const RESTFUL_RESOURCE_URI = '/restful';

    /**
     * @inheritDoc
     */
    public function indexAction()
    {
        $client = new HttpClient();
        $client->setAdapter('Zend\Http\Client\Adapter\Curl');

        $method = $this->params()->fromQuery('method', 'get');
        $client->setUri(self::ROOT_URL.$this->getRequest()->getBaseUrl().self::RESTFUL_RESOURCE_URI);

        switch($method) {
            case 'get' :
                $client->setMethod('GET');
                $client->setParameterGET(array('id'=>1));
                break;
            case 'get-list' :
                $client->setMethod('GET');
                break;
            case 'create' :
                $client->setMethod('POST');
                $client->setParameterPOST(array('name'=>'samsonasik'));
                break;
            case 'update' :
                $data = array('name'=>'ikhsan');
                $uri = $client->getUri().'?id=1';

                $request = new Request();
                $request->getHeaders()->addHeaders(array(
                    'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
                ));
                $request->setUri($uri);
                $request->setMethod('PUT');
                if ($data){
                    $request->setPost(new Parameters($data));
                }

                /*-
                $adapter = $client->getAdapter();

                $adapter->connect(self::ROOT_URL, 80);
                $uri = $client->getUri().'?id=1';
                echo '$uri :: '.$uri.' :: $method :: '.$method;
                // send with PUT Method, with $data parameter
                $adapter->write('PUT', new UriUri($uri), 1.1, array(), http_build_query($data));

                $responsecurl = $adapter->read();
                list($headers, $content) = explode("\r\n\r\n", $responsecurl, 2);
                -*/

                $responsehttp = $client->dispatch($request);
                list($headers, $content) = explode("\r\n\r\n", $responsehttp, 2);
                //-echo '$headers :: '.$headers.' :: $content :: '.$content.' :: $responsehttp->getBody :: '.utf8_decode($responsehttp->getBody());
                $response = $this->getResponse();

                $response->getHeaders()->addHeaderLine('content-type', 'text/html; charset=utf-8');
                //-$response->setContent($content);
                $response->setContent(utf8_decode($responsehttp->getBody()));

                return $response;
            case 'delete' :
                $uri = $client->getUri().'?id=1'; //send parameter id = 1

                $request = new Request();
                $request->getHeaders()->addHeaders(array(
                    'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
                ));
                $request->setUri($uri);
                $request->setMethod($method);

                /*-
                $adapter = $client->getAdapter();

                $adapter->connect(self::ROOT_URL, 80);
                $uri = $client->getUri().'?id=1'; //send parameter id = 1
                echo '$uri :: '.$uri.' :: $method :: '.$method;
                // send with DELETE Method
                $adapter->write('DELETE', new UriUri($uri), 1.1, array());

                $responsecurl = $adapter->read();
                list($headers, $content) = explode("\r\n\r\n", $responsecurl, 2);
                -*/

                $responsehttp = $client->dispatch($request);
                list($headers, $content) = explode("\r\n\r\n", $responsehttp, 2);
                //-echo '$headers :: '.$headers.' :: $content :: '.$content;
                $response = $this->getResponse();

                $response->getHeaders()->addHeaderLine('content-type', 'text/html; charset=utf-8');
                //-$response->setContent($content);
                $response->setContent(utf8_decode($responsehttp->getBody()));

                return $response;
            case 'update-deprecated' :
                $data = array('name'=>'ikhsan');
                $adapter = $client->getAdapter();

                //-$adapter->connect(self::ROOT_URL, 80);
                $adapter->connect('api24.tst', 80);
                $uri = $client->getUri().'?id=1';
                //-echo '$uri :: '.$uri.' :: $method :: '.$method;
                // send with PUT Method, with $data parameter
                $adapter->write('PUT', new UriUri($uri), 1.1, array(), http_build_query($data));

                $responsecurl = $adapter->read();
                list($headers, $content) = explode("\r\n\r\n", $responsecurl, 2);
                $response = $this->getResponse();

                $response->getHeaders()->addHeaderLine('content-type', 'text/html; charset=utf-8');
                $response->setContent($content);

                return $response;
            case 'delete-deprecated' :
                $adapter = $client->getAdapter();

                //-$adapter->connect(self::ROOT_URL, 80);
                $adapter->connect('api24.tst', 80);
                $uri = $client->getUri().'?id=1'; //send parameter id = 1
                //-echo '$uri :: '.$uri.' :: $method :: '.$method;
                // send with DELETE Method
                $adapter->write('DELETE', new UriUri($uri), 1.1, array());

                $responsecurl = $adapter->read();
                list($headers, $content) = explode("\r\n\r\n", $responsecurl, 2);
                $response = $this->getResponse();

                $response->getHeaders()->addHeaderLine('content-type', 'text/html; charset=utf-8');
                $response->setContent($content);

                return $response;
        }

        //if get/get-list/create
        $response = $client->send();
        if (!$response->isSuccess()) {
            // report failure
            $message = $response->getStatusCode() . ': ' . $response->getReasonPhrase();

            $response = $this->getResponse();
            $response->setContent($message);
            return $response;
        }
        $body = $response->getBody();

        $response = $this->getResponse();
        $response->setContent($body);

        return $response;
    }

}