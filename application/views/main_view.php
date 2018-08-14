<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<title><?php echo $title; ?></title>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <html lang="en">
    	<head>
    		<title><?php echo $title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    		<link rel="stylesheet" href="./css/redfox.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
				<script type="text/javascript" src="datatables/datatables.min.js"></script>
				<script src="<?php echo base_url();?>/js/jquery.easyPaginate.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
        <style>
    		.foot {
    			text-align: center;
    			color: #333;
    			font-size: 13px;
    			width: 100%;
    		}

    		.foot a:link {
    			color: #333;
    		}
    		.foot a:visited {
    			color: #333;
    		}

    		.foot a:hover {
    			color: #B31B1B;
    		}
    		</style>
      </head>
      <body>
        <div id="navi" align="right" class="container fluid">
          <br /><br /><button id="home" class="btn btn-primary"><span class="glyphicon glyphicon-home"></span> Home</button>
          <a href="https://login.marist.edu/cas/logout"><button id="logout" type="reset" class="btn btn-logout"><span class="glyphicon glyphicon-log-out"></span> Logout</button></a>
        </div>

        <div class="container fluid" id="cview">
          <div id="main_page" class="form-group">

            <?php echo "<h3>".$title."</h3>" ?><br />
            <button type="button" class="btn btn-default btn-lg" id="newDiscussion" name="newDiscussion" data-toggle="modal" data-target="#newModal">Create Discussion</button>
          </div>
          <div id="disclist" name="disclist" class="col-md-8"><!--This shows the list of discussion on the first page - Uses datatables --></div>
					<div id="dlist" name="dlist" class="col-md-8"><!--This div is for displaying the discussion details when one of the link from the datatable of discussion list is clicked. --></div>
					<div id="ddetails"><!-- This is to show the newly created discussion. --></div>

          <!-- Modal for adding new Discussion -->
  		    <div class="modal fade" id="newModal" name="newModal" role="dialog" >
  		      <div class="modal-dialog">
  		        <!-- Modal content-->
  		        <div name="newd" id="newd" class="modal-content">
  		          <div class="modal-header">
  		            <button type="button" id="cancel" name="cancel" class="close" data-dismiss="modal">&times;</button>
  		            <h4 class="modal-title col-md-9">Create a new Discussion</h4>
  		          </div>
  		          <div class="modal-body">
  								<form role="form" id="newModalDisc">
  									<div class="form-group">
  										<div class="dropdown">
  											<label for="category">Category</label>
  										  <select class="form-control" id="category" name="category">
  												<option value="General"><a href="#">General</a></option>
  										    <option value="Academic"><a href="#">Academic</a></option>
  												<option value="Accommodation"><a href="#">Accommodation</a></option>
  										    <option value="Registrar"><a href="#">Registrar</a></option>
  												<option value="Events"><a href="#">Events</a></option>
  											 	<option value="IT issues"><a href="#">IT issues</a></option>
  											 	<option value="Transportation"><a href="#">Transportation</a></option>
  										  </select>
  										</div>
  									</div>
  									<div class="form-group">
  								    <div>
  								      <label for="ds_title"><?php echo $this->lang->line('discussion_ds_title');?></label>
  								      <input type="text" name="ds_title" class="form-control" id="ds_title" value="<?php echo set_value('ds_title'); ?>" />
  								    </div>
  									</div>
  									<div class="form-group">
  								    <div>
  								      <label for="ds_body"><?php echo $this->lang->line('discussion_ds_body');?></label>
  								      <textarea class="form-control" rows="3" name="ds_body" id="ds_body" value="<?php echo set_value('ds_body'); ?>" ></textarea>
  								    </div>
  									</div>
  									<div class="modal-footer">
  				            <button type="submit" class="btn btn-success" onclick="submitDiscussionForm()"><?php echo $this->lang->line('common_form_elements_go');?></button>
  				            <button type="button" class="btn btn-warning" data-dismiss="modal" id="cancel" name="cancel">Close</button>
  				          </div>
  								</form>
  								<!--<input type="text" name="ds_num" class="form-control" id="ds_num" value="<?php //echo mt_rand(); ?>" />-->
  							</div>
  							<?php //echo form_close() ; ?>
  		        </div>
  		      </div>
  		    </div>  <!-- Modal end for adding discussion -->
          </div>
					<div class="bottom_container">
    	        <p class = "foot">
    	            James A. Cannavino Library, 3399 North Road, Poughkeepsie, NY 12601; 845.575.3199
    	            <br />
    	            &#169; Copyright 2007-2016 Marist College. All Rights Reserved.
    			<a href="http://www.marist.edu/disclaimers.html" target="_blank" >Disclaimers</a> | <a href="http://www.marist.edu/privacy.html" target="_blank" >Privacy Policy</a>
    	        </p>
    	    </div>

          <script type="text/javascript" class="init">
    			$(document).ready(function(){
            var resultUrll = '<?php echo base_url('Discussion/discussionList') ?>';
     				$('#disclist').load(resultUrll);
     				$('#disclist').css('display','block');
    				$("#navi").click(function(){
    					window.location.href = '<?php echo base_url() ?>';
    				});
    				//validation for create discussions
            $("#newModalDisc").validate({
    					errorClass: "my-error-class",
    					 rules: {
    						 ds_title:"required",
    						 ds_body:"required",
    							ds_title: {
    								 required: true,
    								 minlength: 8,
    								 maxlength: 255
    							},
    							ds_body: {
    								 required: true,
    								 minlength: 20,
    								 maxlength: 500
    							},
    					 },
    					 messages: {
    							ds_title: {
    								 required: "Discussion title required",
    								 minlength: "Your Discussion title must be at least 8 characters long",
    								 maxlength: "Your Discussion title must be of maximum 255 characters"
    							},
    							ds_body: {
    								 required: "Discussion body required",
    								 minlength: "Your Discussion body must be at least 20 characters long",
    								 maxlength: "Your Discussion body must be of maximum 500 characters"
    							}
    					 },
    					 onfocusout: function (element) {
    						 $(element).valid();
    					 }
    				 });
    			 });
	           function submitPostForm(){
    					var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    					//var ptitle = $('#postTitle').val();
							var ptitle = 'default';
    					var pbody = $('#postBody').val();
    					var d_id = $('#di_id ').val();
    					if(ptitle.trim() == '' ){
    							alert('Please enter your post title.');
    							$('#postTitle').focus();
    							return false;
    					}else if(pbody.trim() == '' ){
    							alert('Please enter your message.');
    							$('#postBody').focus();
    							return false;
    					}else{
    						//console.log("finally in else");
    							$.ajax({
    									type:'POST',
    									url:'<?php echo base_url() ?>'+'Discussion/addNewPost', //+cwid+'/'+title+'/'+body+'/'+d_id
    									//data:'contactFrmSubmit=1&cwid='+cwid+'&postTitle='+title+'&postBody='+body+'&d_id='+d_id,//,
    									data:{'contactFrmSubmit':'1', 'postTitle' :ptitle, 'postBody':pbody, 'd_id':d_id},
    									beforeSend: function () {
    											$('.submitBtn').attr("disabled","disabled");
    											$('.modal-body').css('opacity', '.5');
    									},
    									success:function(msg){
    											if(msg == 'ok'){
    													//$('#cwid').val('');
    													//$('#postTitle').val('');
    													$('#postBody').val('');
    													$('.statusMsg').html('<span style="color:green;">Thanks for contacting us, we\'ll get back to you soon.</p>');
    											}else{
    													$('.statusMsg').html('<span style="color:red;">Some problem occurred, please try again.</span>');
    											}

													fetchPost('<?php echo base_url()?>'+'Discussion/search_discussion/'+d_id);
    											$('.submitBtn').removeAttr("disabled");
    											$('.modal-body').css('opacity', '');
    											$('#myModal').modal('hide');
    											$('.modal-backdrop').remove();
    											$(document).on('hidden.bs.modal','#myModal', function () {
    												$('.modal-backdrop').remove();
    												});
    									},
    							});
    					}
    			}
    			//this method submits the newly created discussion and returns to the discussion details page.
    			function submitDiscussionForm(){
    					var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    					//var cwid = $('#ccwid').val();
    					var category = $('#category').val();
    					console.log("this is your category\n"+category);
    					var ds_title = $('#ds_title').val();
    					console.log("discussion title:"+ds_title);
    					var ds_body = $('#ds_body').val();
    					console.log("discussion body:"+ds_body);
    					//var r_num = Math.random() * 1000;
							var ds_num = Math.floor((Math.random() * 10000) + 1);
    					console.log("discussion random number:"+ds_num);
    					if(category.trim() == '' ){
    							alert('Please enter the discussion category.');
    							$('#category').focus();
    							return false;
    					}else if(ds_title.trim() == '' ){
    							alert('Please enter your message.');
    							$('#ds_title').focus();
    							return false;
    					}else if(ds_body.trim() == '' ){
    							alert('Please enter your message.');
    							$('#ds_body').focus();
    							return false;
    					}else{
    						//alert("in else");
    							$.ajax({
    									type:'POST',
    									url:'<?php echo base_url(); ?>'+'Discussion/create',
    									data:{'category' : category, 'ds_title':ds_title, 'ds_body':ds_body, 'ds_num':ds_num},
    									beforeSend: function () {
    											$('.submitBtn').attr("disabled","disabled");
    											$('.modal-body').css('opacity', '.5');
    									},
    									success:function(msg){
    											if(msg == 'ok'){
    													//$('#ccwid').val('');
    													$('#category').val('');
    													$('#ds_title').val('');
    													$('#ds_body').val('');
    													$('.statusMsg').html('<span style="color:green;">Thanks for contacting us, we\'ll get back to you soon.</p>');
    											}else{
    													$('.statusMsg').html('<span style="color:red;">Some problem occurred, please try again.</span>');
    											}
													var resultUrl = '<?php echo base_url()?>'+'Discussion/search_discussion/'+ds_num;//document.getElementById('getURL').value; //"<?php //echo base_url().'Discussion/discussionDetails/'; ?>"+getdid;
						    			    console.log(resultUrl);
						    					//$('#ddetails').empty();
						    					$('#dlist').css('display','none');
						    					$('#disclist').css('display','none');
						    			    $('#ddetails').load(resultUrl);
						    			    $('#ddetails').css('display','block');

													$('#disclist').empty();
													$('#dlist').empty();
													console.log('<?php echo base_url()?>'+'Discussion/search_discussion/'+ds_num);
													//fetchDiscussion('<?php //echo base_url()?>'+'Discussion/search_discussion/'+ds_num);
    											$('.submitBtn').removeAttr("disabled");
    											$('.modal-body').css('opacity', '');
    											$('#newModal').modal('hide');
													//$('.modal-backdrop').remove();
    											$(document).on('hidden.bs.modal','#newModal', function () {
														$('.modal-backdrop').remove();

    								});
    							}
    						});
    					}
    				}
    				$(function(){
    					$(".dropdown-menu option a").click(function(){
    						$("#cat:first-child").text($(this).text());
    						$("#cat:first-child").val($(this).text());

    					});
    				});
    			  function addComments(myURL){
    			    var resultUrl = myURL;//document.getElementById('getURL').value; //"<?php //echo base_url().'Discussion/discussionDetails/'; ?>"+getdid;
    			    console.log(resultUrl);
    			    $('#viewreplies').load(resultUrl);
    			    $('#viewreplies').css('display','block');//showing the list of discussion
    			    $('#dlist').css('display','none');
    					$('#disclist').css('display','none'); //hiding the button create new discussion and view on-going discussions
    			    //$('#dlist').css('display','none');//hiding the list of on going discussions
    			    //console.log(resultUrl);
    			  }
    				//function fetchDiscussion(myURL){

    			  //}

    				function fetchPost(myURL){
    			    var resultUrl = myURL;//document.getElementById('getURL').value; //"<?php //echo base_url().'Discussion/discussionDetails/'; ?>"+getdid;
    			    console.log(resultUrl);
    					$('#ddetails').empty();
    					$('#dlist').css('display','none');
    					$('#disclist').css('display','none');
    			    $('#ddetails').load(resultUrl);
    			    $('#ddetails').css('display','block');//showing the list of discussion
    			  }
    			  function addNewComment(){
    			    $('#myComment').modal('show');
    			  }
    			  function commentclose(){
    			    $('#myComment').modal('hide');
    			  }
					$("#cancel").click(function() {
						 $("#category:first-child").text("Select Discussion Category");
						 $("#category:first-child").val("default");
						 $("#ds_title").val("");
						 $("#ds_body").val("");
						 //$("#cwid-error").hide();
						 $("#ds_title-error").hide();
						 $("#ds_body-error").hide();
						 $(".error").removeClass(".my-error-class");
						//alert("clicked cancel");
					});
				</script>
			</body>
			</html>
