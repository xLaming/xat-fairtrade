<?php
/**
 * *** TRADEXAT APIs ***
 * This class is a way to provide you a few tools that will make your life easier;
 * It is simple, but we'll improving it as well...
 * @copyright MIT License. Copyright (c) 2018 Paulo Rodriguez
 * @author Paulo Rodriguez(xLaming)
 * @link https://github.com/xLaming/xat-fairtrade
 * @version 1.0 (stable)
 */

class API
{

  /**
   * This function is used to load pages using cURL method.
   * @param  string $url
   * @return string
   */
  private function loadPage($url)
  {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

  /**
   * This function is used to search powers in fairtrade's database;
   * It works using power name or ID;
   * You can set type xml or json
   * @param  mixed $power
   * @param  string $type
   * @return mixed
   */
  public function searchPower($power, $type = 'json')
  {
    if (empty($power))
    {
      return 'Power name cannot be empty!';
    }
    $page = $this->loadPage("https://xat.trade/api.php?action=search_power&power={$power}&type={$type}");
    $json = json_decode($page, true);
    if ($json['status'] == 'fail')
    {
      if ($json['message'] == 'power_not_found')
      {
        return 'This power does not exists!';
      }
      else
      {
        return 'Unknown error!';
      }
    }
    return $json['power'];
  }

  /**
   * This function is used to list all powers by categories;
   * Categories available are: unlimited, limited, group, hug, game, epic, allp
   * You can set type xml or json
   * @param  string $cat
   * @param  string $type
   * @return mixed
   */
  public function listPowersByCategory($cat, $type = 'json')
  {
    if (empty($cat))
    {
      return 'Category cannot be empty!';
    }
    $page = $this->loadPage("https://xat.trade/api.php?action=list_powers&category={$cat}&type={$type}");
    $json = json_decode($page, true);
    if ($json['status'] == 'fail')
    {
      if ($json['message'] == 'invalid_category')
      {
        return 'This category does not exists!';
      }
      else
      {
        return 'Unknown error!';
      }
    }
    return $json['powers'];
  }

  /**
   * This function will list all powers;
   * You can set type xml or json
   * @param  string $type
   * @return array
   */
  public function listPowers($type = 'json')
  {
    $page = $this->loadPage("https://xat.trade/api.php?action=powers&type={$type}");
    $json = json_decode($page, true);
    return $json['powers'];
  }
}

$API = new API();

/**
 * Some examples will be listed above, so you can see how it works:
 *
 * => Looking for a power via name:
 * $API->searchPower('gold');
 *
 * => Looking for a power via id:
 * $API->searchPower(153);
 *
 * => Listing all powers by categories:
 * $API->listPowersByCategory('limited');
 * $API->listPowersByCategory('unlimited');
 * $API->listPowersByCategory('epic');
 * $API->listPowersByCategory('game');
 * $API->listPowersByCategory('group');
 *
 * => Listing all powers:
 * $API->listPowers();
 *
 */
?>
