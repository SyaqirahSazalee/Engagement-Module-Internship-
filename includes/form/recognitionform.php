<!-- <?php
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
?> -->

<script type="text/javascript">
  $(document).ready(function() {

    $("#amount").click(function(){
      $("#amounts").toggle();
      $("#users").css('display','none');
      $("#tags").css('display','none');
    });   

    $("#alias").click(function(){
      $("#users").toggle();
      $("#amounts").css('display','none');
      $("#tags").css('display','none');
    });

    $("#tag").click(function(){
      $("#tags").toggle();
      $("#amounts").css('display','none');
      $("#users").css('display','none');
    });

    $(document).on('click', '.addpostamount', function(){
      var sent = $(this).attr('title');
      var old = document.getElementById('addrecogdesc').value;
      // var point = old.match(/\+(\w+)/gm);
      if(old.match(/\+(\w+)/gm)){
        var newpost = (old.replace(/\+(\w+)/gm,"")).trim();
        $("#addrecogdesc").val(sent+newpost);
        $("#amounts").css('display','none');
      }else{
        $("#addrecogdesc").val(old+sent);
        $("#amounts").css('display','none');
      }
    });

    $(document).on('click', '.addpostuser', function(){
      var sent = $(this).attr('title');
      var old = document.getElementById('addrecogdesc').value;
      $("#addrecogdesc").val(old+sent);
      $("#users").css('display','none');
    });

    $(document).on('click', '.addposttag', function(){
      var sent = $(this).attr('title');
      var old = document.getElementById('addrecogdesc').value;
      $("#addrecogdesc").val(old+sent);
      $("#tags").css('display','none');
    });

    var form = $('#addrecogform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();

      var addrecogdesc = document.getElementById("addrecogdesc").value;
      var description = (addrecogdesc.replace(/\+(\w+)|@(\w+)|#(\w+)|\s+/gm," ")).trim();
      // var description = recogdescription.trim();
      var word = addrecogdesc.split(" ");
      var wordlength = addrecogdesc.split(" ").length;
      var point=null;
      var aliasto=[];
      var tagapply=[];
      var aliastonum=0;
      var tagapplynum=0;

      for(var i=0; i<wordlength; i++)
      {
        if (word[i].match(/\+(\w+)/gm)){
          var replace = word[i].replace("+","");
          point = replace.trim();
        }
        
        if(word[i].match(/@(\w+)/gm)){
          var replace = word[i].replace("@","");
          aliasto.push(replace.trim());
          aliastonum += 1;
        }
        
        if(word[i].match(/#(\w+)/gm))
        {
          var replace = word[i].replace("#","");
          tagapply.push(replace.trim());
          tagapplynum += 1;
        }
      }

      var alldata={
        addrecogdesc:addrecogdesc,
        description:description,
        point:point,
        aliasto:aliasto,
        tagapply:tagapply,
        aliastonum:aliastonum,
        tagapplynum:tagapplynum
      };

      $.ajax({
        url: "ajax-addrecognition.php",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          if(obj.condition === "Passed"){
            $("#addrecog").modal("hide");
            getrecognitioninfo();
            gethometaginfo();
            gettrendingtaginfo();
          }else{
            checkvalidity("addrecogdescerror","#addrecogdescerror", "#addrecogdesc", obj.description);
          }
        }
      });
    });

    $("#addrecog").on('hidden.bs.modal', function(){
      document.getElementById("addrecogform").reset(); 
      clearform("#addrecogdescerror","addrecogdescerror", "#addrecogdesc");
    });

    function getrecognitioninfo()
    {
      $.ajax({
        url: "ajax-getviewrecognition.php",
        success:function(data){
          $("#showrecognitioninfo").html(data);
        }
      });
    }

    function gethometaginfo()
    {
      $.ajax({
        url: "ajax-getviewhometag.php",
        success:function(data){
          $("#showhometaginfo").html(data);
        }
      });
    }

    function gettrendingtaginfo()
    {
      $.ajax({
        url: "ajax-getviewtrendinghashtags.php",
        success:function(data){
          $("#showtrendingtaginfo").html(data);
        }
      });
    }
  });
</script>

<div class="modal fade" id="addrecog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h6 class="modal-title text-white" id="scoreboardModalLabel">New Recognition</h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="addrecogform">
          <div class="form-group">
            <input type="button" value="+ Amount" class="mb-2 btn btn-secondary rounded-pill" id="amount" style="width: 15%;">
            <script>
              function getpointrecoginfo(){
                $.ajax({
                  url:"ajax-getviewpointrecog.php?lang=<?php echo $extlg;?>",
                  success:function(data){
                    $("#amounts").html(data);
                  }
                });
              }
              getpointrecoginfo();
            </script>

            <input type="button" value="@ Recipient" class="mb-2 btn btn-secondary rounded-pill" id="alias" style="width: 15%;">
            <script>
              function getuserrecoginfo(){
                $.ajax({
                  url:"ajax-getviewuserrecog.php?lang=<?php echo $extlg;?>",
                  success:function(data){
                    $("#users").html(data);
                  }
                });
              }
              getuserrecoginfo();
            </script>

            <input type="button" value="# Hashtag" class="mb-2 btn btn-secondary rounded-pill" id="tag" style="width: 15%;">
            <script>
              function gettagrecoginfo(){
                $.ajax({
                  url:"ajax-getviewtagrecog.php?lang=<?php echo $extlg;?>",
                  success:function(data){
                    $("#tags").html(data);
                  }
                });
              }
              gettagrecoginfo();
            </script>

            <div id="amounts" style="display: none;"></div>
            <div id="users" style="display: none;"></div>
            <div id="tags" style="display: none;"></div>

            <textarea style="width: 100%" type="text" id="addrecogdesc" autocomplete="off" placeholder="+amount @Recipient #Hashtag Type your recognition post here"></textarea>
            <small><span id="addrecogdescerror"></span></small>
          </div>         
          <div class="row">
            <div class="col text-right">
                <button id="submit" name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm">Create</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function(){

    $(document).on('click', ".addComment", function(){
      var recogID = $(this).data('id');
      $.ajax({
        url:"ajax-getrecognition.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{recogID:recogID},
        dataType:"json",
        success:function(data){
          console.log(data);
          $("#addrecogcommentid").val(data.recogID);
        }
      });

      $.ajax({
        url:"ajax-getaliasto.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{recogID:recogID},
        // dataType:"json",
        success:function(data){
          console.log(data);
          $("#addrecogcommentdesc").val(data);
        }
      });

      $.ajax({
        url:"ajax-getviewcomment.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{recogID:recogID},
        // dataType:"json",
        success:function(data){
          console.log(data);
          $("#showrecogcomment").html(data);
        }
      });
    });

    $("#amount2").click(function(){
      $("#amounts2").toggle();
      $("#tags2").css('display','none');
    }); 

    $("#tag2").click(function(){
      $("#tags2").toggle();
      $("#amounts2").css('display','none');
    }); 

    $(document).on('click', '.addpostamount', function(){
      var sent = $(this).attr('title');
      var old = document.getElementById('addrecogcommentdesc').value;
      // var point = old.match(/\+(\w+)/gm);
      if(old.match(/\+(\w+)/gm)){
        var newpost = (old.replace(/\+(\w+)/gm,"")).trim();
        $("#addrecogcommentdesc").val(sent+newpost);
        $("#amounts2").css('display','none');
      }else{
        $("#addrecogcommentdesc").val(old+sent);
        $("#amounts2").css('display','none');
      }
    });

    $(document).on('click', '.addposttag', function(){
      var sent = $(this).attr('title');
      var old = document.getElementById('addrecogcommentdesc').value;
      $("#addrecogcommentdesc").val(old+sent);
      $("#tags2").css('display','none');
    });

    var form = $('#addrecogcommentform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();

      var addrecogcommentid = document.getElementById("addrecogcommentid").value;
      var addrecogcommentdesc = document.getElementById("addrecogcommentdesc").value;
      var comment = (addrecogcommentdesc.replace(/\+(\w+)|@(\w+)|#(\w+)|\s+/gm," ")).trim();
      // var comment = commentdescription.trim();
      var commentword = addrecogcommentdesc.split(" ");
      var commentwordlength = addrecogcommentdesc.split(" ").length;
      var point;
      var commentaliasto=[];
      var commenttagapply=[];
      var commentaliastonum=0;
      var commenttagapplynum=0;

      for (var i=0; i<commentwordlength; i++) 
      {
        if (commentword[i].match(/\+(\w+)/gm)){
          var replace = commentword[i].replace("+","");
          point = replace.trim();
        }
        else if (commentword[i].match(/@(\w+)/gm)) 
        {
          var replace = commentword[i].replace("@","");
          commentaliasto.push(replace.trim());
          commentaliastonum += 1;
        }
        else if (commentword[i].match(/#(\w+)/gm))
        {
          var replace = commentword[i].replace("#","");
          commenttagapply.push(replace.trim());
          commenttagapplynum += 1;
        }
      }

      var alldata={
        addrecogcommentid:addrecogcommentid,
        addrecogcommentdesc:addrecogcommentdesc,
        comment:comment,
        point:point,
        commentaliasto:commentaliasto,
        commenttagapply:commenttagapply,
        commentaliastonum:commentaliastonum,
        commenttagapplynum:commenttagapplynum
      };

      $.ajax({
        url: "ajax-addcomment.php",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          if(obj.condition === "Passed"){
            $("#addrecogcomment").modal("hide");
            getrecognitioninfo();
            gethometaginfo();
            gettrendingtaginfo();
          }else{
            checkvalidity("addrecogcommentdescerror","#addrecogcommentdescerror", "#addrecogcommentdesc", obj.description);
          }
        }
      });
    });

    $("#addrecogcomment").on('hidden.bs.modal', function(){
      document.getElementById("addrecogcommentform").reset(); 
      clearform("#addrecogcommentdescerror","addrecogcommentdescerror", "#addrecogcommentdesc");
      getrecognitioninfo();
    });

    function getrecognitioninfo()
    {
      $.ajax({
        url: "ajax-getviewrecognition.php",
        success:function(data){
          $("#showrecognitioninfo").html(data);
        }
      });
    }

    function gethometaginfo()
    {
      $.ajax({
        url: "ajax-getviewhometag.php",
        success:function(data){
          $("#showhometaginfo").html(data);
        }
      });
    }

    function gettrendingtaginfo()
    {
      $.ajax({
        url: "ajax-getviewtrendinghashtags.php",
        success:function(data){
          $("#showtrendingtaginfo").html(data);
        }
      });
    }
  });
</script>

<div class="modal fade" id="addrecogcomment">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h6 class="modal-title text-white" id="scoreboardModalLabel">Comment</h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="addrecogcommentform">
          <input type="hidden" name="addrecogcommentid" id="addrecogcommentid">
          <div class="form-group">

            <input type="button" value="+ Amount" class="mb-2 btn btn-secondary rounded-pill" id="amount2" style="width: 15%;">
            <script>
              function getpointrecoginfo(){
                $.ajax({
                  url:"ajax-getviewpointrecog.php?lang=<?php echo $extlg;?>",
                  success:function(data){
                    $("#amounts2").html(data);
                  }
                });
              }
              getpointrecoginfo();
            </script>

            <input type="button" value="# Hashtag" class="mb-2 btn btn-secondary rounded-pill" id="tag2" style="width: 15%;">
            <script>
              function gettagrecoginfo2(){
                $.ajax({
                  url:"ajax-getviewtagrecog.php?lang=<?php echo $extlg;?>",
                  success:function(data){
                    $("#tags2").html(data);
                  }
                });
              }
              gettagrecoginfo2();
            </script>

            <div id="amounts2" style="display: none;"></div>
            <div id="tags2" style="display: none;"></div>

            <input style="width: 100%" type="text" id="addrecogcommentdesc" autocomplete="off" placeholder="Type Your Comment"></input>
            <small><span id="addrecogcommentdescerror"></span></small>
          </div> 
          <div class="row">
            <div class="col text-right">
                <?php
                if ($resultresult->point_company<=0) {
                  ?>
                  <button id="submit" name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm" disabled>Comment</button>
                  <?php
                } else {
                  ?>
                  <button id="submit" name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm">Comment</button>
                  <?php
                }
                ?>
            </div>
          </div>
            <h6 class="m-0 border-0 py-1 mt-2">Comments</h6>
          <div class="collapse show" id="allcomments">
            <div class="row px-2 my-3" id="showrecogcomment"></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



