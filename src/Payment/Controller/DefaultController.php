<?php

namespace Payment\Controller;

use Core\Model\ErrorModel;

class DefaultController extends \Core\Controller\DefaultController {

    protected $_shippingModel;

    public function returnPagSeguroAction() {
        $data['token'] = 'seutoken';
        $data['email'] = 'seuemail';
        $data['currency'] = 'BRL';
        $data['itemId1'] = '1';
        $data['itemQuantity1'] = '1';
        $data['itemDescription1'] = 'Produto de Teste';
        $data['itemAmount1'] = '299.00';

        $url = 'https://ws.pagseguro.uol.com.br/v2/checkout';

        $data = http_build_query($data);

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $xml = curl_exec($curl);

        curl_close($curl);

        $xml = simplexml_load_string($xml);
        if (count($xml->error) > 0) {
            $return = 'Dados Inválidos ' . $xml->error->message;
            echo $return;
            exit;
        }
        echo $xml->code;
        /*
         * <form id="comprar" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">
          <input type="hidden" name="code" id="code" value="" />
          </form>
          <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
         */
    }

}
