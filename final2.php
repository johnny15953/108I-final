<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">

  <title>電子化流程設計與管理</title>
</head>

<body>

<?php
ini_set ("soap.wsdl_cache_enabled", "0");
$client = new SoapClient("http://140.133.78.60:8086/NaNaWeb/services/WorkflowService?wsdl");
if($_POST){
    if(
        !empty($_POST['oid'])
        && !empty($_POST['uid'])
        && !empty($_POST['eid'])
    ) {
        $oid = $_POST['oid'];
        $uid = $_POST['uid'];
        $eid = $_POST['eid'];
        $starttime = $_POST['starttime'];
        $endtime = $_POST['endtime'];
	try{
		
        $procesesStr = $client->findFormOIDsOfProcess($oid);
        $proceses = explode(",", $procesesStr);
        $process = $proceses[0];
        $template = $client->getFormFieldTemplate($process);
        $form = simplexml_load_string($template);
        $form->Textbox0 = $eid;
        $form->Textbox1 = $uid;
		$form->Textbox2 = $starttime;
		$form->Textbox3 = $endtime;
        $result = $form->asXML();
        $client->invokeProcess($oid, $eid, $uid, $process, $result, "出差申請");
	}catch(Exception $e){
		echo $e->getMessage();
	}
    } else{
        echo "系統錯誤";
    }
    
}
?>

  <div class="container">
    <div class="py-5 text-center">
      <h2>出差申請表</h2>
    </div>

    <div class="row">

      <div class="col-md-12 order-md-1">
        <h4 class="mb-3"></h4>
        <form class="needs-validation" method="POST" action="./index.php">
          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="eid">員工編號</label>
              <input name="eid" type="text" class="form-control" id="eid" placeholder="" value="" required>
              <div class="invalid-feedback">
                員工編號 必填
              </div>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="uid">員工單位編號</label>
                  <input name="uid" type="text" class="form-control" id="uid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    員工單位編號 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="oid">流程編號</label>
                  <input name="oid" type="text" class="form-control" id="oid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    流程編號 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="starttime">到職日</label>
                  <input name="starttime" type="date" class="form-control" id="starttime" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    範例輸入 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="endtime">離職日</label>
                  <input name="endtime" type="date" class="form-control" id="endtime" placeholder="" value="" >
                </div>
          </div>
          

          <hr class="mb-4">
          <button class="btn btn-primary btn-lg btn-block" type="submit">送出</button>
        </form>
      </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2017-2018 NKUST MIS</p>
    </footer>
  </div>

  <!-- Bootstrap core JavaScript
        ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict';
      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>

</html>