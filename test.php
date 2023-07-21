<html>
       <head>
             <title>show-hide-div-on-click-using-jquery</title>
             <script src="http://code.jquery.com/jquery-latest.js"></script>
             <script type="text/javascript">
                 $(document).ready(function () {
                    $('#id_radio1').click(function () {
                       $('#div2').hide('fast');
                       $('#div1').show('fast');
                });
                $('#id_radio2').click(function () {
                      $('#div1').hide('fast');
                      $('#div2').show('fast');
                 });
               });
            </script>
            <script>
            $('document').ready(function(){
                $('input[name="rep"]').change(function(){
                var val = $('input[name="rep"]:checked').val();
                $('.form-group.triggerDiv').hide();
                $('.form-group.triggerDiv.type_'+val).show();
                });

                var val_ref = $('input[name="rep"]:checked').val();
                $('.form-group.triggerDiv.type_'+val_ref).show();
            });
            </script>            
</head>

<body>
     <center>
             <h2>show hide div on click using jquery</h2>
              <div style="padding:25px;width: 100px;">
                   <input id="id_radio1" type="radio" name="name_radio1" value="value_radio1" />Radio1
                   <input id="id_radio2" type="radio" name="name_radio1" value="value_radio2" />Radio2
              </div>
              <div align="center" style="padding:25px;width: 300px;">
                   <div id="div1">This is First (1st) division</div>
                   <div id="div2">This is Second (2nd) division</div>
              </div>
     </center>
</body>
</html>

<div class="form-group">
  <label class="col-sm-4 control-label" for=""></label>
  <div class="col-sm-8">
    <div class="input-group">
      <input type="radio" name="rep" class="minimal" value="none">
      None<br>
      <input type="radio" name="rep" class="minimal" value="daily">
      Daily<br>
      <input type="radio" name="rep" class="minimal" value="weekly">
      Weekly<br>
    </div>
  </div>
</div>

<div class="form-group triggerDiv type_none" style="display: none;">
  <label class="col-sm-4 control-label" for=""></label>
  <div class="col-sm-8">
    Test None
  </div>
</div>
<div class="form-group triggerDiv type_daily" style="display: none;">
  <label class="col-sm-4 control-label" for=""></label>
  <div class="col-sm-8">
    Test Daily
  </div>
</div>
<div class="form-group triggerDiv type_weekly" style="display: none;">
  <label class="col-sm-4 control-label" for=""></label>
  <div class="col-sm-8">
    Test Weekly
  </div>
</div>