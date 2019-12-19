<?php
  require_once '../vendor/autoload.php';

  $url = 'https://yourwebsite.com';
  $key  = 'YOUR_SECRET_KEY';
  $debug = false;

  $webService = new PrestaShopWebservice($url, $key, $debug);
  $xmlResponse = $webService->get(['resource' => 'customers', 'id' => 1]);

  $customerXML = $xmlResponse->customer[0];
  $customerXML->firstname = 'Carmen';
  $customerXML->lastname = 'Sandiego';
  $customerXML->passwd = 'Rome1';

  try {
    $updatedCustomerResponse = $webService->edit([
      'resource' => 'customers',
      'id' => (int) $customerXML->id,
      'putXml' => $xmlResponse->asXML(),
    ]);
    $customerXML = $updatedCustomerResponse->customer[0];
    echo sprintf("Successfully updated customer with ID: %s\n", (string) $customerXML->id);
  } catch (PrestaShopWebserviceException $e) {
    echo $e->getMessage()."\n";
  }
