
<?php
/*
* Plugin Name: Cashflow Over Years
* Description: Calculate Cashflow after a certain number of Years.
* Version: 1.0
* Author: Preston Wallace
* Author URI: http://prestonwallace.com
*/

// Example 1 : WP Shortcode to display form on any page or post.
function calc_cashflow_years_dollars(){
  if( isset($_GET['submit']) ) {
    echo "<h2> Results </h2>";

    $startingSavings = htmlentities($_GET['startingSavings']);
    $savingPerYear = htmlentities($_GET['savingPerYear']);
    $cashflowPerHouse = htmlentities($_GET['cashflowPerHouse']);
    $houseCount = htmlentities($_GET['houseCount']);
    $numYears = htmlentities($_GET['numYears']); 
    $cashDownPerHouse = htmlentities($_GET['cashDownPerHouse']);


    function calculateCashflow($startingSavings = 0, $savingPerYear = 0, $cashflowPerHouse = 0, $houseCount = 0, $numYears = 10, $cashDownPerHouse = 20000) {
      setlocale(LC_MONETARY,"en_US");
      $currYear = 1;
      $currCash = $startingSavings;
      $valueEachHouse = $cashDownPerHouse * 4;

      echo "STARTING Cash: <strong>" . money_format("%(.0n",$currCash) . "</strong></br>"; 
      echo "STARTING Rental Property Count: <strong>" . $houseCount . "</strong></br>";
      echo "NON-REAL ESTATE Savings Per Year: <strong>" . money_format("%(.0n",$savingPerYear) . "</strong></br>";
      echo "Assumed Cashflow Per House: <strong>" . money_format("%(.0n",$cashflowPerHouse) . "</strong></br>";
      echo "Cash Down Needed Per House: <strong>" . money_format("%(.0n",$cashDownPerHouse) . "</strong></br>";
      echo "Approximate value/cost per house: <strong>" . money_format("%(.0n",$valueEachHouse) . "</strong></br></br>";

      $annualRealEstateCashFlow = 0;
      while($currYear <= $numYears){
        $annualRealEstateCashFlow = $cashflowPerHouse * $houseCount;
        $currCash = $currCash + $savingPerYear + $annualRealEstateCashFlow;
    
        $numHousesToBuy = floor($currCash / $cashDownPerHouse);
        if($currCash > $cashDownPerHouse) {
          $houseCount += $numHousesToBuy;
          $currCash -= $cashDownPerHouse * $numHousesToBuy;
        }
        echo "Cash at end of year $currYear: <strong>" . money_format("%(.0n",$currCash) . "</strong></br>"; 
        echo "House Count at end of year $currYear: <strong>" . $houseCount . "</strong></br>";
        echo "Total RE Portfolio Value at end of year $currYear: <strong>" . money_format("%(.0n",($valueEachHouse * 0.75 * $houseCount)) . "</strong></br>";
        echo "Annual Real Estate Cash Flow at end of year $currYear: <strong>" . money_format("%(.0n",$annualRealEstateCashFlow) . "</strong></br></br>";
        $currYear++;
      }
    
      return $annualRealEstateCashFlow;
      
    }
    
    calculateCashflow($startingSavings, $savingPerYear, $cashflowPerHouse, $houseCount, $numYears, $cashDownPerHouse);
    echo "</br> Choose Different Numbers: <a href=\"#\">Try Again</a>";
  } 
  else {
    
    echo "
      <form>
      Starting Savings: <input type=\"text\" name=\"startingSavings\"><br>

      Savings Per Year: <input type=\"text\" name=\"savingPerYear\">(amount you can set aside apart from real estate investing) <br> 

      Annual Cashflow Per Property: <input type=\"text\" name=\"cashflowPerHouse\">(amount you expect to make, per property, once ALL expenses are paid)<br>

      Starting Rental Property Count: <input type=\"text\" name=\"houseCount\"><br>

      Number of Years to Calculate Off Of: <input type=\"text\" name=\"numYears\"><br>

      Cash Down Per House: <input type=\"text\" name=\"cashDownPerHouse\"><br>


      <input type=\"submit\" name=\"submit\" value=\"submit\" >
      </form>
      ";
  }
};
add_shortcode('cashflow-years', 'calc_cashflow_years_dollars');
?> 
