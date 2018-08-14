<!DOCTYPE html>
<html lang="en">
<head>
  <title>Marist Discussion Forum</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
  <!-- jQuery -->
  <!-- BS JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url();?>/js/jquery.easyPaginate.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="./css/redfox.css">
  <style>
  .easyPaginateNav a {
    padding:5px;float: inherit;color: #000;
    text-decoration: none;
  }
  .easyPaginateNav a.current {
    font-weight:bold;background-color: #fff;color: #000;border-radius: 8px;text-decoration: none;
  }
  .easyPaginateNav a.active {
    background-color: #4CAF50;color: #000;
    color: white;text-decoration: none;
  }
  .easyPaginate a:hover:not(.active) {background-color: #ddd;}

</style>
</head>
<body>
  <div class="container fluid" style="">
    <!--View to show the body of discussions, forums and comments on the discussions -->
    <div class="list-group list-group-item">
      <?php if($query->result()) {
      foreach ($query->result() as $result) : $this->input->post($result->d_title,$result->cwid,$result->d_id,$result->d_body); //$d_id=$result->d_id;?>
        <h4 class="list-group-item-heading">Title: <?php echo $result->d_title; ?></h4>
        <p class="list-group-item-text" style="color:gray"><?php echo "Created by ".ucfirst($result->username); ?></p>
        <p><?php echo $result->d_body; ?></p>
    <?php endforeach; } else {?>
      </div>
      <div class="list-group list-group-item">
        <p>No discussion found</p>
      </div>
    <?php } ?>
    <button type="button" style="color:#fff;" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Reply</button>
    <br /><br />
    <div class="list-group" style="margin-left:20px" id="easyPaginate" name="easyPaginate">
          <?php
          if($postquery) {
          foreach ($postquery->result() as $postresult) : $this->input->post($postresult->p_title,$postresult->p_body);?>
            <li class="list-group-item" style="margin-bottom: 7px;">
              <!--<h4 class="list-group-item-heading">Post title: <//?php echo $postresult->p_title; ?></h4>-->

              <input type="hidden" id="p_id" value = "<?php echo (isset($postresult->p_id))?$postresult->p_id:'';?>" /><p><?php echo $postresult->p_body; ?></p>
              <p class="list-group-item-text" style="color:	#444444"><?php echo "Reply from ".ucfirst($postresult->username).""; ?></p><p class="list-group-item-text" style="color:gray"><?php echo $postresult->age; ?></p><input type="hidden" id="getURL" name="getURL" value="<?php echo base_url().'discussion/commentView/'.$postresult->p_id; ?>"></input><!--this is to pass urls to specific discussions-->
            </li>
          <?php endforeach;?>
  </div>
  <div id="pagination"></div>
  <?php } else {?>
      <div class="list-group list-group-item">
        <p>No posts on this discussion yet.</p>
      </div><br />
    <?php } ?>
    <!-- Modal for adding Post -->
    <div class="modal fade" id="myModal" name="myModal" role="dialog" >
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" style="background:#000000;color:#fff;" id="postcancel" name="postcancel" class="close" data-dismiss="modal" onclick="commentclose()">&times;</button>
            <h4 class="modal-title">New Post</h4>
          </div>
          <div class="modal-body">
                   <form role="form" id="postmodal">
                  <!-- <div class="form-group">
                       <label for="postTitle">Post Title</label>
                       <input type="text" class="form-control" id="postTitle" placeholder="Title"/>
                   </div>-->
                   <div class="form-group">
                       <label for="postBody">Post Body</label>
                       <textarea class="form-control" rows="5" id="postBody" placeholder="Enter your message"></textarea>
                       <input type="hidden" id="di_id" value = "<?php echo (isset($result->d_id))?$result->d_id:'';?>" />
                   </div>
                   </form>
          </div>
          <div class="modal-footer">
            <button style="color:#fff;" type="button" class="btn btn-primary submitBtn" onclick="submitPostForm()" >Submit</button>
            <button style="color:#fff;" type="button" class="btn btn-primary" data-dismiss="modal" id="postcancel" name="postcancel" onclick="commentclose()">Close</button>
          </div>

        </div>
      </div>
    </div>  <!-- Modal end for adding Post -->
    <!-- Modal for adding comment on a post -->

    </div>
    <!--<?php// echo form_close(); ?>-->
    <script type="text/javascript">
    //$('#postdatatable').DataTable();
    $('#easyPaginate').easyPaginate({
	      paginateElement: 'li',
	      elementsPerPage: 5,
	      effect: 'climb'
	});
  function fetchComments(myURL){
    var resultUrl = myURL;//document.getElementById('getURL').value; //"<?php //echo base_url().'Discussion/discussionDetails/'; ?>"+getdid;
    console.log(resultUrl);
    $('#viewreplies').load(resultUrl);
    $('#viewreplies').css('display','block');//showing the list of discussion
    $('#dlist').css('display','block');
    $('#disclist').css('display','none'); //hiding the button create new discussion and view on-going discussions
  }
  function addComments(myURL){
    var resultUrl = myURL;//document.getElementById('getURL').value; //"<?php //echo base_url().'Discussion/discussionDetails/'; ?>"+getdid;
    console.log(resultUrl);
    $('#viewreplies').load(resultUrl);
    $('#viewreplies').css('display','block');//showing the list of discussion
    $('#dlist').css('display','none');
    $('#disclist').css('display','none'); //hiding the button create new discussion and view on-going discussions
  }
  function addNewComment(someid){
    var postid = someid;
    $('#myComment').modal('show');
  }
  function commentclose(){
    $("#postBody").val("");
    $("#postBody-error").hide();
    $(".error").removeClass(".my-error-class");
    $('#myModal').modal('hide');
  }
  $("#postmodal").validate({
   errorClass: "my-error-class",
    rules: {
      //postTitle:"required",
      postBody:"required",
       //postTitle: {
      //    minlength: 8,
      //    maxlength: 255
      // },
       postBody: {
          minlength: 20,
          maxlength: 500
       },
    },
    messages: {
       //postTitle: {
      //    required: "Post title required",
      //    minlength: "Your post title must be at least 8 characters long",
      //    maxlength: "Your post title must be of maximum 255 characters"
       //},
       postBody: {
          required: "Post body required",
          minlength: "Your post body must be at least 20 characters long",
          maxlength: "Your post body must be of maximum 500 characters"
       }
    }
  });
  </script>
</body>
</html>
