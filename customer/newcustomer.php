<?php
  require_once '../vendor/autoload.php';
  
  $url = 'https://yourwebsite.com';
  $key  = 'YOUR_SECRET_KEY';
  $debug = false;

  $webService = new PrestaShopWebservice($url, $key, $debug);
  $xmlResponse = $webService->get(['url' => $url . '/api/customers?schema=blank']);
  $customerXML = $xmlResponse->customer[0];

  $customerXML->lastname = 'DOE';
  $customerXML->firstname = 'John';
  $customerXML->id_default_group = 3; // 3 = customer group. See http://doc.prestashop.com/display/PS16/Customer+Groups to understand better PrestaShop customer groups
  $customerXML->id_lang = 1; // to map with your App/Website/CRM/etc
  $customerXML->passwd = 'Paris';
  $customerXML->email = 'customer.email@gmail.com';
  $customerXML->active = 1;

  try {
    $addedCustomerResponse = $webService->add([
      'resource' => 'customers',
      'postXml' => $xmlResponse->asXML()
    ]);
    $customerXML = $addedCustomerResponse->customer[0];
    echo sprintf("Successfully create customer with ID: %s\n", (string) $customerXML->id);
  } catch (PrestaShopWebserviceException $e) {
        echo $e->getMessage();
  }
