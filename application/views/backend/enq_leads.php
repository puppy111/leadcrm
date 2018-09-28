<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <i class="fa fa-tachometer" aria-hidden="true"></i> Project Details <small>Control panel</small> </h1>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12 text-right">
        <div class="form-group">
          <button class="btn btn-danger btn-sm pull-left" id="del_all"><i class="glyphicon glyphicon-trash"></i>&nbsp; <b> Delete Selected </b> </button>
          <button class="btn btn-success" onclick="goBack()">
          <li class="glyphicon glyphicon-step-backward">Back</li>
          </button>
          <a class="btn btn-primary" onclick="add_block()"> <i class="glyphicon glyphicon-plus"></i> Add New</a>
          <button class="btn btn-default" onclick="reload_table()"> <i class="glyphicon glyphicon-refresh"></i> Reload </button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box"> 
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th><input id="selecctall" type="checkbox">
                    &nbsp;Check All</th>
                  <th>Lead Name</th>
                  <th>Phone</th>
                  <th>Subject</th>
                  <th>Added On</th>
                  <th>Status</th>
                  <th style="width:150px;">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
    </div>
  </section>
</div>
<script src="<?php echo base_url('assets/js/jQuery-2.1.4.min.js')?>"></script> 
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script> 
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script> 
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.min.js')?>"></script> 
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script> 
<script src="<?php echo base_url('assets/datatables/js/dataTables.tableTools.min.js')?>"></script> 
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script> 
<script src="<?php echo base_url('assets/summernote/summernote.js')?>"></script> 
<script type="text/javascript">
 
var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		
		"dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "<?php echo site_url('assets/datatables/swf/copy_csv_xls_pdf.swf')?>",
        },
        // Load data for the table's content from an Ajax source
        "ajax": {
			"url": "<?php echo site_url('admin/enq_leads/ajax_list/'.$category_id)?>",
            "type": "POST"
        },
		
		
        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            { 
                "targets": [ -2 ], //2 last column (photo)
                "orderable": false, //set not orderable
            },
			{ 
                "targets": [ 0 ], //2 last column (photo)
                "orderable": false, //set not orderable
            },
        ],
 
    });
 
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
 
    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
 
});
 

