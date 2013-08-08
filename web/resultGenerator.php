<?php
  include_once 'transportType.class.php';
  include_once 'route.class.php';
  
  
  include 'tflxmlparser.php'; //not once
  ?>
          <table class='table' style='width: 360px; margin: auto;'>
            <thead>
              <th></th>
              <th><b>Start</b></th>
              <th><b>End</b></th>
              <th><b>Duration</b></th>
              <th><b>Cost</b></th>
              <th></th>
            </thead>
            <tbody>
              <?php
                $i = 1;
    
                foreach ($routes as $routeElement) {
                  ?>
                  <tr>
                    <td><b><?php echo $i ?></b></td>
                    <td><?php echo $routeElement->departure ?></td>
                    <td><?php echo $routeElement->arrival   ?></td>
                    <td><?php echo $routeElement->duration  ?></td>
                    <td>&pound;<?php printf("%01.2f", $routeElement->cost/100)?></td>
                    <td><a href="<?php echo $routeElement->detailsLink ?>">Details</a></td>
                  </tr>
                  <tr>
                    <td colspan="6" style="border-top: none;">
                      <b>Interchanges:</b>
                      <div style="float: right;">
                        <?php foreach ($routeElement->interchanges as $interchange) {
                          echo '<img src="' . transportType::$imgDomain
                          . $interchange->imgURI . '" alt="'
                          . $interchange->englishName . '" />';
                        } ?>
                      </div>
                    </td>
                  </tr>
                  <?php $i++;
                }
              ?>
            </tbody>
          </table>
          <hr style='width: 360px; margin: auto; margin-bottom: 25px' />
        <?php if($invalidPostcode) { ?>
          <h3> Invalid Postcode </h3>
        <?php }
        
?>