<?
namespace App;

require_once './server/test.php';


use Sanity\Basic as Sanity;
use Sanity\Extended as Sanity2;
use Sanity\Low\Basic as Low;

Sanity::say();
Sanity2::say();
Low::say();

?>