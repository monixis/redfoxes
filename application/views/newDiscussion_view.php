<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

   	<script>
      $(document).ready(function() {
         $("#newd").validate({
					 errorClass: "my-error-class",
            rules: {
							cwid:"required",
							ds_title:"required",
							ds_body:"required",

               cwid: {
                  required: true,
                  minlength: 8,
                  maxlength: 8
               },
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
               cwid: {
                  required: "CWID required",
                  minlength: "Your CWID must be 8 characters long",
                  maxlength: "Your CWID must be 8 characters long"
               },
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
   </script>

  </head>
  <body>

  <?php echo validation_errors(); ?>
    <div class="col-md-9 fluid" id="cview">
			<?php $attributes = array('name' => 'newd','id'=>'newd');echo form_open(base_url().'Discussion/create',$attributes) ; ?>
	    <h4> Create a new Discussion</h4>
	    <br />
	    <div class="form-group col-md-5">
	      <label for="cwid"><?php echo $this->lang->line('cwid');?></label>
	      <input type="text" name="cwid" class="form-control" id="cwid" required="required" value="<?php echo set_value('cwid'); ?>">
	    </div>
	    <div class="form-group col-md-10">
	      <label for="ds_title"><?php echo $this->lang->line('discussion_ds_title');?></label>
	      <input type="text" name="ds_title" class="form-control" id="ds_title" value="<?php echo set_value('ds_title'); ?>">
	    </div>
	    <div class="form-group  col-md-10">
	      <label for="ds_body"><?php echo $this->lang->line('discussion_ds_body');?></label>
	      <textarea class="form-control" rows="3" name="ds_body" id="ds_body" value="<?php echo set_value('ds_body'); ?>" ></textarea>
	    </div>
	    <div class="form-group  col-md-11">
	      <button type="submit" class="btn btn-success btn-md"><?php echo $this->lang->line('common_form_elements_go');?></button>
	    </div>
	    <?php echo form_close() ; ?>
    </div>
  </body>
</html>