function status_on(id,smethod)
{
    //alert(smethod);
	$.ajax({
        url : "<?php echo site_url('admin/enq_leads/ajax_status_on')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			table.ajax.reload(null,false);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
	
}

function status_off(id)
{
    $.ajax({
        url : "<?php echo site_url('admin/enq_leads/ajax_status_off')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			table.ajax.reload(null,false);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
	
}
  
function add_block()
{
    $('[name="id"]').val("");
	//$('#summernote').summernote({ height: 150 });
	$('#summernote,#summernote2').summernote({
	height: 150,   
	toolbar: [
		['style', ['bold', 'italic', 'underline', 'clear']],
		['para', ['ul', 'ol', 'paragraph']]
	]
	});

    $('[name="address_en"]').summernote('code','');
	$('[name="address_hi"]').summernote('code','');

	save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
	$('#photo-preview').hide(); // hide photo preview modal
    $('#label-photo').text('Upload Photo (Upto 1 mb)'); // label photo upload
	
	 //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin/enq_leads/ajax_addform')?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			//console.log(data);
			$('#selector').append( $('<option> </option>').val('').html('Select State') );
					
			$.each(data.state, function(val,cat_data) 
			{
				$('#selector').append( $('<option> </option>').val(cat_data.state_id).html(cat_data.state_name) )
				
			});
			
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
	
} 

  
function edit_block(id)
{
    save_method = 'update';
	
	$('#summernote,#summernote2').summernote({
	height: 150,   
	toolbar: [
		['style', ['bold', 'italic', 'underline', 'clear']],
		['para', ['ul', 'ol', 'paragraph']]
	]
	})


    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); 
	$("#selector").html("");
	$("#selector2").html("");
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin/enq_leads/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
			$('[name="id"]').val(data.form_data.id);
			$('[name="name"]').val(data.form_data.name);
			$('[name="email"]').val(data.form_data.phone);
			$('[name="phone"]').val(data.form_data.email);
			$('[name="subject"]').val(data.form_data.subject);
			$('[name="source"]').val(data.form_data.source);

			
			$('[name="message"]').html();
			$('[name="message"]').summernote('code',data.form_data.message);
			
			$('#selector').append( $('<option> </option>').val('').html('Select State') );
			
			$.each(data.state, function(val,cat_data) 
			{
				$('#selector').append( $('<option> </option>').val(cat_data.state_id).html(cat_data.state_name) )
			});
			
			$("#selector").val(data.form_data.state);
			
			
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit'); // Set title to Bootstrap modal title
			$('.modal-title').text('Edit'); // Set title to Bootstrap modal title
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('admin/enq_leads/ajax_add')?>";
    } else {
        url = "<?php echo site_url('admin/enq_leads/ajax_update')?>";
    }
 
    // ajax adding data to database
 
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
}
 
function delete_block(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('admin/enq_leads/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}
 
</script> 
<script>
$(document).ready(function() 
{
	resetcheckbox();
	$('#selecctall').click(function(event) 
	{  //on click
		if (this.checked) 
		{ // check select status
			$('.checkbox1').each(function() 
			{ //loop through each checkbox
				this.checked = true;  //select all checkboxes with class "checkbox1"              
			});
		} 
		else 
		{
			$('.checkbox1').each(function() 
			{ //loop through each checkbox
				this.checked = false; //deselect all checkboxes with class "checkbox1"                      
			});
		}
	});


	$("#del_all").on('click', function(e) 
	{
		if(confirm('Are you sure delete all data?'))
		{
			e.preventDefault();
			var checkValues = $('.checkbox1:checked').map(function()
			{
				return $(this).val();
			}).get();
			console.log(checkValues);
			
			$.each( checkValues, function( i, val ) 
			{
				$("#"+val).remove();
			});
			$.ajax
			({
				url: '<?php echo site_url('admin/enq_leads/ajax_multi_delete')?>',
				type: 'post',
				data: 'ids=' + checkValues
			}).done(function(data) 
			{
				reload_table();
				$("#respose").html(data);
				$('#selecctall').attr('checked', false);
			});
		}
	});

	function  resetcheckbox()
	{
		$('input:checkbox').each(function() 
		{ 
			this.checked = false;                  
		});
	}
});
</script> 

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"> Form</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="<?=$this->uri->segment(3)?>" name="project_id"/>
          <input type="hidden" value="" name="id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Name</label>
              <div class="col-md-9">
                <input name="name" placeholder="Lead Name" class="form-control" type="text">
                <span class="help-block"></span> </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Phone</label>
              <div class="col-md-9">
                <input name="phone" placeholder="Phone" class="form-control" type="text">
                <span class="help-block"></span> </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Email</label>
              <div class="col-md-9">
                <input name="email" placeholder="Email" class="form-control" type="text">
                <span class="help-block"></span> </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Location *</label>
              <div class="col-md-9">
                <select id="selector" name="state" class="form-control">
                </select>
                <span class="help-block"></span> </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Subject </label>
              <div class="col-md-9">
                <input name="subject" placeholder="Subject" class="form-control" type="text">
                <span class="help-block"></span> </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Source </label>
              <div class="col-md-9">
                <input name="source" placeholder="Source" class="form-control" type="text">
                <span class="help-block"></span> </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3" id="desc_lable">Message</label>
            <div class="col-md-9"> <span class="help-block" id="description_error"></span>
              <textarea name="message" id="summernote" placeholder="Message" class="form-control">
              </textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- /.modal --> 
<!-- End Bootstrap modal -->
</body></html>