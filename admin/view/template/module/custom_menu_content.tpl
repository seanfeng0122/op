<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-custom_block_inside_menu" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
        <h1><?php echo $heading_title; ?></h1>
        <ul class="breadcrumb">
          <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="container-fluid">
      <?php if ($error_warning) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      <?php } ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
        </div>
        <div class="panel-body">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-custom_block_inside_menu" class="form-horizontal">

            <table id="module" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left"><?php echo "Category"; ?></td>
                <td class="text-left"><?php echo "Top Block Content"; ?></td>
                <td class="text-left"><?php echo "Bottom Block Content"; ?></td>
                <td class="text-left"><?php echo "Right Block content Type"; ?></td>
                <td class="text-left"><?php echo "Right Block content"; ?></td>
                <td></td>
              </tr>
            </thead>
           
              <?php $module_row = 0; ?>
              <?php foreach ($modules as $module) { ?>
               <tbody id="module-row<?php echo $module_row; ?>">
              <tr>
                <td>
                  <select name="custom_menu_content[<?php echo $module_row; ?>][category_id]" class="form-control">
                  <?php foreach ($top_categories as $category) { ?>
                  <?php if ($category['category_id'] == $module['category_id']) { ?>
                  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else {?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php }} ?>
                </select>
                </td>
                <td>
                 <textarea name="custom_menu_content[<?php echo $module_row; ?>][topcontent]" placeholder="Enetr text here" class="form-control"><?php echo $module["topcontent"]; ?></textarea>
                </td>
                <td>
                  <textarea name="custom_menu_content[<?php echo $module_row; ?>][bottomcontent]" placeholder="Enetr text here" class="form-control"><?php echo $module["bottomcontent"]; ?></textarea>
                </td>
                <td>
                <select name="custom_menu_content[<?php echo $module_row; ?>][type]" class="form-control" onchange="callMe(this.value,<?php echo $module_row; ?>)">           
                  <option value="0"></option>	       
                  <option value="product" <?php if($module['type']=='product'){?>selected<?php } ?> >Product</option>         
                  <option value="static" <?php if($module['type']=='static'){ ?>selected<?php } ?> >Static Content</option>    
                </select>
                </td>
                <td>
                  <div id="static<?php echo $module_row; ?>" <?php if($module['type']!='static') { ?> style="display:none;" <?php } ?> >
                  <textarea name="custom_menu_content[<?php echo $module_row; ?>][rightcontent]" placeholder="Enetr text here" class="form-control"><?php echo $module["rightcontent"]; ?></textarea>
                  </div>
                  <div id="product<?php echo $module_row; ?>" <?php if($module['type']!='product') { ?> style="display:none;" <?php } ?> >
                  	<select name="custom_menu_content[<?php echo $module_row; ?>][rightcontentproduct]">
                  		<?php foreach ($productlist as $pid=>$pname) { ?>
                  		<option value="<?php echo $pid; ?>" <?php if($module['rightcontentproduct']==$pid){ ?>selected<?php }?> ><?php echo $pname; ?></option>					    
                  		<?php } ?>
                  	</select>
                  </div>
                </td>

                <td class="text-left"><button type="button" onclick="$('#module-row<?php echo $module_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
              </tr>
              <?php $module_row++; ?>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="5"></td>
                <td class="text-left"><button type="button" onclick="addModule();" data-toggle="tooltip" title="<?php echo $button_module_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
              </tr>
            </tfoot>
          </table>

          </form>
        </div>
      </div>
    </div>



  </div>

    <script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {  
  html  = '<tbody id="module-row' + module_row + '">';
  
  html += '  <tr>';
  html += '    <td><select class="form-control" name="custom_menu_content[' + module_row + '][category_id]">';
  <?php foreach ($top_categories as $category) { ?>
  html += '      <option value="<?php echo $category['category_id']; ?>"><?php echo addslashes($category['name']); ?></option>';
  <?php } ?>
  html += '    </select></td>';

  html += '    <td><textarea class="form-control" name="custom_menu_content[' + module_row + '][topcontent]" placeholder="Enetr text here" class="form-control"></textarea></td>';

  html += '    <td><textarea class="form-control" name="custom_menu_content[' + module_row + '][bottomcontent]" placeholder="Enetr text here" class="form-control"></textarea></td>';

  html += '<td><select name="custom_menu_content[' + module_row + '][type]" class="form-control" onchange="callMe(this.value,'+module_row+')"><option value="0"></option><option value="product">Product</option><option value="static">Static Content</option> </select></td>';

  html += '<td><div id="static'+ module_row +'" style="display:none"><textarea class="form-control" name="custom_menu_content['+ module_row + '][rightcontent]" placeholder="Enetr text here" class="form-control" ></textarea></div><div id="product'+ module_row +'" style="display:none"><select name="custom_menu_content['+module_row+'][rightcontentproduct]" >';
  <?php foreach ($productlist as $pid=>$pname) { ?>
  html += '<option value="<?php echo $pid; ?>"><?php echo addslashes($pname); ?></option>';             
  <?php } ?>
  html += '</select></div></td>';

  html += '<td  class="left"><button type="button" onclick="$(\'#module-row' + module_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '  </tr>';
  html += '</tbody>';
  
  $('#module tfoot').before(html);

  
  module_row++;
}


function callMe(val,row)
{
	if(val=='static') {		
		$('#product'+row).hide();	
		$('#static'+row).show();	
	} else {
		$('#product'+row).show();	
		$('#static'+row).hide();	
	}
	//alert(val);
}
//--></script> 
  <?php echo $footer; ?>