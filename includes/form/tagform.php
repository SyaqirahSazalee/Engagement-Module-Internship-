<!--Add Tag-->

<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#addtagform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var addtagname = document.getElementById("addtagname").value;
      var addtagdesc = document.getElementById("addtagdesc").value;
      
      var alldata = 
      {
        addtagname:addtagname,
        addtagdesc:addtagdesc
      };

      $.ajax({
        url: "ajax-addtag.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          if(obj.condition === "Passed"){
            $("#addtag").modal("hide");
            gettaginfo();
          }else{
            checkvalidity("addtagnameerror","#addtagnameerror", "#addtagname", obj.tagname);
            checkvalidity("addtagdescerror","#addtagdescerror", "#addtagdesc", obj.tagdesc);
          }
        }
      });
    });

    $("#addtag").on('hidden.bs.modal', function(){
      document.getElementById("addtagform").reset(); 
      clearform("#addtagnameerror", "addtagnameerror", "#addtagname");
      clearform("#addtagdescerror", "addtagdescerror", "#addtagdesc");
    });

    function gettaginfo()
    {
      $.ajax({
        url: "ajax-getviewtag.php",
        success:function(data){
          $("#showtaginfo").html(data);
        }
      });
    }

  });
</script>

<!--Modal for Add Tag-->
<div class="modal fade" id="addtag">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h6 class="modal-title text-white" id="scoreboardModalLabel">New Hashtag</h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="addtagform">
          <div class="form-group">
            <div class="row">
              <div class="col-2">Hashtag :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="addtagname" name="addtagname" autocomplete="off">
                <small><span id="addtagnameerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-2">Description :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="addtagdesc" name="addtagdesc" autocomplete="off">
                <small><span id="addtagdescerror"></span></small>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col text-right">
              <button name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm">Create</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Update Tag -->
<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#edittagform');

    $(document).on('click', ".editTag", function(){
      var tagID = $(this).data('id');
      $.ajax({
        url:"ajax-gettag.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{tagID:tagID},
        dataType:"json",
        success:function(data){
          console.log(data);
          $("#edittagid").val(data.tagID);
          $("#edittagname").val(data.tagname);
          $("#edittagdesc").val(data.tagdesc);
        }
      });
    });

    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();

      var edittagid = document.getElementById("edittagid").value;
      var edittagname = document.getElementById("edittagname").value;
      var edittagdesc = document.getElementById("edittagdesc").value;

      var alldata=
      {
        edittagid:edittagid,
        edittagname:edittagname,
        edittagdesc:edittagdesc
      };

      $.ajax({
        url: "ajax-edittag.php",
        type: "POST",
        data: alldata,
        dataType:"json",
        success:function(data){
          if(data.condition === "Passed"){
            $("#edittag").modal("hide");
            gettaginfo();
          }else{
            checkvalidity("edittagnameerror","#edittagnameerror", "#edittagname", obj.tagname);
            checkvalidity("edittagdescerror","#edittagdescerror", "#edittagdesc", obj.tagdesc);
          }
        }
      });
    });

    $("#edittag").on('hidden.bs.modal', function(){
      document.getElementById("edittagform").reset(); 
      clearform("#edittagnameerror", "edittagnameerror", "#edittagname");
      clearform("#edittagdescerror", "edittagdescerror", "#edittagdesc");
    });

    function gettaginfo()
    {
      $.ajax({
        url: "ajax-getviewtag.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#showtaginfo").html(data);
        }
      });
    }

  });
</script>

<!-- Modal for Edit Tag-->
<div class="modal fade" id="edittag">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h6 class="modal-title text-white" id="scoreboardModalLabel">Edit Hashtag</h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="edittagform">
          <input type="hidden" name="edittagid" id="edittagid">
          <div class="form-group">
            <div class="row">
              <div class="col-2">Hashtag :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="edittagname" name="edittagname" autocomplete="off">
                <small><span id="edittagnameerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-2">Description :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="edittagdesc" name="edittagdesc" autocomplete="off">
                <small><span id="edittagdescerror"></span></small>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col text-right">
              <button name="submit" id="edittagbutton" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </div>
          
        </form>
        
      </div>
    </div>
  </div>
</div>

<!-- Delete Tag -->
<script>
  $(document).ready(function(){

    $(document).on('click',".deleteTag",function(){
      var tagID = $(this).data('id');
      $.ajax({
        url:"ajax-gettag.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: {tagID:tagID},
        dataType: "json",
        success:function(data){
          $("#deletetagid").val(data.tagID);
          console.log(data.tagID);
        }
      });
    });

    var form = $('#deletetag');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var deletetagid = document.getElementById("deletetagid").value;
      var alldata = 
      {
        deletetagid:deletetagid,
      };

      $.ajax({
        url:"ajax-deletetag.php",
        type:"POST",
        data:alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $("#deletetag").modal("hide");
            gettaginfo();
          }
        }
      });
    });

    $("#deletetag").on('hidden.bs.modal', function(){
      document.getElementById("deletetagform").reset(); 
    });

    function gettaginfo()
    {
      $.ajax({
        url: "ajax-getviewtag.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#showtaginfo").html(data);
        }
      });
    }
  });
</script>

<!-- Modal for Delete Tag-->
<div class="modal fade" id="deletetag">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="scoreboardModalLabel">Delete Hashtag</h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="deletetagform">
          Are you sure you want to delete this Hashtag?
          <input type="hidden" class="form-control" name="deletetagid" id="deletetagid">
          <div class="row mt-3">
            <div class="col text-right">
              <button name="submit" value="deletetag" type="submit" class="btn btn-primary shadow-sm mx-1">Delete</button>
              <button type="button" class="btn shadow-sm btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

