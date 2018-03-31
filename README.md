Official API repository for Tradexat APIs
Version: 1.0.0 (stable)

## Examples:

### List all powers:
* api.php?action=powers


### List powers by category:
* api.php?action=list_powers&category=CATEGORY_HERE
* Categories available are: 
  * category=unlimited
  * category=limited
  * category=group
  * category=hug
  * category=game
  * category=epic
  * category=allp


### Search a power:
* api.php?action=search_power&power=POWER_VALUES
* POWER_VALUES you can use power name or ID


You also can add ?type=TYPE_HERE
* Available methods:
  * type=xml
  * type=json
  * type=csv
