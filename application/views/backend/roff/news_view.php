<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <i class="fa fa-tachometer" aria-hidden="true"></i>News<small>Control panel</small> </h1>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12 text-right">
        <div class="form-group">
          <button class="btn btn-danger btn-sm pull-left" id="del_all"> <i class="glyphicon glyphicon-trash"></i>&nbsp; <b> Delete Selected </b> </button>
          <button class="btn btn-success" onclick="goBack()">
          <li class="glyphicon glyphicon-step-backward">Back</li>
          </button>
          <a class="btn btn-primary" onclick="add_block()"><i class="glyphicon glyphicon-plus"></i> Add New</a>
          <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
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
                  <th>English Title</th>
                  <th>Hindi Title</th>
                  <th>Added On</th>
                  <th>Status</th>
                  <th style="width:150px;">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="<?php echo base_url('assets/js/jQuery-2.1.4.min.js')?>"></script> 
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script> 
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script> 
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.min.js')?>"></script> 
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
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/news/ajax_list')?>",
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
        url : "<?php echo site_url('admin/news/ajax_status_on')?>/" + id,
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
        url : "<?php echo site_url('admin/news/ajax_status_off')?>/" + id,
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
	$('#summernote').summernote({
	height: 150,   
	toolbar: [
		['style', ['bold', 'italic', 'underline', 'clear']],
		['para', ['ul', 'ol', 'paragraph']]
	]
	});

    $('[name="description"]').summernote('code','');
	
	save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
	
	$('[name="id"]').html("");
	$("#selector").html("");
	
	$('#img1-preview').hide(); 
	$('#img2-preview').hide(); 
	$('#img3-preview').hide(); 
	$('#img4-preview').hide(); 
	$('#img5-preview').hide(); 
	
	
	 //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin/news/ajax_add')?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			//console.log(data);
            $('[name="id"]').val(data.id);
			$('[name="title_en"]').val(data.title_en);
			$('[name="title_hi"]').val(data.title_hi);
			$('[name="source"]').val(data.form_data.source);
			
			$('#selector').append( $('<option> </option>').val('').html('Select Vehicle Type') );
					
			$.each(data.vehicle, function(val,cat_data) 
			{
				$('#selector').append( $('<option> </option>').val(cat_data.id).html(cat_data.title) )
				 //console.log(cat_data);
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
	
	$('#summernote').summernote({
	height: 150,   
	toolbar: [
		['style', ['bold', 'italic', 'underline', 'clear']],
		['para', ['ul', 'ol', 'paragraph']]
	]
	})
	 
	 
    $('#form')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
	$("#selector").html("");
	$("#student").html("");
	$("#batch").html("");
	
 
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin/news/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //console.log(data);
			$('[name="id"]').val(data.form_data.id);
			$('[name="title_en"]').val(data.form_data.title_en);
			$('[name="title_hi"]').val(data.form_data.title_hi);
			$('[name="source"]').val(data.form_data.source);
			$('[name="description"]').html();
			$('[name="description"]').summernote('code',data.form_data.description);
			//$('#photo-preview').show(); // show photo preview modal
            
			for(var i=1;i<=5;i++)
			{ 
				//alert(data.form_data['img'+i]);
				//console.log(data.form_data+'img'+$i);
				if(data.form_data['img'+i])
				{
					$('#label-photo').text('Change Photo'); // label photo upload
					$('#img'+i+'-preview div').html('<img width="170px" height="170px" src="'+base_url+'nws/'+data.form_data['img'+i]+'" class="img-responsive">'); // show photo
					$('#img'+i+'-preview div').append('<input type="checkbox" name="removepics[img'+i+']" value="'+data.form_data['img'+i]+'"/> Remove photo when saving'); // remove photo
				}
				else
				{
					$('#label-photo').text('Upload Photo (Upto 1 mb)'); // label photo upload
					$('#img'+i+'-preview div').text('(No photo)');
				}
			}
			            
			$('#modal_form').modal('show'); 
            $('.modal-title').text('Edit'); 
			
 
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
        url = "<?php echo site_url('admin/news/ajax_add')?>";
    } else {
        url = "<?php echo site_url('admin/news/ajax_update')?>";
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
            url : "<?php echo site_url('admin/news/ajax_delete')?>/"+id,
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
				url: '<?php echo site_url('admin/news/ajax_multi_delete')?>',
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
          <input type="hidden" value="" name="id"/>
          <div class="form-group">
            <label class="control-label col-md-3">English Title *</label>
            <div class="col-md-9">
              <input name="title_en" placeholder="English Title" class="form-control" type="text">
              <span class="help-block"></span> </div>
          </div>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Hindi Title</label>
              <div class="col-md-9">
                <input name="title_hi" placeholder="Hindi Title" class="form-control" type="text">
                <span class="help-block"></span> </div>
            </div>
          </div>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Source</label>
              <div class="col-md-9">
                <input name="source" placeholder="Link" class="form-control" type="text">
                <span class="help-block"></span> </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3" id="desc_lable">Description </label>
            <div class="col-md-9"> <span class="help-block" id="description_error"></span>
              <textarea name="description" id="summernote" placeholder="Description" class="form-control">
                </textarea>
            </div>
          </div>
          <div class="form-group" id="img1-preview">
            <label class="control-label col-md-3">Photo(1000*1000px)*</label>
            <div class="col-md-9"> (No photo) <span class="help-block"></span> </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3" id="label-photo">Upload Photo </label>
            <div class="col-md-9">
              <input name="img1" type="file">
              <span class="help-block"></span> </div>
          </div>
          <div class="form-group" id="img2-preview">
            <label class="control-label col-md-3">Photo(1000*1000px)</label>
            <div class="col-md-9"> (No photo) <span class="help-block"></span> </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3" id="label-photo">Upload Photo </label>
            <div class="col-md-9">
              <input name="img2" type="file">
              <span class="help-block"></span> </div>
          </div>
          <div class="form-group" id="img3-preview">
            <label class="control-label col-md-3">Photo(1000*1000px)</label>
            <div class="col-md-9"> (No photo) <span class="help-block"></span> </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3" id="label-photo">Upload Photo </label>
            <div class="col-md-9">
              <input name="img3" type="file">
              <span class="help-block"></span> </div>
          </div>
          <div class="form-group" id="img4-preview">
            <label class="control-label col-md-3">Photo(1000*1000px)</label>
            <div class="col-md-9"> (No photo) <span class="help-block"></span> </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3" id="label-photo">Upload Photo </label>
            <div class="col-md-9">
              <input name="img4" type="file">
              <span class="help-block"></span> </div>
          </div>
          <div class="form-group" id="img5-preview">
            <label class="control-label col-md-3">Photo(1000*1000px)</label>
            <div class="col-md-9"> (No photo) <span class="help-block"></span> </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3" id="label-photo">Upload Photo </label>
            <div class="col-md-9">
              <input name="img5" type="file">
              <span class="help-block"></span> </div>
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