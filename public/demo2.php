<?

  $mrh_login = "arabiaufa";
  $mrh_pass1 = "nOedgM87lp2rm0JeXB6F";
  $inv_id = 678678;
  $inv_desc = "Товары для животных";
  $out_summ = "100.00";
  $IsTest = 1;
  $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
  print "<html><script language=JavaScript ".
      "src='https://auth.robokassa.ru/Merchant/PaymentForm/FormMS.js?".
      "MerchantLogin=$mrh_login&OutSum=$out_summ&InvoiceID=$inv_id".
      "&Description=$inv_desc&SignatureValue=$crc&IsTest=$IsTest'></script></html>";

exit;

// 2.
// Оплата заданной суммы с выбором валюты на сайте ROBOKASSA
// Payment of the set sum with a choice of currency on site ROBOKASSA

// регистрационная информация (логин, пароль #1)
// registration info (login, password #1)
$mrh_login = "arabiaufa";
$mrh_pass1 = "nOedgM87lp2rm0JeXB6F";

// номер заказа
// number of order
$inv_id = 1;

// описание заказа
// order description
$inv_desc = "Test order";

// сумма заказа
// sum of order
$out_summ = '13.37';

// тип товара
// code of goods
$shp_item = "2";

// предлагаемая валюта платежа
// default payment e-currency
$in_curr = "";

// язык
// language
$culture = "ru";

// формирование подписи
// generate signature
$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");
$crc  = md5("$mrh_login:$out_summ:$mrh_pass1:Shp_item=$shp_item");

// форма оплаты товара
// payment form
print "<html>".
      "<form action='https://merchant.roboxchange.com/Index.aspx' method=POST>".
      "<input type=text name=MrchLogin value=$mrh_login>".
      "<input type=text name=OutSum value=$out_summ>".
      "<input type=text name=InvId value=$inv_id>".
      "<input type=text name=Desc value='$inv_desc'>".
      "<input type=text name=SignatureValue value=$crc>".
      "<input type=text name=Shp_item value='$shp_item'>".
      "<input type=text name=IncCurrLabel value=$in_curr>".
      "<input type=text name=Culture value=$culture>".
      "<input type=submit value='Pay'>".
      "</form></html>";
?>