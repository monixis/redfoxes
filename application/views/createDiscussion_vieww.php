<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="./css/redfox.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
		<!-- jQuery -->
		<!-- BS JavaScript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>/js/jquery.easyPaginate.js"></script>
		<script type="text/javascript" src="datatables/datatables.min.js"></script>
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
		body {
			font-family: "Times New Roman", Times, serif;
			font-size: 1.5em;
		}
		</style>
  </head>
  <body style="overflow:scroll;">
		<div id="navi"  class="container fluid" style="margin-bottom: 30px;">
			<br /><br />

			<button type="button" class="btn btn-primary" id="newDiscussion" name="newDiscussion" data-toggle="modal" data-target="#newModal" style="margin-left:14px; margin-bottom:10px;">Start a new Discussion</button>

			<!--<button type="button" class="btn btn-primary" id="newDiscussion" name="newDiscussion" data-toggle="modal" data-target="#newModal" style="margin-left:0px; margin-bottom:0px;">Start a new Discussion</button>-->
			<a href="https://login.marist.edu/cas/logout"><button style="float: right;margin-left:14px;" id="logout" type="reset" class="btn btn-primary" style="color:#fff;"><span class="glyphicon glyphicon-log-out"></span> Logout</button></a>
			<button style="float: right;" id="home" class="btn btn-primary" style="color:#fff;"><span class="glyphicon glyphicon-home"></span> Home</button>
		</div>
		<div class="container fluid" id="cview">

				<?php if($username == ''){ ?>
					<div class="form-group" id="mailform" class="mailform">
						<div>
							<label for="emailid">Please Enter your Marist Email ID</label>
							<input type="text" name="emailid" class="form-control" id="emailid" value="<?php echo set_value('emailid'); ?>" /><br />
							<button style="color:#fff;" type="submit" class="btn btn-primary" onclick="submitEmailForm()"><?php echo $this->lang->line('common_form_elements_go');?></button>
						</div>
					</div>
				<?php } else { ?>
				<div id="main_page" class="form-group">
	      <!--?php echo "<p class='pull-left' style='font-size: 22px;'>".$title."</p>"; echo "<p class='pull-right' style='font-size: 22px;'>Hello, <font color='#0040ff'>".ucfirst($username)."!</font></p>"; ?><br /><br /><br />
	      <button type="button" class="btn btn-primary" id="newDiscussion" name="newDiscussion" data-toggle="modal" data-target="#newModal" style="margin-left:14px; margin-bottom:10px;">Start a new Discussion</button>-->
				<p><?php //echo $username; ?></p>

				<div id="ddetails"></div>
				<div id="ddetails1"></div>
				<div id="casdata" class="container fluid"></div>
				<div id="disclist" name="disclist"></div>
				<div id="dlist" style="float:center" class="col-md-9 fluid"></div>
				<div id="newDisc" class="form-horizontal"></div>
				<!-- Modal for adding Post -->
		    <div class="modal fade" id="newModal" name="newModal" role="dialog" >
		      <div class="modal-dialog">

		        <!-- Modal content-->
		        <div name="newd" id="newd" class="modal-content">

		          <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		            <h4 class="modal-title col-md-9">Start a new Discussion</h4>
		          </div>
							<!--<?php //$attributes = array('name' => 'newd','id'=>'newd');echo form_open(base_url().'Discussion/create',$attributes) ; ?>-->

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
								      <textarea class="form-control" rows="5" name="ds_body" id="ds_body" value="<?php echo set_value('ds_body'); ?>" ></textarea>
								    </div>
									</div>
									<div class="modal-footer">
				            <button style="background-color:#333;color:#fff;" type="submit" class="btn btn-dark" onclick="submitDiscussionForm()"><?php echo $this->lang->line('common_form_elements_go');?></button>
				            <button style="background-color:#333;color:#fff;" type="button" class="btn btn-dark" data-dismiss="modal" id="cancel" name="cancel">Close</button>
				          </div>
								</form>
								<!--<input type="text" name="ds_num" class="form-control" id="ds_num" value="<?php //echo mt_rand(); ?>" />-->
							</div>
							<?php //echo form_close() ; ?>
		        </div>
		      </div>
		    </div>  <!-- Modal end for adding Post -->
			</div>
	    </div>
		<?php }
		?>
			<div class="bottom_container">
	        <p class = "foot">
	            James A. Cannavino Library, 3399 North Road, Poughkeepsie, NY 12601; 845.575.3199
	            <br />
	            &#169; Copyright 2007-2018 Marist College. All Rights Reserved.
			<a href="http://www.marist.edu/disclaimers.html" target="_blank" >Disclaimers</a> | <a href="http://www.marist.edu/privacy.html" target="_blank" >Privacy Policy</a>
	        </p>
	    </div>
			<script type="text/javascript" class="init">
			$(document).keydown(function(e) { 
				if (e.keyCode == 27) { 
					$('.modal-backdrop').remove();
					$("#postBody").val("");
					$("#postBody-error").hide();
					$(".error").removeClass(".my-error-class");
					$('.submitBtn').attr("enabled","enabled");
					$('#myModal').modal('hide');
					$('#newModal').modal('hide');
				} 
			});
			$(document).ready(function(){
				$("#home").click(function(){
					window.location.href = '<?php echo base_url() ?>';
				});
				var resultUrll = "<?php echo base_url()?>"+'discussion/discussionList';
				$('#disclist').load(resultUrll);
				//$("#casdata").html('<object data="http://ldap.geminiodyssey.org/casattributes.php" />');
				//$("#casdata").load('http://ldap.geminiodyssey.org/casattributes.php li');
				//$("#casdata").css('display','block');
				//var username = $('#casdata ul li:first').text();
				//setTimeout(function(){alert($("li#casdata").html());},2000);
        //$('#ddetails').css('display','block');
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
				 $("#cancel").click(function() {
					 $("#cat:first-child").text("Select Discussion Category");
					 $("#cat:first-child").val("default");
					$("#ds_title").val("");
					$("#ds_body").val("");
					//$("#cwid-error").hide();
					$("#ds_title-error").hide();
					$("#ds_body-error").hide();
					$(".error").removeClass(".my-error-class");
					//alert("clicked cancel");
				 });
			 });
			 //this method submits the newly created discussion and returns to the discussion details page.
 			function submitDiscussionForm(e){
				//e.preventDefault();
 					var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
 					//var cwid = $('#ccwid').val();
 					var category = $('#category').val();
 					console.log("this is your category\n"+category);
 					var ds_title = $('#ds_title').val();
 					console.log("discussion title:"+ds_title);
 					var ds_body = $('#ds_body').val();
 					console.log("discussion body:"+ds_body);
 					var ds_num = Math.random() * 1000000;
 					console.log("discussion random number:"+ds_num);

 					if(category.trim() == ''){
 							alert('Please enter your CWID.');
 							$('#category').focus();
 							return false;
 					}else if(ds_title.trim() == ''){
 							alert('Please enter your message.');
 							$('#ds_title').focus();
 							return false;
 					}else if(ds_body.trim() == ''){
 							alert('Please enter your message.');
 							$('#ds_body').focus();
 							return false;
 					}else{
 						//alert("in else");
 							$.ajax({
 									type:'POST',
 									url:'<?php echo base_url(); ?>'+'discussion/create', //+cwid+'/'+title+'/'+body+'/'+d_id
 									//data:'contactFrmSubmit=1&cwid='+cwid+'&postTitle='+title+'&postBody='+body+'&d_id='+d_id,//,
 									data:{/*'cwid' :cwid,*/ 'category' : category, 'ds_title':ds_title, 'ds_body':ds_body, 'ds_num':ds_num},
									dataType: 'text',
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
 											$('.submitBtn').removeAttr("disabled");
 											$('.modal-body').css('opacity', '');
 											$('#newModal').modal('hide');
 											$('.modal-backdrop').remove();
 											fetchDiscussion('<?php echo base_url()?>'+'discussion/search_discussion/'+ds_num);
 										//	$(document).on('hidden.bs.modal','#newModal', function () {
 								//});
 							}
							
 						});
 					}
 				}
				function submitPostForm(){
					var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
					//var pcwid = $('#pcwid').val();
					var ptitle = 'default';
					var pbody = $('#postBody').val();
					var d_id = $('#di_id').val();
					if(ptitle.trim() == '' ){
							alert('Please enter your post title.');
							//$('#postTitle').focus();
							return false;
					}else if(pbody.trim() == '' ){
							alert('Please enter your message.');
							$('#postBody').focus();
							return false;
					}else{
						//console.log("finally in else");
							$.ajax({
									type:'POST',
									url:'<?php echo base_url() ?>'+'discussion/addNewPost', //+cwid+'/'+title+'/'+body+'/'+d_id
									data:{'contactFrmSubmit':'1', 'postTitle' :ptitle, 'postBody':pbody, 'd_id':d_id},
									dataType: 'text',
									beforeSend: function () {
											$('.submitBtn').attr("disabled","disabled");
											$('.modal-body').css('opacity', '.5');
									},
									success:function(msg){
											if(msg == 'ok'){
													$('#postBody').val('');
													$('.statusMsg').html('<span style="color:green;">Thanks for contacting us, we\'ll get back to you soon.</p>');
											}else{
													$('.statusMsg').html('<span style="color:red;">Some problem occurred, please try again.</span>');
											}
											var resultUrl = '<?php echo base_url()?>'+'discussion/search_discussion/'+d_id;//document.getElementById('getURL').value; //"<?php //echo base_url().'Discussion/discussionDetails/'; ?>"+getdid;
									    console.log(resultUrl);
											//$('#ddetails').empty();
											$('#dlist').css('display','none');
											$('#disclist').css('display','none');
									    $('#ddetails').load(resultUrl);
									    $('#ddetails').css('display','block');
//need to fix this part!
											//fetchPost('<?php //echo base_url()?>'+'Discussion/search_discussion/'+d_id);
											$('.submitBtn').removeAttr("disabled");
											$('.modal-body').css('opacity', '');
											$('#myModal').modal('hide');
											$('.modal-backdrop').remove();
											$(document).on('hidden.bs.modal','#myModal', function () {
												//alert('closed modal');
												$('.modal-backdrop').remove();
												//document.location.reload();
												//window.location.assign('<?php //echo base_url()?>'+'Discussion/search_discussion/'+d_id);
												});
									}
							});
					}
			}
			/*function fetchList(myURL){
				var resultUrl = myURL;//document.getElementById('getURL').value; //"<//?php //echo base_url().'Discussion/discussionDetails/'; ?>"+getdid;
				console.log(resultUrl);
				$('#dlist').load(resultUrl);
				$('#dlist').css('display','block');//showing the list of discussion
				$('#main_page').css('display','none'); //hiding the button create new discussion and view on-going discussions
				//console.log(resultUrl);
			}*/
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
				function fetchDiscussion(myURL){
			    var resultUrl = myURL;//document.getElementById('getURL').value; //"<?php //echo base_url().'Discussion/discussionDetails/'; ?>"+getdid;
			    console.log(resultUrl);
					//$('#ddetails').empty();
					$('#dlist').css('display','none');
					$('#disclist').css('display','none');
			    $('#ddetails').load(resultUrl);
			    $('#ddetails').css('display','block');//showing the list of discussion
					$('#dlist').empty();
					$('#disclist').empty();
			    //$('#main_page').css('display','none'); //hiding the button create new discussion and view on-going discussions
			    //$('#dlist').css('display','none');//hiding the list of on going discussions
			    //console.log(resultUrl);
			  }
				function fetchPost(myURL){
			    var resultUrl = myURL;//document.getElementById('getURL').value; //"<?php //echo base_url().'Discussion/discussionDetails/'; ?>"+getdid;
			    console.log(resultUrl);
					//$('#ddetails').empty();
					//$('#dlist').css('display','none');
					//$('#disclist').css('display','none');
			    $('#ddetails').load(resultUrl);
			    $('#ddetails').css('display','block');//showing the list of discussion
			  }
			  function addNewComment(){
			    $('#myComment').modal('show');
			  }
			  function commentclose(){
			    $('#myComment').modal('hide');
			  }
				function submitEmailForm(){
					var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
					//var pcwid = $('#pcwid').val();
					var emailid = $('#emailid').val();
					//alert($('#emailid').val());
					var fullname = emailid.split('@')[0];
					//alert(fullname);
					var firstname = fullname.split('.')[0];
					//alert(firstname);
					var lastname = fullname.split('.')[1].replace(/[0-9]/g, '');
					//var lastname = lastname.
					alert(lastname);
					console.log(emailid);
					if(emailid.trim() == '' ){
							alert('Please enter your Email-Id.');
							$('#emailid').focus();
							return false;
					} else {
							$.ajax({
									type: 'POST',
									url: '<?php echo base_url(); ?>'+'discussion/addEmail',
									data: {'emailid':emailid, 'firstname':firstname,'lastname':lastname},
									dataType: 'text',
									beforeSend: function () {
 											$('.submitBtn').attr("disabled","disabled");
 									},
									success:function(msg){
										if(msg == 'ok'){
												$('#emailid').val('');
												$('.statusMsg').html('<span style="color:green;">Thanks for contacting us, we\'ll get back to you soon.</p>');
										}else{
												$('.statusMsg').html('<span style="color:red;">Some problem occurred, please try again.</span>');
										}
										document.location.reload();
									}
							});
					}
				}
			</script>
  </body>
</html>
