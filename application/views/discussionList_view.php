<!DOCTYPE html>
<html lang="en">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-3375146-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-3375146-1');
</script>

  <title>Redfoxes Forums</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
  .dataTables_filter input {
    width:100%;
    position:relative;
  }
  .dataTables_filter label {
    width:100%;
    font-size: 22px;
    font-style: normal;
    position:relative;
  }
  .dataTables_length label {
    width:100%;
    font-size: 16px;
    font-style: normal;
    position:relative;
  }
  body {
    font-family: "Times New Roman", Times, serif;
    font-size: 1.5em;
  }
  th { font-size: 18px; }
  td { font-size: 16px; }
  </style>
</head>
<body>
<?php @session_start();//echo form_open(base_url().'Discussion/discussionDetails','role="form"'); ?>
<div>
  <form name="dview" id="dview" method="post" class="form-group" style="width:100%;" action="<?php echo base_url().'discussion/discussionDetails/'; ?>">
    <div id="new-search-area" class="new-search-area container container-fluid" style="width: 100%;"></div>
    <div id="new-drop-area" class="new-drop-area container container-fluid" style="width: 100%;"></div>
      <!--div-->
        <table id="tabledata" class="table table-responsive" style="border-bottom:1px solid" cellspacing="0" width="100%">
          <thead >
            <tr>
              <th>Discussion Title</th>
              <th>Created By</th>
              <th>Category</th>
              <th>Created on</th>
              <th class="hidden-xs hidden-sm hidden-md hidden-lg"></th>
              <th class="hidden-xs hidden-sm hidden-md hidden-lg"></th>
            </tr>
          </thead>

        <!--/div-->
        <tbody>
          <?php
            foreach ($query->result() as $result) ://$this->input->post($result->d_id, $result->d_title, $result->cwid);?>
            <div>
              <tr>
                <td><a id="anchorid" href="javascript:fetchList('<?php echo base_url().'discussion/discussionDetails/'.$result->d_id; ?>')"><?php echo ucfirst($result->d_title); ?></a></td>
                <td><?php echo ucwords($result->username); ?></td>
                <td><?php echo $result->category; ?></td>
                <td><?php echo $result->age; ?></td>
                <td class="hidden-xs hidden-sm hidden-md hidden-lg"><input type="hidden" id="d_id" name= "d_id" value ="<?php echo (isset($result->d_id))?$result->d_id:'';?>" required="required" /></td>
                <td class="hidden-xs hidden-sm hidden-md hidden-lg"><input type="hidden" id="getURL" name="getURL" value="<?php echo base_url().'discussion/discussionDetails/'.$result->d_id; ?>"></input></td><!--this is to pass urls to specific discussions -->
              </tr>
            </div>
          <?php endforeach; ?>
        </tbody>
      </table>
    </form>
  </div>
<!--<?php //echo form_close(); ?>-->
<script type="text/javascript">
 $('#tabledata').DataTable({
   "order": [[3, "desc"]],
   initComplete : function() {
     $("#tabledata_filter").detach().appendTo('#new-search-area');
     $("#tabledata_filter input").addClass('form-control form-control-sm');
     $("#tabledata_length").detach().appendTo('#new-drop-area');
   }

 });
  function fetchList(myURL){
    console.log(resultUrl);
    var resultUrl = myURL;//document.getElementById('getURL').value; //"<?php //echo base_url().'Discussion/discussionDetails/'; ?>"+getdid;
    $('#dlist').load(resultUrl);
    $('#dlist').css('display','block');//showing the list of discussion
    $('#disclist').css('display','none'); //hiding the button create new discussion and view on-going discussions
    //console.log(resultUrl);
  }
</script>
</body>
</html>
